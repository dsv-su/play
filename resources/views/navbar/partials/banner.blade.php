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
    <aside x-data="{ visible: true }" x-show="visible" id="play-banner" class="glass-nav-banner" aria-label="{{ __('Announcement') }}">
        <div class="glass-nav-banner-content">
            <p>{{ app()->getLocale() === 'sv' && filled($banner->content_sv) ? $banner->content_sv : $banner->content }}</p>
            @if($banner->link_url)
                <a href="{{ $banner->link_url }}" class="glass-nav-banner-link">
                    {{ $banner->link_text ?? __('Learn more') }} <span aria-hidden="true">&rarr;</span>
                </a>
            @endif
        </div>
        <button @click="visible = false; $refs.navigationHome.focus()" id="play-banner-dismiss" type="button" class="glass-nav-banner-dismiss" aria-label="{{ __('Dismiss announcement') }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" aria-hidden="true"><path d="m6 6 12 12M6 18 18 6" /></svg>
        </button>
    </aside>
@endif
