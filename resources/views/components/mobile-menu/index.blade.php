<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu hidden lg:hidden fixed inset-0 bg-slate-900 text-white z-50 overflow-y-auto" style="background-color: #1E3A8A;">
    <!-- Header -->
    <div class="flex h-[70px] items-center px-4 sm:px-8 justify-between border-b border-slate-700 lg:hidden">
        <a href="{{ route('dashboard-overview') }}" class="flex items-center gap-2">
            <span class="font-semibold text-lg">Quản lý thiên tai</span>
        </a>
        <span role="button" class="mobile-menu-close cursor-pointer"
      onclick="document.querySelector('.mobile-menu')?.classList.add('hidden')">
    {!! $icons['x-circle'] !!}
    </span>

    </div>

    <!-- Menu list -->
    <ul class="py-4 px-4 space-y-2">
        @if (!empty($mainMenu))
            @foreach ($mainMenu as $menu)
                @if ($menu === 'divider')
                    <li class="my-6 border-t border-slate-700"></li>
                @else
                    <li>
                        <a class="flex items-center justify-between px-4 py-3 hover:bg-slate-700 rounded transition {{ isset($menu['sub_menu']) ? 'toggle-submenu' : '' }}"
                           href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params'] ?? []) : 'javascript:;' }}">
                            <div class="flex items-center gap-2">
                                {!! $icons[$menu['icon']] ?? '' !!}
                                <span>{{ $menu['title'] }}</span>
                            </div>
                            @if (isset($menu['sub_menu']))
                                {!! $icons['chevron-down'] ?? '' !!}
                            @endif
                        </a>

                        @if (isset($menu['sub_menu']))
                            <ul class="submenu ml-4 mt-1 hidden space-y-1">
                                @foreach ($menu['sub_menu'] as $subMenu)
                                    <li>
                                        <a class="flex items-center justify-between px-4 py-2 text-sm hover:bg-slate-700 rounded transition {{ isset($subMenu['sub_menu']) ? 'toggle-submenu' : '' }}"
                                           href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params'] ?? []) : 'javascript:;' }}">
                                            <div class="flex items-center gap-2">
                                                {!! $icons[$subMenu['icon']] ?? '' !!}
                                                <span>{{ $subMenu['title'] }}</span>
                                            </div>
                                            @if (isset($subMenu['sub_menu']))
                                                {!! $icons['chevron-down'] ?? '' !!}
                                            @endif
                                        </a>

                                        @if (isset($subMenu['sub_menu']))
                                            <ul class="submenu ml-4 mt-1 hidden space-y-1">
                                                @foreach ($subMenu['sub_menu'] as $lastSubMenu)
                                                    <li>
                                                        <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params'] ?? []) : 'javascript:;' }}"
                                                           class="flex items-center px-4 py-2 text-sm hover:bg-slate-700 rounded transition">
                                                            {!! $icons[$lastSubMenu['icon']] ?? '' !!}
                                                            <span class="ml-2">{{ $lastSubMenu['title'] }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
<!-- END: Mobile Menu -->

<!-- BEGIN: Mobile Menu Toggle Button -->
<div class="flex h-[10px] items-center px-3 sm:px-8 md:hidden" >
    <a class="mr-auto flex" href="{{ route('dashboard-overview') }}">
        <img class="w-6" src="{{ Vite::asset('resources/images/logo.svg') }}" alt="Logo" />
    </a>
    <a class="mobile-menu-toggler text-white" href="#" onclick="document.querySelector('.mobile-menu')?.classList.remove('hidden')">
        {!! $icons['menu'] ?? '' !!}
    </a>
</div>
<!-- END: Toggle Button -->

@pushOnce('styles')
    @vite('resources/css/vendors/simplebar.css')
    @vite('resources/css/components/mobile-menu.css')
@endPushOnce

@pushOnce('vendors')
    @vite('resources/js/vendors/simplebar.js')
@endPushOnce


