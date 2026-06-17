@if($video->permission_type == 'dsv')
    <span
        role="img"
        aria-label="{{ __('Permission: DSV') }}"
        class="inline-flex size-6 items-center justify-center text-white drop-shadow"
        data-tooltip-target="dsv-tooltip"
        data-tooltip-placement="top"
        title="DSV">
        <svg class="mt-1 shrink-0 size-4 text-white dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
    </span>
@elseif($video->permission_type == 'dsv_staff')
    <span
        role="img"
        aria-label="{{ __('Permission: Staff') }}"
        class="inline-flex size-6 items-center justify-center text-white drop-shadow"
        data-tooltip-target="staff-tooltip"
        data-tooltip-placement="top"
        title="Staff">
        <svg class="w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z"/>
        </svg>
    </span>

@elseif($video->permission_type == 'public')
    <span
        role="img"
        aria-label="{{ __('Permission: Public') }}"
        class="inline-flex size-6 items-center justify-center text-white drop-shadow"
        data-tooltip-target="public-tooltip"
        data-tooltip-placement="top"
        title="Public">
        <svg class="w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14v3m4-6V7a3 3 0 1 1 6 0v4M5 11h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
        </svg>

    </span>
@elseif($video->permission_type == 'custom')
    <span
        role="img"
        aria-label="{{ __('Permission: Custom') }}"
        class="inline-flex size-6 items-center justify-center text-white drop-shadow"
        data-tooltip-target="custom-tooltip"
        data-tooltip-placement="top"
        title="Custom">
        <svg class="w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-7a1 1 0 0 1 1-1Z"/>
        </svg>

    </span>
@endif
@if($video->hidden && $video->unlisted == false)
    <span
        role="img"
        aria-label="{{ __('Presentation is hidden') }}"
        class="inline-flex size-6 items-center justify-center text-white drop-shadow"
        data-tooltip-target="visibility-tooltip"
        data-tooltip-placement="top"
        title="Hidden">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-width="1.4" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
            <path stroke="currentColor" stroke-width="1.4" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        </svg>
    </span>
@endif

@if($video->unlisted)
    <span
        role="img"
        aria-label="{{ __('Presentation is unlisted') }}"
        class="inline-flex size-6 items-center justify-center text-white drop-shadow"
        data-tooltip-target="unlisted-tooltip"
        data-tooltip-placement="top"
        title="Unlisted">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"
                  d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        </svg>
    </span>

@endif

@if(json_decode($video->subtitles))
    <span
        role="img"
        aria-label="{{ __('Presentation has subtitles') }}"
        class="inline-flex size-6 items-center justify-center text-white drop-shadow"
        data-tooltip-target="subtitle-tooltip"
        data-tooltip-placement="top"
        title="Subtitles">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4"
                  d="M10.855 14.322a2.475 2.475 0 1 1 .133-4.241m6.053 4.241a2.475 2.475 0 1 1 .133-4.241M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
        </svg>
    </span>
@endif
