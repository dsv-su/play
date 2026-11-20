<div role="search" aria-label="{{ __('Search play') }}">
        <div class="flex justify-center">
            <div class="relative w-full md:w-1/2">
                <!-- Search input -->
                <input
                    type="search"
                    class="p-4 w-full border rounded-md
                           text-gray-800 placeholder:text-gray-800
                           border-slate-500
                           focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent
                           dark:bg-slate-800 dark:text-slate-100 dark:placeholder:text-slate-400
                           dark:border-slate-400 dark:focus:ring-blue-400"
                    wire:model.live.debounce.300ms="searchTerm"
                    placeholder="{{__('Search')}}"
                    autocomplete="off"
                    aria-label="{{ __('Search play') }}"
                />

                @php
                    // Shared maps
                    $LABEL_MAP = [
                        'title'                 => 'Title',
                        'description'           => 'Description',
                        'tag_names'             => 'Tags',
                        'course_names'          => 'Courses',
                        'course_designation'    => 'Designation',
                        'presenter_names'       => 'Presenter',
                        'presenter_usernames'   => 'Presenter',
                    ];

                    // Dark-friendly badge styles
                    $BADGE_CLASSES = [
                        'title'                 => 'bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-300',
                        'description'           => 'bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300',
                        'tag_names'             => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300',
                        'course_names'          => 'bg-green-100 text-green-800 dark:bg-green-950/40 dark:text-green-300',
                        'course_designation'    => 'bg-green-100 text-green-800 dark:bg-green-950/40 dark:text-green-300',
                        'presenter_names'       => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300',
                        'presenter_usernames'   => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300',
                    ];

                    // Highlight query terms (dual-theme blue)
                    $highlightTerms = function (?string $text, ?string $query) {
                        $text = (string) $text;
                        if ($text === '' || $query === null) return e($text);

                        $terms = collect(preg_split('/\s+/u', $query, -1, PREG_SPLIT_NO_EMPTY))
                            ->filter(fn($t) => mb_strlen($t) >= 2)
                            ->map(fn($t) => preg_quote($t, '~'))
                            ->unique()
                            ->values();

                        if ($terms->isEmpty()) return e($text);

                        $escaped = e($text);
                        $pattern = '~(' . $terms->implode('|') . ')~iu';

                        return preg_replace(
                            $pattern,
                            '<span class="font-bold text-blue-700 dark:text-blue-400">$1</span>',
                            $escaped
                        );
                    };

                    // Replace <mark>…</mark> with bold blue (dual-theme)
                    $decorateMarks = function (string $html) {
                        return str_replace(
                            ['<mark>', '</mark>'],
                            ['<span class="font-bold text-blue-700 dark:text-blue-400">', '</span>'],
                            $html
                        );
                    };
                @endphp

                <div role="status" aria-atomic="true" class="sr-only">
                    @if(filled($searchTerm))
                        {{ trans_choice(':count search result|:count search results', count($videos) + count($presenters) + count($courses) + count($tags) + count($channels)) }}
                    @endif
                </div>

                @if(filled($searchTerm))
                    <div class="mt-2 rounded-md border border-slate-200 bg-white p-4 shadow-md dark:border-slate-800 dark:bg-slate-900">

                        <!-- Loading -->
                        <div wire:loading.flex wire:target="searchTerm" class="justify-center py-2 text-gray-600 italic dark:text-slate-400">
                            {{ __('Searching…') }}
                        </div>

                        <!-- Results -->
                        <div wire:loading.remove wire:target="searchTerm">

                            <!-- COURSES -->
                            @if(count($courses))
                                <h4 class="text-sm sm:text-base font-semibold text-indigo-700 dark:text-indigo-400 mb-2">
                                    {{ __("Courses") }}
                                </h4>

                                <div class="space-y-2 mb-2">
                                    @foreach($courses as $c)
                                        @php
                                            $docId = (string) ($c->id ?? $c->getKey());
                                            $hit   = $courseHighlightsById[$docId] ?? ['highlights' => []];
                                            $hlsBy = collect($hit['highlights'])->groupBy('field');

                                            $name  = data_get($hlsBy->get('name'), '0.snippet') ?: e($c->name ?? '');
                                            $des   = data_get($hlsBy->get('designation'), '0.snippet') ?: ($c->designation ?? '');
                                            $sem   = data_get($hlsBy->get('semester'), '0.snippet') ?: ($c->semester ?? '');
                                            $year  = e($c->year ?? '');
                                        @endphp

                                        <a href="{{ route('courses.show', $c->designation) }}"
                                           class="block focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-700 dark:focus-visible:ring-blue-400 rounded-lg">
                                            <article class="border rounded-lg p-3 sm:p-4 space-y-1 transition
                                                            border-slate-200 hover:bg-blue-50 active:bg-blue-100
                                                            dark:border-slate-800 dark:hover:bg-slate-800 dark:active:bg-slate-700">

                                                <div class="flex items-start gap-2">
                                                    {{--}}
                                                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-gray-800 dark:text-white shrink-0"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M20 14H4m6.5 3L8 20m5.5-3 2.5 3M4.88889 17H19.1111c.4909 0 .8889-.4157.8889-.9286V4.92857C20 4.41574 19.602 4 19.1111 4H4.88889C4.39797 4 4 4.41574 4 4.92857V16.0714c0 .5129.39797.9286.88889.9286ZM13 14v-3h4v3h-4Z"/>
                                                    </svg>
                                                    {{--}}
                                                    <div class="font-semibold text-xs sm:text-base leading-tight min-w-0 break-words text-slate-900 dark:text-slate-100">
                                                        @if($des){!! $des !!}@else{{ e($des) }}@endif
                                                        @if($sem)&nbsp;<span class="text-gray-700 dark:text-slate-300">{!! $sem !!}</span>@endif
                                                        @if($year)&nbsp;<span class="text-gray-600 dark:text-slate-400">{{ $year }}</span>@endif
                                                    </div>
                                                </div>

                                                @if($name)
                                                    <p class="text-xs sm:text-sm text-gray-800 dark:text-slate-200 min-w-0">
                                                        <span class="line-clamp-2 sm:line-clamp-3">{!! $name !!}</span>
                                                    </p>
                                                @endif

                                                @php $desc = data_get($hlsBy->get('semester'), '0.snippet'); @endphp
                                                @if($desc)
                                                    <div class="text-[9px] sm:text-xs text-gray-700 dark:text-slate-300">
                                                        {!! $desc !!}
                                                    </div>
                                                @endif

                                            </article>
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <!-- PRESENTERS -->
                            @if(count($presenters))
                                <h4 class="text-sm sm:text-base font-semibold text-green-700 dark:text-green-400 mb-2">
                                    {{ __("Presenters") }}
                                </h4>

                                <div class="space-y-2 mb-2">
                                    @foreach($presenters as $p)
                                        @php
                                            $docId = (string) ($p->id ?? $p->getKey());
                                            $hit   = $presenterHighlightsById[$docId] ?? ['highlights' => []];
                                            $hlsBy = collect($hit['highlights'])->groupBy('field');
                                            $name  = data_get($hlsBy->get('name'), '0.snippet') ?: e($p->name ?? '');
                                            $user  = data_get($hlsBy->get('username'), '0.snippet');
                                            $bio   = data_get($hlsBy->get('bio'), '0.snippet');
                                        @endphp

                                        <a href="{{ route('presenters.show', $p->username) }}"
                                           class="block focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-700 dark:focus-visible:ring-blue-400 rounded-lg">
                                            <article class="border rounded-lg p-3 sm:p-4 space-y-1 transition
                                                            border-slate-200 hover:bg-blue-50 active:bg-blue-100
                                                            dark:border-slate-800 dark:hover:bg-slate-800 dark:active:bg-slate-700">

                                                <div class="flex items-start gap-2">
                                                    {{--}}
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800 dark:text-white shrink-0"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                         fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-width="2"
                                                              d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                    {{--}}
                                                    <div class="font-medium text-sm sm:text-base min-w-0 break-words text-slate-900 dark:text-slate-100">
                                                        {!! $name !!}
                                                    </div>
                                                </div>

                                                @if($bio)
                                                    <p class="text-xs sm:text-sm text-gray-700 dark:text-slate-300">
                                                        {!! $bio !!}
                                                    </p>
                                                @endif
                                            </article>
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <!-- TAGS -->
                            @if(count($tags))
                                <h4 class="text-sm sm:text-base font-semibold text-teal-700 dark:text-teal-400 mb-2">
                                    {{ __("Tags") }}
                                </h4>

                                <div class="space-y-2 mb-2">
                                    @foreach($tags as $t)
                                        @php
                                            $docId = (string) ($t->id ?? $t->getKey());
                                            $hit   = $tagHighlightsById[$docId] ?? ['highlights' => []];
                                            $hlsBy = collect($hit['highlights'])->groupBy('field');
                                            $name  = data_get($hlsBy->get('name'), '0.snippet') ?: e($t->name ?? '');
                                        @endphp

                                        <a href="{{ route('tags.show', $t->slug ?? $t->name) }}"
                                           class="block focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-700 dark:focus-visible:ring-blue-400 rounded-lg">
                                            <article class="border rounded-lg p-3 sm:p-4 transition
                                                            border-slate-200 hover:bg-blue-50 active:bg-blue-100
                                                            dark:border-slate-800 dark:hover:bg-slate-800 dark:active:bg-slate-700">
                                                <div class="flex items-start gap-2">
                                                    {{--}}
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800 dark:text-white shrink-0"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15.2 6H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11.2a1 1 0 0 0 .747-.334l4.46-5a1 1 0 0 0 0-1.332l-4.46-5A1 1 0 0 0 15.2 6Z"/>
                                                    </svg>
                                                    {{--}}
                                                    <div class="text-sm sm:text-base font-medium min-w-0 break-words text-slate-900 dark:text-slate-100">
                                                        {!! $name !!}
                                                    </div>
                                                </div>
                                            </article>
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <!-- CHANNELS -->
                            @if(count($channels))
                                <h4 class="text-sm sm:text-base font-semibold text-purple-700 dark:text-purple-400 mb-2">
                                    {{ __('Channels') }}
                                </h4>

                                <div class="space-y-2 mb-2">
                                    @foreach($channels as $channel)
                                        @php
                                            $docId = (string) ($channel->id ?? $channel->getKey());
                                            $hit = $channelHighlightsById[$docId] ?? ['highlights' => []];
                                            $hlsBy = collect($hit['highlights'])->groupBy('field');
                                            $name = data_get($hlsBy->get('name'), '0.snippet') ?: e($channel->name ?? '');
                                        @endphp

                                        <a href="{{ route('channels.show', $channel) }}"
                                           class="block focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-700 dark:focus-visible:ring-blue-400 rounded-lg">
                                            <article class="border rounded-lg p-3 sm:p-4 transition border-slate-200 hover:bg-blue-50 active:bg-blue-100 dark:border-slate-800 dark:hover:bg-slate-800 dark:active:bg-slate-700">
                                                <div class="flex items-start gap-2">
                                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800 dark:text-white shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
                                                    </svg>
                                                    <div class="text-sm sm:text-base font-medium min-w-0 break-words text-slate-900 dark:text-slate-100">{!! $name !!}</div>
                                                </div>
                                            </article>
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <!-- VIDEOS -->
                            @if(count($videos))
                                <h4 class="text-sm sm:text-base font-semibold text-blue-700 dark:text-blue-400 mb-2">{{ __("Presentations") }}</h4>
                                <div class="space-y-2 mb-2">
                                    @foreach ($videos as $video)
                                        @php
                                            // Ensure we have a $stripAnchors helper available
                                            if (!isset($stripAnchors) || !is_callable($stripAnchors)) {
                                                $stripAnchors = function (string $html) {
                                                    return preg_replace('~</?a\b[^>]*>~i', '', $html);
                                                };
                                            }

                                            $docId = (string) ($video->getKey() ?? $video->id);
                                            $hit   = $videoHighlightsById[$docId] ?? ['highlights' => [], 'score' => null];
                                            $hls   = $hit['highlights'] ?? [];

                                            // Group highlights by field
                                            $hlsByField = collect($hls)->groupBy('field');
                                            $fields     = $hlsByField->keys();

                                            $has = function(...$keys) use ($fields) {
                                                return $fields->intersect($keys)->isNotEmpty();
                                            };

                                            // Snippet helpers (strip any <a> from snippets)
                                            $firstSnippet = function (string $field, string $fallback = '') use ($hlsByField, $stripAnchors) {
                                                $snip = data_get($hlsByField->get($field), '0.snippet');
                                                return $snip ? $stripAnchors($snip) : e($fallback);
                                            };

                                            $firstPlain = function (string $field) use ($hlsByField) {
                                                $snip = data_get($hlsByField->get($field), '0.snippet');
                                                return $snip ? trim(html_entity_decode(strip_tags($snip))) : null;
                                            };

                                            $snippetsFor = function (array $keys) use ($hlsByField, $stripAnchors) {
                                                return collect($keys)
                                                    ->map(fn($k) => $hlsByField->get($k, collect()))
                                                    ->flatten(1)
                                                    ->pluck('snippet')
                                                    ->filter()
                                                    ->map($stripAnchors)
                                                    ->unique()
                                                    ->values();
                                            };

                                            // Snippets
                                            $tagSnippets        = $snippetsFor(['tag_names']);
                                            $courseSnippets     = $snippetsFor(['course_names', 'course_designation']);
                                            $presenterSnippets  = $snippetsFor(['presenter_names', 'presenter_usernames']);

                                            // Matched values
                                            $matchedTagName             = $firstPlain('tag_names');
                                            $matchedCourseTitle         = $firstPlain('course_names');
                                            $matchedCourseDesignation   = $firstPlain('course_designation');
                                            $matchedPresenterName       = $firstPlain('presenter_names');
                                            $matchedPresenterUsername   = $firstPlain('presenter_usernames');

                                            // Normalize relations
                                            $tagsCol       = collect($video->tagsRelation ?? $video->tags ?? []);
                                            $coursesCol    = collect($video->coursesRelation ?? $video->courses ?? []);
                                            $presentersCol = collect($video->presenterRelation ?? $video->presenters ?? []);

                                            $tagForBadge = $tagsCol->first(function($t) use ($matchedTagName) {
                                                return $matchedTagName && strcasecmp(trim($t->name ?? ''), trim($matchedTagName)) === 0;
                                            }) ?? $tagsCol->first();

                                            $courseForBadge = $coursesCol->first(function ($c) use ($matchedCourseTitle, $matchedCourseDesignation) {
                                                $title       = trim(($c->title ?? $c->name ?? ''));
                                                $designation = trim($c->designation ?? '');
                                                $titleMatch        = $matchedCourseTitle && strcasecmp($title, trim($matchedCourseTitle)) === 0;
                                                $designationMatch  = $matchedCourseDesignation && strcasecmp($designation, trim($matchedCourseDesignation)) === 0;
                                                return $titleMatch || $designationMatch;
                                            }) ?? $coursesCol->first();

                                            $presenterForBadge = $presentersCol->first(function ($p) use ($matchedPresenterName, $matchedPresenterUsername) {
                                                $nameMatch = $matchedPresenterName && strcasecmp(trim($p->name ?? ''), trim($matchedPresenterName)) === 0;
                                                $userMatch = $matchedPresenterUsername && strcasecmp(trim($p->username ?? ''), trim($matchedPresenterUsername)) === 0;
                                                return $nameMatch || $userMatch;
                                            }) ?? $presentersCol->first();

                                            // Primary destination
                                            $primaryUrl = route('player.show', $video);
                                            /*if (! $has('title','description')) {
                                                if ($has('tag_names') && ! $has('course_names','course_designation')) {
                                                    $primaryUrl = $tagForBadge
                                                        ? route('tags.show', $tagForBadge->slug ?? $tagForBadge->id)
                                                        : $primaryUrl;
                                                } elseif ($has('course_names','course_designation') && ! $has('tag_names')) {
                                                    $primaryUrl = $courseForBadge
                                                        ? route('courses.show', $courseForBadge->slug ?? $courseForBadge->id)
                                                        : $primaryUrl;
                                                } elseif ($has('presenter_names','presenter_usernames') && ! $has('tag_names','course_names','course_designation')) {
                                                    $primaryUrl = $presenterForBadge
                                                        ? route('presenters.show', $presenterForBadge->slug ?? $presenterForBadge->id)
                                                        : $primaryUrl;
                                                }
                                            }*/

                                            $matchedFields = $fields->values();
                                        @endphp
                                        <article class="border rounded-lg p-3 sm:p-4 space-y-1.5 transition
                                                            border-slate-200 hover:bg-blue-50 active:bg-blue-100
                                                            dark:border-slate-800 dark:hover:bg-slate-800 dark:active:bg-slate-700">
                                            <a target="_blank" rel="noopener noreferrer" href="{{ $primaryUrl }}"
                                               class="block focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-700 dark:focus-visible:ring-blue-400 rounded-lg">


                                                <!-- Title row -->
                                                <h3 class="text-sm sm:text-base font-semibold leading-tight text-slate-900 dark:text-slate-100">
                                                    <span class="flex items-start gap-2">
                                                      <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-800 dark:text-white shrink-0"
                                                           aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                           viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M8 18V6l8 6-8 6Z"/>
                                                      </svg>
                                                      <span class="min-w-0 break-words">
                                                        {!! $firstSnippet('title', $video->title ?? '') !!}
                                                      </span>
                                                    </span>
                                                </h3>

                                                @if(!empty($video->description))
                                                    <p class="text-xs sm:text-sm text-gray-700 dark:text-slate-300 overflow-hidden">
                                                        <span class="line-clamp-2 sm:line-clamp-3">
                                                            {!! $firstSnippet('description', \Illuminate\Support\Str::limit($video->description, 140)) !!}
                                                        </span>
                                                    </p>
                                                @endif

                                                @if($tagSnippets->isNotEmpty() || $courseSnippets->isNotEmpty() || $presenterSnippets->isNotEmpty())
                                                    <div class="flex flex-wrap gap-1 text-[11px] sm:text-xs text-gray-800 dark:text-slate-200">
                                                        @foreach ($tagSnippets as $snip)
                                                            <span class="inline-block">{!! $snip !!}</span>
                                                        @endforeach
                                                        @foreach ($courseSnippets as $snip)
                                                            <span class="inline-block">{!! $snip !!}</span>
                                                        @endforeach
                                                        @foreach ($presenterSnippets as $snip)
                                                            <span class="inline-block">{!! $snip !!}</span>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if($matchedFields->isNotEmpty())
                                                    <div class="flex flex-wrap items-center gap-1 text-[11px] sm:text-xs text-gray-600 dark:text-slate-400">
                                                        <span class="text-gray-600 dark:text-slate-400">{{ __('Found in:') }}</span>

                                                        @foreach ($matchedFields as $field)
                                                            @php
                                                                $label = __($LABEL_MAP[$field] ?? \Illuminate\Support\Str::headline($field));
                                                                $cls   = $BADGE_CLASSES[$field] ?? 'bg-gray-100 text-gray-800 dark:bg-slate-800 dark:text-slate-200';
                                                            @endphp

                                                            @if ($field === 'tag_names' && $tagForBadge)
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded {{ $cls }} ring-1 ring-black/0 dark:ring-white/5">
                                                                    {{ $label }}
                                                                </span>

                                                            @elseif (in_array($field, ['course_names','course_designation'], true) && $courseForBadge)
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded {{ $cls }} ring-1 ring-black/0 dark:ring-white/5">
                                                                    {{ $label }}
                                                                </span>

                                                            @elseif (in_array($field, ['presenter_names','presenter_usernames'], true) && $presenterForBadge)
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded {{ $cls }} ring-1 ring-black/0 dark:ring-white/5">
                                                                    {{ $label }}:
                                                                    @php
                                                                        $rawNameHtml = $has('presenter_names')
                                                                          ? $firstSnippet('presenter_names', $presenterForBadge->name ?? '')
                                                                          : ($highlightTerms ?? fn($t) => e($t))($presenterForBadge->name ?? '', $searchTerm);
                                                                    @endphp
                                                                    {!! (isset($decorateMarks) && is_callable($decorateMarks))
                                                                        ? $decorateMarks($stripAnchors($rawNameHtml))
                                                                        : $stripAnchors($rawNameHtml) !!}
                                                                </span>

                                                            @else
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded {{ $cls }} ring-1 ring-black/0 dark:ring-white/5">
                                                                    {{ $label }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </a>
                                            @if(isset($editableVideoIds[$video->id]))
                                                @include('livewire.search.result-partials.admin_edit')
                                            @endif
                                        </article>
                                    @endforeach <!-- endforeach videos -->
                                </div>
                            @endif

                            <!-- Empty-state if all buckets empty -->
                            @if(!count($videos) && !count($presenters) && !count($courses) && !count($tags) && !count($channels))
                                <div class="text-sm text-gray-600 dark:text-slate-400">{{ __('No results.') }}</div>
                            @endif

                        </div>
                        <!-- /Results -->
                    </div>
                @endif

            </div>
        </div>
</div>
