@extends('themes.base')

@section('subhead')
    <title>Danh Sách Công Trình Ngập Lụt - PCTT Cà Mau Dashboard</title>
@endsection
@vite(['resources/js/district-commune.js'])
@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['arlett-triangle'] !!}
            Danh Sách Công Trình Ngập Lụt
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-construction-flooding') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <x-alert/>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-construction-flooding') }}" method="GET"
                class="flex flex-wrap items-center gap-3 grow">
                
                <select id="districtSelect" name="district_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">--Chọn huyện--</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                <select id="communeSelect" name="commune_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">--Chọn xã--</option>
                </select>
                
                <select name="type_of_construction"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">Công trình</option>
                    @foreach ($typeOfConstructions as $typeOfConstruction)
                        <option value="{{ $typeOfConstruction->id }}"
                            {{ request('type_of_construction') == $typeOfConstruction->id ? 'selected' : '' }}>
                            {{ $typeOfConstruction->name }}
                        </option>
                    @endforeach
                </select>
                
                 <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="name" placeholder="Tìm kiếm..." value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            @auth
                <a href="{{ route('create-construction-flooding') }}">
                    <button class="h-10 shadow-md" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Tạo mới công trình
                    </button>
                </a>
                <a href="{{ route('export-flooding-construction') }}">
                    <button class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    {!! $icons['download'] !!}Tải dữ liệu
                    </button>
                </a> 
                <button type="button" onclick="openUploadModal('{{ route('import-flooding-construction') }}')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                    {!! $icons['cloud-upload'] !!} Nhập file
                </button>
                <a href="{{ asset('downloads/mau-du-lieu-cong-trinh-ngap-lut.xlsx') }}" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" download>
                    Tải file mẫu
                </a>
            @endauth
        </div>
        
        <div class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng công trình ngập lụt: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        

        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            @auth
            <form action="{{ route('delete-multiple-construction-flooding') }}" method="POST" id="delete-multiple-form">
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
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">
                        Tên công trình</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Loại công trình</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Cấp độ</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Vị trí công trình</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Xã</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Huyện</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Năm xây dựng</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Năm hoàn thành</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Thời gian cập nhật</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Toạ độ</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Quy mô</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Đặc điểm nhận dạng</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Bề rộng 1 cửa (m)</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Cao trình đáy (m)</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Cao trình đỉnh trụ pin (m)</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Ghi chú</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hình thức vận hành</th>
                        
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hệ thống thuỷ lợi</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Vùng thuỷ lợi</th>
                        
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Loại cống</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Mã cống</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Đơn vị quản lý</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hình ảnh</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Video</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Thời gian cập nhật</th>
                        @auth
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">HÀNH ĐỘNG</th>
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
                            </div></td>
                    </tr>
                @else
                @foreach ($data as $key => $value)
                    <tr class="bg-white ">
                        <td class="sticky left-0 z-1 bg-white w-[40px] min-w-[40px] max-w-[40px]  text-center">
                            <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}"></td>
                        <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                            <a class="whitespace-nowrap font-medium"
                                href="/construction/edit-flooding/{{ $value->id }}">
                                {{ $value->name }}
                            </a></td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->type_of_constructions->name ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->risk_level->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->commune->name ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->commune->district->name ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->year_of_construction }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->year_of_completion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->update_time }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->coordinates }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->scale }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->characteristic }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->width_of_door ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->base_level ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->pillar_top_level ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->notes ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->operation_method ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->irrigation_system ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->irrigation_area ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->culver_type ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->culver_code ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->management_unit ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
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
                            @endif</td>
                                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">@if (!empty($value->video))
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
                            @endif</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->updated_at ?? '' }}</td>
                            @auth
                                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px]"><div class="flex items-center text-center">
                                <a class=" flex items-center text-blue-700"
                                    href="/construction/edit-flooding/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                <a class="flex items-center text-red-600"
                                onclick="openDeleteModal('{{ route('delete-construction-flooding', ['id' => $value->id]) }}')"
                                href="javascript:void(0);">
                                    {!! $icons['trash-2'] !!} Xoá
                                </a>  
                            </div></td>
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
