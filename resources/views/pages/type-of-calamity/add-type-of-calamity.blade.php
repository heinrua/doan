@extends('themes.base')

@section('subhead')
    <title>Tạo Loại Hình Thiên Tai - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['chevron-right'] !!}
        Tạo Loại Hình Thiên Tai
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/create-type-of-calamity" method="post">
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
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Loại Hình Thiên Tai</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="name" id="name" type="text"
                                        placeholder="Tên Loại Hình Thiên Tai" />
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mô Tả</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="description" id="description" type="text"
                                        placeholder="Mô Tả" />
                                    <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Product Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <button class="w-full py-3 md:w-52" type="submit" variant="primary">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
