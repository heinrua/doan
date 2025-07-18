@extends('themes.base')
@section('subhead')
    <title>Bản Đồ Sạt Lở Bờ Sông & Bờ Biển - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['map'] !!}
        Bản Đồ Thiên Tai
    </h2>
   
    <div class="mt-3 grid grid-cols-12 gap-6">

        <div class="col-span-12 md:col-span-3">
            <div class="p-5 bg-white shadow rounded-lg h-[950px] overflow-y-auto">
                <h3 class="text-lg font-semibold mb-3">Sạt Lở:</h3>

                <select id="yearRiverBankSelect" class="w-full p-2 border rounded-md">
                    <option value="">-- Chọn Năm --</option>
                    @foreach ($riverBankByYear as $year => $data)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>

                <h3 class="text-lg font-semibold mb-3">Lũ Lụt:</h3>

                <select id="levelFloodingSelect" class="w-full p-2 border rounded-md">
                    <option value="">-- Chọn mức độ ngập --</option>
                    @foreach ($floodByRange as $level => $data)
                        <option value="{{ $level }}">{{ $level === 'all' ? 'Tất cả' : $level }}</option>
                    @endforeach
                </select>

                <h3 class="text-lg font-semibold mb-3">Bão:</h3>

                <select id="yearStormSelect" class="w-full p-2 border rounded-md">
                    <option value="">-- Chọn Năm --</option>
                    @foreach ($stormsByYear as $year => $data) 
                        <option value="{{ $year }}">{{ $year === 'all' ? 'Tất cả' : $year }}</option>
                    @endforeach
                </select>

                <div id="locationContainer" class="mt-5 space-y-3 hidden">
                    <h3 class="text-lg font-semibold mb-2">Quận & Huyện:</h3>
                    <ul id="districtWardList" class="space-y-2"></ul>
                </div>
                
               
                <div class="flex mt-5 items-center ps-3 w-full rounded-lg border border-gray-200  dark:border-gray-600">
                    <input type="checkbox" value="Diagioi.kmz" onchange="setKml(this)" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                    <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Địa giới hành chính</label>
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
                            <input type="checkbox" value="{{ $data->id }}"
                                onchange="toggleMarkers(constructions[{{ $data->id }}] || [], this.checked,'{{ $data->slug }}')"

                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
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
                        $coords = explode(',', $data['coordinates']); 
                                                $lat = trim($coords[0]);
                        $lng = trim($coords[1]);
                        $urls = $data['map'];
                       
                        if (is_string($urls)) {
                            $urls = json_decode($urls, true) ?: [$urls];
                        }                        
                    @endphp
                    <li class="w-full border-b border-gray-200 rounded-t-lg">
                        <div class="flex items-center ps-3">
                            <input type="radio"
                                    name="district"                    
                                    class="district-radio w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500"
                                    value="{{ $data['id'] }}"
                                    data-lat="{{ $lat }}"
                                    data-lng="{{ $lng }}"
                                    data-urls="{{ json_encode($urls) }}"
                                    >
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
                                     onchange="toggleMarkers(schoolData, this.checked, 'school')"
                                    class="option-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Trường học</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input type="checkbox" value="medical"
                                onchange="toggleMarkers(medicalData, this.checked, 'medical')"
                                 class="w-4 option-checkbox h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Bệnh viện</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input type="checkbox" value="center_commune" 
                                onchange="toggleMarkers(centerCommuneData, this.checked, 'center_commune')"
                                class="option-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Trung tâm hành chính xã</label>
                            </div>
                        </li>
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input id="laravel-checkbox" type="checkbox" value="center_district"
                                 onchange="toggleMarkers(centerDistrictData, this.checked, 'center_district')"
                                 class="option-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="laravel-checkbox" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Trung tâm hành chính huyện</label>
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </div>
            
        </div>

        <div class="col-span-12 md:col-span-9">
            <div class="p-5 bg-white shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-3">Bản đồ khu vực Cà Mau</h3>
                <div id="map" class="w-full h-screen rounded-lg border"></div>
            </div>
                        @auth
            <!-- Thêm vào vị trí bạn muốn trên trang -->
            <button id="createMapBtn" onclick="createMap()" class="btn btn-primary">Tạo bản đồ</button>
            <button id="clearDrawBtn" onclick="clearDraw()" class="btn btn-danger" style="display:none;">Xóa tất cả</button>
            <button id="saveDrawBtn" onclick="saveDraw()" class="btn btn-success" style="display:none;">Lưu bản đồ</button>
            <select id="drawType" style="margin-top: 10px; display: none;">
              <option value="Point">Điểm</option>
              <option value="LineString">Đường</option>
              <option value="Polygon">Vùng</option>
            </select>
            <div id="map2" style="width: 100%; height: 400px; display: none; margin-top: 20px;"></div>
            <div id="coords" style="margin-top: 10px; color: #333;"></div>
            <input type="color" id="colorPicker" value="#ff0000" style="display:none; margin-left:10px;">
            <div id="popup" style="background: white; border: 1px solid #ccc; padding: 8px; position: absolute; display: none; z-index: 1000;"></div>
            @endauth
        </div>
           
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v9.2.4/ol.css">
<script src="https://cdn.jsdelivr.net/npm/ol@v9.2.4/dist/ol.js"></script>
@endsection

@push('scripts')
<script>
let map2, draw, vectorLayer;

function hexToRgba(hex, alpha) {
    let r = 0, g = 0, b = 0;
    if (hex.length == 7) {
        r = parseInt(hex.slice(1, 3), 16);
        g = parseInt(hex.slice(3, 5), 16);
        b = parseInt(hex.slice(5, 7), 16);
    }
    return `rgba(${r},${g},${b},${alpha})`;
}

function addInteraction() {
    if (draw) map2.removeInteraction(draw);
    const value = document.getElementById('drawType').value;
    draw = new ol.interaction.Draw({
        source: vectorLayer.getSource(),
        type: value
    });
    map2.addInteraction(draw);

    draw.on('drawend', function(evt) {
        const color = document.getElementById('colorPicker').value;
        let style;
        if (value === 'Point') {
            style = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 7,
                    fill: new ol.style.Fill({
                        color: color
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#fff',
                        width: 2
                    })
                })
            });
        } else if (value === 'LineString') {
            style = new ol.style.Style({
                stroke: new ol.style.Stroke({
                    color: color,
                    width: 3
                })
            });
        } else if (value === 'Polygon') {
            style = new ol.style.Style({
                fill: new ol.style.Fill({
                    color: hexToRgba(color, 0.4)
                }),
                stroke: new ol.style.Stroke({
                    color: color,
                    width: 2
                })
            });
        }
        evt.feature.setStyle(style);

        // Hỏi mô tả
        const desc = prompt('Nhập mô tả cho đối tượng này:', '');
        evt.feature.set('description', desc || '');
    });
}

function clearDraw() {
    if (vectorLayer) {
        vectorLayer.getSource().clear();
    }
}

function saveDraw() {
    if (vectorLayer) {
        const features = vectorLayer.getSource().getFeatures();
        if (features.length === 0) {
            alert('Chưa có đối tượng nào để lưu!');
            return;
        }
        const kmlFormat = new ol.format.KML();
        const kmlStr = kmlFormat.writeFeatures(features, {
            featureProjection: map2.getView().getProjection()
        });

        // Tải về file KML
        const blob = new Blob([kmlStr], {type: "application/vnd.google-earth.kml+xml"});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'ban_do_da_ve.kml';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
}

function createMap() {
    document.getElementById('map2').style.display = 'block';
    document.getElementById('drawType').style.display = 'inline';
    document.getElementById('clearDrawBtn').style.display = 'inline';
    document.getElementById('saveDrawBtn').style.display = 'inline';
    document.getElementById('colorPicker').style.display = 'inline';

    if (!window.map2Initialized) {
        vectorLayer = new ol.layer.Vector({
            source: new ol.source.Vector()
        });

        map2 = new ol.Map({
            target: 'map2',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                }),
                vectorLayer
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([105.0, 10.5]),
                zoom: 10
            })
        });

        document.getElementById('drawType').addEventListener('change', function() {
            addInteraction();
        });

        document.getElementById('colorPicker').addEventListener('change', function() {
            addInteraction();
        });

        map2.on('singleclick', function(evt) {
            const feature = map2.forEachFeatureAtPixel(evt.pixel, function(feature) {
                return feature;
            });
            if (feature) {
                let desc = feature.get('description') || 'Chưa có mô tả';
                const popup = document.getElementById('popup');
                popup.innerHTML = `<b>Mô tả:</b> ${desc}`;
                popup.style.left = evt.pixel[0] + 'px';
                popup.style.top = evt.pixel[1] + 'px';
                popup.style.display = 'block';
            } else {
                document.getElementById('popup').style.display = 'none';
            }

            // Hiện tọa độ
            const coord = ol.proj.toLonLat(evt.coordinate);
            document.getElementById('coords').innerText =
                'Tọa độ: ' + coord[0].toFixed(6) + ', ' + coord[1].toFixed(6);
        });

        addInteraction();

        window.map2Initialized = true;
    } else {
        addInteraction();
    }
}
</script>
    <script>
        const NGROK_DOMAIN = 'https://ad4999a1bb78.ngrok-free.app';
        const districts = @json($districts);
        const riverBankByYear = @json($riverBankByYear);
        const stormsByYear = @json($stormsByYear);
        const floodByRange = @json($floodByRange);
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
        const icons = {
            school: "/uploads/map/school.png",
            medical: "/uploads/map/medical.png",
            center_commune: "/uploads/map/commune_center.png",
            center_district: "/uploads/map/district_center.png",
            flooding:"/uploads/map/swimming.png",
            storm:"/uploads/map/caution.png",
            river_bank: "/uploads/map/falling_rocks.png",
            default: "https://maps.google.com/mapfiles/kml/shapes/placemark_circle.png"
        };
        

        let map, kmlLayers = new Map(),
            currentKmlLayer = null;
        let markers = new Map();
        let kmlLayer = new Map(); 
        let infoWindowRiver;
        let sharedInfoWindow; 

        function initializeApp() {
            initMap(); 
            setupDistrictRadios();
            setupDistrictToggle();
            setupConstructionToggle();
            console.log("River Bank:", riverBankByYear);
            console.log("Flood by Range:", floodByRange);
            console.log("Storms by Year:", stormsByYear);

            document.getElementById("yearRiverBankSelect").addEventListener("change", function () {
                const year = this.value;
                // Ẩn hết marker sạt lở cũ
                Array.from(markers.keys()).forEach(key => {
                    if (key.startsWith('river_bank-')) {
                        markers.get(key).setMap(null);
                        markers.delete(key);
                    }
                });
                // Hiện marker năm mới
                if (year && riverBankByYear[year]) {
                    toggleMarkers(riverBankByYear[year], true, 'river_bank');
                }
            });
            document.getElementById("levelFloodingSelect").addEventListener("change", function () {
                const level = this.value;
                
                Array.from(markers.keys()).forEach(key => {
                    if (key.startsWith('flooding-')) {
                        markers.get(key).setMap(null);
                        markers.delete(key);
                    }
                });
                if (level && floodByRange[level]) {
                    toggleMarkers(floodByRange[level], true, 'flooding');
                }
            });
            document.getElementById("yearStormSelect").addEventListener("change", function () {
                const year = this.value;
                // Ẩn hết marker bão cũ
                Array.from(markers.keys()).forEach(key => {
                    if (key.startsWith('storm-')) {
                        markers.get(key).setMap(null);
                        markers.delete(key);
                    }
                });
                if (year && stormsByYear[year]) {
                    toggleMarkers(stormsByYear[year], true, 'storm');
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
        
        function setupDistrictRadios() {
            const radios = document.querySelectorAll('.district-radio');
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const id = parseInt(this.value);
                    const lat = parseFloat(this.dataset.lat);
                    const lng = parseFloat(this.dataset.lng);
                    const district = districts.find(d => d.id === id);
                    const fileUrls = JSON.parse(this.dataset.urls);
                    if (!district) return;

                    if (!isNaN(lat) && !isNaN(lng)) {
                        map.setCenter({ lat, lng });
                        map.setZoom(10);
                    }
                    fileUrls.forEach(url => {
                        const cleanKmlUrl = url.replace(/^\/+/, '');
                        const fullUrl = url.startsWith("http") ? url : `${NGROK_DOMAIN}/${cleanKmlUrl}`;
                        const layer = showKML(fullUrl);
                        kmlLayers.set(url, layer);
                    });
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
        function setupConstructionToggle() {
            const toggleBtn = document.getElementById('toggleConstruction');
            const list = document.getElementById('listConstructionTypes');

            if (toggleBtn && list) {
                toggleBtn.addEventListener('click', function () {
                    list.classList.toggle('hidden');
                });
            }
        }

        function toggleMarkers(data, show, type) {
           
            if (!data || data.length === 0) return;
            
            let iconUrl = icons[type] || icons.default;
            data.forEach(value => {
                let markerKey = `${type}-${value.id}`;

                if (show) {
                    if (!markers.has(markerKey)) {
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
                        markers.set(markerKey, marker);
                    } else {
                        markers.get(markerKey).setMap(map);
                    }
                } else {
                    if (markers.has(markerKey)) {
                        markers.get(markerKey).setMap(null);
                        markers.delete(markerKey);
                    }
                }
            });
        }
        function getContent(value, type) {
            let iconUrl = icons[type] || icons.default;
            return `
                <div style="max-width: 360px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff;">
                    <div style="background: linear-gradient(to right, #2c3e50, #4ca1af); color: white; padding: 14px 20px; text-align: center;">
                        <div style="font-size: 17px; font-weight: bold;">${value.name || "Không có tên"}</div>
                    </div>
                    <div style="padding: 16px 20px; font-size: 14px; color: #333; line-height: 1.8;">
                        ${value.address ? `<div><strong>📍 Địa chỉ:</strong> ${value.address}</div>` : ''}
                        ${value.commune ? `<div><strong>📍 Xã:</strong> ${value.commune}</div>` : ''}
                        ${value.risk_level?.type_of_calamities ? `<div><strong>🌍 Thiên tai:</strong> ${value.risk_level?.type_of_calamities?.name}</div>` : ''}
                        ${value.sub_type_of_calamities ? `<div><strong>🌀 Tác nhân:</strong> ${value.sub_type_of_calamities?.[0]?.name}</div>` : ''}
                        ${value.risk_level?.name ? `<div><strong>⚠️ Cấp độ:</strong> ${value.risk_level?.name}</div>` : ''}
                        ${value.district ? `<div><strong>🏞️ Huyện:</strong> ${value.district}</div>` : ''}
                        ${value.population ? `<div><strong>👥 Sức chứa:</strong> ${value.population}</div>` : ''}
                        ${value.width ? `<div><strong>📏 Chiều rộng:</strong> ${value.width} m</div>` : ''}
                        ${value.length ? `<div><strong>📐 Chiều dài:</strong> ${value.length} m</div>` : ''}
                        ${value.acreage ? `<div><strong>🗺️ Diện tích:</strong> ${value.acreage} m²</div>` : ''}
                        ${value.reason ? `<div><strsong>💥 Nguyên nhân:</strong> ${value.reason}</div>` : ''}
                        ${value.time ? `<div><strong>🕒 Thời gian:</strong> ${value.time}</div>` : ''}
                        ${value.latitude && value.longitude ? `<div><strong>🌐 Tọa độ:</strong> (${value.latitude}, ${value.longitude})</div>` : ''}
                        
                    </div>
                </div>

            `;
        }
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLat = position.coords.latitude;
                var userLng = position.coords.longitude;
                
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }

        function showKML(kmlUrl) {
        
            const kmlLayer = new google.maps.KmlLayer({
                url: kmlUrl,
                map: map,
                suppressInfoWindows: false,
                preserveViewport: false
            });

         
            kmlLayer.addListener('defaultviewport_changed', function() {
                const bounds = kmlLayer.getDefaultViewport();
                if (bounds) {
                    map.fitBounds(bounds);
                }
            });

            return kmlLayer;
        }
        const mapLayers = {};
        function setKml(checkbox) {
            let fileName = checkbox.value;
            const fileUrl = `${NGROK_DOMAIN}/uploads/map/${fileName}`;
            if (checkbox.checked) {
                // Nếu đã có lớp này thì không thêm nữa
                if (mapLayers[fileUrl]) return;
                const kmlLayer = new google.maps.KmlLayer({
                    url: fileUrl,
                    map: map,
                    suppressInfoWindows: false,
                    preserveViewport: true
                });

                kmlLayer.addListener('defaultviewport_changed', function() {
                    const bounds = kmlLayer.getDefaultViewport();
                    if (bounds) {
                        map.fitBounds(bounds);
                    }
                });
                mapLayers[fileUrl] = kmlLayer;
            } else {
                if (mapLayers[fileUrl]) {
                    mapLayers[fileUrl].setMap(null);
                    delete mapLayers[fileUrl];
                }
            }
        }
    </script>
   



@endpush
