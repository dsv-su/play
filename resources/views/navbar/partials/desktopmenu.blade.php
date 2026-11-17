<ul class="glass-nav-desktop">
    @foreach($navigationItems as $item)
        <li>
            @if(isset($item['children']))
                <button type="button" class="glass-nav-link"
                        aria-controls="navigation-dropdown-{{ $item['key'] }}"
                        :aria-expanded="navigationMenuOpen && navigationMenu === '{{ $item['key'] }}'"
                        @click="$event.detail === 0 ? navigationMenuToggle($el, '{{ $item['key'] }}') : navigationMenuOpenFor($el, '{{ $item['key'] }}')"
                        @keydown.arrow-down.prevent="navigationMenuOpenFor($el, '{{ $item['key'] }}', true)"
                        @mouseenter="navigationMenuOpenFor($el, '{{ $item['key'] }}')"
                        @mouseleave="navigationMenuLeave()">
                    {{ $item['label'] }}
                    @include('navbar.partials.chevron', ['expanded' => "navigationMenuOpen && navigationMenu === '".$item['key']."'"])
                </button>
            @else
                <a href="{{ route($item['route']) }}" class="glass-nav-link"
                   @mouseenter="navigationMenuClose()"
                   @if(request()->routeIs($item['route'])) aria-current="page" @endif>{{ $item['label'] }}</a>
            @endif
        </li>
    @endforeach
</ul>
