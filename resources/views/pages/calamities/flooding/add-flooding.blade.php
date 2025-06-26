@extends('themes.base')

@section('subhead')
    <title>Tạo Mới Ngập Lụt - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['arlett-triangle'] !!}
        Tạo Mới Ngập Lụt
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/calamity/create-flooding" method="post">
                @csrf
                <!-- BEGIN: Flooding Information -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Ngập Lụt
                        </div>
                        {{-- Thông tin chính --}}
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
                                        <input name="name" id="name" type="text"
                                            placeholder="Tên khu vực ngập" />
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
                                        <select id="crud-form-2" name="type_of_calamity_id"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 w-full" >
                                           
                                            @foreach ($calamities as $key => $value)
                                                <option name="calamities" value="{{ $value->id }}">{{ $value->name }}
                                                </option>
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
                                        <input name="coordinates" id="coordinates" type="text"
                                            placeholder="Toạ độ" />
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
                                        <select multiple id="crud-form-2" name="sub_type_of_calamity_ids[]"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 w-full">
                                            @foreach ($sub_calamities as $key => $value)
                                                <option value="{{ $value->id }}">
                                                    {{ $value->name }}
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
                                        
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 w-full" multiple>
                                            @foreach ($communes as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                                        <x-base.preview>
                                            <x-base.litepicker class="mx-auto block" data-single-mode="true"
                                                data-lang="vi-VN" name="time_start" id="time_start" />
                                        </x-base.preview>
                                        <x-base.source>
                                            <x-base.highlight>
                                                <x-base.litepicker class="mx-auto block" data-single-mode="true"
                                                    data-lang="vi-VN" />
                                            </x-base.highlight>
                                        </x-base.source>
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
                                        <select id="crud-form-2" name="risk_level_id"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 w-full">
                                             @foreach ($risk_levels as $key => $value)
                                                <option name="risk_levels" value="{{ $value->id }}">{{ $value->name }}
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
                                        <select id="crud-form-2" name="progress"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 w-full">
                                            <option value="0-0.5m">0m -> 0.5m</option>
                                            <option value="0.5-1m">0.5m -> 1m</option>
                                            <option value="1-1.5m">1m -> 1.5m</option>
                                            <option value="1.5-2m">1.5m -> 2m</option>
                                            <option value=">2m">> 2m</option>
                            
                                        </select>
                                        @error('progress')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- VẠCH KẺ NGANG --}}
                        <div class="w-full border-t-2 border-gray-300 my-4"></div>
                         {{-- Thông tin phụ --}}
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
                                    <label>
                                    <div class="w-full">
                                        <input name="flood_level" id="flood_level" type="text" placeholder="Mức độ ngập (m)" >
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
                                        <input name="reason" id="reason" type="text" placeholder="Nguyên nhân gây ngập" >
                                
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
                                        <input name="mitigation_measures" id="mitigation_measures"
                                            type="text" placeholder="Biện pháp ứng phó"  >
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
                                        <input name="data_source" id="data_source" type="text"
                                            placeholder="Nguồn dữ liệu" />
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
                                        <input name="flooded_area" id="flooded_area" type="text"
                                            placeholder="Diện tích ngập (ha)" />
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
                                        <input name="number_of_people_affected" id="number_of_people_affected"
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
                                        <input name="damaged_infrastructure" id="damaged_infrastructure"
                                            type="text" placeholder="Cơ sở hạ tầng hư hại" />
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
                                        <input name="property_damage" id="property_damage" type="text"
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
                                        <x-base.preview>
                                            <x-base.litepicker class="mx-auto block" data-single-mode="true"
                                                data-lang="vi-VN" name="time_end" id="time_end" />
                                        </x-base.preview>
                                        <x-base.source>
                                            <x-base.highlight>
                                                <x-base.litepicker class="mx-auto block" data-single-mode="true"
                                                    data-lang="vi-VN" />
                                            </x-base.highlight>
                                        </x-base.source>
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
                                        <input name="human_damage" id="human_damage" type="text"
                                            placeholder="Thiệt hại về người" />
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
                                    <div class="mb-4">
                                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Lớp bản đồ</label>
                                        <input type="file" name="map[]" id="map" 
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md" multiple>
                                    </div>
                                </div>

                            </div>
                            <!-- Cột 2 -->
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <div class="mb-4">
                                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh</label>
                                        <input type="file" name="image" id="image" 
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                            <!-- Cột 3 -->
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <div class="mb-4">
                                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Video</label>
                                        <input type="file" name="video" id="video" 
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Flooding Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                   <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
