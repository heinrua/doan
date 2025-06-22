@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Ngập Lụt - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['arlett-triangle'] !!}
        Cập Nhật Ngập Lụt
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-calamity-flooding') }}"
                method="post">
                <input type="hidden" name="id" value="{{ $calamity->id }}">
                @csrf
                <!-- BEGIN: Flooding Information -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            {!! $icons['chevron-down'] !!} Thông Tin Ngập Lụt
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
                                                <div class="font-medium">Tên khu vực ngập</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input value="{{ $calamity->name }}" name="name" id="name"
                                            type="text" placeholder="Tên khu vực ngập" />
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
                                         <select id="yearSelect" id="crud-form-2" name="type_of_calamity_id"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:text-white">
                                            @foreach ($calamities as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ $calamity->type_of_calamity_id == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }}</option>
                                            @endforeach
                            
                                        </select>
        
                                        @error('type_of_calamity_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
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
                                        <x-base.form-input value="{{ $calamity->coordinates }}" name="coordinates"
                                            id="coordinates" type="text" placeholder="Toạ độ" />
                                    </div>
                                </div>
                            </div>
                            <!-- Cột 2 -->
                            <div>
                                <!-- Loại sạt lở -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Loại hình ngập mặn</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select  id="crud-form-2" name="sub_type_of_calamity_ids[]"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:text-white">
                                            @foreach ($subTypeOfCalamities as $subTypeOfCalamity)
                                                <option value="{{ $subTypeOfCalamity->id }}"
                                                    {{ $calamity->sub_type_of_calamities->pluck('id')->contains($subTypeOfCalamity->id) ? 'selected' : '' }}>
                                                    {{ $subTypeOfCalamity->name }}
                                                </option>
                                            @endforeach
                            
                                        </select>
                                        
                                        @error('sub_type_of_calamity_ids')
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
                                                <div class="font-medium">Địa phương ngập</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select id="crud-form-2" name="commune_ids[]"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:text-white">
                                            @foreach ($communes as $commune)
                                                <option value="{{ $commune->id }}"
                                                    {{ $calamity->communes->pluck('id')->contains($commune->id) ? 'selected' : '' }}>
                                                    {{ $commune->name }}
                                                </option>
                                            @endforeach
                            
                                        </select>
                                        
                                        @error('commune_ids')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Thời gian bắt đầu</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.litepicker class="mx-auto block" data-single-mode="true" data-lang="vi-VN"
                                            name="time_start" id="time_start"
                                            value="{{ old('time_start', isset($calamity->time_start) ? \Carbon\Carbon::parse($calamity->time_start)->format('Y-m-d') : '') }}" />
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
                                                <div class="font-medium">Cấp độ rủi ro thiên tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="risk_level_id">
                                            @foreach ($risk_levels as $risk_level)
                                                <option value="{{ $risk_level->id }}"
                                                    {{ $calamity->risk_level_id == $risk_level->id ? 'selected' : '' }}>
                                                    {{ $risk_level->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Phường/Xã -->
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Khoảng ngập lụt</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="flood_range">
                                            <option value="0-0.5m"
                                                {{ $calamity->flood_range == '0-0.5m' ? 'selected' : '' }}>
                                                0m -> 0.5m</option>
                                            <option value="0.5-1m"
                                                {{ $calamity->flood_range == '0.5-1m' ? 'selected' : '' }}>
                                                0.5m -> 1m</option>
                                            <option value="1-1.5m"
                                                {{ $calamity->flood_range == '1-1.5m' ? 'selected' : '' }}>
                                                1m -> 1.5m</option>
                                            <option value="1.5-2m"
                                                {{ $calamity->flood_range == '1.5-2m' ? 'selected' : '' }}>
                                                1.5m -> 2m</option>
                                            <option value=">2m"
                                                {{ $calamity->flood_range == '>2m' ? 'selected' : '' }}>
                                                > 2m
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- VẠCH KẺ NGANG --}}
                        <div class="w-full border-t-2 border-gray-300 my-4"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Cột 1 -->
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Mức độ ngập (m)</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input value="{{ $calamity->flood_level }}" name="flood_level"
                                            id="flood_level" type="text" placeholder="Mức độ ngập (m)" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Nguyên nhân gây ngập</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input value="{{ $calamity->reason }}" name="reason" id="reason"
                                            type="text" placeholder="Nguyên nhân gây ngập" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Biện pháp ứng phó</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input value="{{ $calamity->mitigation_measures }}"
                                            name="mitigation_measures" id="mitigation_measures" type="text"
                                            placeholder="Biện pháp ứng phó" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Nguồn dữ liệu</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input value="{{ $calamity->data_source }}" name="data_source"
                                            id="data_source" type="text" placeholder="Nguồn dữ liệu" />
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
                                                <div class="font-medium">Diện tích ngập (ha)</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input value="{{ $calamity->flooded_area }}" name="flooded_area"
                                            id="flooded_area" type="text" placeholder="Diện tích ngập (ha)" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Số dân bị ảnh hưởng</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input value="{{ $calamity->number_of_people_affected }}"
                                            name="number_of_people_affected" id="number_of_people_affected"
                                            type="text" placeholder="Số dân bị ảnh hưởng" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Cơ sở hạ tầng hư hại</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input value="{{ $calamity->damaged_infrastructure }}"
                                            name="damaged_infrastructure" id="damaged_infrastructure" type="text"
                                            placeholder="Cơ sở hạ tầng hư hại" />
                                    </div>
                                </div>
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
                                        <x-base.form-input value="{{ $calamity->property_damage }}"
                                            name="property_damage" id="property_damage" type="text"
                                            placeholder="Thiệt hại về tài sản" />
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
                                                <div class="font-medium">Thời gian kết thúc</div>
                                            </div>

                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.litepicker class="mx-auto block" data-single-mode="true"
                                            data-lang="vi-VN" name="time_end" id="time_end"
                                            value="{{ old('time_end', isset($calamity->time_end) ? \Carbon\Carbon::parse($calamity->time_end)->format('Y-m-d') : '') }}" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Thời gian nước rút (giờ)</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-input name="sprint_time" id="sprint_time" type="text"
                                            placeholder="Thời gian nước rút (giờ)" />
                                    </div>
                                </div>
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
                                        <x-base.form-input value="{{ $calamity->human_damage }}" name="human_damage"
                                            id="human_damage" type="text" placeholder="Thiệt hại về người" />
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
                                        @php
                                            $maps = !empty($calamity->map) ? json_decode($calamity->map, true) : [];
                                        @endphp
                                        @if (!empty($maps))
                                            <!-- Wrapper để scroll nếu nhiều hơn 5 file -->
                                            <div id="mapContainerWrapper" class="max-h-[200px] overflow-y-auto pr-2">
                                                <div id="mapContainer">
                                                    @foreach ($maps as $map)
                                                        <div class="file-item flex items-center gap-2 mt-2" data-file="{{ $map }}">
                                                            <a href="{{ asset($map) }}" target="_blank" class="text-blue-500 hover:underline">
                                                                {{ basename($map) }}
                                                            </a>
                                                            <button type="button" onclick="hideMap(this)" class="text-red-600 hover:text-red-800">
                                                                ✕
                                                            </button>
                                                            <input type="hidden" name="existing_maps[]" value="{{ $map }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <!-- Nút hoàn tác (ẩn mặc định) -->
                                        <button type="button" id="restoreMap" onclick="showMap()"
                                            class="hidden mt-2 text-blue-600 hover:underline">
                                            Hoàn tác
                                        </button>
                                        <!-- Input để chọn file mới -->
                                        <input type="file" name="map[]" id="map" multiple
                                            class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                        <!-- Input ẩn chứa danh sách file bị xoá -->
                                        <input type="hidden" name="deleted_maps" id="deletedMaps" value="[]">
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
                                        <!-- Hình ảnh -->
                                        <div id="imageContainer" class="relative w-fit mb-3 group">
                                            @if ($calamity->image)
                                                <x-base.image-zoom id="imagePreview"
                                                    class="h-40 w-auto rounded-lg shadow-md transition-all duration-300"
                                                    src="{{ asset($calamity->image) }}" alt="Hình ảnh" />
                                                <!-- Nút X để ẩn ảnh -->
                                                <button type="button" onclick="hideImage()"
                                                    class="absolute top-1 right-1 bg-black/60 text-white rounded-full p-2 shadow-lg transition-all opacity-0 group-hover:opacity-100 hover:bg-red-600">
                                                    ✕
                                                </button>
                                            @endif
                                        </div>
                                        <!-- Input file -->
                                        <input type="file" name="image" id="imageInput" accept="image/*"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                        <!-- Nút Hoàn Tác (Hiện lại ảnh) -->
                                        <button type="button" id="restoreImage" onclick="showImage()"
                                            class="hidden mt-2 text-blue-600 hover:underline">
                                            Hoàn tác
                                        </button>
                                        <!-- Input ẩn để Laravel xử lý -->
                                        <input type="hidden" name="delete_image" id="deleteImage" value="0">
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
                                        <!-- Input file -->
                                        <input type="file" name="video" id="videoInput" accept="video/mp4"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                        <!-- Hiển thị video nếu có -->
                                        @if (!empty($calamity->video))
                                            <div id="videoContainer" class="mt-4 relative w-fit group">
                                                <video id="videoPreview" class="w-full max-w-md rounded-lg shadow-md"
                                                    controls>
                                                    <source src="{{ asset($calamity->video) }}" type="video/mp4">
                                                    Trình duyệt của bạn không hỗ trợ video.
                                                </video>
                                                <!-- Nút X để xóa video -->
                                                <button type="button" onclick="hideVideo()"
                                                    class="absolute top-1 right-1 bg-black/60 text-white rounded-full p-2 shadow-lg transition-all
                                                    opacity-0 group-hover:opacity-100 hover:bg-red-600">
                                                    ✕
                                                </button>
                                            </div>
                                        @endif
                                        <!-- Nút Hoàn Tác -->
                                        <button type="button" id="restoreVideo" onclick="showVideo()"
                                            class="hidden mt-2 text-blue-600 hover:underline">
                                            Hoàn tác
                                        </button>
                                        <!-- Input ẩn để Laravel xử lý xóa -->
                                        <input type="hidden" name="delete_video" id="deleteVideo" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Flooding Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-calamity-flooding') }}">
                        <button type="button"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">Huỷ
                            Bỏ</button>
                    </a>
                    @if ($userCurrent->is_master || $userCurrent->hasPermission('update-calamity-flooding'))
                        <button class="w-full py-3 md:w-52" type="submit" variant="primary">
                            Lưu
                        </button>
                    @endif
                </div>
            </form>
            <div id="mapFlooding" class="mt-5 w-full h-[700px] rounded-lg border"></div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('mapContainer');
            const wrapper = container.parentElement;

            if (container.children.length > 5) {
                wrapper.classList.add('max-h-[200px]', 'overflow-y-auto', 'pr-2');
            }
        });
        //preview video
        document.addEventListener("DOMContentLoaded", function() {
            const videoInput = document.getElementById("videoInput");
            if (videoInput) {
                videoInput.addEventListener("change", function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const videoPreview = document.getElementById("videoPreview");
                        if (videoPreview) {
                            videoPreview.src = URL.createObjectURL(file);
                            videoPreview.load();
                        }
                    }
                });
            }
        });
        //image
        function hideImage() {
            document.getElementById("imagePreview").style.display = "none"; // Ẩn ảnh
            document.getElementById("imageContainer").style.display = "none"; // Ẩn luôn div chứa ảnh
            document.getElementById("deleteImage").value = "1"; // Đánh dấu xóa
            document.getElementById("restoreImage").classList.remove("hidden"); // Hiện nút "Hoàn tác"
        }

        function showImage() {
            document.getElementById("imagePreview").style.display = "block"; // Hiện lại ảnh
            document.getElementById("imageContainer").style.display = "block"; // Hiện lại div ảnh
            document.getElementById("deleteImage").value = "0"; // Bỏ đánh dấu xóa
            document.getElementById("restoreImage").classList.add("hidden"); // Ẩn nút "Hoàn tác"
        }
        //video
        function hideVideo() {
            let videoContainer = document.getElementById("videoContainer");
            let restoreButton = document.getElementById("restoreVideo");
            if (videoContainer) {
                videoContainer.style.display = "none"; // Ẩn video
            }
            document.getElementById("deleteVideo").value = "1"; // Đánh dấu xóa
            restoreButton.classList.remove("hidden"); // Hiện nút "Hoàn tác"
        }

        function showVideo() {
            let videoContainer = document.getElementById("videoContainer");
            let restoreButton = document.getElementById("restoreVideo");
            if (videoContainer) {
                videoContainer.style.display = "block"; // Hiện lại video
            }
            document.getElementById("deleteVideo").value = "0"; // Bỏ đánh dấu xóa
            restoreButton.classList.add("hidden"); // Ẩn nút "Hoàn tác"
        }
        //map
        let deletedMaps = [];

        function hideMap(button) {
            let fileItem = button.parentElement;
            let filePath = fileItem.getAttribute("data-file");

            deletedMaps.push(filePath);
            document.getElementById("deletedMaps").value = JSON.stringify(deletedMaps);

            fileItem.style.display = "none";
            document.getElementById("restoreMap").classList.remove("hidden");
        }

        function showMap() {
            if (deletedMaps.length > 0) {
                let filePath = deletedMaps.pop();
                document.getElementById("deletedMaps").value = JSON.stringify(deletedMaps);

                let fileItems = document.querySelectorAll(".file-item");
                fileItems.forEach(item => {
                    if (item.getAttribute("data-file") === filePath) {
                        item.style.display = "flex";
                    }
                });
            }
            if (deletedMaps.length === 0) {
                document.getElementById("restoreMap").classList.add("hidden");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            if (typeof google === "undefined" || typeof google.maps === "undefined") {
                console.warn("Google Maps API chưa tải xong, đang chờ...");
                let maxRetries = 10; // Tối đa đợi 10 giây
                let retries = 0;
                let checkGoogleMaps = setInterval(() => {
                    if (typeof google !== "undefined" && typeof google.maps !== "undefined") {
                        clearInterval(checkGoogleMaps);
                        console.log("Google Maps API đã sẵn sàng!");
                        initializeApp();
                    } else {
                        retries++;
                        console.warn(`Đợi Google Maps API... (${retries})`);
                        if (retries >= maxRetries) {
                            clearInterval(checkGoogleMaps);
                            console.error("Không thể load Google Maps API sau 10 giây.");
                        }
                    }
                }, 1000);
            } else {
                console.log("Google Maps API đã sẵn sàng!");
                initializeApp();
            }
        });
        let mapFlooding, kmlLayers = new Map(),
            currentLayer = null,
            markers = new Map();
        let infoWindowFlooding;
        let marker;

        function initializeApp() {
            initMap();
            const calamity = @json($calamity); // từ Laravel
            showSingleLandslideMarker(calamity);
            const kmlFiles = JSON.parse(@json($calamity->map));
            kmlFiles.forEach(url => addKmlLayer(url));
        }

        function initMap() {
            mapFlooding = new google.maps.Map(document.getElementById('mapFlooding'), {
                center: {
                    lat: 8.946132,
                    lng: 105.033270
                },
                zoom: 11
            });
            infoWindowFlooding = new google.maps.InfoWindow();
            // Click vào bản đồ để đặt marker mới
            mapFlooding.addListener("click", function(event) {
                let lat = event.latLng.lat().toFixed(6);
                let lng = event.latLng.lng().toFixed(6);
                // Cập nhật input
                document.getElementById("coordinates").value = lat + ", " + lng;
                // Cập nhật marker
                if (marker) {
                    marker.setPosition(event.latLng);
                } else {
                    marker = new google.maps.Marker({
                        position: event.latLng,
                        map: mapFlooding,
                        draggable: true
                    });
                }
            });

        }

        // Cập nhật bản đồ khi rời khỏi ô nhập tọa độ hoặc nhấn Enter
        function updateMapFromInput() {
            let inputVal = document.getElementById("coordinates").value.trim();
            let coords = inputVal.split(",");

            if (coords.length === 2) {
                let lat = parseFloat(coords[0]);
                let lng = parseFloat(coords[1]);

                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    let newLocation = {
                        lat: lat,
                        lng: lng
                    };
                    mapFlooding.setCenter(newLocation);
                    mapFlooding.setZoom(13);
                    marker.setPosition(newLocation); // marker toàn cục đã tồn tại
                } else {
                    showToast("⚠️ Tọa độ không hợp lệ! Vui lòng nhập lại.");
                }
            } else {
                showToast("⚠️ Định dạng tọa độ không đúng! Vui lòng nhập theo dạng: lat, lng");
            }
        }

        function showSingleLandslideMarker(calamity) {
            // Xóa marker cũ nếu có
            if (markers.has("single_landslide")) {
                markers.get("single_landslide").setMap(null);
                markers.delete("single_landslide");
            }
            const [lat, lng] = calamity.coordinates.split(',');
            calamity.latitude = parseFloat(lat.trim());
            calamity.longitude = parseFloat(lng.trim());

            marker = new google.maps.Marker({ // ⚠️ Không dùng const
                position: {
                    lat: parseFloat(calamity.latitude),
                    lng: parseFloat(calamity.longitude)
                },
                map: mapFlooding,
                draggable: true,
                icon: {
                    url: "/uploads/map/swimming.png",
                    scaledSize: new google.maps.Size(25, 25)
                }
            });

            markers.set("single_landslide", marker);
            // Gắn sự kiện drag sau khi marker đã được tạo
            marker.addListener("dragend", function(event) {
                document.getElementById("coordinates").value =
                    event.latLng.lat().toFixed(6) + ", " + event.latLng.lng().toFixed(6);
            });
            marker.addListener("click", function() {
                infoWindowFlooding.setContent(generateContent(calamity));
                infoWindowFlooding.open(mapFlooding, marker);
            });
            google.maps.event.addListener(infoWindowFlooding, "domready", function() {
                const closeBtn = document.querySelector(".gm-ui-hover-effect");
                if (closeBtn) closeBtn.style.display = "none";
                const customClose = document.getElementById("custom-close-btn");
                if (customClose) {
                    customClose.addEventListener("click", () => {
                        infoWindowFlooding.close();
                    });
                }
            });
            mapFlooding.setCenter(marker.getPosition());
            mapFlooding.setZoom(10);
        }

        function generateContent(calamity) {
            const defaultImage = "{{ Vite::asset('resources/images/default-river-bank.png') }}";
            return `
            <div style="max-width: 340px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff; transition: all 0.3s ease-in-out;">
                <!-- Image section -->
                <div style="position: relative; overflow: hidden;">
                    <img src="${calamity.image || defaultImage}" alt="Hình ảnh"
                        style="width: 100%; height: 180px; object-fit: cover; transition: transform 0.3s ease;">
                    <button id="custom-close-btn"
                            style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.9); border: none; border-radius: 50%; padding: 6px 10px; font-size: 16px; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                        ✕
                    </button>
                </div>
                <!-- Title -->
                <div style="background: linear-gradient(to right, #3498db, #2980b9); color: white; padding: 14px 20px; text-align: center;">
                    <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                        ${calamity.name} (Sạt lở)
                    </div>
                </div>
                <!-- Info content -->
               <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                    </div>
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">📍</span>
                        <strong>Địa chỉ:</strong>&nbsp;${calamity.address || "Không có"}
                    </div>
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">🏘️</span>
                        <strong>Xã:</strong>&nbsp;${calamity.communes[0].name || "Không có"}
                    </div>
                    <div style="display: flex; align-items: start;">
                        <span style="width: 25px;">🏞️</span>
                        <strong>Huyện:</strong>&nbsp;${calamity.communes[0].district.name || "Không có"}
                    </div>
                </div>
            </div>
            `;
        }

        function addKmlLayer(url) {
            let kmlUrl = url.startsWith("http") ? url : window.location.origin + "/" + url;
            if (kmlLayers.has(kmlUrl)) return;
            const layer = new google.maps.KmlLayer({
                url: kmlUrl,
                map: mapFlooding,
                preserveViewport: false
            });
            kmlLayers.set(kmlUrl, layer);
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&libraries=places&callback=initMap"
        async defer loading="async"></script>
@endpush
