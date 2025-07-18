@extends('themes.base')

@section('subhead')
    <title>Danh Sách Thiên Tai Bão Và Áp Thấp Nhiệt Đới - PCTT Cà Mau Dashboard</title>
@endsection
@vite(['resources/js/district-commune.js'])
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
    <x-alert/>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-calamity-storm') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                
                <select name="year_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">-- Chọn năm --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year_id') == $year ? 'selected' : '' }}>
                            {{ $year }}</option>
                    @endforeach
                </select>
                
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
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            @auth
                <a href="{{ route('create-calamity-storm') }}">
                    <button class="shadow-md h-10" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Tạo Mới Bão & ATNĐ
                    </button>
                </a>
                <a href="{{ asset('downloads/mau-du-lieu-bao.xlsx') }}" download
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Tải file mẫu thêm dữ liệu bão
                    </a>

                <button type="button" onclick="openUploadModal('{{ route('import-storm-calamity') }}')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                    {!! $icons['cloud-upload'] !!} Nhập file
                </button>
                
                <a href="{{ route('export-storm-calamity') }}">
                    <button class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    {!! $icons['download'] !!}Tải dữ liệu
                    </button>
                </a> 
            @endauth
        </div>
        
        <div
            class="intro-y col-span-3 overflow-visible lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số bão: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        

        <div class="intro-y col-span-12 overflow-visible lg:overflow-x-auto">
            @auth
            <form action="{{ route('delete-multiple-calamity-storm') }}" method="POST" id="delete-multiple-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="openDeleteMultipleModal()" class="bg-red-700 sticky left-0" id="delete-multiple-btn" disabled>
                    {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
                </button>
            </form>
            @endauth
            <table class="mt-2 border-separate border-spacing-y-[10px] ">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                    <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                    <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4  min-w-[180px]"> Tên bão
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Loại hình </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Địa phương ảnh hưởng</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Toạ Độ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Cấp độ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Cấp độ rủi ro thiên tai </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Thời gian bắt đầu </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Thời gian kết thúc</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Thiệt hại về người
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Thiệt hại về tài sản
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Biện pháp ứng phó
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Chọn lớp bản đồ
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Hình ảnh
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Video
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Thời gian cập nhật
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > HÀNH ĐỘNG
                    </th>
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
                        <td class="sticky left-0 z-1 bg-white w-[40px] min-w-[40px] max-w-[40px]  text-center">
                            <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}">
                        </td>
                        <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                                    <a href="/calamity/edit-storm/{{ $value->id }}">{{ $value->name }}</a>
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
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] "> 
                            {{ $value->coordinates }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ $value->investment_level }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ $value->risk_level->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ \Carbon\Carbon::parse($value->time_start)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ \Carbon\Carbon::parse($value->time_end)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ $value->human_damage }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ $value->property_damage }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ $value->mitigation_measures }}
                        </td>
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
                                                <a href="javascript:void(0);" onclick="showMapModal('{{ $map }}')" class="text-blue-500 hover:underline">
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
                        <td
                           class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
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
                        <td
                           class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
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
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ $value->updated_at ?? '' }}
                        </td>
                        @auth
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            <div class="flex items-center justify-center">
                                <a class="mr-3 flex items-center text-blue-700"
                                    href="/calamity/edit-storm/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                <a class="flex items-center text-red-700" data-tw-toggle="modal"
                                    data-tw-target="#delete-confirmation-modal"
                                    onclick="openDeleteModal('{{ route('delete-calamity-storm', ['id' => $value->id]) }}')"
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

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        {{ $data->links() }}
    </div>
    
    </div>

    

    <div id="videoModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden z-50">
        <div class="relative w-[80%] max-w-4xl">
            <video id="videoPlayer" class="w-full rounded-lg shadow-lg" controls>
                <source id="videoSource" src="" type="video/mp4">
            </video>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden z-50">
        <div class="relative w-[80%] max-w-3xl">
            <img id="imagePreview"
                src=""
                class="w-full max-h-[80vh] object-contain rounded-lg shadow-lg" />
            <button onclick="closeImageModal()"
                    >
                ×
            </button>
        </div>
    </div>

<x-importExel/>
<x-delete-modal/>
<x-delete-multiple-modal/>
@vite(['resources/js/confirm-delete.js','resources/js/district-commune.js','resources/js/import-exel.js'])
@endsection

<script>
   
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

<div id="mapModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="relative bg-white rounded-lg w-full max-w-4xl">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900" id="mapModalTitle">Bản đồ</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" onclick="closeMapModal()">
                    <!-- icon close -->
                    &times;
                </button>
            </div>
            <div class="p-6">
                <div id="map" class="w-full h-[60vh] rounded-lg border"></div>
            </div>
        </div>
    </div>
</div>

<script>
const NGROK_DOMAIN = 'https://ad4999a1bb78.ngrok-free.app';
function closeMapModal() {
    document.getElementById('mapModal').classList.add('hidden');
}
let map;
let modalKmlLayers = new Map();
function showMapModal(kmlUrl) {
    const cleanKmlUrl = kmlUrl.replace(/^\/+/, '');
    const fullUrl = kmlUrl.startsWith("http") ? kmlUrl : `${NGROK_DOMAIN}/${cleanKmlUrl}`;
    console.log('Original URL:', kmlUrl);
    console.log('Full URL with ngrok:', fullUrl);
    document.getElementById('mapModal').classList.remove('hidden');
    if (!map) initMap();
    modalKmlLayers.forEach(layer => layer.setMap(null));
    modalKmlLayers.clear();
    const layer = new google.maps.KmlLayer({
        url: fullUrl,
        map: map,
        preserveViewport: false,
    });
    modalKmlLayers.set(fullUrl, layer);
    google.maps.event.addListener(layer, "status_changed", function () {
        if (layer.getStatus() !== google.maps.KmlLayerStatus.OK) {
            alert(`❌ Không thể tải KML từ ${fullUrl}.`);
        }
    });
}
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 9.176, lng: 105.15 },
        zoom: 10
    });
}
</script>
