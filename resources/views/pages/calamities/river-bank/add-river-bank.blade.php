@extends('themes.base')

@section('subhead')
    <title>Tạo Mới Sạt Lở - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-rain'] !!}
        Tạo Mới Sạt Lở
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/calamity/create-river-bank" method="post">
                @csrf
                <!-- BEGIN: Risk Level Information -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            {!! $icons['chevron-down'] !!} Thông Tin Sạt Lở
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Cột 1 -->
                            <div>
                                <!-- Vị trí sạt lở -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Vị Trí Sạt Lở</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="name" id="name" type="text"
                                            placeholder="Vị Trí Sạt Lở" />
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Loại hình thiên tai -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Loại hình thiên tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="type_of_calamity_id">
                                            @foreach ($calamities as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type_of_calamity_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Loại sạt lở -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Loại sạt lở</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="sub_type_of_calamity_id">
                                            @foreach ($sub_calamities as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_type_of_calamity_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Cột 2 -->
                            <div>
                                <!-- Tọa độ vị trí -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Tọa độ vị trí</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="coordinates" id="coordinates" type="text"
                                            placeholder="Tọa độ vị trí" />
                                        @error('coordinates')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cấp độ thiên tai -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Cấp độ thiên tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="risk_level_id">
                                            @foreach ($risk_levels as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Thời gian -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Thời gian</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.litepicker class="w-full" data-single-mode="true" data-lang="vi-VN"
                                            name="selected_date" id="selected_date" />
                                    </div>
                                </div>
                            </div>
                            <!-- Cột 3 -->
                            <div>
                                <!-- Địa điểm -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Địa điểm</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="address" id="address" type="text"
                                            placeholder="Địa điểm" />
                                    </div>
                                </div>
                                <!-- Phường/Xã -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Phường/Xã</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="commune_id">
                                            @foreach ($communes as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- VẠCH KẺ NGANG --}}
                        <div class="w-full border-t-2 border-gray-300 my-4"></div>

                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Thông tin kích thước</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full flex flex-col md:flex-row gap-4">
                                    <div class="w-full md:w-1/3">
                                        <x-base.form-input name="width" id="width" type="text"
                                            placeholder="Chiều rộng (m)" />
                                    </div>
                                    <div class="w-full md:w-1/3">
                                        <x-base.form-input name="length" id="length" type="text"
                                            placeholder="Chiều dài (m)" />
                                    </div>
                                    <div class="w-full md:w-1/3">
                                        <x-base.form-input name="acreage" id="acreage" type="text"
                                            placeholder="Diện tích (m²)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Cột 1 -->
                            <div>
                                <!-- Nguyên nhân -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Nguyên nhân</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="reason" id="reason" type="text"
                                            placeholder="Nguyên nhân" />
                                    </div>
                                </div>

                                <!-- Địa chất -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Địa chất</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="geology" id="geology" type="text"
                                            placeholder="Địa chất" />
                                    </div>
                                </div>
                                <!-- Chính sách hỗ trợ -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Chính sách hỗ trợ</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="support_policy" id="support_policy" type="text"
                                            placeholder="Chính sách hỗ trợ" />
                                    </div>
                                </div>
                            </div>

                            <!-- Cột 2 -->
                            <div>
                                <!-- Đặc điểm thuỷ văn -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Đặc điểm thuỷ văn</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="watermark_points" id="watermark_points" type="text"
                                            placeholder="Đặc điểm thuỷ văn" />
                                    </div>
                                </div>

                                <!-- Các biện pháp giảm thiểu -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Các biện pháp giảm thiểu</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="mitigation_measures" id="mitigation_measures"
                                            type="text" placeholder="Các biện pháp giảm thiểu" />
                                    </div>
                                </div>
                                <!-- Mức độ -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Mức độ</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="investment_level" id="investment_level" type="text"
                                            placeholder="Mức độ" />
                                    </div>
                                </div>
                            </div>

                            <!-- Cột 3 -->
                            <div>
                                <!-- Thiệt hại về người -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Thiệt hại về người</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="human_damage" id="human_damage" type="text"
                                            placeholder="Thiệt hại về người" />
                                    </div>
                                </div>

                                <!-- Thiệt hại về tài sản -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Thiệt hại về tài sản</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="property_damage" id="property_damage" type="text"
                                            placeholder="Thiệt hại về tài sản" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- map,image,video --}}
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Cột 1 -->
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Chọn lớp bản đồ</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="map[]" id="map" type="file" multiple
                                            placeholder="Chọn lớp bản đồ" />
                                    </div>
                                </div>

                            </div>
                            <!-- Cột 2 -->
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Hình ảnh</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="image" id="image" type="file"
                                            placeholder="Hình ảnh" />
                                    </div>
                                </div>
                            </div>
                            <!-- Cột 3 -->
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Video</div>
                                            </div>

                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="video" id="video" type="file"
                                            placeholder="Video" />
                                    </div>
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
