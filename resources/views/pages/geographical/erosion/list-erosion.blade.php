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
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <table class="-mt-2 border-separate border-spacing-y-[10px]">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 pl-4 py-4 min-w-[40px]">#</th>
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
                        <td class="sticky left-0 z-1 bg-white pl-4 py-4 min-w-[40px]">{{ $data->firstItem() + $key }}</td>
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
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->map }}</td>
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
