@extends('themes.base')
@section('subhead')
    <title>Bản Đồ Sạt Lở Bờ Sông & Bờ Biển - PCTT Cà Mau Dashboard</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['map-pin'] !!}
        Bản Đồ Sạt Lở Bờ Sông & Bờ Biển
    </h2>
    <div class="mt-3 flex space-x-2">
            <button id="btn-edit-kml" class="btn btn-outline-primary">✏️ Chỉnh sửa KML</button>
            <button id="btn-create-kml" class="btn btn-outline-success">➕ Tạo KML mới</button>
            <button id="btn-export-kml" class="btn btn-outline-warning hidden">💾 Xuất KML</button>
        </div>
    <div class="mt-3 grid grid-cols-12 gap-6">
        

        <!-- Sidebar danh mục (1/3 màn hình) -->
        <div class="col-span-12 md:col-span-3">
            <div class="p-5 bg-white shadow rounded-lg h-[950px] overflow-y-auto">
                <h3 class="text-lg font-semibold mb-3">Chọn Năm:</h3>

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

                <h3 class="mt-3 text-lg font-semibold mb-3">Tùy chọn:</h3>
                <div id="optionContainer" class="space-y-2">
                    <!-- Checkbox chính cho Địa Phận -->
                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-kml" class="option-checkbox" value="kml">
                        <label for="option-kml" class="cursor-pointer select-none text-gray-700">Địa Phận</label>
                    </div>

                    <!-- Container cho danh sách quận/huyện -->
                    <div id="districtContainer" class="mt-5 space-y-3 hidden">
                        <h3 class="text-lg font-semibold mb-2">Quận & Huyện:</h3>
                        <ul id="districtList" class="space-y-2" style="max-height: 180px; overflow-y: auto;"></ul>
                    </div>

                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-de" class="option-checkbox"
                            data-url="https://www.google.com/maps/d/kml?mid=1TE93n1FxO-UelwWKTLI9ltcpw-nm65s&lid=pL2uUVaEam8">
                        <label for="option-de" class="cursor-pointer select-none text-gray-700">Đê</label>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-cong" class="option-checkbox" value="cong">
                        <label for="option-cong" class="cursor-pointer select-none text-gray-700">Cống</label>
                    </div>
                    <!--  Quận & Huyện -->
                    <div id="locationContainerConstruction" class="mt-5 space-y-3 hidden">
                        <h3 class="text-lg font-semibold mb-2">Quận & Huyện:</h3>
                        <ul id="districtWardListConstruction" class="space-y-2"></ul>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-pumping" class="option-checkbox" value="pumping_station">
                        <label for="option-pumping" class="cursor-pointer select-none text-gray-700">Trạm bơm</label>
                    </div>
                    <!--  Quận & Huyện -->
                    <div id="locationContainerConstruction1" class="mt-5 space-y-3 hidden">
                        <h3 class="text-lg font-semibold mb-2">Quận & Huyện:</h3>
                        <ul id="districtWardListConstruction1" class="space-y-2"></ul>
                    </div>

                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-pumping" class="option-checkbox" value="school">
                        <label for="option-pumping" class="cursor-pointer select-none text-gray-700">Trường học</label>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-pumping" class="option-checkbox" value="medical">
                        <label for="option-pumping" class="cursor-pointer select-none text-gray-700">Y Tế</label>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-pumping" class="option-checkbox" value="center_commune">
                        <label for="option-pumping" class="cursor-pointer select-none text-gray-700">TTHC Xã</label>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-pumping" class="option-checkbox" value="center_district">
                        <label for="option-pumping" class="cursor-pointer select-none text-gray-700">TTHC Huyện</label>
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded border border-gray-300">
                        <input type="checkbox" id="option-pumping" class="option-checkbox" value="evacuation">
                        <label for="option-pumping" class="cursor-pointer select-none text-gray-700">Đường sơ tán</label>
                    </div>
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
        const locationsConstructions = @json($locationsConstructions);
        const constructions = @json($constructions);
        const schools = @json($schools);
        const medicals = @json($medicals);
        const center_communes = @json($center_communes);
        const center_districts = @json($center_districts);

        let map, kmlLayers = new Map(),
            currentLayer = null,
            markers = new Map();
        let markersByCalamity = new Map();
        let kmlLayerSoTan = new Map();
        let infoWindowRiver;
        let sharedInfoWindow; // trường học - y tế - tthc
        let sharedConstructionInfoWindow; // cống - trạm bơm
        let drawingManager;
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof google === "undefined" || typeof google.maps === "undefined") {
                console.warn("Google Maps API chưa tải xong, đang chờ...");
                let maxRetries = 10; // Tối đa đợi 10 giây
                let retries = 0;
                let checkGoogleMaps = setInterval(() => {
                    if (typeof google !== "undefined" && typeof google.maps !== "undefined") {
                        clearInterval(checkGoogleMaps);
                        console.log("Google Maps API đã sẵn sàng!");
                        initializeApp();
                    } else {
                        retries++;
                        console.warn(`Đợi Google Maps API... (${retries})`);
                        if (retries >= maxRetries) {
                            clearInterval(checkGoogleMaps);
                            console.error("Không thể load Google Maps API sau 10 giây.");
                        }
                    }
                }, 1000);
            } else {
                console.log("Google Maps API đã sẵn sàng!");
                initializeApp();
            }
        });

        function initializeApp() {
            initMap();
            setupLocationSelection();
            setupOptionCheckBox();
            loadDistrictList();
            
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
            addDistrictLabels();
            setupDrawingTools()
        }

        //hiển thị quận/huyện lên map khi vào trang
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

        // Sạt lở theo năm
        function setupLocationSelection() {
            const yearSelect = document.getElementById("yearSelect");
            const locationContainer = document.getElementById("locationContainer");
            const districtWardList = document.getElementById("districtWardList");

            function updateDistricts(year) {
                clearAllMarkersByType("sat_lo");
                districtWardList.innerHTML = "";
                districtWardList.style.maxHeight = "180px"; // Giới hạn chiều cao
                districtWardList.style.overflowY = "auto"; // Hiển thị thanh cuộn khi cần
                if (!locations[year]) {
                    locationContainer.classList.add("hidden");
                    return;
                }
                locationContainer.classList.remove("hidden");
                Object.entries(locations[year]).forEach(([district, data]) => {
                    let districtItem = document.createElement("li");

                    districtItem.innerHTML = `
                        <div class="flex items-center space-x-2 bg-gray-50  pr-6 p-2 rounded-md">
                            <input type="checkbox" class="district-checkbox" id="district-${district}" data-name="${district}">
                            <label for="district-${district}" class="cursor-pointer select-none">
                                ${district} (${data.total})
                            </label>
                        </div>
                            <ul class="commune-list hidden pl-5 mt-2">
                                ${Object.entries(data.communes)
                                    .map(([commune, details]) => `
                                                    <li>
                                                        <div class="flex items-center space-x-2 bg-white p-2 rounded-md">
                                                            <input type="checkbox" class="commune-checkbox" id="commune-${commune}"
                                                                data-parent="${district}" data-calamities='${JSON.stringify(details.calamities)}'>
                                                            <label for="commune-${commune}" class="cursor-pointer select-none">
                                                                ${commune} (${details.count})
                                                            </label>
                                                        </div>
                                                    </li>`
                                    )
                                    .join("")}
                            </ul>`;
                    let districtCheckbox = districtItem.querySelector(".district-checkbox");
                    let communeList = districtItem.querySelector(".commune-list");
                    let communeCheckboxes = districtItem.querySelectorAll(".commune-checkbox");
                    // Xử lý chọn/bỏ chọn quận
                    districtCheckbox.addEventListener("change", function() {
                        let isChecked = this.checked;
                        communeList.classList.toggle("hidden", !isChecked);
                        communeCheckboxes.forEach(cb => {
                            cb.checked = isChecked;
                            toggleMarkers(cb.id, JSON.parse(cb.dataset.calamities),
                                isChecked);
                        });
                    });
                    // Xử lý chọn/bỏ chọn xã
                    communeCheckboxes.forEach(cb => {
                        cb.addEventListener("change", function() {
                            let allChecked = [...communeCheckboxes].every(cb => cb.checked);
                            districtCheckbox.checked = allChecked;
                            toggleMarkers(this.id, JSON.parse(this.dataset.calamities), this
                                .checked);
                        });
                    });
                    districtWardList.appendChild(districtItem);
                });
            }
            yearSelect.addEventListener("change", function() {
                updateDistricts(this.value);
            });
            if (yearSelect.value) {
                updateDistricts(yearSelect.value);
            }
        }

        function toggleMarkers(communeId, calamities, show, type = "sat_lo") {
            if (!markers.has(communeId)) {
                markers.set(communeId, new Map());
            }

            let typeMarkers = markers.get(communeId).get(type) || [];

            if (show) {
                if (typeMarkers.length === 0) {
                    typeMarkers = calamities.map(calamity => {
                        const marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(calamity.latitude),
                                lng: parseFloat(calamity.longitude)
                            },
                            map: map,
                            icon: {
                                url: "/uploads/map/falling_rocks.png",
                                scaledSize: new google.maps.Size(25, 25)
                            }
                        });
                        // Chỉ sử dụng 1 popup duy nhất
                        marker.addListener("click", function() {
                            infoWindowRiver.setContent(generateContent(calamity));
                            infoWindowRiver.open(map, marker);
                        });

                        return marker;
                    });
                    markers.get(communeId).set(type, typeMarkers);
                    google.maps.event.addListener(infoWindowRiver, "domready", function() {
                        const closeBtn = document.querySelector(".gm-ui-hover-effect");
                        if (closeBtn) closeBtn.style.display = "none";
                        const customClose = document.getElementById("custom-close-btn");
                        if (customClose) {
                            customClose.addEventListener("click", () => {
                                infoWindowRiver.close();
                            });
                        }
                    });

                } else {
                    typeMarkers.forEach(marker => marker.setMap(map));
                }
            } else {
                if (markers.get(communeId).has(type)) {
                    markers.get(communeId).get(type).forEach(marker => marker.setMap(null));
                    markers.get(communeId).delete(type);
                }
            }
        }

        //content sạt lở
        function generateContent(calamity) {
            const defaultImage = "{{ Vite::asset('resources/images/default-river-bank.png') }}";
            return `
            <div style="max-width: 340px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff; transition: all 0.3s ease-in-out;">
                <!-- Image section -->
                <div style="position: relative; overflow: hidden;">
                    <img src="${calamity.image || defaultImage}" alt="Hình ảnh"
                        style="width: 100%; height: 180px; object-fit: cover; transition: transform 0.3s ease;">
                    <button id="custom-close-btn"
                            style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.9); border: none; border-radius: 50%; padding: 6px 10px; font-size: 16px; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                        ✕
                    </button>
                </div>
                <!-- Title -->
                <div style="background: linear-gradient(to right, #e74c3c, #c0392b); color: white; padding: 14px 20px; text-align: center;">
                    <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                        ${calamity.name} (Sạt lở)
                    </div>
                </div>
                <!-- Info content -->
               <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">📏</span>
                        <strong>Chiều dài:</strong>&nbsp;${calamity.length || "Không có"} m
                    </div>
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">📐</span>
                        <strong>Chiều rộng:</strong>&nbsp;${calamity.width || "Không có"} m
                    </div>
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">🧮</span>
                        <strong>Diện tích:</strong>&nbsp;${calamity.acreage || "Không có"} m²
                    </div>
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">📍</span>
                        <strong>Địa chỉ:</strong>&nbsp;${calamity.address || "Không có"}
                    </div>
                    <div style="display: flex; align-items: start; margin-bottom: 6px;">
                        <span style="width: 25px;">🏘️</span>
                        <strong>Xã:</strong>&nbsp;${calamity.commune || "Không có"}
                    </div>
                    <div style="display: flex; align-items: start;">
                        <span style="width: 25px;">🏞️</span>
                        <strong>Huyện:</strong>&nbsp;${calamity.district || "Không có"}
                    </div>
                </div>
            </div>
            `;
        }
        // Sạt lở theo năm <=====

        // địa phận
        document.getElementById("option-kml").addEventListener("change", function() {
            const districtContainer = document.getElementById("districtContainer");
            if (this.checked) {
                districtContainer.classList.remove("hidden");
                loadDistrictList();
            } else {
                districtContainer.classList.add("hidden");
                clearAllKmlLayers();
            }
        });

        function loadDistrictList() {
            const districtList = document.getElementById("districtList");
            districtList.innerHTML = ""; // Xóa nội dung cũ

            districts.forEach(district => {
                const listItem = document.createElement("li");
                listItem.className = "flex items-center space-x-2 bg-gray-50 p-2 rounded-md pr-6";

                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.className = "district-checkbox";
                checkbox.dataset.urls = JSON.stringify(district.map);
                checkbox.addEventListener("change", function() {
                    const fileUrls = JSON.parse(this.dataset.urls);
                    toggleKmlLayers(fileUrls, this.checked);
                });

                const label = document.createElement("label");
                label.className = "cursor-pointer select-none";
                label.textContent = district.name;

                listItem.appendChild(checkbox);
                listItem.appendChild(label);
                districtList.appendChild(listItem);
            });
        }

        function toggleKmlLayers(urls, show) {
            urls.forEach(url => {
                const fullUrl = url.startsWith("http") ? url : `${window.location.origin}/${url}`;
                if (show) {
                    if (!kmlLayers.has(fullUrl)) {
                        const kmlLayer = new google.maps.KmlLayer({
                            url: fullUrl,
                            map: map,
                            preserveViewport: true,
                        });
                        kmlLayers.set(fullUrl, kmlLayer);
                        google.maps.event.addListener(kmlLayer, "status_changed", function() {
                            if (kmlLayer.getStatus() !== google.maps.KmlLayerStatus.OK) {
                                alert(
                                    `Không thể tải KML từ ${fullUrl}. Kiểm tra đường dẫn hoặc cài đặt CORS.`
                                );
                            }
                        });
                    }
                } else {
                    if (kmlLayers.has(fullUrl)) {
                        kmlLayers.get(fullUrl).setMap(null);
                        kmlLayers.delete(fullUrl);
                    }
                }
            });
        }

        function clearAllKmlLayers() {
            kmlLayers.forEach((layer, url) => {
                layer.setMap(null);
            });
            kmlLayers.clear();
        }
        // địa phận <=====

        // Tuỳ chọn
        function setupOptionCheckBox() {
            document.querySelectorAll(".option-checkbox").forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    let selectedValue = this.value;
                    if (selectedValue === "cong") {
                        toggleConstructionList(locationsConstructions, this.checked, "cong");
                    } else if (selectedValue === "pumping_station") {
                        toggleConstructionList(constructions, this.checked, "pumping_station");
                    } else if (selectedValue === "school") {
                        toggleCalamities(schools, this.checked, selectedValue);
                    } else if (selectedValue === "medical") {
                        toggleCalamities(medicals, this.checked, selectedValue);
                    } else if (selectedValue === "center_commune") {
                        toggleCalamities(center_communes, this.checked, selectedValue);
                    } else if (selectedValue === "center_district") {
                        toggleCalamities(center_districts, this.checked, selectedValue);
                    } else if (this.dataset.url) {
                        toggleKmlLayer(this.dataset.url, this.checked);
                    } else if (selectedValue === "evacuation") {
                        // ✅ Xử lý checkbox "Đường sơ tán"
                        if (this.checked) {
                            addDuongSoTanLayers();
                        } else {
                            removeDuongSoTanLayers();
                        }
                    }
                    // Ẩn danh sách chỉ khi cả 2 đều bỏ chọn
                    if (!document.getElementById("option-cong").checked &&
                        !document.getElementById("option-pumping").checked) {
                        document.getElementById("locationContainerConstruction").classList.add("hidden");
                        document.getElementById("locationContainerConstruction1").classList.add("hidden");
                        clearAllMarkers(); // ❗ Xóa toàn bộ marker
                    }
                });
            });
        }

        function toggleKmlLayer(kmlUrl, show) {
            if (show) {
                if (!kmlLayers.has(kmlUrl)) {
                    let kmlLayer = new google.maps.KmlLayer({
                        url: kmlUrl,
                        map,
                        preserveViewport: true,
                    });
                    kmlLayers.set(kmlUrl, kmlLayer);
                    google.maps.event.addListener(kmlLayer, "status_changed", function() {
                        if (kmlLayer.getStatus() !== google.maps.KmlLayerStatus.OK) {
                            alert("Không thể tải KML/KMZ. Kiểm tra đường dẫn hoặc bật CORS!");
                        }
                    });
                }
            } else {
                if (kmlLayers.has(kmlUrl)) {
                    kmlLayers.get(kmlUrl).setMap(null);
                    kmlLayers.delete(kmlUrl);
                }
            }
        }

        // cống và trạm bơm
        function toggleConstructionList(data, show, type) {
            const container = type === "pumping_station" ?
                document.getElementById("locationContainerConstruction1") :
                document.getElementById("locationContainerConstruction");
            const list = type === "pumping_station" ?
                document.getElementById("districtWardListConstruction1") :
                document.getElementById("districtWardListConstruction");
            if (show) {
                container.classList.remove("hidden");
                list.innerHTML = "";
                updateDistrictsListByType(data, type);
            } else {
                list.innerHTML = "";
                // ❗ Xóa chỉ marker thuộc loại đang tắt
                clearAllMarkersByType(type);
                if (!document.getElementById("option-cong").checked &&
                    !document.getElementById("option-pumping").checked) {
                    container.classList.add("hidden");
                }
            }
        }

        function clearAllMarkersByType(type) {
            markers.forEach((markerGroup, communeId) => {
                if (markerGroup.has(type)) {
                    markerGroup.get(type).forEach(marker => marker.setMap(null));
                    markerGroup.delete(type); // Chỉ xóa marker thuộc loại này
                }
            });
        }

        function updateDistrictsListByType(locations, type) {
            const container = type === "pumping_station" ?
                document.getElementById("locationContainerConstruction1") :
                document.getElementById("locationContainerConstruction");

            const districtList = type === "pumping_station" ?
                document.getElementById("districtWardListConstruction1") :
                document.getElementById("districtWardListConstruction");

            container.classList.remove("hidden");
            districtList.style.maxHeight = "180px";
            districtList.style.overflowY = "auto";

            Object.entries(locations).forEach(([district, data]) => {
                let districtItem = document.createElement("li");
                districtItem.innerHTML = `
                    <div class="flex items-center pr-6 space-x-2 bg-gray-50 p-2 rounded-md">
                        <input type="checkbox" class="district-checkbox" id="district-${district}" data-type="${type}">
                        <label for="district-${district}" class="cursor-pointer select-none">
                            ${district} (${data.total})
                        </label>
                    </div>
                    <ul class="commune-list hidden pl-5 mt-2">
                        ${Object.entries(data.communes)
                            .map(([commune, details]) =>
                            `<li>
                                    <div class="flex items-center space-x-2 bg-white p-2 rounded-md">
                                        <input type="checkbox" class="commune-checkbox" id="commune-${commune}" data-constructions='${JSON.stringify(details.constructions)}' data-type="${type}">
                                        <label for="commune-${commune}" class="cursor-pointer select-none">
                                            ${commune} (${details.count})
                                        </label>
                                    </div>
                                </li>`).join("")}
                    </ul>`;
                let districtCheckbox = districtItem.querySelector(".district-checkbox");
                let communeList = districtItem.querySelector(".commune-list");
                let communeCheckboxes = districtItem.querySelectorAll(".commune-checkbox");
                districtCheckbox.addEventListener("change", function() {
                    let isChecked = this.checked;
                    let type = this.dataset.type;
                    communeList.classList.toggle("hidden", !isChecked);
                    communeCheckboxes.forEach(cb => {
                        cb.checked = isChecked;
                        toggleMarkersConstruction(cb.id, JSON.parse(cb.dataset.constructions),
                            isChecked, type);
                    });
                });
                communeCheckboxes.forEach(cb => {
                    cb.addEventListener("change", function() {
                        let allChecked = [...communeCheckboxes].every(cb => cb.checked);
                        districtCheckbox.checked = allChecked;
                        toggleMarkersConstruction(this.id, JSON.parse(this.dataset.constructions),
                            this.checked, type);
                    });
                });

                districtList.appendChild(districtItem);
            });
        }

        function toggleMarkersConstruction(communeId, calamities, show, type) {
            if (!markers.has(communeId)) {
                markers.set(communeId, new Map());
            }
            let typeMarkers = markers.get(communeId).get(type) || [];
            if (show) {
                if (typeMarkers.length === 0) {
                    typeMarkers = calamities.map(calamity => {
                        let iconUrl = type === 'cong' ?
                            "/uploads/map/drain.png" :
                            "/uploads/map/pump-station.png";

                        let marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(calamity.latitude),
                                lng: parseFloat(calamity.longitude)
                            },
                            map: map,
                            icon: {
                                url: iconUrl,
                                scaledSize: new google.maps.Size(25, 25)
                            }
                        });
                        marker.addListener("click", function() {
                            sharedConstructionInfoWindow.setContent(getContentConstruction(calamity, type));
                            sharedConstructionInfoWindow.open(map, marker);
                        });
                        return marker;
                    });

                    markers.get(communeId).set(type, typeMarkers);
                } else {
                    typeMarkers.forEach(marker => marker.setMap(map));
                }
            } else {
                if (markers.get(communeId).has(type)) {
                    markers.get(communeId).get(type).forEach(marker => marker.setMap(null));
                    markers.get(communeId).delete(type);
                }
            }
        }

        //content cống - trạm bơm
        function getContentConstruction(calamity, type) {
            const label = type === 'cong' ? 'Cống' : 'Trạm bơm';
            const color = type === 'cong' ? '#d35400' : '#16a085';
            return `
                <div style="max-width: 300px; font-family: 'Segoe UI', sans-serif; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 18px rgba(0,0,0,0.15); background: #fff;">
                    <!-- Title -->
                    <div style="background: ${color}; color: white; padding: 12px 18px; text-align: center;">
                        <div style="font-size: 16px; font-weight: bold;">${calamity.name} (${label})</div>
                    </div>
                    <!-- Info -->
                    <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                        <div style="display: flex; margin-bottom: 8px;">
                            <div style="width: 25px; text-align: center;">📍</div>
                            <div><strong>Địa chỉ:</strong> ${calamity.address || "Không có"}</div>
                        </div>
                        <div style="display: flex; margin-bottom: 8px;">
                            <div style="width: 25px; text-align: center;">🏘️</div>
                            <div><strong>Xã:</strong> ${calamity.commune || "Không có"}</div>
                        </div>
                        <div style="display: flex; margin-bottom: 8px;">
                            <div style="width: 25px; text-align: center;">🏞️</div>
                            <div><strong>Huyện:</strong> ${calamity.district || "Không có"}</div>
                        </div>
                        <div style="display: flex; margin-bottom: 8px;">
                            <div style="width: 25px; text-align: center;">⚠️</div>
                            <div><strong>Cấp độ rủi ro:</strong> ${calamity.risk_level_name || "Không có"}</div>
                        </div>
                        <div style="display: flex; margin-bottom: 8px;">
                            <div style="width: 25px; text-align: center;">🏗️</div>
                            <div><strong>Năm xây dựng:</strong> ${calamity.year_of_construction || "Không có"}</div>
                        </div>
                        ${type === 'cong' ? `

                        ` : ''}
                        ${type === 'pumping_station' ? `

                        ` : ''}
                    </div>
                </div>
            `;
        }

        // cống và trạm bơm <=====
        function clearAllMarkers() {
            markers.forEach(markerArray => markerArray.forEach(marker => marker.setMap(null)));
            markers.clear();
        }

        // trường học - y tế - tthc xã, huyện
        function toggleCalamities(data, show, type) {
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

        //set content theo type (school - medical - center)
        function getContent(value, type) {
            switch (type) {
                case "school":
                    return `
                            <div style="max-width: 340px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff; transition: all 0.3s ease-in-out;">
                                <!-- Title -->
                                <div style="background: linear-gradient(to right, #e74c3c, #c0392b); color: white; padding: 14px 20px; text-align: center;">
                                    <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                                        ${value.name} (Trường học)
                                    </div>
                                </div>
                                <!-- Info content -->
                                <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                                    <div style="display: flex; margin-bottom: 8px;">
                                        <div style="width: 25px; text-align: center;">📍</div>
                                        <div><strong>Địa chỉ:</strong> ${value.address || "Không có"}</div>
                                    </div>
                                    <div style="display: flex; margin-bottom: 8px;">
                                        <div style="width: 25px; text-align: center;">🏘️</div>
                                        <div><strong>Xã:</strong> ${value.commune || "Không có"}</div>
                                    </div>
                                    <div style="display: flex;">
                                        <div style="width: 25px; text-align: center;">🏞️</div>
                                        <div><strong>Huyện:</strong> ${value.district || "Không có"}</div>
                                    </div>
                                </div>
                            </div>
                         `;
                case "medical":
                    return `
                        <div style="max-width: 360px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff; transition: all 0.3s ease-in-out;">
                            <!-- Title -->
                            <div style="background: linear-gradient(to right, #27ae60, #229954); color: white; padding: 14px 20px; text-align: center;">
                                <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                                    ${value.name} (Cơ sở y tế)
                                </div>
                            </div>
                            <!-- Info content -->
                            <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                                <div style="display: flex; margin-bottom: 8px;">
                                    <div style="width: 25px; text-align: center;">🏥</div>
                                    <div><strong>Loại hình:</strong> ${value.classify || "Không có"}</div>
                                </div>
                                <div style="display: flex; margin-bottom: 8px;">
                                    <div style="width: 25px; text-align: center;">📋</div>
                                    <div><strong>Phân loại:</strong> ${value.option || "Không có"}</div>
                                </div>
                                <div style="display: flex; margin-bottom: 8px;">
                                    <div style="width: 25px; text-align: center;">📍</div>
                                    <div><strong>Địa chỉ:</strong> ${value.address || "Không có thông tin"}</div>
                                </div>
                                <div style="display: flex; margin-bottom: 8px;">
                                    <div style="width: 25px; text-align: center;">🏘️</div>
                                    <div><strong>Xã:</strong> ${value.commune || "Không có"}</div>
                                </div>
                                <div style="display: flex;">
                                    <div style="width: 25px; text-align: center;">🏞️</div>
                                    <div><strong>Huyện:</strong> ${value.district || "Không có"}</div>
                                </div>
                            </div>
                        </div>
                        `;
                case "center_commune":
                    return `
                            <div style="max-width: 360px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff; transition: all 0.3s ease-in-out;">
                                <!-- Title -->
                                <div style="background: linear-gradient(to right, #2980b9, #2471a3); color: white; padding: 14px 20px; text-align: center;">
                                    <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                                        ${value.name} (TT hành chính xã)
                                    </div>
                                </div>
                                <!-- Info content -->
                                <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                                    <div style="display: flex; margin-bottom: 8px;">
                                        <div style="width: 25px; text-align: center;">📍</div>
                                        <div><strong>Địa chỉ:</strong> ${value.address || "Không có thông tin"}</div>
                                    </div>
                                    <div style="display: flex; margin-bottom: 8px;">
                                        <div style="width: 25px; text-align: center;">🏘️</div>
                                        <div><strong>Xã:</strong> ${value.commune || "Không có"}</div>
                                    </div>
                                    <div style="display: flex; margin-bottom: 8px;">
                                        <div style="width: 25px; text-align: center;">🏞️</div>
                                        <div><strong>Huyện:</strong> ${value.district || "Không có"}</div>
                                    </div>
                                    <div style="display: flex;">
                                        <div style="width: 25px; text-align: center;">📝</div>
                                        <div><strong>Mô tả:</strong> ${value.description || "Không có"}</div>
                                    </div>
                                </div>
                            </div>
                            `;
                case "center_district":
                    return `
                            <div style="max-width: 360px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff; transition: all 0.3s ease-in-out;">
                                <!-- Title -->
                                <div style="background: linear-gradient(to right, #8e44ad, #6c3483); color: white; padding: 14px 20px; text-align: center;">
                                    <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                                        ${value.name} (TT hành chính huyện)
                                    </div>
                                </div>
                                <!-- Info content -->
                                <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                                    <div style="display: flex; margin-bottom: 8px;">
                                        <div style="width: 25px; text-align: center;">📍</div>
                                        <div><strong>Địa chỉ:</strong> ${value.address || "Không có thông tin"}</div>
                                    </div>
                                    <div style="display: flex; margin-bottom: 8px;">
                                        <div style="width: 25px; text-align: center;">🏘️</div>
                                        <div><strong>Xã:</strong> ${value.commune || "Không có"}</div>
                                    </div>
                                    <div style="display: flex; margin-bottom: 8px;">
                                        <div style="width: 25px; text-align: center;">🏞️</div>
                                        <div><strong>Huyện:</strong> ${value.district || "Không có"}</div>
                                    </div>
                                    <div style="display: flex;">
                                        <div style="width: 25px; text-align: center;">📝</div>
                                        <div><strong>Mô tả:</strong> ${value.description || "Không có"}</div>
                                    </div>
                                </div>
                            </div>
                            `;
                default:
                    return `
                    <div>
                        <h3 class="font-bold">${value.name}</h3>
                        <p><strong>Địa chỉ:</strong> ${value.address || "Không có thông tin"}</p>
                    </div>
                `;
            }
        }

        // đường sơ tán
        function addDuongSoTanLayers() {
            let duongSoTanFiles = @json($duongSoTanFiles); // Nhận danh sách file từ backend
            duongSoTanFiles.forEach(file => {
                let kmlLayer = new google.maps.KmlLayer({
                    url: file,
                    map: map,
                    preserveViewport: true
                });
                // Lưu lại layer để có thể xóa khi checkbox bị tắt
                kmlLayerSoTan.set(file, kmlLayer);
            });
        }

        function removeDuongSoTanLayers() {
            kmlLayerSoTan.forEach((layer, key) => {
                layer.setMap(null); // Ẩn layer khỏi bản đồ
            });

            kmlLayerSoTan.clear(); // Xóa danh sách layers
        }

        function setupDrawingTools() {
            const btnCreate = document.getElementById("btn-create-kml");
            const btnExport = document.getElementById("btn-export-kml");

            btnCreate.addEventListener("click", () => {
                // Nếu đã tạo rồi thì reset
                if (drawingManager) {
                    drawingManager.setMap(null);
                }

                drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: null,
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: ["marker", "polygon", "polyline"]
                    },
                });

                drawingManager.setMap(map); // QUAN TRỌNG: gán vào bản đồ

                btnExport.classList.remove("hidden");

                // Khi vẽ xong một overlay
                drawingManager.addListener("overlaycomplete", (e) => {
                    const overlay = e.overlay;
                    const type = e.type;
                    console.log("Vẽ xong:", type, overlay.getPath ? overlay.getPath().getArray() : overlay.getPosition());
                    // Bạn có thể lưu overlay lại để export KML sau
                });
            });
        }
    </script>
<!--     
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&callback=initMap" async &libraries=drawing
        defer loading="async"></script> -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&libraries=drawing&callback=initializeApp"
        async
        defer
        ></script>

    <!-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script> -->
    <script src="https://unpkg.com/togeojson@0.16.0/togeojson.js"></script>
    <script src="https://unpkg.com/@mapbox/tokml@0.4.0/tokml.js"></script>

@endpush
