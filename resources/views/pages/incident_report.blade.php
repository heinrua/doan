@extends('themes.base')
@section('subcontent')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert" id="success-message">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 hover:bg-green-200 rounded" onclick="this.parentElement.remove()">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </button>
    </div>
@endif

@guest

<form enctype="multipart/form-data" class="validate-form" action="{{ route('incident-reports.store') }}" method="post">
    @csrf
    
    <div class="intro-y box">
        <div class="rounded-md border border-slate-200/60 p-5">
            <div
                class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                Thông Tin Báo Cáo Thiên tai
            </div>
            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                
                    <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                        formInline>
                        <label class="md:w-80">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">Tên người gửi thông báo</div>
                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                </div>
                            </div>
                        </label>
                        <div class="w-full">
                            <input name="reporter_name" id="reporter_name" type="text"
                                placeholder="Tên người gửi" />
                            @error('reporter_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                 
                    <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                        formInline>
                        <label class="md:w-80">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">Thiên Tai</div>
                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                </div>
                            </div>
                        </label>
                        <div class="w-full">
                            <select class="w-full" id="type_of_calamity_id"
                                name="type_of_calamity_id">
                                <option>--Chọn thiên tai--</option>
                                @foreach ($typeOfCalamities as $key => $value)
                                    <option value="{{ $value->id }}">
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
                                    <div class="font-medium">Bản đồ</div>
                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>

                                </div>
                            </div>
                        </label>
                        <div class="w-full">
                            <div class="relative">
                                <input type="text" id="coordinates" name="coordinates"
                                placeholder="Nhập tọa độ (VD: 10.7769, 106.7009)"
                                onblur="updateMapFromInput()"
                                 class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" />
                                <button type="button" id="get-current-location" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">{!! $icons['location'] !!}</button>
                            </div>
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
                            <select class="w-full" id="commune_id" name="commune_id">
                                <option value="">--Chọn Xã--</option>
                                @foreach ($communes as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
               
                <div>
                    {{-- Số điện thoại --}}
                    <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                        formInline>
                        <label class="md:w-80">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">Số điện thoại</div>
                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                </div>
                            </div>
                        </label>
                        <div class="w-full">
                            <input name="contact_number" id="contact_number" type="text"
                                placeholder="Số điện thoại" />
                            @error('contact_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                   
                    <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                        formInline>
                        <label class="md:w-80">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">Loại thiên tai phụ</div>
                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                </div>
                            </div>
                        </label>
                        <div class="w-full">
                            <select class="w-full" id="sub-type-of-calamity-select"
                                name="sub_type_of_calamity_id">
                                <option value="">--Chọn thiên tai phụ--</option>
                            </select>
                            @error('sub_type_of_calamity_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- Địa chỉ --}}
                    <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                        formInline>
                        <label class="md:w-80">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">Địa chỉ</div>
                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                </div>
                            </div>
                        </label>
                        <div class="w-full">
                            <input name="address" id="address" type="text"
                                placeholder="Địa chỉ" />
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                        formInline>
                        <label class="md:w-80">
                            <div class="text-left">
                                <div class="flex items-center">
                                    <div class="font-medium">Hình ảnh/Video mô tả</div>
                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                </div>
                            </div>
                        </label>
                        <div class="w-full">
                            <input type="file" name="attachment[]" id="attachment" accept="image/*,video/*,.pdf" multiple
                                            class="block w-full text-sm text-gray-900
                                            file:mr-2 file:py-1 file:px-3
                                            file:rounded file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-blue-100 file:text-blue-700
                                            hover:file:bg-blue-200 border border-gray-300 rounded-md">
                            <p class="text-xs text-gray-500 mt-1">Có thể chọn nhiều file (hình ảnh, video, PDF)</p>
                            <div id="file-progress" class="hidden mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="progress-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <p id="progress-text" class="text-xs text-gray-600 mt-1">Đang tải file...</p>
                            </div>
                            @error('attachment.*')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>
            <div id="map1" class="rounded-lg border shadow-lg"
                style="width: 100%; height: 400px; margin-top: 30px;"></div>
        </div>
    </div>
    
    <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
        <a href="{{ route('view-calamity-storm') }}">
            <button type="button"
            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
            Huỷ Bỏ</button>
        </a>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
            Gửi
        </button>
    </div>
</form>

@endguest

@auth
 <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            Danh sách báo cáo tình hình thiên tai
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-calamity-storm') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-calamity-storm') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                <select name="date_range"
                    class="h-10 w-48 min-w-[150px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">-- Chọn khoảng thời gian --</option>
                    <option value="yesterday" {{ request('date_range') == 'yesterday' ? 'selected' : '' }}>Hôm qua</option>
                    <option value="last_3_days" {{ request('date_range') == 'last_3_days' ? 'selected' : '' }}>3 ngày gần đây</option>
                    <option value="last_7_days" {{ request('date_range') == 'last_7_days' ? 'selected' : '' }}>7 ngày gần đây</option>
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
            
        </div>
       
        <div
            class="intro-y col-span-3 overflow-visible lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số bản ghi: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
   
        <form action="{{ route('delete-multiple-calamity-storm') }}" class = "col-span-2" method="POST">
            @csrf
            @method('DELETE')
  
            <button type="submit" class="bg-red-700 sticky left-0" id="delete-multiple-btn" disabled>
                {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
            </button>
          
        </form>

        <div class="intro-y col-span-12 overflow-visible lg:overflow-x-auto">
            <table class="mt-2 border-separate border-spacing-y-[10px] ">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                    <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                    <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4  min-w-[180px]"> 
                        Loại thiên tai
                    </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Loại hình</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Mô tả</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Toạ Độ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Địa chỉ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Hình ảnh/Video</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Thời gian gửi </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Người gửi </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Số liên lạc </th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] " > Hành động</th>
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
                            {{ $value->sub_type_of_calamity && $value->sub_type_of_calamity->type_of_calamities ? $value->sub_type_of_calamity->type_of_calamities->name : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ $value->sub_type_of_calamity->name  }}
                        </td>
                    
                        <td class="px-6 py-4 min-w-[160px] ">{{ $value->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->coordinates }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->commune ? $value->commune->name : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            @php
                                $attachments = json_decode($value->attachment, true);
                            @endphp
                            @if (!empty($attachments) && is_array($attachments))
                                @foreach ($attachments as $attachment)
                                    @php
                                        $filePath = $attachment;
                                        $fileName = basename($attachment);
                                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                        $isVideo = in_array($fileExtension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm']);
                                        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                                        
                                        // Handle both old storage path and new uploads path
                                        if (strpos($filePath, 'attachments/') === 0) {
                                            $assetPath = 'storage/' . $filePath;
                                        } else {
                                            $assetPath = $filePath;
                                        }
                                    @endphp
                                    @if($isImage)
                                        <div class="mb-1">
                                            <a href="javascript:void(0);" 
                                               onclick="openImageModal('{{ asset($assetPath) }}')"
                                               class="text-blue-500 hover:underline text-xs">
                                                📷 {{ $fileName }}
                                            </a>
                                        </div>
                                    @elseif($isVideo)
                                        <div class="mb-1">
                                            <a href="javascript:void(0);" 
                                               onclick="openVideoModal('{{ asset($assetPath) }}')"
                                               class="text-blue-500 hover:underline text-xs">
                                                🎥 {{ $fileName }}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <span class="text-gray-500 italic">Chưa có file</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->created_at}}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->reporter_name}}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">{{ $value->contact_number}}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            <div class="flex items-center justify-center">
                                <a class="flex items-center text-red-700" data-tw-toggle="modal"
                                    data-tw-target="#delete-confirmation-modal"
                                    onclick="openDeleteModal('{{ route('delete-calamity-storm', ['id' => $value->id]) }}')"
                                    href="javascript:void(0);">
                                    {!! $icons['trash-2'] !!} Xoá
                                </a>
                            </div>
                        </td>
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
                    class="absolute top-4 right-4 text-white text-3xl font-bold hover:text-gray-300">
                ×
            </button>
        </div>
    </div>

    
@endauth

@endsection



@push('scripts')
<script>
    // Simple calamity select functionality
    document.addEventListener("DOMContentLoaded", function() {
        const calamitySelect = document.getElementById("type_of_calamity_id"); 
        const subTypeOfCalamitySelect = document.querySelector("#sub-type-of-calamity-select"); 
        
        if (calamitySelect && subTypeOfCalamitySelect) {
            calamitySelect.addEventListener("change", function() {
                const calamityId = calamitySelect.value;
                
                // Reset sub-type select
                subTypeOfCalamitySelect.innerHTML = `<option value="">--Chọn thiên tai phụ--</option>`;
                
                if (!calamityId || calamityId === '--Chọn thiên tai--') {
                    return;
                }
                
                const subTypeUrl = `{{ route('get-sub-type-of-calamities') }}?calamity_id=${calamityId}`;
                
                fetch(subTypeUrl)
                .then(res => res.json())
                .then(data => {
                    subTypeOfCalamitySelect.innerHTML = `<option value="">--Chọn thiên tai phụ--</option>`;
                    data.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.name;
                        subTypeOfCalamitySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Lỗi khi tải loại hình thiên tai:", error);
                });
            });
        }
    });

    // Google Maps functionality
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

        // Current location button
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
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    alert("Bạn đã từ chối chia sẻ vị trí.");
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    alert("Không thể xác định vị trí.");
                                    break;
                                case error.TIMEOUT:
                                    alert("Yêu cầu vị trí quá thời gian.");
                                    break;
                                default:
                                    alert("Lỗi không xác định.");
                                    break;
                            }
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
   
</script>
<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMhd9dHKpWfJ57Ndv2alnxEcSvP_-_uN8&libraries=places&callback=initMap">
    </script>

@endpush