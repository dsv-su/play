<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Tabs -->
    <div class="mb-8 border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
            <button wire:click="$set('activeTab', 'track')"
                    class="{{ $activeTab === 'track'
                        ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}
                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                Track
            </button>
            <button wire:click="$set('activeTab', 'api-logs')"
                    class="{{ $activeTab === 'api-logs'
                        ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}
                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                API Logs
            </button>
            <button wire:click="$set('activeTab', 'banners')"
                    class="{{ $activeTab === 'banners'
                        ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}
                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                Banner Messages
            </button>
            <button wire:click="$set('activeTab', 'categories')"
                    class="{{ $activeTab === 'categories'
                        ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}
                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                Categories
            </button>
            <button wire:click="$set('activeTab', 'settings')"
                    class="{{ $activeTab === 'settings'
                        ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}
                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                Global Settings
            </button>
        </nav>
    </div>

    @if($activeTab === 'track')
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Presentation</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Retrieve detailed information about a presentation by its UUID.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white dark:bg-gray-700 sm:p-6 space-y-6">
                        @if (session()->has('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <div>
                            <label for="trackUuid" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Presentation UUID</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" wire:model.defer="trackUuid" id="trackUuid" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white" placeholder="e.g. 550e8400-e29b-41d4-a716-446655440000">
                                <button wire:click="trackVideo" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search
                                </button>
                            </div>
                            @error('trackUuid') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        @if($videoData)
                            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-600">
                                    {{ $videoData->title ?? 'Untitled Video' }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Internal ID (UUID)</p>
                                        <p class="text-sm text-gray-900 dark:text-white font-mono">{{ $videoData->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">State</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ $videoData->state ?? 'Unknown' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</p>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $videoData->category->category_name ?? 'None' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Origin</p>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $videoData->origin ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created At</p>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $videoData->created_at ? $videoData->created_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Updated At</p>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $videoData->updated_at ? $videoData->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration</p>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $videoData->duration ?? '0' }}s</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Visibility</p>
                                        <p class="text-sm text-gray-900 dark:text-white">
                                            {{ $videoData->visibility ? 'Visible' : 'Hidden' }}
                                            @if($videoData->unlisted) (Unlisted) @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Notification ID</p>
                                        <p class="text-sm text-gray-900 dark:text-white font-mono">{{ $videoData->notification_id ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="mt-6 space-y-4">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Video Stats</p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            <div class="bg-white dark:bg-gray-900 p-3 rounded border border-gray-100 dark:border-gray-800">
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Playback</p>
                                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $videoData->videoStats?->playback ?? 0 }}</p>
                                            </div>
                                            <div class="bg-white dark:bg-gray-900 p-3 rounded border border-gray-100 dark:border-gray-800">
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Downloads</p>
                                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $videoData->videoStats?->download ?? 0 }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Metrics</p>
                                        <div class="overflow-x-auto rounded border border-gray-100 dark:border-gray-800">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs">
                                                <thead class="bg-gray-100 dark:bg-gray-900">
                                                    <tr>
                                                        <th class="px-3 py-2 text-left font-semibold text-gray-600 dark:text-gray-300">Date</th>
                                                        <th class="px-3 py-2 text-left font-semibold text-gray-600 dark:text-gray-300">Name</th>
                                                        <th class="px-3 py-2 text-left font-semibold text-gray-600 dark:text-gray-300">Category</th>
                                                        <th class="px-3 py-2 text-right font-semibold text-gray-600 dark:text-gray-300">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 bg-white dark:bg-gray-900/60">
                                                    @forelse($videoData->metrics as $metric)
                                                        <tr>
                                                            <td class="px-3 py-2 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                                                {{ sprintf('%04d-%02d-%02d', $metric->year, $metric->month, $metric->day) }}{{ $metric->hour !== null ? sprintf(' %02d:00', $metric->hour) : '' }}
                                                            </td>
                                                            <td class="px-3 py-2 text-gray-900 dark:text-white">{{ $metric->name }}</td>
                                                            <td class="px-3 py-2 text-gray-700 dark:text-gray-300">{{ $metric->category ?? 'N/A' }}</td>
                                                            <td class="px-3 py-2 text-right font-semibold text-gray-900 dark:text-white">{{ $metric->value }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="px-3 py-3 text-center text-gray-400 italic">No metric data</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                @if($videoData->metrics->isNotEmpty())
                                                    <tfoot class="bg-gray-100 dark:bg-gray-900">
                                                        <tr>
                                                            <td colspan="3" class="px-3 py-2 font-semibold text-gray-700 dark:text-gray-300">Total</td>
                                                            <td class="px-3 py-2 text-right font-bold text-gray-900 dark:text-white">{{ $videoData->metrics->sum('value') }}</td>
                                                        </tr>
                                                    </tfoot>
                                                @endif
                                            </table>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Presenters</p>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse($videoData->presenters as $presenter)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200" title="{{ $presenter->username }}">
                                                    {{ $presenter->name }}
                                                </span>
                                            @empty
                                                <span class="text-sm text-gray-400 italic">None</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Courses</p>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse($videoData->courses as $course)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                                    {{ $course->name }} ({{ $course->designation }})
                                                </span>
                                            @empty
                                                <span class="text-sm text-gray-400 italic">None</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tags</p>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse($videoData->tags as $tag)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                    {{ $tag->name }}
                                                </span>
                                            @empty
                                                <span class="text-sm text-gray-400 italic">None</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Subtitles</p>
                                        <div class="space-y-1">
                                            @php
                                                $subtitles = is_array($videoData->subtitles) ? $videoData->subtitles : json_decode($videoData->subtitles, true);
                                            @endphp
                                            @forelse($subtitles ?? [] as $lang => $path)
                                                <div class="text-xs bg-white dark:bg-gray-900 p-2 rounded border border-gray-100 dark:border-gray-800 flex justify-between items-center">
                                                    <div>
                                                        <span class="font-bold">{{ $lang }}:</span>
                                                        <span class="text-gray-600 dark:text-gray-400">{{ $path }}</span>
                                                        @if($lang === 'Generated')
                                                            <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                                Generated
                                                            </span>
                                                            @if(isset($videoData->manual_presentation) && $videoData->manual_presentation->generate_subtitles)
                                                                @php
                                                                    $genInfo = $videoData->manual_presentation->generate_subtitles['Generated'] ?? null;
                                                                @endphp
                                                                @if($genInfo)
                                                                    <span class="text-[10px] text-gray-400 ml-1">
                                                                        ({{ ($genInfo['type'] ?? 'unknown') }}{{ isset($genInfo['language']) ? ' : ' . $genInfo['language'] : '' }})
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <span class="text-sm text-gray-400 italic">None</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Streams</p>
                                        <div class="space-y-1">
                                            @forelse($videoData->streams as $stream)
                                                <div class="text-xs bg-white dark:bg-gray-900 p-2 rounded border border-gray-100 dark:border-gray-800">
                                                    <span class="font-bold">Stream ID:</span> {{ $stream->id }} |
                                                    <span class="font-bold">Name:</span> {{ $stream->name }}
                                                    @if($stream->resolutions->isNotEmpty())
                                                        <div class="mt-1 flex flex-wrap gap-1">
                                                            <span class="font-bold mr-1">Resolutions:</span>
                                                            @foreach($stream->resolutions as $res)
                                                                <span class="bg-blue-50 dark:bg-blue-900/20 px-1 rounded text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800">{{ $res->resolution }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @empty
                                                <span class="text-sm text-gray-400 italic">None</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Permissions & Access</p>
                                        <div class="space-y-3">
                                            @if($videoData->permissions->isNotEmpty())
                                                <div>
                                                    <p class="text-[10px] font-semibold text-gray-400 uppercase mb-1">Global Permissions</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($videoData->permissions as $permission)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300">
                                                                {{ $permission->scope }} ({{ $permission->type ?? 'N/A' }})
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if($videoData->status->isNotEmpty())
                                                <div>
                                                    <p class="text-[10px] font-semibold text-gray-400 uppercase mb-1">Video Permissions (Status)</p>
                                                    <div class="space-y-1">
                                                        @foreach($videoData->status as $vp)
                                                            <div class="text-xs bg-white dark:bg-gray-900 p-2 rounded border border-gray-100 dark:border-gray-800">
                                                                <span class="font-bold">Type:</span> {{ $vp->type }} |
                                                                <span class="font-bold">Notification ID:</span> {{ $vp->notification_id }} |
                                                                <span class="font-bold">Permission ID:</span> {{ $vp->permission_id }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if($videoData->individualPermissions->isNotEmpty())
                                                <div>
                                                    <p class="text-[10px] font-semibold text-gray-400 uppercase mb-1">Individual Permissions</p>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                        @foreach($videoData->individualPermissions as $ip)
                                                            <div class="text-[10px] text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 p-1 rounded">
                                                                <span class="font-bold">{{ $ip->username }}:</span> {{ $ip->permission }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if($videoData->coursepermissions->isNotEmpty())
                                                <div>
                                                    <p class="text-[10px] font-semibold text-gray-400 uppercase mb-1">Course Admin Permissions</p>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                        @foreach($videoData->coursepermissions as $cp)
                                                            <div class="text-[10px] text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 p-1 rounded">
                                                                <span class="font-bold">{{ $cp->username }}:</span> {{ $cp->permission }} ({{ $cp->name }})
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            @if($videoData->permissions->isEmpty() && $videoData->status->isEmpty() && $videoData->individualPermissions->isEmpty() && $videoData->coursepermissions->isEmpty())
                                                <span class="text-sm text-gray-400 italic">No permissions defined</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($videoData->description)
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Description</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 p-3 rounded border border-gray-100 dark:border-gray-800">
                                            {{ $videoData->description }}
                                        </p>
                                    </div>
                                    @endif

                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Raw Sources</p>
                                        <pre class="text-[10px] text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-900 p-2 rounded overflow-x-auto">{{ json_encode($videoData->sources, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($activeTab === 'banners')
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Banner Messages</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Create and manage banner messages displayed at the top of the page.
                </p>
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white dark:bg-gray-700 space-y-6 sm:p-6">
                    <!-- Banner List -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900 dark:text-white">Existing Banners</h4>
                        @forelse($banners as $banner)
                            <div class="flex items-center justify-between p-4 border rounded-lg {{ $banner->visible ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-600' }}">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold dark:text-white">{{ $banner->content }}</p>
                                    @if($banner->content_sv)
                                        <p class="text-sm text-gray-600 dark:text-gray-300"><span class="font-medium">Swedish:</span> {{ $banner->content_sv }}</p>
                                    @endif
                                    @if($banner->link_url)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $banner->link_text ?? 'Link' }}: {{ $banner->link_url }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex flex-col items-end mr-2 text-[10px] text-gray-500 dark:text-gray-400">
                                        @if($banner->visible_for_staff) <span class="bg-purple-100 dark:bg-purple-900/30 px-1 rounded text-purple-700 dark:text-purple-400">Staff</span> @endif
                                        @if($banner->visible_for_student) <span class="bg-green-100 dark:bg-green-900/30 px-1 rounded text-green-700 dark:text-green-400">Student</span> @endif
                                    </div>
                                    <button wire:click="toggleBanner({{ $banner->id }})" class="px-3 py-1 text-xs rounded-full {{ $banner->visible ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-600 dark:text-gray-300' }}">
                                        {{ $banner->visible ? 'Enabled' : 'Disabled' }}
                                    </button>
                                    <button wire:click="editBanner({{ $banner->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs">Edit</button>
                                    <button wire:click="deleteBanner({{ $banner->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-xs" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No banners created yet.</p>
                        @endforelse
                    </div>

                    <hr class="dark:border-gray-600">

                    <!-- Create/Edit Form -->
                    <div>
                        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">{{ $editingBannerId ? 'Edit Banner' : 'Create New Banner' }}</h4>
                        <form wire:submit.prevent="{{ $editingBannerId ? 'updateBanner' : 'createBanner' }}">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Message Content (English)</label>
                                    <textarea id="content" wire:model.defer="{{ $editingBannerId ? 'editBannerContent' : 'newBannerContent' }}" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    @error($editingBannerId ? 'editBannerContent' : 'newBannerContent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-6">
                                    <label for="content_sv" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Message Content (Swedish)</label>
                                    <textarea id="content_sv" wire:model.defer="{{ $editingBannerId ? 'editBannerContentSv' : 'newBannerContentSv' }}" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">The English message is used if this translation is left empty.</p>
                                    @error($editingBannerId ? 'editBannerContentSv' : 'newBannerContentSv') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-3">
                                    <label for="link_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link URL (Optional)</label>
                                    <input type="text" id="link_url" wire:model.defer="{{ $editingBannerId ? 'editBannerLinkUrl' : 'newBannerLinkUrl' }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error($editingBannerId ? 'editBannerLinkUrl' : 'newBannerLinkUrl') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-3">
                                    <label for="link_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link Text (Optional)</label>
                                    <input type="text" id="link_text" wire:model.defer="{{ $editingBannerId ? 'editBannerLinkText' : 'newBannerLinkText' }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>

                                <div class="col-span-6 space-y-4">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="visible" wire:model.defer="{{ $editingBannerId ? 'editBannerVisible' : 'newBannerVisible' }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="visible" class="font-medium text-gray-700 dark:text-gray-300">Visible</label>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs">Enable this banner message.</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="visible_for_staff" wire:model.defer="{{ $editingBannerId ? 'editBannerVisibleForStaff' : 'newBannerVisibleForStaff' }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="visible_for_staff" class="font-medium text-gray-700 dark:text-gray-300">Visible for Staff</label>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs">Only show to Staff</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="visible_for_student" wire:model.defer="{{ $editingBannerId ? 'editBannerVisibleForStudent' : 'newBannerVisibleForStudent' }}" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="visible_for_student" class="font-medium text-gray-700 dark:text-gray-300">Visible for Students</label>
                                            <p class="text-gray-500 dark:text-gray-400 text-xs">Only show to Students.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex justify-end">
                                @if($editingBannerId)
                                    <button type="button" wire:click="$set('editingBannerId', null)" class="mr-2 bg-white dark:bg-gray-800 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                                @endif
                                <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ $editingBannerId ? 'Update Banner' : 'Create Banner' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($activeTab === 'categories')
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Categories</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Create and update presentation categories used across upload, edit, and browsing views.
                </p>
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white dark:bg-gray-700 space-y-6 sm:p-6">
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900 dark:text-white">Existing Categories</h4>
                        @forelse($categories as $category)
                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                                <div>
                                    <p class="text-sm font-semibold dark:text-white">{{ $category->category_name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $category->id }}</p>
                                </div>
                                <button wire:click="editCategory({{ $category->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs">Edit</button>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">No categories created yet.</p>
                        @endforelse
                    </div>

                    <hr class="dark:border-gray-600">

                    <div>
                        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">{{ $editingCategoryId ? 'Edit Category' : 'Create New Category' }}</h4>
                        <form wire:submit.prevent="{{ $editingCategoryId ? 'updateCategory' : 'createCategory' }}">
                            <div>
                                <label for="category_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                                <input type="text" id="category_name" wire:model.defer="{{ $editingCategoryId ? 'editCategoryName' : 'newCategoryName' }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @error($editingCategoryId ? 'editCategoryName' : 'newCategoryName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-4 flex justify-end">
                                @if($editingCategoryId)
                                    <button type="button" wire:click="$set('editingCategoryId', null)" class="mr-2 bg-white dark:bg-gray-800 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                                @endif
                                <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ $editingCategoryId ? 'Update Category' : 'Create Category' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($activeTab === 'settings')
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Global Settings</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Configure general application settings.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white dark:bg-gray-700 sm:p-6">
                        TODO
                        {{--}}
                        @if($settings && count($settings) > 0)
                            <div class="space-y-6">
                                @foreach($settings as $index => $setting)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $setting->name }}</label>
                                        <div class="mt-1">
                                            <input type="text" wire:model.defer="settings.{{ $index }}.value" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md">
                                        </div>
                                        @if($setting->description)
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 text-xs italic">{{ $setting->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button wire:click="saveSettings" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save Settings
                                </button>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No global settings defined yet.</p>
                        @endif
                        {{--}}
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endif

    @if($activeTab === 'api-logs')
        <div class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">API Logs</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Incoming API requests, newest first. Open an entry to inspect its complete payload.
                    </p>
                </div>

                @if($apiLogs->total() > 0)
                    <button type="button" wire:click="clearLogs"
                            wire:confirm="Delete all API log entries? This cannot be undone."
                            class="inline-flex shrink-0 items-center justify-center rounded-md border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-700 shadow-sm hover:bg-red-50 dark:border-red-700 dark:bg-gray-800 dark:text-red-300 dark:hover:bg-red-900/20">
                        Clear all logs
                    </button>
                @endif
            </div>

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="hidden grid-cols-12 gap-4 border-b border-gray-200 bg-gray-50 px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:border-gray-700 dark:bg-gray-900/50 dark:text-gray-400 md:grid">
                    <div class="col-span-2">Received</div>
                    <div class="col-span-3">Job ID</div>
                    <div class="col-span-4">Package ID</div>
                    <div class="col-span-2">Payload</div>
                    <div class="col-span-1 text-right">Action</div>
                </div>

                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($apiLogs as $log)
                        @php
                            $payload = $log->catch;
                            while (is_string($payload)) {
                                $decodedPayload = json_decode($payload, true);
                                if (json_last_error() !== JSON_ERROR_NONE) {
                                    break;
                                }
                                $payload = $decodedPayload;
                            }
                            $payload = is_array($payload) ? $payload : [];
                            $payloadJson = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                        @endphp
                        <details class="group px-5 py-4" wire:key="api-log-{{ $log->id }}">
                            <summary class="grid cursor-pointer list-none grid-cols-1 gap-3 md:grid-cols-12 md:items-center md:gap-4 [&::-webkit-details-marker]:hidden">
                                <div class="md:col-span-2">
                                    <span class="block text-xs font-semibold uppercase text-gray-400 md:hidden">Received</span>
                                    <time datetime="{{ $log->created_at?->toIso8601String() }}" class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $log->created_at?->format('Y-m-d H:i:s') ?? 'Unknown' }}
                                    </time>
                                </div>
                                <div class="min-w-0 md:col-span-3">
                                    <span class="block text-xs font-semibold uppercase text-gray-400 md:hidden">Job ID</span>
                                    <span class="block truncate font-mono text-sm text-gray-900 dark:text-white" title="{{ $log->jobid }}">
                                        {{ $log->jobid ?: '—' }}
                                    </span>
                                </div>
                                <div class="min-w-0 md:col-span-4">
                                    <span class="block text-xs font-semibold uppercase text-gray-400 md:hidden">Package ID</span>
                                    <span class="block truncate font-mono text-sm text-gray-900 dark:text-white" title="{{ $log->pk_id }}">
                                        {{ $log->pk_id ?: '—' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 md:col-span-2">
                                    <span class="rounded-full bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300">
                                        {{ count($payload) }} {{ \Illuminate\Support\Str::plural('field', count($payload)) }}
                                    </span>
                                    <span class="text-xs text-gray-500 group-open:hidden">View</span>
                                    <span class="hidden text-xs text-gray-500 group-open:inline">Hide</span>
                                </div>
                                <div class="md:col-span-1 md:text-right" @click.stop>
                                    <button type="button" wire:click="deleteLog({{ $log->id }})"
                                            wire:confirm="Delete this API log entry?"
                                            class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        Delete
                                    </button>
                                </div>
                            </summary>

                            <div class="mt-4 border-t border-gray-100 pt-4 dark:border-gray-700">
                                <h4 class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Request payload</h4>
                                <pre class="max-h-96 overflow-auto whitespace-pre-wrap break-words rounded-md bg-gray-950 p-4 text-xs leading-5 text-gray-100"><code>{{ $payloadJson ?: '{}' }}</code></pre>
                            </div>
                        </details>
                    @empty
                        <div class="px-6 py-14 text-center">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">No API logs found</p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">New incoming API requests will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($apiLogs->hasPages())
                <div>{{ $apiLogs->links() }}</div>
            @endif
        </div>
    @endif
</div>
