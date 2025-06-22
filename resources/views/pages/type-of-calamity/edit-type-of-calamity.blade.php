@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Loại Hình Thiên Tai - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['chevron-right'] !!}
        Cập Nhật Loại Hình Thiên Tai
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-type-of-calamity') }}"
                method="post">
                <input type="hidden" name="id" value="{{ $calamity->id }}">
                @csrf
                <!-- BEGIN: Thông Tin Loại Hình Thiên Tai -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            {!! $icons['chevron-down'] !!} Thông Tin Loại Hình Thiên Tai
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Loại Hình Thiên Tai</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="name" id="name" type="text"
                                        placeholder="Tên Loại Hình Thiên Tai" value="{{ $calamity->name }}" />
                                    <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mô Tả</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="description" id="description" type="text"
                                        placeholder="Mô Tả" value="{{ $calamity->description }}" />
                                    <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Thông Tin Loại Hình Thiên Tai -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-type-of-calamity') }}">
                        <button type="button"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">Huỷ
                            Bỏ</button>
                    </a>
                    @auth
                        <button class="w-full py-3 md:w-52" type="submit" variant="primary">
                            Lưu
                        </button>
                    @endauth
                </div>
            </form>
        </div>
    </div>
@endsection
