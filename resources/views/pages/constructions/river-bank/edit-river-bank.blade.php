@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Công Trình Sạt Lở Bờ Sông & Bờ Biển - PCTT Cà Mau Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-rain'] !!}
        Cập Nhật Công Trình Sạt Lở Bờ Sông & Bờ Biển
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> 
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-construction-river-bank') }}"
                method="post">
                <input type="hidden" name="id" value="{{ $construction->id }}">
                @csrf
                
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Công Trình Sạt Lở
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Tên công trình</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input value="{{ $construction->name }}" name="name" id="name"
                                            type="text" placeholder="Tên công trình" />
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Phân loại công trình</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select id="type_of_construction_id" name="type_of_construction_id">
                                            @foreach ($typeOfConstructions as $typeOfConstruction)
                                                <option value="{{ $typeOfConstruction->id }}"
                                                    {{ $construction->type_of_construction_id == $typeOfConstruction->id ? 'selected' : '' }}>
                                                    {{ $typeOfConstruction->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type_of_construction_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Xã</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select id="commune_id" name="commune_id">
                                            @foreach ($communes as $commune)
                                                <option value="{{ $commune->id }}"
                                                    {{ !empty($construction->communes) && isset($construction->communes[0]->id) && $construction->communes[0]->id == $commune->id ? 'selected' : '' }}>
                                                    {{ $commune->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('commune_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Phân loại thiên tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="type_of_calamity_id">
                                            @foreach ($calamities as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ $construction->type_of_calamity_id == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('type_of_calamity_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Cấp độ rủi ro thiên tai</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="risk_level_id">
                                            @foreach ($risk_levels as $risk_level)
                                                <option value="{{ $risk_level->id }}"
                                                    {{ $construction->risk_level_id == $risk_level->id ? 'selected' : '' }}>
                                                    {{ $risk_level->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('risk_level_id')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium"> Toạ độ</div>
                                                <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <div class="relative">
                                            <input value="{{ $construction->coordinates }}" name="coordinates"
                                                id="coordinates" type="text" placeholder="Nhập tọa độ (VD: 10.7769, 106.7009)" onblur="updateMapFromInput()" />
                                        </div>
                                        <div id="mapRiverBank" class="w-full h-[200px] rounded-lg border"></div>
                                        @error('coordinates')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="w-full border-t-2 border-gray-300 my-4"></div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Tiến độ thực hiện </div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="progress">
                                            <option value="Đang thi công"
                                                {{ old('progress', $construction->progress) == 'Đang thi công' ? 'selected' : '' }}>
                                                Đang thi công
                                            </option>
                                            <option value="Chưa thực hiện"
                                                {{ old('progress', $construction->progress) == 'Chưa thực hiện' ? 'selected' : '' }}>
                                                Chưa thực hiện
                                            </option>
                                            <option value="Hoàn thành"
                                                {{ old('progress', $construction->progress) == 'Hoàn thành' ? 'selected' : '' }}>
                                                Hoàn thành
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Năm xây dựng</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input value="{{ $construction->year_of_construction }}"
                                            name="year_of_construction" id="year_of_construction" type="number"
                                            placeholder="Năm xây dựng" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Địa chỉ</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input value="{{ $construction->address }}" name="address"
                                            id="address" type="text" placeholder="Địa chỉ" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Mô tả</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input value="{{ $construction->description }}" name="description"
                                            id="description" type="text" placeholder="Mô tả" />
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Tình trạng</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <select class="w-full" id="crud-form-2" name="status">
                                            <option value="Tốt"
                                                {{ old('status', $construction->status) == 'Tốt' ? 'selected' : '' }}>
                                                Tốt
                                            </option>
                                            <option value="Trung bình"
                                                {{ old('status', $construction->status) == 'Trung bình' ? 'selected' : '' }}>
                                                Trung bình
                                            </option>
                                            <option value="Kém"
                                                {{ old('status', $construction->status) == 'Kém' ? 'selected' : '' }}>
                                                Kém
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Chi phí</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input value="{{ $construction->cost }}" name="cost"
                                            id="cost" type="text" placeholder="Chi phí" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Nhà thầu</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input value="{{ $construction->contractor }}" name="contractor"
                                            id="contractor" type="text" placeholder="Nhà thầu" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Ghi chú</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input value="{{ $construction->notes }}" name="notes"
                                            id="notes" type="text" placeholder="Ghi chú" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                    <div class="w-full md:w-auto text-left">
                        <p class="italic">
                            Tạo bởi: {{ optional($construction->created_by_user)->full_name ?? 'Không rõ' }}.
                        </p>
                        <p class="italic">
                            Cập nhật lần cuối: {{ optional($construction->updated_by_user)->full_name ?? 'Không rõ' }}.
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('view-construction-river-bank') }}">
                            <button type="button"
                                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                Huỷ Bỏ</button>
                        </a>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                            Lưu
                        </button>
                    </div>
                </div>
            </form>
   
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof google === "undefined" || typeof google.maps === "undefined") {
            console.warn("Google Maps API chưa tải xong, đang chờ...");
            let maxRetries = 10; 
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
    
    let mapRiverBank, marker;
    let infoWindowRiverBank;

    function initializeApp() {
        initMap();
        const construction = @json($construction); 
        showSingleConstructionMarker(construction);
    }

    function initMap() {
        mapRiverBank = new google.maps.Map(document.getElementById('mapRiverBank'), {
            center: {
                lat: 8.946132,
                lng: 105.033270
            },
            zoom: 11
        });
        infoWindowRiverBank = new google.maps.InfoWindow();
        
        mapRiverBank.addListener("click", function(event) {
            let lat = event.latLng.lat().toFixed(6);
            let lng = event.latLng.lng().toFixed(6);
            
            document.getElementById("coordinates").value = lat + ", " + lng;
            
            if (marker) {
                marker.setPosition(event.latLng);
            } else {
                marker = new google.maps.Marker({
                    position: event.latLng,
                    map: mapRiverBank,
                    draggable: true
                });
            }
        });
    }

    function updateMapFromInput() {
        let inputVal = document.getElementById("coordinates").value.trim();
        let coords = inputVal.split(",");

        if (coords.length === 2) {
            let lat = parseFloat(coords[0]);
            let lng = parseFloat(coords[1]);

            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                let newLocation = {
                    lat: lat,
                    lng: lng
                };
                mapRiverBank.setCenter(newLocation);
                mapRiverBank.setZoom(13);
                if (marker) {
                    marker.setPosition(newLocation); 
                }
            } else {
                showToast("⚠️ Tọa độ không hợp lệ! Vui lòng nhập lại.");
            }
        } else {
            showToast("⚠️ Định dạng tọa độ không đúng! Vui lòng nhập theo dạng: lat, lng");
        }
    }

    function showSingleConstructionMarker(construction) {
        if (construction.coordinates) {
            const [lat, lng] = construction.coordinates.split(',');
            construction.latitude = parseFloat(lat.trim());
            construction.longitude = parseFloat(lng.trim());

            marker = new google.maps.Marker({ 
                position: {
                    lat: parseFloat(construction.latitude),
                    lng: parseFloat(construction.longitude)
                },
                map: mapRiverBank,
                draggable: true,
                icon: {
                    url: "/uploads/map/ke_chong_sat_lo.png",
                    scaledSize: new google.maps.Size(25, 25)
                }
            });
            
            marker.addListener("dragend", function(event) {
                document.getElementById("coordinates").value =
                    event.latLng.lat().toFixed(6) + ", " + event.latLng.lng().toFixed(6);
            });
            
            marker.addListener("click", function() {
                infoWindowRiverBank.setContent(generateContent(construction));
                infoWindowRiverBank.open(mapRiverBank, marker);
            });
            
            google.maps.event.addListener(infoWindowRiverBank, "domready", function() {
                const closeBtn = document.querySelector(".gm-ui-hover-effect");
                if (closeBtn) closeBtn.style.display = "none";
                const customClose = document.getElementById("custom-close-btn");
                if (customClose) {
                    customClose.addEventListener("click", () => {
                        infoWindowRiverBank.close();
                    });
                }
            });
            
            mapRiverBank.setCenter(marker.getPosition());
            mapRiverBank.setZoom(10);
        }
    }

    function generateContent(construction) {
        const defaultImage = "{{ Vite::asset('resources/images/default-river-bank.png') }}";
        return `
        <div style="max-width: 340px; font-family: 'Segoe UI', sans-serif; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.15); background: #fff; transition: all 0.3s ease-in-out;">
            
            <div style="position: relative; overflow: hidden;">
                <img src="${construction.image || defaultImage}" alt="Hình ảnh"
                    style="width: 100%; height: 180px; object-fit: cover; transition: transform 0.3s ease;">
                <button id="custom-close-btn"
                        style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.9); border: none; border-radius: 50%; padding: 6px 10px; font-size: 16px; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                    ✕
                </button>
            </div>
            
            <div style="background: linear-gradient(to right, #3498db, #2980b9); color: white; padding: 14px 20px; text-align: center;">
                <div style="font-size: 17px; font-weight: bold; letter-spacing: 0.5px;">
                    ${construction.name}
                </div>
            </div>
            
           <div style="padding: 16px 20px; font-size: 14.5px; color: #333; line-height: 1.8;">
                <div style="display: flex; align-items: start; margin-bottom: 6px;">
                    <span style="width: 25px;">📍</span>
                    <strong>Địa chỉ:</strong>&nbsp;${construction.address || "Không có"}
                </div>
                <div style="display: flex; align-items: start; margin-bottom: 6px;">
                    <span style="width: 25px;">🏗️</span>
                    <strong>Tiến độ:</strong>&nbsp;${construction.progress || "Không có"}
                </div>
                <div style="display: flex; align-items: start;">
                    <span style="width: 25px;">🏘️</span>
                    <strong>Xã:</strong>&nbsp;${construction.communes && construction.communes[0] ? construction.communes[0].name : "Không có"}
                </div>
            </div>
        </div>
        `;
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&callback=initializeApp" async
defer loading="async"></script>
@endpush
