@extends('themes.base')

@section('subhead')
    <title>Danh Sách Khu Vực Xói, Bồi - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['cloud-rain'] !!}
            Danh Sách Khu Vực Xói, Bồi
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-erosion') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <x-alert/>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            @auth
            <a href="{{ route('create-erosion') }}">
                <button class="mr-2 shadow-md" variant="primary">
                    {!! $icons['plus-circle'] !!}
                    Tạo Mới Khu Vực Xói, Bồi
                </button>
            </a>
            @endauth
             <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    {!! $icons['search'] !!}
                </div>
                <input type="text" name="name" placeholder="Tìm kiếm..." value="{{ request('name') }}"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" />
            </div>
        </div>
       
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            
            <form action="{{ route('delete-multiple-erosion') }}" method="POST" id="delete-multiple-form">
                @csrf
                @method('DELETE')
                <input type="hidden" name="type" value="erosion">

                @auth
                <button type="button" onclick="openDeleteMultipleModal()" class="bg-red-700 z-1 sticky left-0" id="delete-multiple-btn" disabled>
                    {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
                </button>
                @endauth
          
            
        
            <table class="mt-2 border-separate border-spacing-y-[10px] ">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                    <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                    <th class="sticky left-[40px] z-1 bg-blue-100 whitespace-nowrap px-4 py-4 ">
                    Tên khu vực xói bồi</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Phân loại xói bồi</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Xã</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Huyện</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Tiến độ thực hiện</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Năm bắt đầu</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Năm hoàn thành</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Diện tích (ha)</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Quy mô ảnh hưởng</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Mức độ ảnh hưởng</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Toạ độ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Tổng mức đầu tư</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Nguồn vốn</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Bản đồ</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hình ảnh</th>
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Video</th>
                    @auth
                    <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">HÀNH ĐỘNG</th> @endauth
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
                            <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}">
                        </td>
                        <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                            <a class="whitespace-nowrap font-medium"
                             href="/geographical/edit-erosion/{{ $value->id }}">
                                {{ $value->name }}
                            </a></td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->category ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->communes->name ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->communes->district->name ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->progress }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->start_year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->end_year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->area }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->scale }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->impact_level }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->coordinates }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->total_investment }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->funding_source }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">@php
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
                                @endif</td>
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
                            @endif

                        </td>

                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
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
                        @auth
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            <div class="flex gap-3 text-center">
                                <a class="flex items-center text-blue-700"
                                    href="/geographical/edit-erosion/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                <a class="flex items-center text-red-700" 
                                    onclick="openDeleteModal('{{ route('delete-erosion', ['id' => $value->id, 'type' => 'erosion']) }}')"
                                    href="javascript:void(0);">
                                    {!! $icons['trash-2'] !!} Xoá
                                </a>
                            </div>
                        </td>
                        @endauth
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

    <x-delete-modal/>
    <x-delete-multiple-modal/>
    @vite(['resources/js/confirm-delete.js','resources/js/district-commune.js'])
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
