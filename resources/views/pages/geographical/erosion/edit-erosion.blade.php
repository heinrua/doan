@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Khu Vực Xói, Bồi - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-rain'] !!}
        Cập Nhật Khu Vực Xói, Bồi
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-erosion') }}" method="post">
                <input type="hidden" name="id" value="{{ $data->id }}">
                @csrf
                <input type="hidden" name="type" value="erosion">
                <!-- BEGIN: Flooding Information -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            {!! $icons['chevron-down'] !!} Thông Tin Khu Vực Xói, Bồi
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên khu vực xói bồi</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="name" id="name" type="text"
                                        value="{{ $data->name }}" placeholder="Tên khu vực xói bồi" />
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
                                            <div class="font-medium">Xã</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <select class="w-full" id="crud-form-2" name="commune_id">
                                        @foreach ($communes as $commune)
                                            <option value="{{ $commune->id }}"
                                                {{ $data->commune_id == $commune->id ? 'selected' : '' }}>
                                                {{ $commune->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Phân loại xói bồi</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <select class="w-full" id="crud-form-2" name="category">
                                    <option value="Xói lở và bồi tụ" @selected(old('category', $data->category ?? '') == 'Xói lở và bồi tụ')>
                                        Xói lở và bồi tụ
                                    </option>
                                    <option value="Xói lở" @selected(old('category', $data->category ?? '') == 'Xói lở')>
                                        Xói lở
                                    </option>
                                    <option value="Bồi tụ" @selected(old('category', $data->category ?? '') == 'Bồi tụ')>
                                        Bồi tụ
                                    </option>
                                </select>

                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tiến độ thực hiện</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <select class="w-full" id="crud-form-2" name="progress">
                                    <option value="Đang xử lý" @selected(old('progress', $data->progress ?? '') == 'Đang xử lý')>
                                        Đang xử lý
                                    </option>
                                    <option value="Chưa thực hiện" @selected(old('progress', $data->progress ?? '') == 'Chưa thực hiện')>
                                        Chưa thực hiện
                                    </option>
                                    <option value="Hoàn thành" @selected(old('progress', $data->progress ?? '') == 'Hoàn thành')>
                                        Hoàn thành
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Năm bắt đầu</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="start_year" id="start_year" type="text"
                                        value="{{ $data->start_year }}" placeholder="Năm bắt đầu" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Năm hoàn thành</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="end_year" id="end_year" type="text"
                                        value="{{ $data->end_year }}" placeholder="Năm hoàn thành" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Diện tích (ha)</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="area" id="area" type="text"
                                        value="{{ $data->area }}" placeholder="Diện tích (ha)" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Quy mô ảnh hưởng</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="scale" id="scale" type="text"
                                        value="{{ $data->scale }}" placeholder="Quy mô ảnh hưởng" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mức độ ảnh hưởng</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="impact_level" id="impact_level" type="text"
                                        value="{{ $data->impact_level }}" placeholder="Mức độ ảnh hưởng" />
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
                                        value="{{ $data->coordinates }}" placeholder="Toạ độ" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tổng mức đầu tư</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="total_investment" id="total_investment" type="text"
                                        value="{{ $data->total_investment }}" placeholder="Tổng mức đầu tư" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Nguồn vốn</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="funding_source" id="funding_source" type="text"
                                        value="{{ $data->funding_source }}" placeholder="Nguồn vốn" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
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
                                    <x-base.form-input value="{{ $data->map }}" name="map" id="map"
                                        type="file" placeholder="Chọn lớp bản đồ" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
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
                                    <!-- Hiển thị ảnh nếu có -->
                                    @if ($data->image)
                                        <x-base.image-zoom src="{{ asset($data->image) }}" alt="Hình ảnh"
                                            class="mb-3 h-40 w-auto rounded-lg shadow" />
                                    @endif
                                    <!-- Input để upload ảnh mới -->
                                    <x-base.form-input name="image" id="image" type="file"
                                        placeholder="Hình ảnh" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
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
                                    @if (!empty($data->video))
                                        <div class="mt-4">
                                            <video id="videoPreview" class="w-full max-w-md rounded-lg shadow-md"
                                                controls>
                                                <source src="{{ asset($data->video) }}" type="video/mp4">
                                                Trình duyệt của bạn không hỗ trợ video.
                                            </video>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Flooding Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-erosion') }}">
                        <button type="button"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">Huỷ
                            Bỏ</button>
                    </a>
                    <button class="w-full py-3 md:w-52" type="submit" variant="primary">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    document.getElementById('videoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const videoPreview = document.getElementById('videoPreview');
            videoPreview.src = URL.createObjectURL(file);
            videoPreview.load();
        }
    });
</script>
