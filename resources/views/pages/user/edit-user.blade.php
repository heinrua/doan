@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Người Dùng - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['user'] !!}
        Cập Nhật Người Dùng
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <!-- BEGIN: User Information -->
            <form class="validate-form" action="{{ route('update-user') }}" method="post">
                <input type="hidden" name="id" value="{{ $userData->id }}">
                @csrf
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            Thông Tin Người Dùng
                        </div>
                        <div class="mt-5">
                            <div>
                                <label class="md:w-64">
                                    <div class="text-left">

                                        <div class="flex items-center">
                                            <div class="font-medium">Tên</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input  name="name" id="name" type="text" placeholder="Tên"
                                        value="{{ $userData->user_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                
                                </div>
                        </div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Đăng Nhập</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="user_name" id="user_name" type="text" value="{{ $userData->user_name }}" placeholder="Tên Đăng Nhập" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                                    
                                </div>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
                <!-- END: User Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-user') }}">
                        <button type="button"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Huỷ Bỏ</button>
                    </a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
