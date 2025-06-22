@extends('themes.base')

@section('subhead')
    <title>Danh Sách Thiên Tai Bão Và Áp Thấp Nhiệt Đới - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['cloud-lightning'] !!}
            Danh Sách Thiên Tai Bão Và Áp Thấp Nhiệt Đới
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-calamity-storm') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-calamity-storm') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                <!-- Dropdown chọn loại -->
                <select name="year_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">-- Chọn năm --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year_id') == $year ? 'selected' : '' }}>
                            {{ $year }}</option>
                    @endforeach
                </select>
                <!-- Dropdown chọn loại -->
                <select id="districtSelect" name="district_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">--Chọn huyện--</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                <select id="communeSelect" name="commune_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">--Chọn xã--</option>
                </select>
                {{-- Chọn cấp độ thiên tai --}}
                <select id="riskLevelSelect" name="risk_level_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">Cấp độ thiên tai</option>
                    @foreach ($riskLevels as $riskLevel)
                        <option value="{{ $riskLevel->id }}" data-fulltext="{{ $riskLevel->name }}"
                            {{ request('risk_level_id') == $riskLevel->id ? 'selected' : '' }}>
                            {{ request('risk_level_id') == $riskLevel->id ? Str::limit($riskLevel->name, 20, '...') : $riskLevel->name }}
                        </option>
                    @endforeach
                </select>
                <!-- Ô tìm kiếm -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <!-- Nút tìm kiếm -->
                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            @if ($userCurrent->is_master || $userCurrent->hasPermission('create-calamity-storm'))
                <a href="{{ route('create-calamity-storm') }}">
                    <button class="shadow-md h-10" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Tạo Mới Bão & ATNĐ
                    </button>
                </a>
            @endif
        </div>
        <!-- BEGIN: Total Records -->
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số bão: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <!-- END: Total Records -->
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            @if ($data->isEmpty())
                <div class="text-center py-8">
                    {!! $icons['frown'] !!}
                    <div class="mt-3 text-xl text-slate-500">Hiện tại không có dữ liệu</div>
                </div>
        </div>
    @else
        <table class="-mt-2 border-separate border-spacing-y-[10px]">
            <table.thead>
                <table.tr>
                    <table.th class="whitespace-nowrap  bg-white dark:bg-darkmode-700 sticky left-0 z-10">
                        #
                    </table.th>
                    <table.th
                        class="whitespace-nowrap  text-center bg-white dark:bg-darkmode-700 sticky left-12 z-10 uppercase">
                        Tên bão
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Loại hình
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Địa phương ảnh hưởng
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Toạ Độ
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Cấp độ
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Cấp độ rủi ro thiên tai
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Thời gian bắt đầu
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Thời gian kết thúc
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Thiệt hại về người
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Thiệt hại về tài sản
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Biện pháp ứng phó
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Chọn lớp bản đồ
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Hình ảnh
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Video
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Thời gian cập nhật
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        HÀNH ĐỘNG
                    </table.th>
                </table.tr>
            </table.thead>
            <table.tbody>
                @foreach ($data as $key => $value)
                    <table.tr class="intro-x">
                        <table.td
                            class="box sticky rounded-l-none rounded-r-none border-x-0 left-0 z-10 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $data->firstItem() + $key }}
                        </table.td>
                        <table.td
                            class="box sticky rounded-l-none rounded-r-none border-x-0 left-12 z-10 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 ">
                            <a class="whitespace-nowrap font-medium" href="/calamity/edit-storm/{{ $value->id }}">
                                {{ $value->name }}
                            </a>
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {!! $value->sub_type_of_calamities->count() > 1
                                ? $value->sub_type_of_calamities->pluck('name')->implode(',<br>')
                                : $value->sub_type_of_calamities->first()->name ?? '' !!}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {!! $value->communes->count() > 1
                                ? $value->communes->pluck('name')->implode(',<br>')
                                : $value->communes->first()->name ?? '' !!}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->coordinates }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->investment_level }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->risk_level->name }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ \Carbon\Carbon::parse($value->time_start)->format('d-m-Y') }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ \Carbon\Carbon::parse($value->time_end)->format('d-m-Y') }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->human_damage }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->property_damage }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->mitigation_measures }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            @php
                                $maps = json_decode($value->map, true);
                            @endphp
                            @if (!empty($maps) && is_array($maps))
                                <div class="overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200"
                                    style="max-height: {{ count($maps) > 4 ? '150px' : 'auto' }};">
                                    <ul class="list-disc text-left pl-4">
                                        @foreach ($maps as $map)
                                            <li>
                                                <a href="{{ asset($map) }}" target="_blank"
                                                    class="text-blue-500 hover:underline">
                                                    {{ basename($map) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <span class="text-gray-500">Không có bản đồ</span>
                            @endif
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            @if (!empty($value->image))
                                <x-base.image-zoom class="w-full rounded-md" src="{{ asset($value->image) }}" />
                            @else
                                <span class="text-gray-500 italic">Chưa có hình ảnh</span>
                            @endif
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            @if (!empty($value->video))
                                <div class="relative w-24 h-16 cursor-pointer"
                                    onclick="openVideoModal('{{ asset($value->video) }}')">
                                    <video class="w-full h-full object-cover rounded-md shadow-md pointer-events-none">
                                        <source src="{{ asset($value->video) }}" type="video/mp4">
                                        Trình duyệt của bạn không hỗ trợ video.
                                    </video>
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-xs font-bold rounded-md">
                                        Xem Video
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-500 italic">Chưa có video</span>
                            @endif
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->updated_at ?? '' }}
                        </table.td>
                        <table.td @class([
                            'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                            'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                        ])>
                            <div class="flex items-center justify-center">
                                <a class="mr-3 flex items-center text-blue-700"
                                    href="/calamity/edit-storm/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                @if ($userCurrent->is_master || $userCurrent->hasPermission('delete-calamity-storm'))
                                    <a class="flex items-center text-danger" data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal"
                                        onclick="setDeleteUrl('{{ route('delete-calamity-storm', ['id' => $value->id]) }}')"
                                        href="javascript:void(0);">
                                        {!! $icons['trash-2'] !!}> Xoá
                                    </a>
                                @endif
                            </div>
                        </table.td>
                    </table.tr>
                @endforeach
            </table.tbody>
        </table>
        @endif
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        {{ $data->links() }}
    </div>
    <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                {!! $icons['x-circle'] !!}
                <div class="mt-5 text-3xl">Bạn Có Chắc Chắn?</div>
                <div class="mt-2 text-slate-500">
                    Bạn thật sự muốn xoá dữ liệu này? <br />
                    Quá trình sẽ không được hoàn lại.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                    Huỷ Bỏ
                </button>
                <a id="confirm-delete" href="#">
                    <button class="w-24" type="button" variant="danger">
                        Xoá
                    </button>
                </a>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
    <!-- Modal Video -->
    <div id="videoModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden z-50">
        <div class="relative w-[80%] max-w-4xl">
            <video id="videoPlayer" class="w-full rounded-lg shadow-lg" controls>
                <source id="videoSource" src="" type="video/mp4">
            </video>
        </div>
    </div>
@endsection

<script>
    function setDeleteUrl(url) {
        document.getElementById('confirm-delete').setAttribute('href', url);
    }

    function openVideoModal(videoUrl) {
        document.getElementById('videoSource').src = videoUrl;
        document.getElementById('videoPlayer').load();
        document.getElementById('videoModal').classList.remove('hidden');
    }
    document.addEventListener("DOMContentLoaded", function() {
        const videoModal = document.getElementById("videoModal");
        const videoPlayer = document.getElementById("videoPlayer");
        // Đóng modal khi bấm ra ngoài vùng video
        videoModal.addEventListener("click", function(event) {
            if (event.target === videoModal) {
                videoModal.classList.add("hidden");
                videoPlayer.pause();
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        let districtSelect = document.querySelector("#districtSelect");
        let communeSelect = document.querySelector("#communeSelect");
        if (districtSelect && communeSelect) {
            let districtTS = districtSelect.tomselect;
            let communeTS = communeSelect.tomselect;
            //  Hàm lấy giá trị từ URL
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }
            // Lấy giá trị từ URL
            let selectedDistrictId = getQueryParam("district_id") || "";
            let selectedCommuneId = getQueryParam("commune_id") || "";
            //  Hàm tải danh sách xã
            function loadCommunes(districtId = "", selectedCommune = "") {
                communeTS.clear();
                communeTS.clearOptions();

                let url = `{{ route('get-communes') }}`;
                if (districtId) {
                    url += `?district_id=${districtId}`;
                }
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        communeTS.clearOptions();
                        data.forEach(commune => {
                            communeTS.addOption({
                                value: commune.id,
                                text: commune.name
                            });
                        })
                        // Nếu có xã đã chọn từ URL, đặt lại giá trị
                        if (selectedCommune && data.some(c => c.id == selectedCommune)) {
                            communeTS.setValue(selectedCommune);
                        }
                    })
                    .catch(() => {
                        communeTS.clearOptions();
                        communeTS.addOption({
                            value: "",
                            text: "Lỗi tải dữ liệu"
                        });
                    });
            }
            //  Khi tải trang, luôn luôn load danh sách xã
            loadCommunes(selectedDistrictId, selectedCommuneId);
            //  Khi chọn huyện, load lại danh sách xã
            districtTS.on("change", function() {
                let districtId = this.getValue();
                loadCommunes(districtId);
            });
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        let select = document.getElementById("riskLevelSelect");
        let selectedOption = select.options[select.selectedIndex]; // Lấy option đã chọn sau reload
        let maxLength = 15; // Giới hạn ký tự
        function updateDisplayText(option) {
            let fullText = option.getAttribute("data-fulltext") || option.textContent;
            let displayText = fullText.length > maxLength ? fullText.substring(0, maxLength) + "..." : fullText;
            select.nextElementSibling.querySelector(".ts-control").textContent = displayText;
        }
        if (selectedOption && selectedOption.value !== "") {
            updateDisplayText(selectedOption);
        }
        select.addEventListener("change", function() {
            updateDisplayText(this.options[this.selectedIndex]);
        });
    });
</script>
