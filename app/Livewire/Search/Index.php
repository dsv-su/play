<?php

namespace App\Livewire\Search;

use App\Models\Course;
use App\Models\Presenter;
use App\Models\Tag;
use App\Models\Video;
use Livewire\Component;

class Index extends Component
{
    //#[Validate('required')]
    public string $searchTerm = '';
    public array $videoHighlightsById = [];
    public array $presenterHighlightsById = [];
    public array $courseHighlightsById = [];
    public array $tagHighlightsById = [];

    public $videos = [];
    public $presenters = [];
    public $courses = [];
    public $tags = [];

    protected array $videoTsOptions = [
        'query_by'                   => 'title,title_en,description,tag_names,course_names,course_designation,presenter_names,presenter_usernames',
        'highlight_full_fields'      => 'title,title_en,description,tag_names,course_names,course_designation,presenter_names,presenter_usernames',
        'highlight_start_tag'        => '<span class="font-bold text-blue-600">',
        'highlight_end_tag'          => '</span>',
        'snippet_threshold'          => 80,
        'highlight_affix_num_tokens' => 4,
        'filter_by'                  => 'visibility:[1] && unlisted:[0]',
    ];

    protected array $presenterTsOptions = [
        'query_by'                   => 'name,username',
        'highlight_full_fields'      => 'name,username',
        'highlight_start_tag'        => '<span class="font-bold text-blue-600">',
        'highlight_end_tag'          => '</span>',
        'snippet_threshold'          => 80,
        'highlight_affix_num_tokens' => 4,
    ];

    protected array $courseTsOptions = [
        'query_by'                   => 'name,designation,semester',
        'highlight_full_fields'      => 'name,designation,semester',
        'highlight_start_tag'        => '<span class="font-bold text-blue-600">',
        'highlight_end_tag'          => '</span>',
        'snippet_threshold'          => 80,
        'highlight_affix_num_tokens' => 4,
    ];

    protected array $tagTsOptions = [
        'query_by'                   => 'name',
        'highlight_full_fields'      => 'name',
        'highlight_start_tag'        => '<span class="font-bold text-blue-600">',
        'highlight_end_tag'          => '</span>',
        'snippet_threshold'          => 80,
        'highlight_affix_num_tokens' => 4,
    ];

    public function updatedSearchTerm() { $this->search(); }
    public function mount() { if ($this->searchTerm !== '') $this->search(); }

    protected function search(): void
    {
        if (trim($this->searchTerm) === '') {
            $this->videos = $this->presenters = $this->courses = $this->tags = collect();
            $this->videoHighlightsById = $this->presenterHighlightsById = $this->courseHighlightsById = $this->tagHighlightsById = [];
            return;
        }

        // VIDEOS (+ eager load relations)
        $videoBuilder = Video::search($this->searchTerm)->options($this->videoTsOptions);
        $this->videos = $videoBuilder->take(3)->get()->load([
            'tagsRelation:id,name',
            'coursesRelation:id,name,designation',
            'presenterRelation:id,name,username',
        ])->values()->all();
        $videoRaw = $videoBuilder->raw();
        $this->videoHighlightsById = collect($videoRaw['hits'] ?? [])
            ->mapWithKeys(fn ($hit) => [
                (string)($hit['document']['id'] ?? '') => [
                    'highlights' => $hit['highlights'] ?? [],
                    'score'      => $hit['text_match'] ?? null,
                ],
            ])->all();

        // PRESENTERS
        //$presenterBuilder = Presenter::search($this->searchTerm)->options($this->presenterTsOptions);
        $presenterBuilder = Presenter::search($this->searchTerm)
            ->options(array_merge($this->presenterTsOptions, [
                'distinct' => 'id',
            ]));

        $this->presenters = $presenterBuilder->take(3)->get()->values()->all();
        $presenterRaw = $presenterBuilder->raw();
        $this->presenterHighlightsById = collect($presenterRaw['hits'] ?? [])
            ->mapWithKeys(fn ($hit) => [
                (string)($hit['document']['id'] ?? '') => [
                    'highlights' => $hit['highlights'] ?? [],
                    'score'      => $hit['text_match'] ?? null,
                ],
            ])->all();

        // COURSES
        $courseBuilder = Course::search($this->searchTerm)->options($this->courseTsOptions);
        $this->courses = $courseBuilder->take(3)->get()->values()->all();
        $courseRaw = $courseBuilder->raw();
        $this->courseHighlightsById = collect($courseRaw['hits'] ?? [])
            ->mapWithKeys(fn ($hit) => [
                (string)($hit['document']['id'] ?? '') => [
                    'highlights' => $hit['highlights'] ?? [],
                    'score'      => $hit['text_match'] ?? null,
                ],
            ])->all();

        // TAGS
        $tagBuilder = Tag::search($this->searchTerm)->options($this->tagTsOptions);
        $this->tags = $tagBuilder->take(3)->get()->values()->all();
        $tagRaw = $tagBuilder->raw();
        $this->tagHighlightsById = collect($tagRaw['hits'] ?? [])
            ->mapWithKeys(fn ($hit) => [
                (string)($hit['document']['id'] ?? '') => [
                    'highlights' => $hit['highlights'] ?? [],
                    'score'      => $hit['text_match'] ?? null,
                ],
            ])->all();
    }

    public function render()
    {
        return view('livewire.search.index', [
            'searchTerm'             => $this->searchTerm,
            'videos'                 => $this->videos,
            'presenters'             => $this->presenters,
            'courses'                => $this->courses,
            'tags'                   => $this->tags,
            'videoHighlightsById'    => $this->videoHighlightsById,
            'presenterHighlightsById'=> $this->presenterHighlightsById,
            'courseHighlightsById'   => $this->courseHighlightsById,
            'tagHighlightsById'      => $this->tagHighlightsById,
        ]);
    }
}
