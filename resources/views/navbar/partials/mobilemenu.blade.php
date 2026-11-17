<div id="mobile-navigation" x-show="mobileMenuOpen" x-cloak x-transition.opacity.duration.150ms class="glass-nav-mobile glass-nav-surface">
    <ul>
        @foreach($navigationItems as $item)
            <li>
                @if(isset($item['children']))
                    <button type="button" class="glass-nav-link"
                            @click="activeMobileMenu = activeMobileMenu === '{{ $item['key'] }}' ? '' : '{{ $item['key'] }}'"
                            aria-controls="mobile-navigation-{{ $item['key'] }}" :aria-expanded="activeMobileMenu === '{{ $item['key'] }}'">
                        {{ $item['label'] }}
                        @include('navbar.partials.chevron', ['expanded' => "activeMobileMenu === '".$item['key']."'"])
                    </button>
                    <div id="mobile-navigation-{{ $item['key'] }}" x-show="activeMobileMenu === '{{ $item['key'] }}'" class="glass-nav-mobile-children">
                        @foreach($item['children'] as $child)
                            <a href="{{ route($child['route']) }}" class="glass-nav-link" @click="mobileMenuOpen = false; activeMobileMenu = ''"
                               @if(request()->routeIs($child['route'])) aria-current="page" @endif>{{ $child['label'] }}</a>
                        @endforeach
                    </div>
                @else
                    <a href="{{ route($item['route']) }}" class="glass-nav-link" @click="mobileMenuOpen = false; activeMobileMenu = ''"
                       @if(request()->routeIs($item['route'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
