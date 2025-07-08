@extends('themes.base')

@section('subhead')
    <title>Tạo Phương Án Ứng Phó - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['home'] !!}
        Tạo Phương Án Ứng Phó
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> 
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/create-scenarios" method="post">
                @csrf
                
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Phương Án Ứng Phó
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Tên Phương Án</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="name" id="name" type="text"
                                            placeholder="Tên Phương Án" />
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Loại Thiên Tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select id="crud-form-2" name="type_of_calamity_id">
                                            <option value="">Chọn Loại Thiên Tai</option>
                                            @foreach ($calamities as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ old('type_of_calamity_id') == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }}
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
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Ngày Cập Nhật</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.preview>
                                            <x-base.litepicker class="mx-auto block" data-single-mode="true"
                                                data-lang="vi-VN" name="updated_time" id="updated_time" />
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
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Mô Tả Văn Bản</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <x-base.form-textarea name="document_text" id="document_text"
                                            placeholder="Mô Tả Văn Bản" rows="5" cols="40" />
                                        @error('document_text')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Mô Tả Ngắn</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="short_description" id="short_description" type="text"
                                            placeholder="Mô Tả Ngắn" />
                                        @error('short_description')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Quận/Huyện</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" name="district_id">
                                            @foreach ($districts as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('district_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Trạng Thái</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="status">
                                            <option value="">Chọn trạng thái</option>
                                            <option value="Hoạt động">Hoạt động</option>
                                            <option value="Ngừng hoạt động">Ngừng hoạt động</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Tệp Tin (PDF/DOCS)</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="documents[]" id="documents" type="file" multiple
                                            placeholder="Chọn lớp bản đồ" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-scenarios') }}">
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
