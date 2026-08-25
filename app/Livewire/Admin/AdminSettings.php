<?php

namespace App\Livewire\Admin;

use App\Models\ApiLog;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class AdminSettings extends Component
{
    use WithPagination;

    public $activeTab = 'track';
    public $banners;
    public $categories;
    public $settings;

    public $trackUuid;
    public $videoData;

    public $newBannerContent;
    public $newBannerVisible = false;
    public $newBannerVisibleForStaff = false;
    public $newBannerVisibleForStudent = false;
    public $newBannerLinkUrl;
    public $newBannerLinkText;
    
    public $editingBannerId = null;
    public $editBannerContent;
    public $editBannerVisible;
    public $editBannerVisibleForStaff;
    public $editBannerVisibleForStudent;
    public $editBannerLinkUrl;
    public $editBannerLinkText;

    public $newCategoryName;
    public $editingCategoryId = null;
    public $editCategoryName;

    protected $rules = [
        'newBannerContent' => 'nullable|string',
        'newBannerVisible' => 'boolean',
        'newBannerVisibleForStaff' => 'boolean',
        'newBannerVisibleForStudent' => 'boolean',
        'newBannerLinkUrl' => 'nullable|url',
        'newBannerLinkText' => 'nullable|string',
        'editBannerContent' => 'nullable|string',
        'editBannerVisible' => 'boolean',
        'editBannerVisibleForStaff' => 'boolean',
        'editBannerVisibleForStudent' => 'boolean',
        'editBannerLinkUrl' => 'nullable|url',
        'editBannerLinkText' => 'nullable|string',
        'newCategoryName' => 'nullable|string|max:255',
        'editCategoryName' => 'nullable|string|max:255',
        'settings.*.value' => 'nullable|string',
        'trackUuid' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadBanners();
        $this->loadCategories();
        $this->loadSettings();
    }

    public function loadBanners()
    {
        $this->banners = Banner::orderBy('created_at', 'desc')->get();
    }

    public function loadCategories()
    {
        $this->categories = Category::orderBy('category_name')->get();
    }

    public function loadSettings()
    {
        $this->settings = Setting::all();
        if ($this->settings->isEmpty()) {
            // Seed some default settings if none exist
            Setting::create(['name' => 'Site Name', 'value' => 'Play', 'description' => 'The name of the application.']);
            Setting::create(['name' => 'Maintenance Mode', 'value' => 'false', 'description' => 'Whether the site is in maintenance mode.']);
            $this->settings = Setting::all();
        }
    }

    public function createBanner()
    {
        $this->validate([
            'newBannerContent' => 'required',
        ]);

        if ($this->newBannerVisible) {
            Banner::query()->update(['visible' => false]);
        }

        Banner::create([
            'content' => $this->newBannerContent,
            'link_url' => $this->newBannerLinkUrl,
            'link_text' => $this->newBannerLinkText,
            'visible' => $this->newBannerVisible,
            'visible_for_staff' => $this->newBannerVisibleForStaff,
            'visible_for_student' => $this->newBannerVisibleForStudent,
        ]);

        $this->reset(['newBannerContent', 'newBannerLinkUrl', 'newBannerLinkText', 'newBannerVisible', 'newBannerVisibleForStaff', 'newBannerVisibleForStudent']);
        $this->loadBanners();
        session()->flash('message', 'Banner created.');
    }

    public function editBanner($id)
    {
        $banner = Banner::find($id);
        $this->editingBannerId = $id;
        $this->editBannerContent = $banner->content;
        $this->editBannerVisible = $banner->visible;
        $this->editBannerVisibleForStaff = $banner->visible_for_staff;
        $this->editBannerVisibleForStudent = $banner->visible_for_student;
        $this->editBannerLinkUrl = $banner->link_url;
        $this->editBannerLinkText = $banner->link_text;
    }

    public function updateBanner()
    {
        $this->validate([
            'editBannerContent' => 'required',
        ]);

        $banner = Banner::find($this->editingBannerId);

        if ($this->editBannerVisible) {
            Banner::where('id', '!=', $this->editingBannerId)->update(['visible' => false]);
        }

        $banner->update([
            'content' => $this->editBannerContent,
            'visible' => $this->editBannerVisible,
            'visible_for_staff' => $this->editBannerVisibleForStaff,
            'visible_for_student' => $this->editBannerVisibleForStudent,
            'link_url' => $this->editBannerLinkUrl,
            'link_text' => $this->editBannerLinkText,
        ]);

        $this->editingBannerId = null;
        $this->loadBanners();
        session()->flash('message', 'Banner updated.');
    }

    public function toggleBanner($id)
    {
        $banner = Banner::find($id);
        $newStatus = !$banner->visible;

        if ($newStatus) {
            Banner::where('id', '!=', $id)->update(['visible' => false]);
        }

        $banner->update(['visible' => $newStatus]);
        $this->loadBanners();
    }

    public function deleteBanner($id)
    {
        Banner::find($id)->delete();
        $this->loadBanners();
        session()->flash('message', 'Banner deleted.');
    }

    public function createCategory()
    {
        $this->validate([
            'newCategoryName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name'),
            ],
        ]);

        Category::create([
            'category_name' => $this->newCategoryName,
        ]);

        $this->reset('newCategoryName');
        $this->loadCategories();
        session()->flash('message', 'Category created.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);

        $this->editingCategoryId = $category->id;
        $this->editCategoryName = $category->category_name;
    }

    public function updateCategory()
    {
        $this->validate([
            'editCategoryName' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')->ignore($this->editingCategoryId),
            ],
        ]);

        $category = Category::findOrFail($this->editingCategoryId);
        $category->update([
            'category_name' => $this->editCategoryName,
        ]);

        $this->reset(['editingCategoryId', 'editCategoryName']);
        $this->loadCategories();
        session()->flash('message', 'Category updated.');
    }

    public function saveSettings()
    {
        foreach ($this->settings as $setting) {
            $setting->save();
        }
        session()->flash('message', 'Settings saved successfully.');
    }

    public function trackVideo()
    {
        $this->validate([
            'trackUuid' => 'required',
        ]);

        $this->videoData = \App\Models\Video::with([
            'presenters',
            'courses',
            'tags',
            'category',
            'streams.resolutions',
            'permissions',
            'individualPermissions',
            'coursepermissions',
            'status',
            'videoStats',
            'metrics' => fn ($query) => $query
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->orderByDesc('day')
                ->orderByDesc('hour'),
        ])->find($this->trackUuid);

        if ($this->videoData) {
            // Also try to find manual presentation data for extra subtitle info
            $manual = \App\Models\ManualPresentation::where('jobid', $this->videoData->notification_id)
                ->orWhere('pkg_id', $this->videoData->id)
                ->first();
            if ($manual) {
                $this->videoData->manual_presentation = $manual;
            }
        } else {
            session()->flash('error', 'Video not found.');
        }
    }

    public function deleteLog($id)
    {
        ApiLog::findOrFail($id)->delete();
        session()->flash('message', 'Log entry deleted.');
    }

    public function clearLogs()
    {
        ApiLog::truncate();
        session()->flash('message', 'All API logs cleared.');
    }

    public function render()
    {
        return view('livewire.admin.admin-settings', [
            'apiLogs' => ApiLog::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }
}
