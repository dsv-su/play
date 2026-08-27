<?php

namespace App\Livewire\Channel;

use App\Models\Category;
use App\Models\Channel;
use App\Models\ChannelVideoAssignment;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ManageChannels extends Component
{
    public string $name = '';

    public bool $showOnHomepage = true;

    public ?int $editingId = null;

    public string $videoSearch = '';

    public function mount(): void
    {
        abort_if($this->currentUsername() === '', 403);
    }

    public function save(): void
    {
        $existingChannel = $this->editingId ? $this->findManageableChannel($this->editingId) : null;
        $wasEditing = $existingChannel !== null;

        $data = $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('channels', 'name')->ignore($this->editingId)],
            'showOnHomepage' => ['boolean'],
        ]);

        $savedChannel = DB::transaction(function () use ($data, $existingChannel) {
            $channel = $existingChannel ?? new Channel;
            $category = $channel->category ?? new Category;
            $category->category_name = $data['name'];
            $category->save();
            $channel->fill([
                'category_id' => $category->id,
                'name' => $data['name'],
                'slug' => $this->uniqueSlug($data['name'], $channel->id),
                'show_on_homepage' => $data['showOnHomepage'],
                'created_by' => $channel->created_by ?: $this->currentUsername(),
            ])->save();

            return $channel;
        });

        session()->flash('status', $wasEditing ? __('Channel updated.') : __('Channel created. You can now add presentations below.'));
        $this->editingId = $savedChannel->id;
        $this->name = $savedChannel->name;
        $this->showOnHomepage = $savedChannel->show_on_homepage;
        $this->resetValidation();
    }

    public function edit(int $id): void
    {
        $channel = $this->findManageableChannel($id);
        $this->editingId = $channel->id;
        $this->name = $channel->name;
        $this->showOnHomepage = $channel->show_on_homepage;
        $this->resetValidation();
    }

    public function addVideo(string $videoId): void
    {
        $channel = $this->findManageableChannel((int) $this->editingId);
        $video = $this->findManageableVideo($videoId);

        DB::transaction(function () use ($channel, $video) {
            ChannelVideoAssignment::firstOrCreate([
                'channel_id' => $channel->id,
                'video_id' => $video->id,
            ], [
                'assigned_by' => $this->currentUsername(),
            ]);
        });

        session()->flash('status', __('Presentation added to channel.'));
    }

    public function removeVideo(string $videoId): void
    {
        $channel = $this->findManageableChannel((int) $this->editingId);
        $video = $this->findManageableVideo($videoId);

        ChannelVideoAssignment::query()
            ->where('channel_id', $channel->id)
            ->where('video_id', $video->id)
            ->delete();

        session()->flash('status', __('Presentation removed from channel.'));
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset('name', 'editingId', 'videoSearch');
        $this->showOnHomepage = true;
        $this->resetValidation();
    }

    private function uniqueSlug(string $name, ?int $ignoreId): string
    {
        $base = Str::slug($name) ?: 'channel';
        $slug = $base;
        $suffix = 2;
        while (Channel::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function findManageableChannel(int $id): Channel
    {
        $channel = Channel::findOrFail($id);
        abort_unless($this->isAdministrator() || hash_equals((string) $channel->created_by, $this->currentUsername()), 403);

        return $channel;
    }

    private function findManageableVideo(string $id): Video
    {
        $video = $this->manageableVideosQuery()->findOrFail($id);

        return $video;
    }

    private function manageableVideosQuery(): Builder
    {
        return Video::query()->when(! $this->isAdministrator(), function ($query) {
            $username = $this->currentUsername();
            $query->where(function ($query) use ($username) {
                $query->whereHas('presenters', fn ($presenters) => $presenters->where('username', $username))
                    ->orWhereHas('individualPermissions', fn ($permissions) => $permissions
                        ->where('username', $username)
                        ->whereIn('permission', ['edit', 'delete']));
            });
        });
    }

    private function currentUsername(): string
    {
        return app()->bound('play_username') ? (string) app('play_username') : '';
    }

    private function isAdministrator(): bool
    {
        return app()->bound('play_role') && app('play_role') === 'Administrator';
    }

    public function render()
    {
        $editingChannel = $this->editingId ? $this->findManageableChannel($this->editingId) : null;
        $assignedVideos = $editingChannel
            ? $editingChannel->presentations()->latest('creation')->get()
            : collect();
        $manageableVideoIds = $editingChannel
            ? $this->manageableVideosQuery()->whereKey($assignedVideos->pluck('id'))->pluck('videos.id')
            : collect();
        $availableVideos = $editingChannel
            ? $this->manageableVideosQuery()
                ->whereDoesntHave('channels', fn ($query) => $query->whereKey($editingChannel->id))
                ->when($this->videoSearch !== '', function ($query) {
                    $search = '%'.$this->videoSearch.'%';
                    $query->where(function ($query) use ($search) {
                        $query->where('title', 'like', $search)
                            ->orWhereHas('courses', fn ($courses) => $courses
                                ->where('name', 'like', $search)
                                ->orWhere('designation', 'like', $search));
                    });
                })
                ->with([
                    'category:id,category_name',
                    'courses:id,name,name_en,designation,semester,year',
                ])
                ->latest('creation')
                ->limit(40)
                ->get()
            : collect();

        $availableVideosByCourse = $availableVideos
            ->flatMap(function (Video $video) {
                if ($video->courses->isEmpty()) {
                    return [[
                        'key' => 'no-course',
                        'label' => __('No course'),
                        'video' => $video,
                    ]];
                }

                return $video->courses->map(fn ($course) => [
                    'key' => 'course-'.$course->id,
                    'label' => trim($course->designation.' '.$course->semester.$course->year.' — '.(app()->getLocale() === 'en' ? ($course->name_en ?: $course->name) : $course->name)),
                    'video' => $video,
                ]);
            })
            ->groupBy('key')
            ->map(fn ($items) => [
                'label' => $items->first()['label'],
                'videos' => $items->pluck('video'),
            ])
            ->sortBy('label');

        return view('livewire.channel.manage-channels', [
            'channels' => Channel::query()
                ->when(! $this->isAdministrator(), fn ($query) => $query->where('created_by', $this->currentUsername()))
                ->withCount('presentations')
                ->orderBy('name')
                ->get(),
            'isAdministrator' => $this->isAdministrator(),
            'editingChannel' => $editingChannel,
            'assignedVideos' => $assignedVideos,
            'manageableVideoIds' => $manageableVideoIds->flip(),
            'availableVideos' => $availableVideos,
            'availableVideosByCourse' => $availableVideosByCourse,
        ]);
    }
}
