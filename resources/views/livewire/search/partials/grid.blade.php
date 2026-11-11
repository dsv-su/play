<div wire:key="grid-{{ $courseId }}-{{ (int) $switchOn }}"
     class="w-full min-w-0 px-2 py-3 sm:px-4 lg:px-6 mx-auto">
    <!-- Grid wrapper -->
    <section class="min-w-0">
        <div class="grid gap-4 grid-cols-[repeat(auto-fill,minmax(min(100%,14rem),1fr))] [grid-auto-flow:row_dense]">
            @foreach($group as $key => $video)
                @include('home.partials.presentation', ['video' => $video])
            @endforeach
        </div>
    </section>
</div>
