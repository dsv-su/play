<div class="space-y-4">
    <p class="text-sm text-start text-neutral-500">
        {{ __("Select a default subtitle language for your direct link.") }}
    </p>

    @php
        $subtitles = json_decode($video->subtitles ?? '[]', true);
    @endphp

    @if(!empty($subtitles))
        <div class="grid gap-2 sm:grid-cols-2">
            @foreach($subtitles as $key => $subtitle)
                @php
                    $id = 'subtitle-'.$video->id.'-'.$loop->index;
                @endphp

                <div class="relative">

                    <input type="radio" id="{{ $id }}" name="subtitle_default" value="{{ $key }}" class="peer sr-only">

                    <label for="{{ $id }}"
                        class="flex items-center gap-3 w-full rounded-xl border border-neutral-200/80 bg-white px-3 py-2 cursor-pointer
                               text-xs sm:text-sm text-neutral-700
                               shadow-sm hover:shadow-md hover:border-blue-300
                               transition-all duration-150
                               peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700
                               [&_.radio-dot]:opacity-0 [&_.radio-dot]:scale-50
                               peer-checked:[&_.radio-dot]:opacity-100 peer-checked:[&_.radio-dot]:scale-100">

                        <span class="flex items-center justify-center h-4 w-4 rounded-full border border-neutral-400
                                   transition-colors duration-150
                                   peer-checked:border-blue-600">

                            <span class="radio-dot h-2 w-2 rounded-full bg-blue-600 transition-all duration-150"></span>
                        </span>

                        <span class="truncate">{{ $key }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    @endif
</div>

