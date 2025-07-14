@extends('themes.base')

@section('subhead')
    <title>Danh Sách Thiên Tai Sạt Lở - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-5 flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['cloud-rain'] !!}
            Danh Sách Thiên Tai Sạt Lở
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-calamity-river-bank') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <x-alert/>
    <div class="mt-5 grid grid-cols-12 gap-6 ">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            
            <form action="{{ route('view-calamity-river-bank') }}" method="GET"
                class="flex flex-wrap items-center gap-3 grow">
                
                <select name="year_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">-- Chọn năm --</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year_id') == $year ? 'selected' : '' }}>
                            {{ $year }}</option>
                    @endforeach
                </select>
                <select id="districtSelect" name="district_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">-- Chọn huyện --</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                <select id="communeSelect" name="commune_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">-- Chọn xã --</option>
                </select>
                
                <select name="risk_level_id"
                    class="h-10 w-40 min-w-[150px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">Cấp độ thiên tai</option>
                    @foreach ($riskLevels as $riskLevel)
                        <option value="{{ $riskLevel->id }}"
                            {{ request('risk_level_id') == $riskLevel->id ? 'selected' : '' }}>
                            {{ $riskLevel->name }}
                        </option>
                    @endforeach
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
            
            @auth
                <a href="{{ route('create-calamity-river-bank') }}">
                    <button class="shadow-md h-10" variant="primary">
                        {!! $icons['plus-circle'] ?? '' !!}
                        Tạo Mới Sạt Lở
                    </button>
                </a>
                <button type="button" onclick="openUploadModal('{{ route('import-river-bank-calamity') }}')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                    {!! $icons['cloud-upload'] !!} Nhập file
                </button>
                <a href="{{ asset('downloads/mau-du-lieu-sat-lo.xlsx') }}" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" download>
                    Tải file mẫu
                </a>
                <a href="{{ route('export-river-bank-calamity') }}">
                    <button class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    {!! $icons['download'] !!}Tải dữ liệu
                    </button>
                </a>
            @endauth
        </div>
        
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng vị trí sạt lở: <span class="font-semibold">{{ $data->total() }}</span>
        </div>


        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            @auth
            <form action="{{ route('delete-multiple-calamity-river-bank') }}" method="POST" id="delete-multiple-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="openDeleteMultipleModal()" class="bg-red-700 z-1 sticky left-0" id="delete-multiple-btn" disabled>
                    {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
                </button>
            </form>
            @endauth
            <table class="mt-2 border-separate border-spacing-y-[10px] ">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                    <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                    <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4  min-w-[180px]">
                        Tên vị trí sạt lở</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Loại sạt lở</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Cấp độ rủi ro thiên tai</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Địa điểm</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Phường/Xã</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Quận/Huyện</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Chiều dài (m)</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Chiều rộng (m)</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Diện tích</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Toạ độ vị trí</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Thời gian</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Nguyên nhân</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Địa chất</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Đặc điểm thuỷ văn</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Thiệt hại về người</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Thiệt hại về tài sản</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Mức độ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Các biện pháp giảm thiểu</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Chính sách hỗ trợ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Bản đồ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Hình ảnh</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Video</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">Thời gian cập nhật</th>
                    @auth
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px] ">HÀNH ĐỘNG</th>
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
                            </div> </td>
                    </tr>
                    @else
                @foreach ($data as $key => $value)
                    <tr class="bg-white ">
                        <th class="sticky left-0 z-1 bg-white w-[40px] min-w-[40px] max-w-[40px]  text-center">
                            <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}">
                        </th>
                        <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                                    <a href="/calamity/edit-river-bank/{{ $value->id }}">{{ $value->name }}</a>
                                </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->sub_type_of_calamities[0]->name ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->risk_level->name ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->address ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->communes[0]->name ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->communes[0]->district->name ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->length ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->width ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->acreage ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->coordinates ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] "> {{ \Carbon\Carbon::parse($value->time)->format('d-m-Y') ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->reason ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->geology ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->watermark_points ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->human_damage ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->property_damage ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->investment_level ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->mitigation_measures ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->support_policy ?? '' }} </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            @php
                                $maps = json_decode($value->map, true);
                            @endphp
                            @if (!empty($maps) && is_array($maps))
                                <div class="overflow-y-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200"
                                    style="max-height: {{ count($maps) > 4 ? '150px' : 'auto' }};">
                                    <ul class="list-disc text-left pl-4">
                                        @foreach ($maps as $map)
                                            <li>
                                                <a href="{{ asset($map) }}" target="_blank"
                                                    class="text-blue-500 hover:underline">
                                                    {{ basename($map) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <span class="text-gray-500">Không có bản đồ</span>
                            @endif </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                           @if (!empty($value->image))
                            <div class="relative w-24 h-16 cursor-pointer"
                                onclick="openImageModal('{{ asset($value->image) }}')">
                                <img src="{{ asset($value->image) }}"
                                    class="w-full h-full object-cover rounded-md shadow-md pointer-events-none" />
                                <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-xs font-bold rounded-md">
                                    Xem Hình
                                </div>
                            </div>
                        @else
                            <span class="text-gray-500 italic">Chưa có hình ảnh</span>
                        @endif </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            @if (!empty($value->video))
                                <div class="relative w-24 h-16 cursor-pointer"
                                    onclick="openVideoModal('{{ asset($value->video) }}')">
                                    <video class="w-full h-full object-cover rounded-md shadow-md pointer-events-none">
                                        <source src="{{ asset($value->video) }}" type="video/mp4">
                                        Trình duyệt của bạn không hỗ trợ video.
                                    </video>
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-xs font-bold rounded-md">
                                        Xem Video
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-500 italic">Chưa có video</span>
                            @endif 
                        </td>
                        <td
                           class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            {{ $value->updated_at ?? '' }} </td>
                        @auth
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                            <div class="flex items-center justify-center">
                                <a class="mr-3 flex items-center text-blue-700"
                                    href="/calamity/edit-river-bank/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                
                                    <a class="flex items-center text-red-700" data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal"
                                        onclick="setDeleteUrl('{{ route('delete-calamity-river-bank', ['id' => $value->id]) }}')"
                                        href="javascript:void(0);">
                                        {!! $icons['trash-2'] !!}> Xoá
                                    </a>
                                
                            </div> </td>
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
                    >
                ×
            </button>
        </div>
    </div>

    <x-importExel/>
    <x-delete-modal/>
    <x-delete-multiple-modal/>
    @vite(['resources/js/confirm-delete.js','resources/js/district-commune.js','resources/js/import-exel.js'])
@endsection
<script>
    
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
