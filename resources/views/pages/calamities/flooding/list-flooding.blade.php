@extends('themes.base')

@section('subhead')
    <title>Danh Sách Thiên Tai Ngập Lụt - PCTT Cà Mau Dashboard</title>
@endsection
@vite(['resources/js/district-commune.js'])
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
            
            <form action="{{ route('view-calamity-flooding') }}" method="GET"
                class="flex flex-wrap items-center gap-3 grow">
                
                <select id="yearSelect" name="year_id"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5">
                    <option value="">-- Chọn năm --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year_id') == $year ? 'selected' : '' }}>
                            {{ $year }}</option>
                    @endforeach
    
                </select>

                <select id="districtSelect" name="district_id"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5">
                    <option value="">-- Chọn huyện --</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                
                <select id="communeSelect" name="commune_id"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5">
                    <option value="">-- Chọn xã --</option>
                  
                </select>

                
                <select id="riskLevelSelect" name="risk_level_id"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg p-2.5">
                    <option value="">Cấp độ thiên tai</option>
                    @foreach ($riskLevels as $riskLevel)
                        <option value="{{ $riskLevel->id }}" data-fulltext="{{ $riskLevel->name }}"
                            {{ request('risk_level_id') == $riskLevel->id ? 'selected' : '' }}>
                            {{ request('risk_level_id') == $riskLevel->id ? Str::limit($riskLevel->name, 20, '...') : $riskLevel->name }}
                        </option>
                    @endforeach
                </select>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="name" placeholder="Tìm kiếm..." value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>

            @auth
                <a href="{{ route('create-calamity-flooding') }}">
                    <button class="shadow-md h-10" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Tạo Mới Ngập Lụt
                    </button>
                </a>    
                <a href="{{ route('export-flooding-calamity') }}">
                    <button class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    {!! $icons['download'] !!}Tải dữ liệu
                    </button>
                </a> 
            @endauth
            
        </div>
        
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng vị trí ngập lụt: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <form action="{{ route('delete-multiple-calamity-flooding') }}"class = "col-span-2" method="POST">
            @csrf
            @method('DELETE')
            @auth
            <button type="submit" class="bg-red-700 sticky left-0" id="delete-multiple-btn" disabled>
                {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
            </button>
            @endauth
            
        </form>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <table class="mt-2 border-separate border-spacing-y-[10px] ">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">Tên khu vực ngập</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Loại hình ngập</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Địa phương</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Cấp độ rủi ro</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Toạ độ</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Khoảng ngập</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Mức độ (m)</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Diện tích (ha)</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Bắt đầu</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Kết thúc</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Nước rút (giờ)</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Nguyên nhân</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Số hộ ảnh hưởng</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Thiệt hại người</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Thiệt hại tài sản</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Hạ tầng hư hại</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Biện pháp</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Bản đồ</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Hình ảnh</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Video</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Nguồn</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Cập nhật</th>
                        @auth
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Hành động</th>
                        @endauth
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
                            <tr class="bg-white ">
                                <th class="sticky left-0 z-1 bg-white w-[40px] min-w-[40px] max-w-[40px]  text-center">
                                    <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}">
                                </th>
                                <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                                    <a class="whitespace-nowrap font-medium" href="/calamity/edit-flooding/{{ $value->id }}">{{ $value->name }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                                    {!! $value->sub_type_of_calamities->count() > 1
                                    ? $value->sub_type_of_calamities->pluck('name')->implode(',<br>')
                                    : $value->sub_type_of_calamities->first()->name ?? '' !!}
                                    
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                                    {!! $value->communes->count() > 1
                                    ? $value->communes->pluck('name')->implode(',<br>')
                                    : $value->communes->first()->name ?? '' !!}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->risk_level->name ?? '' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->coordinates }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
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
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->flood_level }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->flooded_area }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ \Carbon\Carbon::parse($value->time_start)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ \Carbon\Carbon::parse($value->time_end)->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->sprint_time }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->reason }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->number_of_people_affected }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->human_damage }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->property_damage }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->damaged_infrastructure }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->mitigation_measures }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                                    @if (!empty($value->image))
                                    <div class="relative w-24 h-16 cursor-pointer"
                                        onclick="openImageModal('{{ asset($value->image) }}')">
                                        <img src="{{ asset($value->image) }}"
                                            class="w-full h-full object-cover rounded-md shadow-md pointer-events-none" />
                                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-xs font-bold rounded-md">
                                            Xem Hình
                                        </div>
                                    </div>
                                    @else
                                    <span class="text-gray-500 italic">Chưa có hình ảnh</span>
                                    @endif

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->data_source }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->updated_at }}</td>
                                @auth
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                                    <div class="flex gap-3 text-center">
                                        <a href="/calamity/edit-flooding/{{ $value->id }}" class="text-blue-700 flex items-center">
                                            {!! $icons['edit-2'] !!} Sửa
                                        </a>
                                        <a class="flex items-center text-red-600"
                                        onclick="openDeleteModal('{{ route('delete-calamity-flooding', ['id' => $value->id]) }}')"
                                        href="javascript:void(0);">
                                            {!! $icons['trash-2'] !!} Xoá
                                        </a>
                                    
                                    </div>
                                </td>
                                @endauth
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            
            </form>
        </div>

    </div>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            {{ $data->links() }}
        </div>
        
        </div>

        <div id="videoModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-75 hidden z-50">
            <div class="relative w-[80%] max-w-4xl">
                <video id="videoPlayer" class="w-full rounded-lg shadow-lg" controls>
                    <source id="videoSource" src="" type="video/mp4">
                </video>
            </div>
    </div>
@endsection

    <div class="fixed inset-0 z-50 hidden" id="delete-confirmation-modal" aria-modal="true">
        
        <div class="fixed inset-0 bg-black/50"></div>

        <div class="flex min-h-screen items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md z-50 p-6">
                <div class="flex items-start space-x-3">
                    <div class="text-red-500">
                        {!! $icons['warning-circle'] !!}
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Xác nhận xoá</h3>
                        <p class="mt-1 text-sm text-gray-600">Xác nhận xóa dữ liệu này?</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" onclick="closeDeleteModal()"
                            class="bg-white px-4 py-2 rounded border text-gray-700 hover:bg-gray-100">
                        Hủy
                    </button>
                    
                    <a href="#" id="confirm-delete"
                    class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                        Xoá
                    </a>
                </div>
            </div>
        </div>
    </div>
    
<script>
      
    function openDeleteModal(url) {
        const modal = document.getElementById('delete-confirmation-modal');
        modal.classList.remove('hidden');
        setDeleteUrl(url);
    }
    function closeDeleteModal() {
        document.getElementById('delete-confirmation-modal').classList.add('hidden');
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('confirm-delete').addEventListener('click', closeDeleteModal);
    });
      
    function setDeleteUrl(url) {
        document.getElementById('confirm-delete').setAttribute('href', url);
    }
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const countSpan = document.getElementById('selected-count');
        const deleteBtn = document.getElementById('delete-multiple-btn');

        function updateCount() {
            const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
            countSpan.textContent = selectedCount;
            deleteBtn.disabled = selectedCount === 0;
        }

        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateCount();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', updateCount));

        updateCount();
    });

    function openVideoModal(videoUrl) {
        document.getElementById('videoSource').src = videoUrl;
        document.getElementById('videoPlayer').load();
        document.getElementById('videoModal').classList.remove('hidden');
    }
    document.addEventListener("DOMContentLoaded", function() {
        const videoModal = document.getElementById("videoModal");
        const videoPlayer = document.getElementById("videoPlayer");
       
        videoModal.addEventListener("click", function(event) {
            if (event.target === videoModal) {
                videoModal.classList.add("hidden");
                videoPlayer.pause();
            }
        });
    });
        function openImageModal(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('imagePreview');
        img.src = src;
        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.getElementById('imagePreview').src = ''; 
    }
    document.addEventListener("DOMContentLoaded", function() {
        let districtSelect = document.querySelector("#districtSelect");
        let communeSelect = document.querySelector("#communeSelect");
        if (districtSelect && communeSelect) {
            let districtTS = districtSelect.tomselect;
            let communeTS = communeSelect.tomselect;
            
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }
            
            let selectedDistrictId = getQueryParam("district_id") || "";
            let selectedCommuneId = getQueryParam("commune_id") || "";
            
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
            
            loadCommunes(selectedDistrictId, selectedCommuneId);
            
            districtTS.on("change", function() {
                let districtId = this.getValue();
                loadCommunes(districtId);
            });
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        let select = document.getElementById("riskLevelSelect");
        let selectedOption = select.options[select.selectedIndex]; 
        let maxLength = 15; 
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
