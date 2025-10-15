<section class="px-4 py-2 lg:px-0">
    <div class="mx-auto max-w-7xl">
        <div class="flex justify-center">
            <nav class="flex flex-wrap items-center" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2 lg:space-x-4">
                    @foreach(Statamic::tag('nav:breadcrumbs') as $p)
                        <li>
                            <div class="flex items-center">
                                @if(!$loop->first)
                                    <svg class="w-2 h-2 lg:w-3 lg:h-3 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="m1 9 4-4-4-4"/>
                                    </svg>
                                @endif
                                <a href="{{ $p->url }}"
                                   class="ml-2 lg:ml-3 text-xs lg:text-sm font-medium
                                            @if($p->is_current)
                                                text-blue-500 dark:text-gray-200
                                            @else
                                                text-gray-500 dark:text-gray-400
                                            @endif
                                            hover:scale-95 hover:text-gray-700 dark:hover:text-gray-200">
                                    {{ $p->title }}
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</section>
