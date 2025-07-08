@extends('themes.base')

@section('subhead')
    <title>Tạo Mới Bão Và Áp Thấp Nhiệt Đới - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-lightning'] !!}
        Tạo Mới Bão Và Áp Thấp Nhiệt Đới
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> 
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/calamity/create-storm" method="post">
                @csrf
                
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Bão Và Áp Thấp Nhiệt Đới
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div>
                                
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Tên Bão</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="name" id="name" type="text"
                                            placeholder="Tên Bão" />
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
                                                <div class="font-medium">Loại Hình Thiên Tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" name="type_of_calamity_id">
                                            <option>--Chọn thiên tai--</option>
                                            @foreach ($calamities as $key => $value)
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
                                                <div class="font-medium">Thời gian bắt đầu</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="relative">
                                        
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            {!!$icons['calendar']!!}
                                        </div>

                                        <x-base.litepicker  id="time_start" name="time_start" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            data-single-mode="true"  data-lang="vi-VN"/>
                                    </div>

                                </div>

                            </div>
                            
                            <div>
                                
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    
                                   <div class="w-full">
                                    <label for="commune_ids" class="block text-sm font-medium text-gray-700 mb-1">
                                        Địa phương ảnh hưởng <span class="text-red-500 font-bold">*</span>
                                    </label>
                                    <select id="commune_ids" name="commune_ids[]" multiple>
                                        @foreach ($communes as $commune)
                                            <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('commune_ids')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                </div>
                                
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                   
                                    <div class="w-full">
                                        <label  class="block text-sm font-medium text-gray-700 mb-1">
                                            Loại Hình <span class="text-red-500 font-bold">*</span>
                                        </label>
                                        <select name="sub_type_of_calamity_ids[]" id = "sub_type_of_calamity" multiple>
                                                @foreach ($sub_calamities as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('sub_type_of_calamity_ids')
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
                                                <div class="font-medium">Toạ Độ</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="coordinates" id="coordinates" type="text"
                                            placeholder="Toạ Độ" />
                                    </div>
                                </div>
                                
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
                                        <select class="w-full" name="risk_level_id">
                                            @foreach ($risk_levels as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('risk_level_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                       
                        <div class="w-full border-t-2 border-gray-300 my-4"></div>

                        <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-6">
                            
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
                                     <div class="relative">
                                        
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            {!!$icons['calendar']!!}
                                        </div>

                                        <x-base.litepicker  id="time_end" name="time_end" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                            data-single-mode="true"  data-lang="vi-VN"/>
                                    </div>
                                </div>
                                
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Cấp độ</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="investment_level" id="investment_level" type="text"
                                            placeholder="Cấp độ" />
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
                            
                            <div>
                                
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
                                            type="text" placeholder="Biện pháp ứng phó" />
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
        </div>
        
        <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
              <a href="{{ route('view-calamity-storm') }}">
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
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

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
                                    <span class="ml-2 cursor-pointer text-blue-500 hover:text-blue-700" data-ts-remove>&times;</span>
                                </div>`;
                    },
                    option: function(data, escape) {
                        return `<div class="py-2 px-3 text-sm hover:bg-blue-50 cursor-pointer">${escape(data.text)}</div>`;
                    }
                }
        }
    );
    new TomSelect("#sub_type_of_calamity", {
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