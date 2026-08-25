@php
    $role = app()->make('play_role');
    $banner = \App\Models\Banner::where('visible', true)
        ->where(function($query) use ($role) {
            // General banners (not role-specific)
            $query->where(function($q) {
                $q->where('visible_for_staff', false)
                  ->where('visible_for_student', false);
            });
            // Staff banners
            if ($role === 'Staff' || $role === 'Administrator') {
                $query->orWhere('visible_for_staff', true);
            }
            // Student banners
            if (in_array($role, ['Student', 'Student1', 'Student2', 'Student3']) || $role === 'Administrator') {
                $query->orWhere('visible_for_student', true);
            }
        })
        ->first();
@endphp

@if($banner)
<!-- Banner -->
<div id="play-banner" class="relative isolate flex items-center gap-x-6 overflow-hidden bg-susecondary px-6 py-2.5 sm:px-3.5 sm:before:flex-1">
    <div aria-hidden="true" class="absolute top-1/2 left-[max(-7rem,calc(50%-52rem))] -z-10 -translate-y-1/2 transform-gpu blur-2xl">
        <div style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)" class="aspect-577/310 w-144.25 bg-linear-to-r from-[#ff80b5] to-[#9089fc] opacity-30"></div>
    </div>
    <div aria-hidden="true" class="absolute top-1/2 left-[max(45rem,calc(50%+8rem))] -z-10 -translate-y-1/2 transform-gpu blur-2xl">
        <div style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)" class="aspect-577/310 w-144.25 bg-linear-to-r from-[#ff80b5] to-[#9089fc] opacity-30"></div>
    </div>
    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">

        <p class="text-sm/6 text-gray-900">
            {{ $banner->content }}
        </p>

        @if($banner->link_url)
        <a href="{{ $banner->link_url }}" class="flex-none rounded-full bg-gray-900 px-3.5 py-1 text-sm font-semibold text-white shadow-xs hover:bg-gray-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">
            {{ $banner->link_text ?? 'Learn more' }}
            <span aria-hidden="true">&rarr;</span>
        </a>
        @endif
    </div>
    <div class="flex flex-1 justify-end">
        <button id="play-banner-dismiss" type="button" class="-m-3 p-3 focus-visible:-outline-offset-4">
            <span class="sr-only">Dismiss</span>
            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 text-gray-900">
                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
            </svg>
        </button>
    </div>
</div>
<!-- end Banner -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const banner = document.getElementById('play-banner');
        const btn = document.getElementById('play-banner-dismiss');

        if (banner && btn) {
            btn.addEventListener('click', () => banner.classList.add('hidden'));
        }
    });
</script>
@endif

