@extends('themes.base')

@section('subhead')
    <title>Tạo Mới Địa Điểm Y Tế - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['aperture'] !!}
        Tạo Mới Địa Điểm Y Tế
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> 
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/administrative/create-medical" method="post">
                @csrf
                <input type="hidden" name="type" value="medical">
                
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Địa Điểm Y Tế
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Y Tế</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="name" id="name" type="text"
                                        placeholder="Tên Y Tế" />
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mã</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="code" id="code" type="text" placeholder="Mã" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Địa Điểm</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="address" id="address" type="text"
                                        placeholder="Địa Điểm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
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
                                    <select class="w-full" id="crud-form-2" name="commune_id">
                                        @foreach ($communes as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('commune_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Toạ độ</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <div class="relative">
                                        <input name="coordinates" id="coordinates" type="text"
                                            placeholder="Nhập tọa độ (VD: 10.7769, 106.7009)"
                                            onblur="updateMapFromInput()"
                                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" />
                                        <button type="button" id="get-current-location" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                            {!! $icons['location'] !!}
                                        </button>
                                    </div>
                                    <div id="map1" class="rounded-lg border shadow-lg" style="width: 100%; height: 400px; margin-top: 30px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Sức chứa</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="population" id="population" type="number"
                                        placeholder="Sức chứa" />
                                    @error('population')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Loại hình</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="classify" id="classify" type="text"
                                        placeholder="Loại hình" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Phân loại</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="option" id="option" type="text"
                                        placeholder="Phân loại" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mô tả</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="description" id="description" type="text"
                                        placeholder="Mô tả" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-medical') }}">
                        <button type="button"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                            Huỷ Bỏ</button>
                    </a>
                   <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let map1, marker;
    function initMap() {
        map1 = new google.maps.Map(document.getElementById('map1'), {
            center: { lat: 9.176, lng: 105.15 },
            zoom: 10
        });
        marker = new google.maps.Marker({
            position: { lat: 9.176, lng: 105.15 },
            map: map1,
            draggable: true
        });
        marker.addListener("dragend", function(event) {
            const coordinatesElement = document.getElementById("coordinates");
            if (coordinatesElement) {
                coordinatesElement.value = event.latLng.lat().toFixed(6) + ", " + event.latLng.lng().toFixed(6);
            }
        });
        map1.addListener("click", function(event) {
            let lat = event.latLng.lat().toFixed(6);
            let lng = event.latLng.lng().toFixed(6);
            const coordinatesElement = document.getElementById("coordinates");
            if (coordinatesElement) {
                coordinatesElement.value = lat + ", " + lng;
            }
            marker.setPosition(event.latLng);
        });
        const getCurrentLocationBtn = document.getElementById("get-current-location");
        if (getCurrentLocationBtn) {
            getCurrentLocationBtn.addEventListener("click", function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            const currentLocation = { lat: lat, lng: lng };
                            map1.setCenter(currentLocation);
                            map1.setZoom(15);
                            marker.setPosition(currentLocation);
                            const coordinatesElement = document.getElementById("coordinates");
                            if (coordinatesElement) {
                                coordinatesElement.value = lat.toFixed(6) + ", " + lng.toFixed(6);
                            }
                        },
                        function (error) {
                            alert("Không thể lấy vị trí hiện tại.");
                        }
                    );
                } else {
                    alert("Trình duyệt không hỗ trợ lấy vị trí.");
                }
            });
        }
    }
    function updateMapFromInput() {
        const coordinatesElement = document.getElementById("coordinates");
        if (!coordinatesElement) return;
        let inputVal = coordinatesElement.value.trim();
        let coords = inputVal.split(",");
        if (coords.length === 2) {
            let lat = parseFloat(coords[0]);
            let lng = parseFloat(coords[1]);
            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                let newLocation = { lat: lat, lng: lng };
                map1.setCenter(newLocation);
                map1.setZoom(15);
                marker.setPosition(newLocation);
            }
        }
    }
</script>

@endpush
