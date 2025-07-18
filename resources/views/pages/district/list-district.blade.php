@extends('themes.base')

@section('subhead')
    <title>Danh Sách Quận Huyện - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['home'] !!}
            Danh Sách Quận Huyện
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-district') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <x-alert/>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            
            <form action="{{ route('view-district') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                
                <select name="type"
                    class="h-10 w-40 min-w-[150px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">Loại tìm kiếm</option>
                    <option value="name" {{ request('type') == 'name' ? 'selected' : '' }}>Tên</option>
                    <option value="code" {{ request('type') == 'code' ? 'selected' : '' }}>Mã</option>
                    <option value="coordinates" {{ request('type') == 'coordinates' ? 'selected' : '' }}>Toạ độ</option>
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
                
                <a href="{{ route('create-district') }}">
                    <button class="shadow-md h-10 flex items-center gap-2 bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-blue-800">
                        {!! $icons['plus-circle'] !!} Thêm Mới Quận Huyện
                    </button>
                </a>
                <button type="button" onclick="openUploadModal('{{ route('import-districts') }}')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2 ml-2">
                    {!! $icons['cloud-upload'] !!} Nhập file
                </button>
                <a href="{{ asset('downloads/mau-du-lieu-huyen.xlsx') }}" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" download>
                    Tải file mẫu
                </a>
            @endauth
        </div>
        
        <div
            class="intro-y col-span-3 text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm w-full text-center">
            Tổng số quận/huyện: <span class="font-semibold">{{ $data->total() }}</span>
        </div>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            @auth
            <form action="{{ route('delete-multiple-district') }}" method="POST" id="delete-multiple-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="openDeleteMultipleModal()" class="bg-red-700 z-1 sticky left-0" id="delete-multiple-btn" disabled>
                    {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
                </button>
            </form>
            @endauth
            <table class="mt-2 border-separate border-spacing-y-[10px]">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">Tên quận, huyện</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Mã</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Tỉnh/Thành</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Toạ độ</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Số dân</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Lớp Bản Đồ</th>
                        @auth 
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hành động</th> 
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
                            <td class="sticky left-0 z-1 bg-white w-[40px] min-w-[40px] max-w-[40px]  text-center">
                                <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}">
                            </td>
                            <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                            <a class="whitespace-nowrap font-medium"
                                href="/edit-district/{{ $value->id }}">
                                {{ $value->name }}
                            </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                {{ $value->city->name ?? '' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                    {{ $value->coordinates }}
                                </td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                    {{ number_format($value->population, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                @php
                                    $maps = json_decode($value->map, true);
                                @endphp
                                @if (!empty($maps) && is_array($maps))
                                    <div class="overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200"
                                        style="max-height: {{ count($maps) > 4 ? '150px' : 'auto' }};">
                                        <ul class="list-disc text-left pl-4">
                                            @foreach ($maps as $map)
                                            <li>
                                            <a onclick="showMapModal('{{ $map }}')"
                                            href="javascript:void(0);"
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
                            @auth
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                <div class="flex gap-3 text-center">
                                    <a href="/edit-district/{{ $value->id }}" class="text-blue-700 flex items-center">
                                        {!! $icons['edit-2'] !!} Sửa
                                    </a>
                                    <a class="flex items-center text-red-600"
                                    onclick="openDeleteModal('{{ route('delete-district', ['id' => $value->id]) }}')"
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

        
    </div>

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        {{ $data->links() }}
    </div>
    
    </div>

    <div id="mapModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            
            <div class="relative bg-white rounded-lg w-full max-w-4xl">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900" id="mapModalTitle">
                        Bản đồ
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" onclick="closeMapModal()">
                        {!! $icons['x'] !!}
                    </button>
                </div>
                <div class="p-6">
                    <div id="map" class="w-full h-screen rounded-lg border"></div>
                </div>
            </div>
        </div>
    </div>    
    <x-importExel/>
    <x-delete-modal/>
    <x-delete-multiple-modal/>
    @vite(['resources/js/confirm-delete.js','resources/js/import-exel.js'])
@endsection
<script>
const NGROK_DOMAIN = 'https://ad4999a1bb78.ngrok-free.app';
        
        function closeMapModal() {
            document.getElementById('mapModal').classList.add('hidden');
        }

        let map;
        let currentKmlLayer = null;
        let markers = new Map();
        let kmlLayer = new Map(); 
        let infoWindowRiver;
        let sharedInfoWindow; 


        // Biến lưu các lớp KML đang hiển thị trong modal
        let modalKmlLayers = new Map();
        function showMapModal(kmlUrl) {
            console.log("⛳ KML INPUT:", kmlUrl);
            const cleanKmlUrl = kmlUrl.replace(/^\/+/, '');
            const fullUrl = kmlUrl.startsWith("http")
                ? kmlUrl
                : `${NGROK_DOMAIN}/${cleanKmlUrl}`;
            console.log("📍 FULL URL:", fullUrl);
            document.getElementById('mapModal').classList.remove('hidden');
            if (!map) initMap();
            // Xoá lớp cũ nếu có
            modalKmlLayers.forEach(layer => layer.setMap(null));
            modalKmlLayers.clear();
            const layer = new google.maps.KmlLayer({
                url: fullUrl,
                map: map,
                preserveViewport: false,
            });
            modalKmlLayers.set(fullUrl, layer);
            // DEBUG lỗi nếu có
            google.maps.event.addListener(layer, "status_changed", function () {
                if (layer.getStatus() !== google.maps.KmlLayerStatus.OK) {
                    alert(`❌ Không thể tải KML từ ${fullUrl}.`);
                }
            });
}




      
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 9.176,
                    lng: 105.15
                },
                zoom: 10
            });
            infoWindowRiver = new google.maps.InfoWindow();
            sharedInfoWindow = new google.maps.InfoWindow();

        }

</script>


   
