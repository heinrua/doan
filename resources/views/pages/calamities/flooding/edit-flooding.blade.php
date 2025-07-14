@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Ngập Lụt - PCTT Cà Mau Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['arlett-triangle'] !!}
        Cập Nhật Ngập Lụt
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> 
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-calamity-flooding') }}"
                method="post">
                <input type="hidden" name="id" value="{{ $calamity->id }}">
                @csrf
                
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Ngập Lụt
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <div>
                                
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
                                        <input value="{{ $calamity->name }}" name="name" id="name"
                                            type="text" placeholder="Tên khu vực ngập" />
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
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
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5">
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
                                        <input value="{{ $calamity->coordinates }}" name="coordinates"
                                            id="coordinates" type="text" placeholder="Toạ độ" />
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                
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
                                        <select id="sub_type_of_calamity_ids" name="sub_type_of_calamity_ids[]" multiple>
                                            @foreach ($subTypeOfCalamities as $subTypeOfCalamity)
                                                <option value="{{ $subTypeOfCalamity->id }}" {{ $calamity->sub_type_of_calamities->pluck('id')->contains($subTypeOfCalamity->id) ? 'selected' : '' }}>{{ $subTypeOfCalamity->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('sub_type_of_calamity_ids')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
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
                                        <select id="commune_ids" name="commune_ids[]" multiple>
                                            @foreach ($communes as $commune)
                                                <option value="{{ $commune->id }}" {{ $calamity->communes->pluck('id')->contains($commune->id) ? 'selected' : '' }}>{{ $commune->name }}</option>
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
                            
                            <div>
                                
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

                       
                        <div class="w-full border-t-2 border-gray-300 my-4"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
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
                                        <input value="{{ $calamity->flood_level }}" name="flood_level"
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
                                        <input value="{{ $calamity->reason }}" name="reason" id="reason"
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
                                        <input value="{{ $calamity->mitigation_measures }}"
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
                                        <input value="{{ $calamity->data_source }}" name="data_source"
                                            id="data_source" type="text" placeholder="Nguồn dữ liệu" />
                                    </div>
                                </div>

                            </div>
                            
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
                                        <input value="{{ $calamity->flooded_area }}" name="flooded_area"
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
                                        <input value="{{ $calamity->number_of_people_affected }}"
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
                                        <input value="{{ $calamity->damaged_infrastructure }}"
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
                                        <input value="{{ $calamity->property_damage }}"
                                            name="property_damage" id="property_damage" type="text"
                                            placeholder="Thiệt hại về tài sản" />
                                    </div>
                                </div>
                            </div>
                            
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
                                        <input name="sprint_time" id="sprint_time" type="text"
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
                                        <input value="{{ $calamity->human_damage }}" name="human_damage"
                                            id="human_damage" type="text" placeholder="Thiệt hại về người" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
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
                                        
                                        <button type="button" id="restoreMap" onclick="showMap()"
                                            class="hidden mt-2 text-blue-600 hover:underline">
                                            Hoàn tác
                                        </button>
                                        
                                        <input type="file" name="map[]" id="map" multiple
                                            class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                        
                                        <input type="hidden" name="deleted_maps" id="deletedMaps" value="[]">
                                    </div>
                                </div>
                            </div>
                            
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
                                        
                                        <div id="imageContainer" class="relative w-fit mb-3 group">
                                            @if ($calamity->image)
                                                <x-base.image-zoom id="imagePreview"
                                                    class="h-40 w-auto rounded-lg shadow-md transition-all duration-300"
                                                    src="{{ asset($calamity->image) }}" alt="Hình ảnh" />
                                                
                                                <button type="button" onclick="hideImage()"
                                                    class="absolute top-1 right-1 bg-black/60 text-white rounded-full p-2 shadow-lg transition-all opacity-0 group-hover:opacity-100 hover:bg-red-600">
                                                    ✕
                                                </button>
                                            @endif
                                        </div>
                                        
                                         <input type="file" name="image" id="imageInput" accept="image/*"
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">
                                        
                                        <button type="button" id="restoreImage" onclick="showImage()"
                                            class="hidden mt-2 text-blue-600 hover:underline">
                                            Hoàn tác
                                        </button>
                                        
                                        <input type="hidden" name="delete_image" id="deleteImage" value="0">
                                    </div>
                                </div>
                            </div>

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
                                        
                                        <input type="file" name="video" id="videoInput" accept="video/mp4"
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">

                                        @if (!empty($calamity->video))
                                            <div id="videoContainer" class="mt-4 relative w-fit group">
                                                <video id="videoPreview" class="w-full max-w-md rounded-lg shadow-md"
                                                    controls>
                                                    <source src="{{ asset($calamity->video) }}" type="video/mp4">
                                                    Trình duyệt của bạn không hỗ trợ video.
                                                </video>
                                                
                                                <button type="button" onclick="hideVideo()"
                                                    class="absolute top-1 right-1 bg-black/60 text-white rounded-full p-2 shadow-lg transition-all
                                                    opacity-0 group-hover:opacity-100 hover:bg-red-600">
                                                    ✕
                                                </button>
                                            </div>
                                        @endif
                                        
                                        <button type="button" id="restoreVideo" onclick="showVideo()"
                                            class="hidden mt-2 text-blue-600 hover:underline">
                                            Hoàn tác
                                        </button>
                                        
                                        <input type="hidden" name="delete_video" id="deleteVideo" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                    <div class="w-full md:w-auto text-left">
                        <p class="italic">
                            Tạo bởi: {{ optional($calamity->created_by_user)->full_name ?? 'Không rõ' }}.
                        </p>
                        <p class="italic">
                            Cập nhật lần cuối: {{ optional($calamity->updated_by_user)->full_name ?? 'Không rõ' }}.
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('view-calamity-flooding') }}">
                            <button type="button"
                                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                Huỷ Bỏ</button>
                        </a>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                            Lưu
                        </button>
                    </div>
                </div>
            </form>
            <div id="mapFlooding" class="mt-5 w-full h-[700px] rounded-lg border"></div>
        </div>
    </div>
@endsection
@push('scripts')

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect(
            "#commune_ids", {
                plugins: ['remove_button'],
                placeholder: "Chọn các xã...",
                maxItems: null,
                render: {
                    item: function(data, escape) {
                        return `<div class="bg-blue-100 text-blue-800 text-sm rounded-full px-3 py-1 mr-2 mb-1 inline-flex items-center">
                                    ${escape(data.text)}
                                    
                                </div>`;
                    },
                    option: function(data, escape) {
                        return `<div class="py-2 px-3 text-sm hover:bg-blue-50 cursor-pointer">${escape(data.text)}</div>`;
                    }
                }
        }
    );
    new TomSelect("#sub_type_of_calamity_id", {
        plugins: ['remove_button'],
        placeholder: "Chọn các loại hình...",
        maxItems: null,
        render: {
            item: function(data, escape) {
                return `<div class="bg-green-100 text-green-800 text-sm rounded-full px-3 py-1 mr-2 mb-1 inline-flex items-center">
                            ${escape(data.text)}
                            <span class="ml-2 cursor-pointer text-green-500 hover:text-green-700" data-ts-remove>&times;</span>
                        </div>`;
            },
            option: function(data, escape) {
                return `<div class="py-2 px-3 text-sm hover:bg-green-50 cursor-pointer">${escape(data.text)}</div>`;
            }
        }
    });

    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('mapContainer');
            const wrapper = container.parentElement;

            if (container.children.length > 5) {
                wrapper.classList.add('max-h-[200px]', 'overflow-y-auto', 'pr-2');
            }
        });
        
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
        
        function hideImage() {
            document.getElementById("imagePreview").style.display = "none"; 
            document.getElementById("imageContainer").style.display = "none"; 
            document.getElementById("deleteImage").value = "1"; 
            document.getElementById("restoreImage").classList.remove("hidden"); 
        }

        function showImage() {
            document.getElementById("imagePreview").style.display = "block"; 
            document.getElementById("imageContainer").style.display = "block"; 
            document.getElementById("deleteImage").value = "0"; 
            document.getElementById("restoreImage").classList.add("hidden"); 
        }
        
        function hideVideo() {
            let videoContainer = document.getElementById("videoContainer");
            let restoreButton = document.getElementById("restoreVideo");
            if (videoContainer) {
                videoContainer.style.display = "none"; 
            }
            document.getElementById("deleteVideo").value = "1"; 
            restoreButton.classList.remove("hidden"); 
        }

        function showVideo() {
            let videoContainer = document.getElementById("videoContainer");
            let restoreButton = document.getElementById("restoreVideo");
            if (videoContainer) {
                videoContainer.style.display = "block"; 
            }
            document.getElementById("deleteVideo").value = "0"; 
            restoreButton.classList.add("hidden"); 
        }
        
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
                let maxRetries = 10; 
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
            const calamity = @json($calamity); 
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
            
            mapFlooding.addListener("click", function(event) {
                let lat = event.latLng.lat().toFixed(6);
                let lng = event.latLng.lng().toFixed(6);
                
                document.getElementById("coordinates").value = lat + ", " + lng;
                
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
                    marker.setPosition(newLocation); 
                } else {
                    showToast("⚠️ Tọa độ không hợp lệ! Vui lòng nhập lại.");
                }
            } else {
                showToast("⚠️ Định dạng tọa độ không đúng! Vui lòng nhập theo dạng: lat, lng");
            }
        }

        function showSingleLandslideMarker(calamity) {
            
            if (markers.has("single_landslide")) {
                markers.get("single_landslide").setMap(null);
                markers.delete("single_landslide");
            }
            const [lat, lng] = calamity.coordinates.split(',');
            calamity.latitude = parseFloat(lat.trim());
            calamity.longitude = parseFloat(lng.trim());

            marker = new google.maps.Marker({ 
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
                
                <div style="position: relative; overflow: hidden;">
                    <img src="${calamity.image || defaultImage}" alt="Hình ảnh"
                        style="width: 100%; height: 180px; object-fit: cover; transition: transform 0.3s ease;">
                    <button id="custom-close-btn"
                            style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.9); border: none; border-radius: 50%; padding: 6px 10px; font-size: 16px; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                        ✕
                    </button>
                </div>
                
                <div style="background: linear-gradient(to right, #3498db, #2980b9); color: white; padding: 14px 20px; text-align: center;">
                    <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                        ${calamity.name} (Sạt lở)
                    </div>
                </div>
                
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
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&callback=initializeApp" async
   defer loading="async"></script>
@endpush
