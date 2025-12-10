<div class="space-y-4">
    <p class="text-sm text-start text-neutral-500">{{__("Select a default subtitle language for your direct link.")}}</p>
    @if(json_decode($video->subtitles))
        @foreach(json_decode($video->subtitles) as $key => $subtitle)
            <div class="relative">
                <input type="checkbox" id="subs-{{$video->id}}-checkbox" value="" class="hidden peer" required="">
                <label for="alpine-checkbox"
                       class="inline-flex items-center justify-between w-1/2 p-3 bg-white border-2 rounded-lg cursor-pointer group border-neutral-200/70
                       text-neutral-600 peer-checked:border-blue-600 peer-checked:text-neutral-900 peer-checked:bg-blue-50/50 hover:text-neutral-900">
                    <div class="flex items-center space-x-5">
                        <div class="flex flex-col justify-start">
                            <div class="w-full text-sm text-blue-500">{{$key}}</div>
                        </div>
                    </div>
                </label>
            </div>
        @endforeach
    @endif
</div>
