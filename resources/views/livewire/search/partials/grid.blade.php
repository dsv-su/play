<div wire:key="grid-{{ $courseId }}-{{ (int) $switchOn }}"
     class="px-4 sm:px-6 lg:px-8 lg:py-8 mx-auto">
    <!-- Grid wrapper -->
    <section class="px-3 md:px-4">
        <div class="grid gap-4 grid-cols-[repeat(auto-fill,minmax(14rem,1fr))] [grid-auto-flow:row_dense]">
            @foreach($group as $key => $video)
                @include('home.partials.presentation', ['video' => $video])
            @endforeach
        </div>
    </section>
</div>
