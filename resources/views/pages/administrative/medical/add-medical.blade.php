@extends('themes.base')

@section('subhead')
    <title>Tạo Mới Địa Điểm Y Tế - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['aperture'] !!}
        Tạo Mới Địa Điểm Y Tế
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/administrative/create-medical" method="post">
                @csrf
                <input type="hidden" name="type" value="medical">
                <!-- BEGIN: Flooding Information -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            {!! $icons['chevron-down'] !!} Thông Tin Địa Điểm Y Tế
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Y Tế</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="name" id="name" type="text"
                                        placeholder="Tên Y Tế" />
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mã</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="code" id="code" type="text" placeholder="Mã" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Địa Điểm</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="address" id="address" type="text"
                                        placeholder="Địa Điểm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Xã</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <select class="w-full" id="crud-form-2" name="commune_id">
                                        @foreach ($communes as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('commune_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Toạ độ</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="coordinates" id="coordinates" type="text"
                                        placeholder="Toạ độ" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Sức chứa</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="population" id="population" type="number"
                                        placeholder="Sức chứa" />
                                    @error('population')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Loại hình</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="classify" id="classify" type="text"
                                        placeholder="Loại hình" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Phân loại</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="option" id="option" type="text"
                                        placeholder="Phân loại" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mô tả</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="description" id="description" type="text"
                                        placeholder="Mô tả" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Flooding Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <button class="w-full py-3 md:w-52" type="submit" variant="primary">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
