@extends('../themes/base')
@php
    $activeTheme = $activeTheme ?? 'default-theme';
    $activeLayout = $activeLayout ?? 'default-layout';
@endphp
@section('head')
    <title>Error Page - Dashboard - PCTT Cà Mau</title>
@endsection

@section('content')
    <div class="bg-gradient-to-b from-theme-1 to-theme-2 min-h-screen flex items-center justify-center text-center">
        <div>
            
            <div class="flex flex-col items-center justify-center">
                
                <img class="w-full max-w-[220px] sm:max-w-[300px] md:max-w-[500px] h-auto"
                src="{{ Vite::asset('resources/images/logo-camau.png') }}"
                alt="Dashboard - PCTT Cà Mau" />
                
                <div class="text-white text-2xl font-medium mt-5">
                    Có thể bạn đã gõ sai địa chỉ hoặc trang không tồn tại.
                </div>
                
                <button as="a" href="{{ url('/') }}"
                    class="mt-8 border-white px-4 py-3 text-white">
                    Quay trở lại trang chủ
                </button>
            </div>
            
        </div>
    </div>
@endsection
