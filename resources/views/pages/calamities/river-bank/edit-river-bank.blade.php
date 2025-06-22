@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Sạt Lở - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-rain'] !!}
        Cập Nhật Sạt Lở
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-calamity-river-bank') }}"
                method="post">
                <input type="hidden" name="id" value="{{ $calamity->id }}">
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
                                            placeholder="Vị Trí Sạt Lở" value="{{ $calamity->name }}" />
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
                                                <div class="font-medium">Loại Hình Thiên Tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="type_of_calamity_id">
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
                                            @foreach ($subTypeOfCalamities as $subTypeOfCalamity)
                                                <option value="{{ $subTypeOfCalamity->id }}"
                                                    {{ optional($calamity->sub_type_of_calamities->first())->id == $subTypeOfCalamity->id ? 'selected' : '' }}>
                                                    {{ $subTypeOfCalamity->name }}
                                                </option>
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
                                        <x-base.form-input value="{{ $calamity->coordinates }}" name="coordinates"
                                            id="coordinates" type="text" placeholder="Tọa độ vị trí"
                                            onblur="updateMapFromInput()" />
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
                                            @foreach ($risk_levels as $risk_level)
                                                <option value="{{ $risk_level->id }}"
                                                    {{ $calamity->risk_level_id == $risk_level->id ? 'selected' : '' }}>
                                                    {{ $risk_level->name }}
                                                </option>
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
                                        <x-base.litepicker class="mx-auto block" data-single-mode="true" data-lang="vi-VN"
                                            name="selected_date" id="selected_date"
                                            value="{{ old('selected_date', isset($calamity->time) ? \Carbon\Carbon::parse($calamity->time)->format('Y-m-d') : '') }}" />
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
                                        <x-base.form-input value="{{ $calamity->address }}" name="address" id="address"
                                            type="text" placeholder="Điạ điểm" />
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
                                            @foreach ($communes as $commune)
                                                <option value="{{ $commune->id }}"
                                                    {{ optional($calamity->communes->first())->id == $commune->id ? 'selected' : '' }}>
                                                    {{ $commune->name }}
                                                </option>
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
                                        <x-base.form-input value="{{ $calamity->width }}" name="width" id="width"
                                            type="text" placeholder="Chiều rộng (m)" />
                                    </div>
                                    <div class="w-full md:w-1/3">
                                        <x-base.form-input value="{{ $calamity->length }}" name="length" id="length"
                                            type="text" placeholder="Chiều dài (m)" />
                                    </div>
                                    <div class="w-full md:w-1/3">
                                        <x-base.form-input value="{{ $calamity->acreage }}" name="acreage"
                                            id="acreage" type="text" placeholder="Diện tích (m²)" />
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
                                        <x-base.form-input value="{{ $calamity->reason }}" name="reason" id="reason"
                                            type="text" placeholder="Nguyên nhân" />
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
                                        <x-base.form-input value="{{ $calamity->geology }}" name="geology"
                                            id="geology" type="text" placeholder="Địa chất" />
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
                                        <x-base.form-input value="{{ $calamity->support_policy }}" name="support_policy"
                                            id="support_policy" type="text" placeholder="Chính sách hỗ trợ" />
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
                                        <x-base.form-input value="{{ $calamity->watermark_points }}"
                                            name="watermark_points" id="watermark_points" type="text"
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
                                        <x-base.form-input value="{{ $calamity->mitigation_measures }}"
                                            name="mitigation_measures" id="mitigation_measures" type="text"
                                            placeholder="Các biện pháp giảm thiểu" />
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
                                        <x-base.form-input value="{{ $calamity->human_damage }}" name="human_damage"
                                            id="human_damage" type="text" placeholder="Thiệt hại về người" />
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
                                        <x-base.form-input value="{{ $calamity->property_damage }}"
                                            name="property_damage" id="property_damage" type="text"
                                            placeholder="Thiệt hại về tài sản" />
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
                                        <x-base.form-input value="{{ $calamity->investment_level }}"
                                            name="investment_level" id="investment_level" type="text"
                                            placeholder="Mức độ" />
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
                                                        <div class="file-item flex items-center gap-2 mt-2"
                                                            data-file="{{ $map }}">
                                                            <a href="{{ asset($map) }}" target="_blank"
                                                                class="text-blue-500 hover:underline">
                                                                {{ basename($map) }}
                                                            </a>
                                                            <button type="button" onclick="hideMap(this)"
                                                                class="text-red-600 hover:text-red-800">
                                                                ✕
                                                            </button>
                                                            <input type="hidden" name="existing_maps[]"
                                                                value="{{ $map }}">
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
                <!-- END: Product Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-calamity-river-bank') }}">
                        <button type="button"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">Huỷ
                            Bỏ</button>
                    </a>
                    @if ($userCurrent->is_master || $userCurrent->hasPermission('update-calamity-river-bank'))
                        <button class="w-full py-3 md:w-52" type="submit" variant="primary">
                            Lưu
                        </button>
                    @endif
                </div>
            </form>
            <div id="mapRiver" class="mt-5 w-full h-[700px] rounded-lg border"></div>
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
        let mapRiver, kmlLayers = new Map(),
            currentLayer = null,
            markers = new Map();
        let infoWindowRiver;
        let marker;

        function initializeApp() {
            initMap();
            const calamity = @json($calamity); // từ Laravel
            showSingleLandslideMarker(calamity);
            const kmlFiles = @json($calamity->map);
            // Đảm bảo kmlFiles là mảng, nếu không thì gán mảng rỗng
            const safeKmlFiles = Array.isArray(kmlFiles) ? kmlFiles : [];
            safeKmlFiles.forEach(url => addKmlLayer(url));
        }

        function initMap() {
            mapRiver = new google.maps.Map(document.getElementById('mapRiver'), {
                center: {
                    lat: 8.946132,
                    lng: 105.033270
                },
                zoom: 11
            });
            infoWindowRiver = new google.maps.InfoWindow();
            // Click vào bản đồ để đặt marker mới
            mapRiver.addListener("click", function(event) {
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
                        map: mapRiver,
                        draggable: true
                    });
                }
                // Gọi hàm lấy địa chỉ
                getAddressFromCoordinates(lat, lng);
            });

        }

        // tự động điền địa chỉ khi click marker trên bản đồ.
        function getAddressFromCoordinates(lat, lng) {
            const geocoder = new google.maps.Geocoder();
            const latlng = {
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            };
            geocoder.geocode({
                location: latlng
            }, function(results, status) {
                if (status === "OK") {
                    if (results[0]) {
                        const address = results[0].formatted_address;
                        document.getElementById("address").value = address;
                    } else {
                        console.warn("Không tìm thấy địa chỉ");
                    }
                } else {
                    console.error("Lỗi geocoder: " + status);
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
                    mapRiver.setCenter(newLocation);
                    mapRiver.setZoom(13);
                    marker.setPosition(newLocation); // marker toàn cục đã tồn tại
                    getAddressFromCoordinates(lat, lng);
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
                map: mapRiver,
                draggable: true,
                icon: {
                    url: "/uploads/map/falling_rocks.png",
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
                infoWindowRiver.setContent(generateContent(calamity));
                infoWindowRiver.open(mapRiver, marker);
            });
            google.maps.event.addListener(infoWindowRiver, "domready", function() {
                const closeBtn = document.querySelector(".gm-ui-hover-effect");
                if (closeBtn) closeBtn.style.display = "none";
                const customClose = document.getElementById("custom-close-btn");
                if (customClose) {
                    customClose.addEventListener("click", () => {
                        infoWindowRiver.close();
                    });
                }
            });
            mapRiver.setCenter(marker.getPosition());
            mapRiver.setZoom(11);
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
                <div style="background: linear-gradient(to right, #e74c3c, #c0392b); color: white; padding: 14px 20px; text-align: center;">
                    <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                        ${calamity.name} (Sạt lở)
                    </div>
                </div>
                <!-- Info content -->
               <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">📏</span>
                        <strong>Chiều dài:</strong>&nbsp;${calamity.length || "Không có"} m
                    </div>
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">📐</span>
                        <strong>Chiều rộng:</strong>&nbsp;${calamity.width || "Không có"} m
                    </div>
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">🧮</span>
                        <strong>Diện tích:</strong>&nbsp;${calamity.acreage || "Không có"} m²
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
            if (kmlLayers.has(url)) return;

            const layer = new google.maps.KmlLayer({
                url: url,
                map: mapRiver,
                preserveViewport: true
            });
            kmlLayers.set(url, layer);
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&libraries=places&callback=initMap"
        async defer loading="async"></script>
@endpush
