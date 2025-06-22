@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Quận Huyện - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['home'] !!}
        Cập Nhật Quận Huyện
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-district') }}" method="post">
                <input type="hidden" name="id" value="{{ $district->id }}">
                @csrf
                <!-- BEGIN: Risk Level Information -->
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                            {!! $icons['chevron-down'] !!} Thông Tin Quận Huyện
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Quận Huyện</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="name" id="name" type="text"
                                        placeholder="Tên Quận Huyện" value="{{ $district->name }}" />
                                    <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mã</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="code" id="code" type="text"
                                        placeholder="Mã Quận Huyện" value="{{ $district->code }}" />
                                    <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
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
                                    <x-base.form-input name="coordinates" id="coordinates" type="text"
                                        placeholder="Toạ Độ" value="{{ $district->coordinates }}" />
                                    <x-base.form-help class="text-right"> Tối thiểu 5 ký tự </x-base.form-help>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Địa Bàn ( đường dẫn )</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    @php
                                        $maps = !empty($district->map) ? json_decode($district->map, true) : [];
                                    @endphp
                                    @if (!empty($maps))
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
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Sức chứa</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <x-base.form-input name="population" id="population" type="number"
                                        placeholder="Sức chứa"
                                        value="{{ number_format($district->population, 0, ',', '.') }}" />
                                    <x-base.form-help class="text-right"> Sử dụng số liệu </x-base.form-help>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tỉnh Thành</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <select class="w-full" id="crud-form-2" name="city_id">
                                        @foreach ($cities as $city)
                                            <option value="{{ $district->city_id }}"
                                                {{ $district->city_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Product Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-district') }}">
                        <button type="button"
                            class="transition duration-200 border shadow-sm inline-flex items-center justify-center px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed w-full border-slate-300 py-3 text-slate-500 dark:border-darkmode-400 md:w-52">Huỷ
                            Bỏ</button>
                    </a>
                    @if ($userCurrent->is_master || $userCurrent->hasPermission('update-district'))
                        <button class="w-full py-3 md:w-52" type="submit" variant="primary">
                            Lưu
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
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
</script>
