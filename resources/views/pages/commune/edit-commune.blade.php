@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Xã Phường - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['home'] !!}
        Cập Nhật Xã Phường
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-commune') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $commune->id }}">
                <!-- BEGIN: Cập Nhật Xã Phường -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            {!! $icons['chevron-down'] !!} Thông Tin Xã Phường
                        </div>
                        {{-- Tên Xã Phường --}}
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0">
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Xã Phường</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="name" id="name" type="text"
                                        placeholder="Tên Xã Phường" value="{{ $commune->name }}" class="w-full" />
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Mã --}}
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0">
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mã</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="code" id="code" type="text"
                                        placeholder="Mã Xã Phường" value="{{ $commune->code }}" class="w-full" />
                                    @error('code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Toạ Độ --}}
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0">
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Toạ Độ</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="coordinates" id="coordinates" type="text"
                                        placeholder="Toạ Độ" value="{{ $commune->coordinates }}" class="w-full" />
                                    @error('coordinates')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Quận Huyện --}}
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0">
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Quận Huyện</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <select id="crud-form-2" name="district_id" class="w-full">
                                        <option value="">Chọn Quận/Huyện</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $commune->district_id == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Cập Nhật Xã Phường -->

                {{-- Nút Lưu & Huỷ --}}
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-commune') }}" class="w-full md:w-auto">
                        <button type="button"
                            class="w-full md:w-auto border border-slate-300 py-3 px-6 rounded-md text-slate-500 hover:bg-gray-100 dark:border-darkmode-400">
                            Huỷ Bỏ
                        </button>
                    </a>
                    @if ($userCurrent->is_master || $userCurrent->hasPermission('update-commune'))
                        <button class="w-full md:w-auto px-6 py-3" type="submit" variant="primary">
                            Lưu
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
