@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Phương Án Ứng Phó - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['home'] !!}
        Cập Nhật Phương Án Ứng Phó
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-scenarios') }}" method="post">
                <input type="hidden" name="id" value="{{ $data->id }}">
                @csrf
                <!-- BEGIN: Risk Level Information -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Phương Án Ứng Phó
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Cột 1 -->
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
                                            placeholder="Tên Phương Án" value="{{ $data->name }}" />
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-64">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Loại Hình Thiên Tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="type_of_calamity_id">
                                            @foreach ($calamities as $calamity)
                                                <option value="{{ $calamity->id }}"
                                                    {{ $data->type_of_calamity_id == $calamity->id ? 'selected' : '' }}>
                                                    {{ $calamity->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                        <x-base.litepicker class="mx-auto block" data-single-mode="true" data-lang="vi-VN"
                                            name="updated_time" id="updated_time"
                                            value="{{ old('updated_time', isset($data->updated_time) ? \Carbon\Carbon::parse($data->updated_time)->format('Y-m-d') : '') }}" />
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
                                            placeholder="Mô Tả Văn Bản" rows="5" cols="40">
                                            {{ $data->short_description }}
                                        </x-base.form-textarea>
                                        @error('document_text')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                    </div>
                                </div>
                            </div>
                            <!-- Cột 2 -->
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
                                            placeholder="Mô Tả Ngắn" value="{{ $data->short_description }}" />
                                        @error('short_description')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
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
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ $data->district_id == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
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
                                            <option value="Hoạt động"
                                                {{ old('status', $data->status) == 'Hoạt động' ? 'selected' : '' }}>
                                                Hoạt động
                                            </option>
                                            <option value="Ngừng hoạt động"
                                                {{ old('status', $data->status) == 'Ngừng hoạt động' ? 'selected' : '' }}>
                                                Ngừng hoạt động
                                            </option>
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
                                        @php
                                            $documents = !empty($data->document_path)
                                                ? json_decode($data->document_path, true)
                                                : [];
                                        @endphp
                                        @if (!empty($documents))
                                            <div id="documentContainer">
                                                @foreach ($documents as $document)
                                                    <div class="file-item flex items-center gap-2 mt-2"
                                                        data-file="{{ $document }}">
                                                        <a href="{{ asset($document) }}" target="_blank"
                                                            class="text-blue-500 hover:underline">
                                                            {{ basename($document) }}
                                                        </a>
                                                        <button type="button" onclick="hideDocument(this)"
                                                            class="text-red-600 hover:text-red-800">
                                                            ✕
                                                        </button>
                                                        <input type="hidden" name="existing_documents[]"
                                                            value="{{ $document }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <!-- Nút hoàn tác (ẩn mặc định) -->
                                        <button type="button" id="restoreDocument" onclick="showDocument()"
                                            class="hidden mt-2 text-blue-600 hover:underline">
                                            Hoàn tác
                                        </button>
                                   
                                        <!-- Input để chọn file mới -->
                                        <input type="file" name="documents[]" id="documents" multiple
                                             class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">
                                        <!-- Input ẩn chứa danh sách file bị xoá -->
                                        <input type="hidden" name="deleted_documents" id="deletedDocuments"
                                            value="[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Product Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-scenarios') }}">
                        <button type="button"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                            Huỷ Bỏ</button>
                    </a>
                    @if ($userCurrent->is_master || $userCurrent->hasPermission('update-scenarios'))
                       <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                        Lưu
                    </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        //file document
        let deletedDocuments = [];

        function hideDocument(button) {
            let fileItem = button.parentElement;
            let filePath = fileItem.getAttribute("data-file");
            deletedDocuments.push(filePath);
            document.getElementById("deletedDocuments").value = JSON.stringify(deletedDocuments);
            fileItem.style.display = "none";
            document.getElementById("restoreDocument").classList.remove("hidden");
        }

        function showDocument() {
            if (deletedDocuments.length > 0) {
                let filePath = deletedDocuments.pop();
                document.getElementById("deletedDocuments").value = JSON.stringify(deletedDocuments);

                let fileItems = document.querySelectorAll(".file-item");
                fileItems.forEach(item => {
                    if (item.getAttribute("data-file") === filePath) {
                        item.style.display = "flex";
                    }
                });
            }
            if (deletedDocuments.length === 0) {
                document.getElementById("restoreDocument").classList.add("hidden");
            }
        }
    </script>
@endpush
