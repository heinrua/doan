@extends('themes.base')
@section('subhead')
    <title>Bản Đồ Sạt Lở Bờ Sông & Bờ Biển - PCTT Cà Mau Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['map'] !!}
        Bản Đồ Thiên Tai
    </h2>
   
    <div class="mt-3 grid grid-cols-12 gap-6">
        

        <!-- Sidebar danh mục (1/3 màn hình) -->
        <div class="col-span-12 md:col-span-3">
            <div class="p-5 bg-white shadow rounded-lg h-[950px] overflow-y-auto">
                <h3 class="text-lg font-semibold mb-3">Sạt Lở:</h3>

                <select id="yearSelect" class="w-full p-2 border rounded-md">
                    <option value="">-- Chọn Năm --</option>
                    @foreach ($locations as $year => $data)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>

                <h3 class="text-lg font-semibold mb-3">Lũ Lụt:</h3>

                <select id="yearSelect" class="w-full p-2 border rounded-md">
                    <option value="">-- Chọn Năm --</option>
                    @foreach ($locations as $year => $data)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>

                <h3 class="text-lg font-semibold mb-3">Bão:</h3>

                <select id="yearSelect" class="w-full p-2 border rounded-md">
                    <option value="">-- Chọn Năm --</option>
                    @foreach ($locations as $year => $data)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>

                <!--  Quận & Huyện -->
                <div id="locationContainer" class="mt-5 space-y-3 hidden">
                    <h3 class="text-lg font-semibold mb-2">Quận & Huyện:</h3>
                    <ul id="districtWardList" class="space-y-2"></ul>
                </div>
                <div class="flex mt-5 items-center ps-3 w-full rounded-lg border border-gray-200  dark:border-gray-600">
                    <input id="laravel-checkbox" type="checkbox" value="evacuation" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                    <label for="laravel-checkbox" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Đường sơ tán</label>
                </div>
                <h3 class="mt-3 text-lg font-semibold mb-3">Chọn công trình:</h3>
                <div class="flex  items-center ps-3 w-full rounded-lg border border-gray-200  dark:border-gray-600" id="toggleConstruction">
                    <p class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Công trình phòng chống thiên tai</p>
                </div>
                <div class="max-h-[200px] overflow-y-auto">
                    <ul id="listConstructionTypes" class="w-full hidden text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @foreach($constructionTypes as $data)
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input type="checkbox" value="school" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$data->name}}</label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <h3 class="mt-3 text-lg font-semibold mb-3">Địa phận:</h3>
                <div id="toggleDistricts"
                    class="flex items-center ps-3 w-full rounded-lg border hover:bg-blue-500 border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50">
                    <p class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Danh sách huyện</p>
                </div>
                <div class="overflow-y-auto max-h-[200px]">
                    <ul id="listDistricts" class="w-full text-sm hidden font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                    @foreach($districts as $data)
                    @php
                        $coords = explode(',', $data['coordinates']); // dạng "9.17,105.15"
                        $lat = trim($coords[0]);
                        $lng = trim($coords[1]);
                    @endphp
                    <li class="w-full border-b border-gray-200 rounded-t-lg">
                        <div class="flex items-center ps-3">
                            <input type="radio"
                                    name="district"                    
                                    class="district-radio w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                    value="{{ $data['id'] }}"
                                    data-lat="{{ $lat }}"
                                    data-lng="{{ $lng }}">
                            <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$data['name']}}</label>
                        </div>
                    </li>
                    @endforeach
                </ul>
                </div>
                
                <div id="optionContainer" class="space-y-2">
                    <h3 class="text-lg font-semibold mb-2">Địa danh hành chính:</h3>
                    <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input type="checkbox" value="school" 
                                     onchange="toggleAdministrative(schoolData, this.checked, 'school')"
                                    class="option-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Trường học</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input type="checkbox" value="medical"
                                onchange="toggleAdministrative(medicalData, this.checked, 'medical')"
                                 class="w-4 option-checkbox h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Bệnh viện</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input type="checkbox" value="center_commune" 
                                onchange="toggleAdministrative(centerCommuneData, this.checked, 'commune_center')"
                                class="option-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Trung tâm hành chính xã</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input id="laravel-checkbox" type="checkbox" value="center_district"
                                 onchange="toggleAdministrative(centerDistrictData, this.checked, 'district_center')"
                                 class="option-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="laravel-checkbox" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Trung tâm hành chính huyện</label>
                            </div>
                        </li>
                    </ul>
                    
                    <!-- Checkbox chính -->


                </div>
            </div>
        </div>

        <!-- Bản đồ Google Maps (2/3 màn hình) -->
        <div class="col-span-12 md:col-span-9">
            <div class="p-5 bg-white shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-3">Bản đồ khu vực Cà Mau</h3>
                <div id="map" class="w-full h-screen rounded-lg border"></div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const districts = @json($districts);
        const locations = @json($locations);
     
        const constructions = @json($constructions);
        const constructionTypes = @json($constructionTypes);
        const administratives = @json($administratives);
        const schoolData = administratives.filter(item => item.type === 'school');
        const medicalData = administratives.filter(item => item.type === 'medical');
        const centerCommuneData = administratives.filter(item =>
            item.type === 'center' && item.classify === 'Cấp xã'
            );

            const centerDistrictData = administratives.filter(item =>
            item.type === 'center' && item.classify === 'Cấp huyện'
            );

        

        let map, kmlLayers = new Map(),
            currentKmlLayer = null,
            markers = new Map();
        let markersByCalamity = new Map();
        let kmlLayerSoTan = new Map();
        let infoWindowRiver;
        let sharedInfoWindow; // trường học - y tế - tthc
        let sharedConstructionInfoWindow; // cống - trạm bơm
      

       

        function initializeApp() {
            initMap(); 
            setupDistrictRadios();
            setupDistrictToggle();
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
            sharedConstructionInfoWindow = new google.maps.InfoWindow();
      

        }
        function addKmlLayer(map, url, options = {}) {
            // Xóa lớp hiện tại nếu có
            if (currentKmlLayer) {
                currentKmlLayer.setMap(null);
            }

            // Tạo lớp mới
            const layer = new google.maps.KmlLayer({
                url: url,
                map: map,
                preserveViewport: options.preserveViewport ?? true,
                suppressInfoWindows: options.suppressInfoWindows ?? false
            });


            currentKmlLayer = layer;
           

            return layer; // nếu bạn muốn lưu riêng thì gán ra biến bên ngoài
        }
       
       function setupDistrictRadios() {
            const radios = document.querySelectorAll('.district-radio');
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const id = parseInt(this.value);
                    const lat = parseFloat(this.dataset.lat);
                    const lng = parseFloat(this.dataset.lng);

                    const district = districts.find(d => d.id === id);
                    if (!district) return;

                    if (!isNaN(lat) && !isNaN(lng)) {
                        map.setCenter({ lat, lng });
                        map.setZoom(12);
                    }

                    if (district.map && Array.isArray(district.map) && district.map.length > 0) {
                        const kmlUrl = district.map[0];
                        const fullUrl = kmlUrl.startsWith("http")
                        ? kmlUrl
                        : `${window.location.origin}/${kmlUrl.replace(/^\/+/, '')}`;


                        addKmlLayer(map, fullUrl);
                    } else {
                        console.warn("Không có file bản đồ KML cho huyện này:", district.name);
                    }
                });
            });
        }

        function setupDistrictToggle() {
            const toggleBtn = document.getElementById('toggleDistricts');
            const list = document.getElementById('listDistricts');

            if (toggleBtn && list) {
                toggleBtn.addEventListener('click', function () {
                    list.classList.toggle('hidden');
                });
            }
        }

        
        function toggleAdministrative(data, show, type) {
            if (!data || data.length === 0) return;
            // Map icon theo type
            const icons = {
                school: "/uploads/map/school.png",
                medical: "/uploads/map/medical.png",
                center_commune: "/uploads/map/commune_center.png",
                center_district: "/uploads/map/district_center.png",
                default: "https://maps.google.com/mapfiles/kml/shapes/placemark_circle.png"
            };
            let iconUrl = icons[type] || icons.default;
            data.forEach(value => {
                let markerKey = `${type}-${value.id}`;

                if (show) {
                    if (!markersByCalamity.has(markerKey)) {
                        let marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(value.latitude),
                                lng: parseFloat(value.longitude)
                            },
                            map: map,
                            icon: {
                                url: iconUrl,
                                scaledSize: new google.maps.Size(25, 25)
                            }
                        });
                        marker.addListener("click", function() {
                            sharedInfoWindow.setContent(getContent(value, type));
                            sharedInfoWindow.open(map, marker);
                        });
                        markersByCalamity.set(markerKey, marker);
                    } else {
                        markersByCalamity.get(markerKey).setMap(map);
                    }
                } else {
                    if (markersByCalamity.has(markerKey)) {
                        markersByCalamity.get(markerKey).setMap(null);
                        markersByCalamity.delete(markerKey);
                    }
                }
            });
        }



       
        
            
        


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&callback=initializeApp" async
        defer loading="async"></script>
    <!-- <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&libraries=drawing&callback=initializeApp"
        async
        defer
        ></script> -->

    
    

@endpush
