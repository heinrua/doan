@extends('themes.base')

@section('subhead')
    <title>Tạo Mới Sạt Lở - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-rain'] !!}
        Tạo Mới Sạt Lở
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> 
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/calamity/create-river-bank" method="post">
                @csrf
                
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Sạt Lở
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <div>
                                
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
                                        <input name="name" id="name" type="text"
                                            placeholder="Vị Trí Sạt Lở" />
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
                                        <select class="w-full" id="sub_type_of_calamity_ids" name="sub_type_of_calamity_ids[]" multiple>
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
                            
                            <div>
                                
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
                                        <input name="coordinates" id="coordinates" type="text"
                                            placeholder="Tọa độ vị trí" />
                                        @error('coordinates')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

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
                            
                            <div>
                                
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
                                        <input name="address" id="address" type="text"
                                            placeholder="Địa điểm" />
                                    </div>
                                </div>
                                
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
                                        <select class="w-full" id="commune_ids" name="commune_ids[]" multiple>
                                            @foreach ($communes as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                       
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
                                        <input name="width" id="width" type="text"
                                            placeholder="Chiều rộng (m)" />
                                    </div>
                                    <div class="w-full md:w-1/3">
                                        <input name="length" id="length" type="text"
                                            placeholder="Chiều dài (m)" />
                                    </div>
                                    <div class="w-full md:w-1/3">
                                        <input name="acreage" id="acreage" type="text"
                                            placeholder="Diện tích (m²)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div>
                                
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
                                        <input name="reason" id="reason" type="text"
                                            placeholder="Nguyên nhân" />
                                    </div>
                                </div>

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
                                        <input name="geology" id="geology" type="text"
                                            placeholder="Địa chất" />
                                    </div>
                                </div>
                                
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
                                        <input name="support_policy" id="support_policy" type="text"
                                            placeholder="Chính sách hỗ trợ" />
                                    </div>
                                </div>
                            </div>

                            <div>
                                
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
                                        <input name="watermark_points" id="watermark_points" type="text"
                                            placeholder="Đặc điểm thuỷ văn" />
                                    </div>
                                </div>

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
                                        <input name="mitigation_measures" id="mitigation_measures"
                                            type="text" placeholder="Các biện pháp giảm thiểu" />
                                    </div>
                                </div>
                                
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
                                        <input name="investment_level" id="investment_level" type="text"
                                            placeholder="Mức độ" />
                                    </div>
                                </div>
                            </div>

                            <div>
                                
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
                        </div>

                        
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                   <div class="mb-4">
                                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Chọn lớp bản đồ</label>
                                        <input type="file" name="map[]" id="map" 
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">
</div>   
                                </div>

                            </div>
                            
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
                
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-calamity-river-bank') }}">
                        <button type="button"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                            Huỷ Bỏ</button>
                    </a>
                   <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect("#sub_type_of_calamity_ids", {
            plugins: ['remove_button'],
            placeholder: "Chọn các loại hình...",
            maxItems: null,
            render: {
                item: function(data, escape) {
                    return `<div class="bg-green-100 text-green-800 text-sm rounded-full px-3 py-1 mr-2 mb-1 inline-flex items-center">
                        ${escape(data.text)}
                    </div>`;
                },
                option: function(data, escape) {
                    return `<div class="py-2 px-3 text-sm hover:bg-green-50 cursor-pointer">${escape(data.text)}</div>`;
                }
            }
        });
        new TomSelect("#commune_ids", {
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
        });
    }); 
</script>       