<div x-ref="navigationDropdown" x-show="navigationMenuOpen" x-cloak
     x-transition:enter="transition ease-out duration-150 motion-reduce:transition-none"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-100 motion-reduce:transition-none"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     @mouseenter="navigationMenuClearCloseTimeout()" @mouseleave="navigationMenuLeave()"
     class="glass-nav-dropdown">
    <div class="glass-nav-surface">
        @foreach($navigationItems as $item)
            @if(isset($item['children']))
                <div id="navigation-dropdown-{{ $item['key'] }}" data-navigation-panel="{{ $item['key'] }}"
                     x-show="navigationMenu === '{{ $item['key'] }}'" class="glass-nav-panel">
                    <p class="glass-nav-eyebrow">{{ $item['label'] }}</p>
                    <div class="glass-nav-cards">
                        @foreach($item['children'] as $child)
                            <a href="{{ route($child['route']) }}" @click="navigationMenuClose()" class="glass-nav-card"
                               @if(request()->routeIs($child['route'])) aria-current="page" @endif>
                                <span class="glass-nav-card-title">{{ $child['label'] }} <span aria-hidden="true">↗</span></span>
                                <span class="glass-nav-description">{{ $child['description'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
