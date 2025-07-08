@extends('themes.base')

@section('subhead')
    <title>Trang chủ - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-12">
            <div class="grid grid-cols-12 gap-6">
                
                <div class="col-span-12 mt-5">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="flex items-center mr-5 uppercase text-lg font-medium">
                            {!! $icons['clipboard-minus'] !!}
                            Báo Cáo Tổng Hợp <a href="/list-district">...</a>

                        </h2>
                        <a class="ml-auto flex items-center text-primary" href="/">
                            {!! $icons['refresh-ccw'] !!}
                            Tải lại dữ liệu
                        </a>
                    </div>
                    <div class="mt-5 grid grid-cols-12 gap-6">
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-4 ">
                            <div>
                                <div
                                    class="box p-5 bg-gradient-to-r from-rose-500 to-purple-500 text-white rounded-lg shadow-lg">
                                    
                                    <div class="flex items-center gap-6">
                                        {!! $icons['cloud-lightning'] !!}   
                                        <span class="text-2xl font-bold tracking-wide">BÃO, ÁP THẤP</span>
                                    </div>
                                    
                                    <div class="mt-6 grid grid-cols-2 gap-4">
                                        <div class="flex items-center gap-2">
                                            {!! $icons['chevron-right'] !!}
                                            <a href="{{ route('view-construction-storm') }}"
                                                class="text-xl hover:text-gray-500 transition-all">
                                                Tổng số công trình
                                            </a>
                                        </div>
                                        @if (isset($typeOfCalamities[2]))
                                            <div class="text-center text-xl font-semibold">
                                                {{ $typeOfCalamities[2]->constructions_count }}
                                            </div>
                                        @else
                                            <div class="text-center text-xl font-semibold text-red-500">
                                                Không có dữ liệu
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-2">
                                            {!! $icons['chevron-right'] !!}
                                            <a href="{{ route('view-calamity-storm') }}"
                                                class="text-xl hover:text-gray-500 transition-all">
                                                Số lượng thiên tai
                                            </a>
                                        </div>
                                        @if (isset($typeOfCalamities[2]))
                                            <div class="text-center text-xl font-semibold">
                                                {{ $typeOfCalamities[2]->calamities_count}}
                                            </div>
                                        @else
                                            <div class="text-center text-xl font-semibold text-red-500">
                                                Không có dữ liệu
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-4">
                                <div
                                    class="box p-5 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg shadow-lg">
                                    
                                    <div class="flex items-center gap-6">
                                        {!! $icons['arlett-triangle'] !!}
                                        <span class="text-2xl font-bold tracking-wide">NGẬP LỤT</span>
                                    </div>
                                    
                                    <div class="mt-6 grid grid-cols-2 gap-4">
                                        <div class="flex items-center gap-2">
                                            {!! $icons['chevron-right'] !!}
                                            <a href="{{ route('view-construction-flooding') }}"
                                                class="text-xl hover:text-gray-500 transition-all">
                                                Tổng số công trình
                                            </a>
                                        </div>
                                        @if (isset($typeOfCalamities[1]))
                                            <div class="text-center text-xl font-semibold">
                                                {{ $typeOfCalamities[1]->constructions_count }}
                                            </div>
                                        @else
                                            <div class="text-center text-xl font-semibold text-red-500">
                                                Không có dữ liệu
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-2">
                                            {!! $icons['chevron-right'] !!}
                                            <a href="{{ route('view-calamity-flooding') }}"
                                                class="text-xl hover:text-gray-500 transition-all">
                                                Số lượng thiên tai
                                            </a>
                                        </div>
                                        @if (isset($typeOfCalamities[1]))
                                            <div class="text-center text-white text-xl font-semibold">
                                                {{ $typeOfCalamities[1]->calamities_count }}
                                            </div>
                                        @else
                                            <div class="text-center text-xl font-semibold text-red-500">
                                                Không có dữ liệu
                                            </div>
                                        @endif
                                    </div>
                                </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-4">
                            
                                <div
                                    class="box p-5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg shadow-lg">
                               
                                    <div class="flex items-center gap-6">
                                        {!! $icons['cloud-rain'] !!}
                                        <span class="text-2xl font-bold tracking-wide">SẠT LỞ</span>
                                    </div>
                                   
                                    <div class="mt-6 grid grid-cols-2 gap-4">
                                        <div class="flex items-center gap-2">
                                            {!! $icons['chevron-right'] !!}
                                            <a href="{{ route('view-construction-river-bank') }}"
                                                class=" text-xl hover:text-gray-500 transition-all">
                                                Tổng số công trình
                                            </a>
                                        </div>
                                        @if (isset($typeOfCalamities[0]))
                                            <div class="text-center text-xl font-semibold">
                                                {{ $typeOfCalamities[0]->constructions_count }}
                                            </div>
                                        @else
                                            <div class="text-center text-xl font-semibold text-red-500">
                                                Không có dữ liệu
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-2">
                                            {!! $icons['chevron-right'] !!}
                                            <a href="{{ route('view-calamity-river-bank') }}"
                                                class="text-xl hover:text-gray-500 transition-all">
                                                Số lượng thiên tai
                                            </a>
                                        </div>
                                        @if (isset($typeOfCalamities[0]))
                                            <div class="text-center text-xl font-semibold">
                                                {{ $typeOfCalamities[0]->calamities_count }}
                                            </div>
                                        @else
                                            <div class="text-center text-xl font-semibold text-red-500">
                                                Không có dữ liệu
                                            </div>
                                        @endif
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-span-12 xl:col-span-5 flex flex-col mt-5">
                    <div class="intro-y flex h-10 items-center">
                        
                        <h2 class="flex items-center mr-5 uppercase text-lg font-medium">
                            {!! $icons['list'] !!}
                            Dữ Liệu Mới Nhất
                        </h2>
                    </div>
                    <div class="mt-3 flex-1 space-y-3">
                        @foreach ($calamities as $calamity)
                            <div class="intro-y bg-white shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100 rounded-xl">

                                <a href="/" class="block">
                                    <div class="box zoom-in mb-3 flex items-center px-5 py-5">
                                     
                                        <div class="h-10 w-10 flex items-center justify-center rounded-md bg-primary/20">
                                            {!! $icons['shield-alert'] !!}
                                        </div>
                                      
                                        <div class="ml-4 flex-1 min-w-0">
                                            @if ($calamity->calamity_type == 'BÃO, ÁP THẤP NHIỆT ĐỚI')
                                                    <div class="font-medium truncate">
                                                    <a href="{{ route('view-calamity-storm') }}">
                                                        {{ $calamity->name }}
                                                    </a></div>
                                                
                                            @endif
                                            @if ($calamity->calamity_type == 'NGẬP LỤT')
                                                    <div class="font-medium truncate">
                                                    <a href="{{ route('view-calamity-flooding') }}">
                                                        {{ $calamity->name }}
                                                    </a>
                                            </div>
                                                
                                            @endif
                                            @if ($calamity->calamity_type == 'SẠT LỞ BỜ SÔNG & BỜ BIỂN')
                                                    <div class="font-medium truncate">
                                                    <a href="{{ route('view-calamity-river-bank') }}">
                                                        {{ $calamity->name }}
                                                    </a></div>
                                                
                                            @endif
</div>

                                        <div
                                            class="rounded-full bg-success px-3 py-1 text-xs font-medium text-white whitespace-nowrap">
                                            {{ $calamity->created_at }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
               
                @php
                    
                    $colors = ['#2563eb', '#f59e0b', '#ef4444'];
                @endphp
               <div class="col-span-12 p-4 xl:col-span-7 flex flex-col ">

                    <div class="intro-y flex h-10 items-center">
                        <h2 class="flex items-center mr-5 gap-x-2 uppercase text-lg font-medium">
                            {!! $icons['trending-up'] !!}
                            Biểu Đồ Thiên Tai
                        </h2>
                    </div>
                    <div class="intro-y box mt-3 p-5 flex flex-1 items-center bg-white border border-gray-100 rounded-2xl justify-center">
                       
                        <div class="w-2/3 flex flex-col items-center justify-center h-full">
                            <div id="disaster-chart" class="h-[370px] w-full"></div>
                            <p class="mt-2 text-center text-sm text-gray-600">Biểu đồ thể hiện số lượng thiên tai theo loại
                                hình thiên tai</p>
                        </div>
                       
                        <div class="w-1/3 pl-3 flex flex-col justify-center gap-2">
                            @if ($disasters->isEmpty())
                                <p class="text-center text-gray-500">Không có dữ liệu thiên tai</p>
                            @else
                                @foreach ($disasters as $index => $disaster)
                                    @php $color = $colors[$index % count($colors)]; @endphp
                                    <div class="flex items-center">
                                        <div class="mr-2 h-2 w-2 rounded-full"
                                            style="background-color: {{ $color }};"></div>
                                        <span class="truncate text-lg font-medium">{{ $disaster['type'] }}</span>
                                        <span class="ml-auto font-semibold text-lg">{{ $disaster['percentage'] }}%</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-span-12 xl:col-span-12 flex flex-col mt-4">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="flex items-center mr-5 uppercase text-lg font-medium">
                            {!! $icons['map-pin'] !!}
                            Bản Đồ Cảnh Báo Thiên Tai 7 Ngày Gần Nhất
                        </h2>
                    </div>
                    <div class="intro-y flex items-center flex-wrap gap-x-4 mt-4">
                        
                        @guest
                        <button class="mb-2" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview"
                            as="a" variant="primary">
                            {!! $icons['plus'] !!}
                             Đăng ký nhận thông tin thiên tai mới 
                        </button>
                       @endguest
                       
                        <div class="flex flex-wrap gap-x-4">
                            @foreach ($data7Days as $disaster)
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" id="toggle-{{ Str::slug($disaster['type']) }}"
                                        class="form-checkbox h-5 w-5 text-blue-600" checked>
                                    <span>{{ $disaster['type'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                   
                    <div class="intro-y box mt-4 p-5 flex flex-col items-center justify-center space-y-4">
                        <div id="map" class="w-full h-[500px] md:h-[700px] rounded-lg border shadow-lg"></div>
                    </div>
                </div>
                
                <div class="col-span-12 xl:col-span-12 flex flex-col mt-5">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="flex items-center mr-5 uppercase text-lg font-medium">
                            {!! $icons['map-pin'] !!}
                            Bản Đồ Thời Tiết
                        </h2>
                    </div>
                    <div class="intro-y box mt-4 p-5 flex flex-1 items-center justify-center">
                        <iframe src="https://vrain.vn/52/overview?public_map=windy" width="100%" height="700px"
                            class="rounded-lg shadow-lg border" allowfullscreen>
                        </iframe>
                    </div>
                   
                </div>
                <div class="col-span-12 xl:col-span-12 mt-5">
                
                <div class="flex flex-col xl:flex-row gap-5">
                    
                    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 w-full xl:w-1/2">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                            <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ $citizenCount }}</span>
                            <h3 class="text-base font-normal text-gray-500">Người dân quan tâm thiên tai</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                            14.6%
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 w-full xl:w-1/2">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{ $visitorCount }}</span>
                                <h3 class="text-base font-normal text-gray-500">Khách truy cập hệ thống</h3>
                            </div>
                            <div class="ml-5 w-0 flex items-center justify-end flex-1 text-green-500 text-base font-bold">
                            32.9%
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
   </div>
</div>

            </div>
        </div>
        <x-base.dialog id="large-modal-size-preview" size="xl">
            <x-base.dialog.panel class="p-5">
                <form action="{{ route('guest.disaster.subscribe') }}" method="POST">

                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên của bạn</label>
                        <input type="text" name="name" id="name" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email nhận thông tin</label>
                        <input type="email" name="email" id="email"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                    </div>
                    <div class="text-right">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md">
                            Đăng ký
                        </button>
                    </div>
            </form>
            </x-base.dialog.panel>
        </x-base.dialog>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>

        document.addEventListener("DOMContentLoaded", function() {
            var disasterData = @json($disasters);
            var labels = disasterData.map(item => item.type);
            var series = disasterData.map(item => item.count);
            
            var colors = ['#2563eb', '#f59e0b', '#ef4444'];
            if (series.reduce((a, b) => a + b, 0) === 0) {
                document.getElementById("disaster-chart").innerHTML =
                    "<p class='text-gray-500 text-center'>Không có dữ liệu để hiển thị</p>";
            } else {
                var options = {
                    series: series,
                    chart: {
                        type: 'pie',
                        height: 370
                    },
                    labels: labels,
                    colors: colors,
                    legend: {
                        show: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['#ffffff']
                    }
                };
                var chart = new ApexCharts(document.querySelector("#disaster-chart"), options);
                chart.render();
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            if (typeof google === "undefined" || typeof google.maps === "undefined") {
                console.warn("Google Maps API chưa tải xong, đợi 1 giây...");
                let checkGoogleMaps = setInterval(() => {
                    if (typeof google !== "undefined" && typeof google.maps !== "undefined") {
                        clearInterval(checkGoogleMaps);
                        console.log("Google Maps API đã sẵn sàng!");
                        initializeApp();
                    }
                }, 1000);
            } else {
                console.log("Google Maps API đã sẵn sàng!");
                initializeApp();
            }
        });
        let calamitiesData = @json($data7Days)

        let map;
        let markers = {}; 
        let kmlLayers = {}; 
        let map1, marker;

        function initializeApp() {
            initMap();
            addMarkersAndKML()
            setupCheckboxListeners()
        }

        function initMap() {
            
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 9.176,
                    lng: 105.15
                },
                zoom: 10
            });
            addDistrictLabels();

        }

        function addDistrictLabels() {
            const districts = [{
                    name: "TP.Cà Mau",
                    lat: 9.180768,
                    lng: 105.191980
                },
                {
                    name: "H.U Minh",
                    lat: 9.3458,
                    lng: 104.9432
                },
                {
                    name: "H.Thới Bình",
                    lat: 9.340954,
                    lng: 105.163154
                },
                {
                    name: "H.Trần Văn Thời",
                    lat: 9.139329,
                    lng: 104.916711
                },
                {
                    name: "H.Cái Nước",
                    lat: 9.028582,
                    lng: 105.046749
                },
                {
                    name: "H.Đầm Dơi",
                    lat: 8.965907,
                    lng: 105.243772
                },
                {
                    name: "H.Năm Căn",
                    lat: 8.7815,
                    lng: 104.9735
                },
                {
                    name: "H.Phú Tân",
                    lat: 8.889554,
                    lng: 104.877030
                },
                {
                    name: "H.Ngọc Hiển",
                    lat: 8.6235,
                    lng: 104.8435
                }
            ];
            districts.forEach(district => {
                new google.maps.Marker({
                    position: {
                        lat: district.lat,
                        lng: district.lng
                    },
                    map,
                    label: {
                        text: district.name,
                        color: "black",
                        fontSize: "12px"
                    },
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 0
                    },
                });
            });
        }

        function removeVietnameseTones(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Loại bỏ dấu
                .replace(/đ/g, "d").replace(/Đ/g, "D") // Chuyển đ -> d
                .replace(/\s+/g, '-').toLowerCase(); // Thay khoảng trắng bằng dấu '-'
        }

        function addMarkersAndKML() {
            markers = {}; 
            let sharedInfoWindow = new google.maps.InfoWindow();
            calamitiesData.forEach(disaster => {
                disaster.data.forEach(item => {
                    console.log("📍 Marker:", item.name, item.coordinates);
                });

                let type = disaster.type;
                let slug = removeVietnameseTones(type); 
                markers[slug] = [];
                
                let iconUrl = "";
                switch (type.toLowerCase()) {
                    case "sạt lở":
                        iconUrl = "/uploads/map/falling_rocks.png";
                        break;
                    case "ngập lụt":
                        iconUrl = "/uploads/map/swimming.png";
                        break;
                    case "bão":
                        iconUrl = "/uploads/map/caution.png";
                        break;
                    default:
                        iconUrl = "https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png"; 
                }
                
                if (Array.isArray(disaster.data)) {
                    disaster.data.forEach(item => {
                        if (item.coordinates) {
                            let [lat, lng] = item.coordinates.split(',').map(coord => parseFloat(coord
                                .trim()));
                            let marker = new google.maps.Marker({
                                position: {
                                    lat,
                                    lng
                                },
                                map: map,
                                icon: {
                                    url: iconUrl,
                                    scaledSize: new google.maps.Size(25, 25)
                                }
                            });
                            marker.addListener("click", () => {
                                sharedInfoWindow.setContent(generateContent(item, type));
                                sharedInfoWindow.open(map, marker);
                            });
                            google.maps.event.addListener(sharedInfoWindow, "domready", function() {
                                const closeBtn = document.querySelector(".gm-ui-hover-effect");
                                if (closeBtn) closeBtn.style.display = "none";
                                const customClose = document.getElementById("custom-close-btn");
                                if (customClose) {
                                    customClose.addEventListener("click", () => {
                                        sharedInfoWindow.close();
                                    });
                                }
                            });
                            markers[slug].push(marker);
                        }
                    });
                }
            });
        }

        function generateContent(calamity, type) {
            let headerColor = "linear-gradient(to right, #95a5a6, #7f8c8d)";
            if (type === "Sạt Lở") {
                headerColor = "linear-gradient(to right, #e74c3c, #c0392b)";
            } else if (type === "Ngập Lụt") {
                headerColor = "linear-gradient(to right, #3498db, #2980b9)";
            } else if (type === "Bão") {
                headerColor = "linear-gradient(to right, #f39c12, #e67e22)";
            }
            const content = `
                    <div style="max-width: 320px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff; position: relative;">
                        <button id="custom-close-btn"
                            style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.9); border: none; border-radius: 50%; padding: 6px 10px; font-size: 16px; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.2); z-index: 2;">
                            ✕
                        </button>
                        <div style="background: ${headerColor}; color: white; padding: 14px 20px; text-align: center;">
                            <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                                ${calamity.name || "Không có tên"} (${type})
                            </div>
                        </div>
                    <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                            <div style="margin-bottom: 6px;"><strong>🌍 Thiên tai:</strong> ${calamity.risk_level.type_of_calamities.name || "Không có"}</div>
                            <div style="margin-bottom: 6px;"><strong>🌀 Tác nhân:</strong> ${calamity.sub_type_of_calamities[0].name || "Không có"}</div>
                            <div style="margin-bottom: 6px;"><strong>⚠️ Cấp độ:</strong> ${calamity.risk_level.name || "Không có"}</div>
                            <div style="margin-bottom: 6px;"><strong>📍 Địa chỉ:</strong> ${calamity.address || "Không có"}</div>
                            <div style="margin-bottom: 6px;"><strong>🏘️ Xã:</strong> ${calamity.communes?.[0]?.name || "Không có"}</div>
                            <div style="margin-bottom: 6px;"><strong>🏞️ Huyện:</strong> ${calamity.communes?.[0]?.district?.name || "Không có"}</div>
                        </div>
                    </div>
                    `;
            return content;
        }

        function setupCheckboxListeners() {
            document.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    let typeSlug = this.id.replace("toggle-", "");
                    if (this.checked) {
                        if (markers[typeSlug]) {
                            markers[typeSlug].forEach(marker => marker.setVisible(true));
                        }
                        if (kmlLayers[typeSlug]) {
                            kmlLayers[typeSlug].forEach(layer => layer.setMap(map));
                        }
                    } else {
                        if (markers[typeSlug]) {
                            markers[typeSlug].forEach(marker => marker.setVisible(false));
                        }
                        if (kmlLayers[typeSlug]) {
                            kmlLayers[typeSlug].forEach(layer => layer.setMap(null));
                        }
                    }
                });
            });
        }

        function showToast(message) {
            let toast = document.createElement("div");
            toast.innerText = message;
            toast.style.position = "fixed";
            toast.style.bottom = "20px";
            toast.style.left = "50%";
            toast.style.transform = "translateX(-50%)";
            toast.style.background = "#ff4d4d";
            toast.style.color = "white";
            toast.style.padding = "10px 20px";
            toast.style.borderRadius = "5px";
            toast.style.zIndex = "1000";
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&libraries=places&callback=initMap">
    </script>
    @if (session('success') || $errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('large-modal-size-preview');
        if (modalEl) {
            tailwind.Modal.getOrCreateInstance(modalEl).show();
        }
    });
</script>
@endif

@endpush
