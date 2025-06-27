<!DOCTYPE html>
<html class="opacity-0" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="LEFT4CODE">
    @yield('head')

    <!-- BEGIN: CSS Assets-->
    @stack('styles')
    <!-- END: CSS Assets-->

    
    <!-- BEGIN: Vendor JS Assets-->
    @vite('resources/js/vendors/dom.js')
    
    @stack('vendors')
    <!-- END: Vendor JS Assets-->

    <!-- BEGIN: Pages, layouts, components JS Assets-->
    @vite('resources/js/components/base/theme-color.js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @vite('resources/css/themes/rubick/side-nav.css')
    @vite('resources/js/themes/rubick.js')
    @stack('scripts')
</head>
<!-- END: Head -->

<body style="background-color: #1E3A8A;">

    <div class=" px-5 sm:px-8 py-5 ">
        <!-- BEGIN: Mobile Menu -->
        <x-mobile-menu/>
        <div class="mt-7 flex md:mt-0">
            <!-- BEGIN: Side Menu -->
            <nav class=" hidden w-[80px] overflow-x-hidden pb-16 pr-5 md:block xl:w-[230px]">
                <a class="intro-x flex items-center pl-5 pt-4" href="/">
                    <span class=" lg:text-2xl xl:text-3xl  font-bold uppercase text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-emerald-600">Quản lý thiên tai</span>
                </a>
                <div class=" my-3"></div>
                <ul >
                    @if (!empty($mainMenu))
                    @foreach ($mainMenu as $menuKey => $menu)
                        @if ($menu == 'divider')
                            <li class="my-6 border-t border-slate-700"></li>
                        @else
                            <li>
                                <a class="flex items-center justify-between px-4 py-3 hover:bg-white hover:text-black text-white transition rounded cursor-pointer {{ isset($menu['sub_menu']) ? 'toggle-submenu' : '' }}"
                                    href="{{ isset($menu['route_name']) ? route($menu['route_name'], isset($menu['params']) ? $menu['params'] : []) : 'javascript:;' }}">
                                    
                                    <div class="flex items-center gap-2" title="{{ $menu['title'] }}">
                                        <div title="{{ $menu['title'] }}">{!! $icons[$menu['icon']] !!}</div>
                                        <span class="hidden xl:inline" >{{ $menu['title'] }}</span>
                                    </div>

                                    @if (isset($menu['sub_menu']))
                                        <span class="hidden xl:inline">{!! $icons['chevron-down'] !!}</span>
                                    @endif
                                </a>
                                @if (isset($menu['sub_menu']))
                                    <ul class="submenu ml-6 mt-1 hidden">
                                        @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                            <li  class="group relative">
                                                <a class="flex items-center justify-between px-4 py-2 text-sm text-slate-300 hover:text-white hover:bg-slate-700 rounded transition {{ isset($subMenu['sub_menu']) ? 'toggle-submenu' : '' }}"
                                                    href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], isset($subMenu['params']) ? $subMenu['params'] : []) : 'javascript:;' }}">
                                                   <div class="flex items-center gap-2">
                                                        {!! $icons[$subMenu['icon']] !!}
                                                        <span class="hidden xl:inline">{{ $subMenu['title'] }}</span>
                                                    </div>
                                                    @if (isset($subMenu['sub_menu']))
                                                        {!! $icons['chevron-down'] !!}
                                                    @endif
                                                </a>
                                                @if (isset($subMenu['sub_menu']))
                                                    <ul class="submenu ml-5 mt-1 hidden">
                                                        @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                            <li>
                                                                <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], isset($lastSubMenu['params']) ? $lastSubMenu['params'] : []) : 'javascript:;' }}"
                                                                    class="flex items-center px-4 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-700 rounded transition">
                                                                    {!! $icons['last-sub-menu'] !!}
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
            </nav>
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="md:max-w-auto overflow-x-hidden overflow-y-auto max-h-[100vh] min-w-0 max-w-full flex-1 rounded-[30px] bg-slate-100 px-4 pb-10 before:block before:h-px before:w-full before:content-[''] md:px-[22px]">
                <!-- BEGIN: Top Bar -->
                <div class="relative sticky top-0 z-2 flex items-center h-[68px] px-4 border-b border-slate-100 bg-slate-100">
  
                    <div class="mr-auto"> 
                       <div class="rounded-[8px] overflow-hidden w-[200px] md:w-[325px] h-[40px] bg-[#1E3A8A] border-[2px] border-[#133086] shadow-[0_2px_6px_rgba(0,0,0,0.1)] flex items-center justify-center">
                    <!--Begin thoitiet.app widget -->
                    <iframe src="https://thoitiet247.vn/widget/embed/ca-mau?style=6&day=7&td=%232e0000&ntd=%231e3a8a&mvb=%23000205&mv=%231e3a8a&mdk=%23000000&htd=true" 
                        id="widgeturl" class = "w-[200px] md:w-[325px]" height="55px" scrolling="no" frameborder="0" allowtransparency="true" style="border:none;overflow:hidden;"></iframe><!-- End thoitiet.app widget -->
                    </div>


                    </div>
                    
                    <!-- BEGIN: Account Menu -->
                    <div class="relative">
                        @auth
                            <!-- Nếu đã đăng nhập -->
                            <button type="button" style="all: unset" id="user-menu-button" aria-expanded="false">
                                {!! $icons['user-circle'] !!}
                            </button>

                            <div class="hidden absolute right-0 mt-2 w-48 z-1 text-base bg-white divide-y divide-gray-100 rounded-lg shadow-lg" id="user-dropdown">
                                <div class="px-4 py-3">
                                    <span class="block text-sm text-gray-900">Tên: {{ Auth::user()->full_name ?? 'user' }}</span>
                                    <span class="block text-sm text-gray-500 truncate">Tên đăng nhập: {{ Auth::user()->user_name ?? '' }}</span>
                                </div>
                                <ul class="py-2" aria-labelledby="user-menu-button">
                                    <li>
                                        <a href="{{ route('edit-profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hồ sơ</a>
                                    </li>
                                   
                                    <li>
                                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
                        @endauth

                        @guest
                            <!-- Nếu chưa đăng nhập -->
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:underline">
                                <button>Đăng nhập</button>
                            </a>
                        @endguest
                    </div>
                    <!-- END: Account Menu -->
                </div>
                
                @yield('subcontent')
            </div>
            <!-- END: Content -->
        </div>
    </div>

    
</body>

</html>

<script>
    
    document.addEventListener("DOMContentLoaded", function () {
        const toggles = document.querySelectorAll('.toggle-submenu');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;

                // Đóng các submenu khác (tùy chọn)
                document.querySelectorAll('.submenu').forEach(sm => {
                    if (sm !== submenu) sm.classList.add('hidden');
                });

                // Toggle submenu hiện tại
                if (submenu && submenu.classList.contains('submenu')) {
                    submenu.classList.toggle('hidden');
                }
            });
        });
         const btn = document.getElementById('user-menu-button');
    const dropdown = document.getElementById('user-dropdown');

    if (btn && dropdown) {
      btn.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
      });

      document.addEventListener('click', function (e) {
        if (!dropdown.classList.contains('hidden') &&
            !dropdown.contains(e.target) &&
            !btn.contains(e.target)) {
          dropdown.classList.add('hidden');
        }
      });
    }
    });
</script>
