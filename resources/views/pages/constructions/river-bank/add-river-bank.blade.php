@extends('themes.base')

@section('subhead')
    <title>Tạo Mới Công Trình Sạt Lở Bờ Sông & Bờ Biển - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-rain'] !!}
        Tạo Mới Công Trình Sạt Lở Bờ Sông & Bờ Biển
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> 
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="/construction/create-river-bank" method="post">
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
                                        <input name="name" id="name" type="text"
                                            placeholder="Tên công trình" />
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
                                        <select class="w-full" id="crud-form-2" name="type_of_construction_id">
                                            @foreach ($typeOfConstructions as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}
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
                                        <select class="w-full" id="crud-form-2" name="commune_id">
                                            @foreach ($communes as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
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
                                            @foreach ($calamities as $key => $value)
                                                <option name="calamities" value="{{ $value->id }}">{{ $value->name }}
                                                </option>
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
                                            @foreach ($risk_levels as $key => $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}
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
                                            <input name="coordinates" id="coordinates" type="text"
                                                placeholder="Nhập tọa độ (VD: 10.7769, 106.7009)"
                                                onblur="updateMapFromInput()"
                                                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" />
                                           
                                        </div>
                                        <div id="map1" class="rounded-lg border shadow-lg" style="width: 100%; height: 400px; margin-top: 30px;"></div>
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
                                            <option name="Đang thi công" value="Đang thi công">Đang thi công</option>
                                            <option name="Chưa thực hiện" value="Chưa thực hiện">Chưa thực hiện</option>
                                            <option name="Hoàn thành" value="Hoàn thành">Hoàn thành</option>
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
                                        <input name="year_of_construction" id="year_of_construction"
                                            type="number" placeholder="Năm xây dựng" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Chiều rộng</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="width" id="width" type="text"
                                            placeholder="Chiều rộng" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium"> Mức độ ảnh hưởng</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="influence_level" id="influence_level" type="text"
                                            placeholder="Mức độ ảnh hưởng" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium"> Tổng mức đầu tư</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="total_investment" id="total_investment" type="text"
                                            placeholder="Tổng mức đầu tư" />
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium"> Quy mô</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="scale" id="scale" type="text"
                                            placeholder=" Quy mô" />
                                    </div>
                                </div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Năm hoàn thành</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="year_of_completion" id="year_of_completion"
                                            type="number" placeholder="Năm hoàn thành" />
                                    </div>
                                </div>

                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Chiều dài (km)</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="length" id="length" type="text"
                                            placeholder="Chiều dài (km)" />
                                    </div>
                                </div>

                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium"> Nguồn vốn</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input name="capital_source" id="capital_source" type="text"
                                            placeholder="Nguồn vốn" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium"> Hình ảnh</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input type="file" name="image" id="image" accept="image/*"
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                    formInline>
                                    <label class="md:w-80">
                                        <div class="text-left">
                                            <div class="flex items-center">
                                                <div class="font-medium">Video</div>
                                            </div>
                                        </div>
                                    </label>
                                    <div class="w-full">
                                        <input type="file" name="video" id="video" 
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-construction-river-bank') }}">
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
