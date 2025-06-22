@extends('themes.base')

@section('subhead')
    <title>Danh Sách Thiên Tai Ngập Lụt - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['arlett-triangle'] !!}
            Danh Sách Thiên Tai Ngập Lụt
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-calamity-flooding') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <!-- Form tìm kiếm -->
            <form action="{{ route('view-calamity-flooding') }}" method="GET"
                class="flex flex-wrap items-center gap-3 grow">
                <!-- Dropdown chọn loại -->
                <select id="yearSelect" name="year_id"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Chọn năm --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year_id') == $year ? 'selected' : '' }}>
                            {{ $year }}</option>
                    @endforeach
    
                </select>

                <!-- Dropdown chọn huyện -->
                <select id="districtSelect" name="district_id"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Chọn huyện --</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                
                <select id="communeSelect" name="commune_id"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Chọn xã --</option>
                    
                </select>

    

                {{-- Chọn cấp độ thiên tai --}}
                <select id="riskLevelSelect" name="risk_level_id"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5 dark:bg-gray-700 dark:text-white">
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
                    <input type="text" name="name" placeholder="Tìm kiếm..." value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <!-- Nút tìm kiếm -->
                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            <!-- Nút tạo mới -->
            
            
            @if ($userCurrent->is_master || $userCurrent->hasPermission('create-calamity-flooding'))
                <a href="{{ route('create-calamity-flooding') }}">
                    <button class="shadow-md h-10" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Tạo Mới Ngập Lụt
                    </button>
                </a>
            @endif
        </div>
        <!-- BEGIN: Total Records -->
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng vị trí ngập lụt: <span class="font-semibold">{{ $data->total() }}</span>
        </div>

        <!-- END: Total Records -->
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <table class="w-full min-w-[1200px] text-left text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="sticky left-0 z-20 bg-white px-4 py-2 border-r">#</th>
                            <th class="sticky left-[60px] z-20 bg-white px-4 py-2 border-r">Tên khu vực ngập</th>
                            <th class="px-6 py-3">Loại hình ngập</th>
                            <th class="px-6 py-3">Địa phương</th>
                            <th class="px-6 py-3">Cấp độ rủi ro</th>
                            <th class="px-6 py-3">Toạ độ</th>
                            <th class="px-6 py-3">Khoảng ngập</th>
                            <th class="px-6 py-3">Mức độ (m)</th>
                            <th class="px-6 py-3">Diện tích (ha)</th>
                            <th class="px-6 py-3">Bắt đầu</th>
                            <th class="px-6 py-3">Kết thúc</th>
                            <th class="px-6 py-3">Nước rút (giờ)</th>
                            <th class="px-6 py-3">Nguyên nhân</th>
                            <th class="px-6 py-3">Số hộ ảnh hưởng</th>
                            <th class="px-6 py-3">Thiệt hại người</th>
                            <th class="px-6 py-3">Thiệt hại tài sản</th>
                            <th class="px-6 py-3">Hạ tầng hư hại</th>
                            <th class="px-6 py-3">Biện pháp</th>
                            <th class="px-6 py-3">Bản đồ</th>
                            <th class="px-6 py-3">Hình ảnh</th>
                            <th class="px-6 py-3">Video</th>
                            <th class="px-6 py-3">Nguồn</th>
                            <th class="px-6 py-3">Cập nhật</th>
                            <th class="px-6 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->isEmpty())
                        <tr>
                            <td colspan="11" class="text-center py-6">
                                <div class="flex flex-col items-center justify-center text-slate-500">
                                    {!! $icons['frown'] !!}
                                    <div class="mt-2 text-lg">Hiện tại không có dữ liệu</div>
                                </div>
                            </td>
                        </tr>
                        @else
                        @foreach ($data as $key => $value)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="sticky left-0 z-10 bg-white  px-10 py-2 border-r">{{ $data->firstItem() + $key }}</td>
                                <td class="sticky left-[60px] z-10 bg-white px-10 py-2 border-r">
                                    <a href="/calamity/edit-flooding/{{ $value->id }}">{{ $value->name }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    {!! $value->sub_type_of_calamities->count() > 1
                                    ? $value->sub_type_of_calamities->pluck('name')->implode(',<br>')
                                    : $value->sub_type_of_calamities->first()->name ?? '' !!}
                                    
                                </td>
                                <td class="px-6 py-4">
                                    {!! $value->communes->count() > 1
                                    ? $value->communes->pluck('name')->implode(',<br>')
                                    : $value->communes->first()->name ?? '' !!}
                                </td>
                                <td class="px-6 py-4">{{ $value->risk_level->name ?? '' }}</td>
                                <td class="px-6 py-4">{{ $value->coordinates }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $floodRangeMapping = [
                                            '0-0.5m' => '0m -> 0.5m',
                                            '0.5-1m' => '0.5m -> 1m',
                                            '1-1.5m' => '1m -> 1.5m',
                                            '1.5-2m' => '1.5m -> 2m',
                                            '>2m' => '> 2m',
                                        ];
                                        echo $floodRangeMapping[$value->flood_range] ?? $value->flood_range;
                                    @endphp
                                </td>
                                <td class="px-6 py-4">{{ $value->flood_level }}</td>
                                <td class="px-6 py-4">{{ $value->flooded_area }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($value->time_start)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($value->time_end)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">{{ $value->sprint_time }}</td>
                                <td class="px-6 py-4">{{ $value->reason }}</td>
                                <td class="px-6 py-4">{{ $value->number_of_people_affected }}</td>
                                <td class="px-6 py-4">{{ $value->human_damage }}</td>
                                <td class="px-6 py-4">{{ $value->property_damage }}</td>
                                <td class="px-6 py-4">{{ $value->damaged_infrastructure }}</td>
                                <td class="px-6 py-4">{{ $value->mitigation_measures }}</td>
                                <td class="px-6 py-4">
                                    @php $maps = json_decode($value->map, true); @endphp
                                    @if (!empty($maps) && is_array($maps))
                                        <ul class="list-disc pl-4 max-h-32 overflow-y-auto text-sm">
                                            @foreach ($maps as $map)
                                                <li><a href="{{ asset($map) }}" target="_blank" class="text-blue-500 hover:underline">{{ basename($map) }}</a></li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-500 italic">Không có</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if (!empty($value->image))
                                        <img src="{{ asset($value->image) }}" class="w-24 h-auto rounded shadow-md" />
                                    @else
                                        <span class="text-gray-500 italic">Chưa có</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if (!empty($value->video))
                                        <div class="relative w-24 h-16 cursor-pointer" onclick="openVideoModal('{{ asset($value->video) }}')">
                                            <video class="w-full h-full object-cover rounded-md pointer-events-none">
                                                <source src="{{ asset($value->video) }}" type="video/mp4">
                                            </video>
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white text-xs font-bold rounded-md">Xem Video</div>
                                        </div>
                                    @else
                                        <span class="text-gray-500 italic">Chưa có</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $value->data_source }}</td>
                                <td class="px-6 py-4">{{ $value->updated_at }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3 justify-center">
                                        <a href="/calamity/edit-flooding/{{ $value->id }}" class="text-blue-700 flex items-center">
                                            {!! $icons['edit-2'] !!} Sửa
                                        </a>
                                        @if ($userCurrent->role_id == 2)
                                            <a href="javascript:void(0);" onclick="openDeleteModal('{{ route('delete-calamity-flooding', ['id' => $value->id]) }}')" class="text-red-600 flex items-center">
                                                {!! $icons['trash-2'] !!} Xoá
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

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
        <div id="videoModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-75 hidden z-50">
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
