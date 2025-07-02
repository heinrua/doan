@extends('themes.base')

@section('subhead')
    <title>Danh Sách Mốc Quan Trắc - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-rain'] !!}
        Danh Sách Mốc Quan Trắc
    </h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            @auth
            <a href="{{ route('create-monitoring') }}">
                <button class="mr-2 shadow-md" variant="primary">
                    {!! $icons['plus-circle'] !!}
                    Tạo Mới Mốc Quan Trắc
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
        <!-- BEGIN: Data List -->
        <!-- BEGIN: Data List -->
         <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <form action="{{ route('destroy-multiple-user') }}" method="POST">
            @csrf
            @method('DELETE')
            @auth
            <button type="submit" class="bg-red-700" id="delete-multiple-btn" disabled>
                {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
            </button>
            @endauth
            <table class="mt-2 border-separate border-spacing-y-[10px] table-fixed">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 whitespace-nowrap px-4 py-4 ">Vị trí mốc quan trắc</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Xã</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Huyện</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Năm khảo sát</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Thuộc sông</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Thời gian cập nhật</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Cao trình Z</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Toạ độ (X,Y)</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Đặc điểm nhận dạng</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Bản đồ</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hình ảnh</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Video</th>
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
                        <td class="sticky left-0 z-1 bg-white  w-[40px]" >
                            <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}">

                        </td>
                        <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                            <a class="whitespace-nowrap font-medium" 
                             href="/geographical/edit-monitoring/{{ $value->id }}">
                                {{ $value->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->communes->name ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->communes->district->name ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->survey_year ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->river ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ \Carbon\Carbon::parse($value->last_updated)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ number_format($value->elevation_z) ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->coordinates ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->description ?? '' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
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
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">@if (!empty($value->video))
                                <div class="relative w-24 h-16 cursor-pointer"
                                    onclick="openVideoModal('{{ asset( $value->video) }}')">
                                    <video class="w-full h-full object-cover rounded-md shadow-md pointer-events-none">
                                        <source src="{{ asset( $value->video) }}" type="video/mp4">
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
                                    href="/geographical/edit-monitoring/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                <a class="flex items-center text-red-700" 
                                    onclick="openDeleteModal('{{ route('delete-monitoring', ['id' => $value->id, 'type' => 'monitoring']) }}')"
                                    href="javascript:void(0);">
                                    {!! $icons['trash-2'] !!}> Xoá
                                </a>
                            </div>
                        </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        {{ $data->links() }}
    </div>
    <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <div class="fixed inset-0 z-50 hidden" id="delete-confirmation-modal" aria-modal="true">
        <!-- Nền mờ -->
        <div class="fixed inset-0 bg-black/50"></div>

        <!-- Khung modal chính giữa màn hình -->
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
    <!-- END: Delete Confirmation Modal -->
    <!-- Modal Video -->
    <div id="videoModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 hidden z-50">
        <div class="relative w-[80%] max-w-4xl">
            <video id="videoPlayer" class="w-full rounded-lg shadow-lg" controls>
                <source id="videoSource" src="" type="video/mp4">
            </video>
        </div>
    </div>
    <!-- Modal Hình -->
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
@endsection

<script>
      function openDeleteModal(url) {
        const modal = document.getElementById('delete-confirmation-modal');
        modal.classList.remove('hidden');
        setDeleteUrl(url);
    }

    function closeDeleteModal() {
        document.getElementById('delete-confirmation-modal').classList.add('hidden');
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('confirm-delete').addEventListener('click', closeDeleteModal);
    });
    function setDeleteUrl(url) {
        document.getElementById('confirm-delete').setAttribute('href', url);
    }

    function openVideoModal(videoUrl) {
        document.getElementById('videoSource').src = videoUrl;
        document.getElementById('videoPlayer').load();
        document.getElementById('videoModal').classList.remove('hidden');
    }
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const countSpan = document.getElementById('selected-count');
        const deleteBtn = document.getElementById('delete-multiple-btn');

        function updateCount() {
            const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
            countSpan.textContent = selectedCount;
            deleteBtn.disabled = selectedCount === 0;
        }

        // Khi checkbox "Chọn tất cả" được click
        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateCount();
        });

        // Khi checkbox từng dòng được click
        checkboxes.forEach(cb => cb.addEventListener('change', updateCount));

        // Khởi tạo giá trị ban đầu (trường hợp reload giữ lại checkbox đã chọn)
        updateCount();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const videoModal = document.getElementById("videoModal");
        const videoPlayer = document.getElementById("videoPlayer");

       // Đóng modal khi bấm ra ngoài vùng video
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
        document.getElementById('imagePreview').src = ''; // clear ảnh
    }
</script>
