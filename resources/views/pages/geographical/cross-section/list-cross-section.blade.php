@extends('themes.base')

@section('subhead')
    <title>Danh Sách Mặt Cắt Ngang - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
<div class="intro-y mt-5  flex items-center justify-between">
    <div class="flex items-center text-lg font-medium uppercase">
        {!! $icons['cloud-rain'] !!}
        Danh Sách Mặt Cắt Ngang
    </div>
    <a class="flex items-center text-primary" href="{{ route('view-cross-section') }}">
        {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
    </a>
</div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('create-cross-section') }}">
                <button class="mr-2 shadow-md" variant="primary">
                    {!! $icons['plus-circle'] !!}
                    Tạo Mới Mặt Cắt Ngang
                </button>
            </a>
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
            @if ($data->isEmpty())
                <div class="text-center py-8">
                    {!! $icons['frown'] !!}
                    <div class="mt-3 text-xl text-slate-500">Hiện tại không có dữ liệu</div>
                </div>
        </div>
    @else
        <table class="-mt-2 border-separate border-spacing-y-[10px]">
            <thead>
                <tr>
                    <table.th class="whitespace-nowrap  bg-white sticky left-0 z-10">
                        #
                    </table.th>
                    <table.th
                        class="whitespace-nowrap  text-center bg-white sticky left-12 z-10">
                        Vị trí mặt cắt ngang
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Xã
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Huyện
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Năm khảo sát
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Số hiệu
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Thời gian cập nhật
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Vị trí điểm đầu (X,Y)
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Vị trí điểm cuối (X,Y)
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Thông tin mô tả
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Bản đồ
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Hình ảnh
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        Video
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center">
                        HÀNH ĐỘNG
                    </table.th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                    <tr class="intro-x">
                        <td
                            class="box sticky rounded-l-none rounded-r-none border-x-0 left-0 z-10 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $data->firstItem() + $key }}
                        </td>
                        <td
                            class="box sticky rounded-l-none rounded-r-none border-x-0 left-12 z-10 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r ">
                            <a class="whitespace-nowrap font-medium" >
                                {{ $value->name }}
                            </a>
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->communes->name ?? '' }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->communes->district->name ?? '' }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->survey_year ?? '' }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->reference_number }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ \Carbon\Carbon::parse($value->last_updated)->format('d-m-Y') }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->start_coordinates }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->end_coordinates }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->description }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->map }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            @if (!empty($value->image))
                                <x-base.image-zoom class="w-full rounded-md"
                                    src="{{ asset( $value->image) }}" />
                            @else
                                <span class="text-gray-500 italic">Chưa có hình ảnh</span>
                            @endif
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            @if (!empty($value->video))
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
                        <td @class([
                            'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r',
                            'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                        ])>
                            <div class="flex items-center justify-center">
                                <a class="mr-3 flex items-center text-blue-700"
                                    href="/geographical/edit-cross-section/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                <a class="flex items-center text-red-700" data-tw-toggle="modal"
                                    data-tw-target="#delete-confirmation-modal"
                                    onclick="setDeleteUrl('{{ route('delete-cross-section', ['id' => $value->id, 'type' => 'cross-section']) }}')"
                                    href="javascript:void(0);">
                                    {!! $icons['trash-2'] !!}> Xoá
                                </a>
                            </div>
                        </td>
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
                    <a class="flex items-center text-red-600"
                    onclick="openDeleteModal('{{ route('delete-user', ['id' => $value->id]) }}')"
                    href="javascript:void(0);">
                        {!! $icons['trash-2'] !!} Xoá
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
</script>
