@extends('themes.base')

@section('subhead')
    <title>Trang chủ - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')

    
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
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
                                    <!-- Dòng 1: Icon - Tên -->
                                    <div class="flex items-center gap-6">
                                        {!! $icons['cloud-lightning'] !!}   
                                        <span class="text-2xl font-bold tracking-wide">BÃO, ÁP THẤP</span>
                                    </div>
                                    <!-- Dòng 2 + 3: Dữ liệu có icon -->
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
                                    <!-- Dòng 1: Icon - Tên -->
                                    <div class="flex items-center gap-6">
                                        {!! $icons['arlett-triangle'] !!}
                                        <span class="text-2xl font-bold tracking-wide">NGẬP LỤT</span>
                                    </div>
                                    <!-- Dòng 2 + 3: Dữ liệu có icon -->
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
                                    <!-- Dòng 1: Icon - Tên -->
                                    <div class="flex items-center gap-6">
                                        {!! $icons['cloud-rain'] !!}
                                        <span class="text-2xl font-bold tracking-wide">SẠT LỞ</span>
                                    </div>
                                    <!-- Dòng 2 + 3: Dữ liệu có icon -->
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
                <!-- END: General Report -->
                <!-- BEGIN: New Post Calamity -->
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
                                        <!-- Icon -->
                                        <div class="h-10 w-10 flex items-center justify-center rounded-md bg-primary/20">
                                            {!! $icons['shield-alert'] !!}
                                        </div>
                                        <!-- Nội dung chính -->
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
                                    
                                        <!-- Thời gian -->
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
                <!-- END: New Post Calamity -->
                <!-- BEGIN: Bieu do -->
                @php
                    // Màu sắc đẹp hơn (xanh, cam, đỏ)
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
                        <!-- Biểu đồ -->
                        <div class="w-2/3 flex flex-col items-center justify-center h-full">
                            <div id="disaster-chart" class="h-[370px] w-full"></div>
                            <p class="mt-2 text-center text-sm text-gray-600">Biểu đồ thể hiện số lượng thiên tai theo loại
                                hình thiên tai</p>
                        </div>
                        <!-- Danh sách -->
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
                <!-- END: Bieu do -->
                <!-- BEGIN: Map Cảnh Báo Thiên Tai -->
                <div class="col-span-12 xl:col-span-12 flex flex-col mt-4">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="flex items-center mr-5 uppercase text-lg font-medium">
                            {!! $icons['map-pin'] !!}
                            Bản Đồ Cảnh Báo Thiên Tai 7 Ngày Gần Nhất
                        </h2>
                    </div>
                    <!-- Nút tạo -->
                    <!-- Container chứa nút và danh sách checkbox trên cùng một hàng -->
                    <div class="intro-y flex items-center flex-wrap gap-x-4 mt-4">
                        <!-- Nút tạo -->
                      
                        <button class="mb-2" data-tw-toggle="modal" data-tw-target="#large-modal-size-preview"
                            as="a" variant="primary">
                            {!! $icons['plus'] !!}
                            @auth Tạo Mới Cảnh Báo Thiên Tai @endauth
                            @guest Đăng ký nhận thông tin thiên tai mới @endguest
                        </button>
                       
                       
                        <!-- Danh sách Checkbox -->
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
                    <!-- Bản đồ -->
                    <div class="intro-y box mt-4 p-5 flex flex-col items-center justify-center space-y-4">
                        <!-- Bản đồ -->
                        <div id="map" class="w-full h-[500px] md:h-[700px] rounded-lg border shadow-lg"></div>
                    </div>
                </div>
                <!-- END: Map Cảnh Báo Thiên Tai -->
                <!-- BEGIN: Map Windy Ca Mau -->
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
                <!-- END: Map Windy Ca Mau -->

            </div>
        </div>
        <!-- BEGIN: Large Modal Content -->
        <!-- Modal chứa Form -->
        <x-base.dialog id="large-modal-size-preview" size="xl">
            <x-base.dialog.panel class="p-5">
                
                @auth
                <form enctype="multipart/form-data" class="validate-form" action="/create-disaster" method="post">
                    @csrf
                    <!-- BEGIN: Tạo Tỉnh Thành -->
                    <div class="intro-y box">
                        <div class="rounded-md border border-slate-200/60 p-5">
                            <div
                                class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                                {!! $icons['chevron-down'] !!} 
                                Thông Tin Cảnh Báo Thiên Tai
                            </div>
                            <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Cột 1 -->
                                <div>
                                    {{-- Loại thiên tai --}}
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
                                            <select class="w-full" id="crud-form-2"
                                                name="type_of_calamity_id">
                                                <option>
                                                    --Chọn thiên tai--</option>
                                                @foreach ($typeOfCalamities as $key => $value)
                                                    <option value="{{ $value->id }}">
                                                        {{ $value->name }}</option>
                                                @endforeach
                                            <select>
                                            @error('type_of_calamity_id')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Tác nhân --}}
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
                                    {{-- Cấp độ --}}
                                    <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                        formInline>
                                        <label class="md:w-80">
                                            <div class="text-left">
                                                <div class="flex items-center">
                                                    <div class="font-medium">Cấp Độ</div>
                                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                                </div>
                                            </div>
                                        </label>
                                        <div class="w-full">
                                            <select class="w-full" id="risk-level-select"
                                                name="risk_level_id">
                                                <option value="">Cấp độ thiên tai</option>
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
                                                    <div class="font-medium">Bản đồ</div>
                                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>

                                                </div>
                                            </div>
                                        </label>
                                        <div class="w-full">
                                            <input type="text" id="coordinates" name="coordinates"
                                                placeholder="Nhập tọa độ (VD: 10.7769, 106.7009)"
                                                onblur="updateMapFromInput()" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Cột 2 -->
                                <div>
                                    {{-- Tên --}}
                                    <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                        formInline>
                                        <label class="md:w-80">
                                            <div class="text-left">
                                                <div class="flex items-center">
                                                    <div class="font-medium">Tên</div>
                                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                                </div>
                                            </div>
                                        </label>
                                        <div class="w-full">
                                            <input name="name" id="name" type="text"
                                                placeholder="Tên" />
                                            @error('name')
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
                                                    <div class="font-medium">Xã</div>
                                                    <div class="ml-2 text-red-500 text-xl font-bold">*</div>

                                                </div>
                                            </div>
                                        </label>
                                        <div class="w-full">
                                            <select class="w-full" id="crud-form-2" name="commune_id">
                                                <option value="">--Chọn Xã--</option>
                                                @foreach ($communes as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="map1" class="rounded-lg border shadow-lg"
                                style="width: 100%; height: 400px; margin-top: 30px;"></div>
                        </div>
                    </div>
                    <!-- END: Tạo Tỉnh Thành -->

                    <!-- Nút Lưu -->
                    <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                        Lưu
                        </button>
                    </div>
                </form>
                @endauth
                @guest
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
            @endguest
            </x-base.dialog.panel>
        </x-base.dialog>
        
        
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // load sub-type-of-calamity - risk-level follow type-of-calamity
        document.addEventListener("DOMContentLoaded", function() {
            const calamitySelect = document.getElementById("crud-form-2"); // type_of_calamity_id
            const riskLevelSelect = document.querySelector("#risk-level-select"); // risk_level_id
            const subTypeOfCalamitySelect = document.querySelector("#sub-type-of-calamity-select"); // sub_type_of_calamity_id
            
            calamitySelect.addEventListener("change", function() {
                const calamityId = calamitySelect.value;
             
                // Load cấp độ rủi ro
                const riskLevelUrl = `{{ route('get-risk-levels') }}${calamityId ? '?calamity_id=' + calamityId : ''}`;
                fetch(riskLevelUrl)
                    .then(res => res.json())
                    .then(data => {
                        riskLevelSelect.innerHTML = `<option value="">-- Chọn cấp độ --</option>`;
                        data.forEach(level => {
                            const option = document.createElement("option");
                            option.value = level.id;
                            option.textContent = level.name;
                            riskLevelSelect.appendChild(option);
                        });
                    })
                .catch(error => console.error("Lỗi khi tải cấp độ rủi ro:", error));

                // Load tác nhân (loại hình thiên tai phụ)
                const subTypeUrl = `{{ route('get-sub-type-of-calamities') }}${calamityId ? '?calamity_id=' + calamityId : ''}`;
                fetch(subTypeUrl)
                    .then(res => res.json())
                    .then(data => {
                        subTypeOfCalamitySelect.innerHTML = `<option value="">-- Chọn tác nhân --</option>`;
                        data.forEach(item => {
                            const option = document.createElement("option");
                            option.value = item.id;
                            option.textContent = item.name;
                            subTypeOfCalamitySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Lỗi khi tải loại hình thiên tai:", error));
                    });
                });

        // load màu cho biểu đồ tròn
        document.addEventListener("DOMContentLoaded", function() {
            var disasterData = @json($disasters);
            var labels = disasterData.map(item => item.type);
            var series = disasterData.map(item => item.count);
            // Màu sắc đồng nhất với danh sách
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
        let markers = {}; // Lưu marker theo loại thiên tai
        let kmlLayers = {}; // Lưu KML Layer theo loại thiên tai
        let map1, marker;

        function initializeApp() {
            initMap();
            addMarkersAndKML()
            setupCheckboxListeners()
        }

        function initMap() {
            // Khởi tạo bản đồ chính
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 9.176,
                    lng: 105.15
                },
                zoom: 10
            });
            addDistrictLabels();

            // Khởi tạo bản đồ nhập tọa độ
            map1 = new google.maps.Map(document.getElementById('map1'), {
                center: {
                    lat: 9.176,
                    lng: 105.15
                },
                zoom: 10
            });

            marker = new google.maps.Marker({
                position: {
                    lat: 9.176,
                    lng: 105.15
                },
                map: map1,
                draggable: true
            });

            // Khi kéo marker, cập nhật tọa độ trong ô input
            marker.addListener("dragend", function(event) {
                document.getElementById("coordinates").value =
                    event.latLng.lat().toFixed(6) + ", " + event.latLng.lng().toFixed(6);
            });

            // Click vào bản đồ để đặt marker mới
            map1.addListener("click", function(event) {
                let lat = event.latLng.lat().toFixed(6);
                let lng = event.latLng.lng().toFixed(6);

                document.getElementById("coordinates").value = lat + ", " + lng;
                marker.setPosition(event.latLng);
                getAddressFromCoordinates(lat, lng);
            });
            // Khi nhập tọa độ, cập nhật bản đồ
            document.getElementById("coordinates").addEventListener("input", updateMapFromInput);
        }

        // tự động điền địa chỉ khi click marker trên bản đồ.
        function getAddressFromCoordinates(lat, lng) {
            const geocoder = new google.maps.Geocoder();
            const latlng = {
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            };
            geocoder.geocode({
                location: latlng
            }, function(results, status) {
                if (status === "OK") {
                    if (results[0]) {
                        const address = results[0].formatted_address;
                        document.getElementById("address").value = address;
                    } else {
                        console.warn("Không tìm thấy địa chỉ");
                    }
                } else {
                    console.error("Lỗi geocoder: " + status);
                }
            });
        }

          // Cập nhật bản đồ khi rời khỏi ô nhập tọa độ hoặc nhấn Enter
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
                    map1.setCenter(newLocation);
                    map1.setZoom(15);
                    marker.setPosition(newLocation);
                    getAddressFromCoordinates(lat, lng);
                } else {
                    showToast("⚠️ Tọa độ không hợp lệ! Vui lòng nhập lại.");
                }
            } else {
                showToast("⚠️ Định dạng tọa độ không đúng! Vui lòng nhập theo dạng: lat, lng");
            }
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

        // slug
        function removeVietnameseTones(str) {
            return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Loại bỏ dấu
                .replace(/đ/g, "d").replace(/Đ/g, "D") // Chuyển đ -> d
                .replace(/\s+/g, '-').toLowerCase(); // Thay khoảng trắng bằng dấu '-'
        }

        // hiển thị marker sạt lở - kml ngập lụt & bão
        function addMarkersAndKML() {
            markers = {}; // Reset markers
            let sharedInfoWindow = new google.maps.InfoWindow();
            calamitiesData.forEach(disaster => {
                disaster.data.forEach(item => {
                    console.log("📍 Marker:", item.name, item.coordinates);
                });

                let type = disaster.type;
                let slug = removeVietnameseTones(type); // Ví dụ: "sat-lo", "ngap-lut", "bao"
                markers[slug] = [];
                // Chọn icon theo loại thiên tai
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
                        iconUrl = "https://maps.google.com/mapfiles/kml/shapes/info-i_maps.png"; // icon mặc định
                }
                // Vẽ marker
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

        // bật tắt option sạt lở - ngập lụt - bão
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

        // Hiển thị thông báo lỗi
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
