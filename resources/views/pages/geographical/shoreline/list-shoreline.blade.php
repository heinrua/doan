@extends('themes.base')

@section('subhead')
    <title>Danh Sách Lịch Sử Bờ Đường - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['cloud-rain'] !!}
        Danh Sách Lịch Sử Bờ Đường
    </h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route('create-shoreline') }}">
                <button class="mr-2 shadow-md" variant="primary">
                    {!! $icons['plus-circle'] !!}
                    Tạo Mới Lịch Sử Bờ Đường
                </button>
            </a>
            <div class="mt-3 w-full sm:ml-auto sm:mt-0 sm:w-auto md:ml-0">
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input class="!box w-56 pr-10" type="text" placeholder="Tìm kiếm..." />
                   {!! $icons['search'] !!}
                </div>
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
            <table.thead>
                <table.tr>
                    <table.th class="whitespace-nowrap  bg-white dark:bg-darkmode-700 sticky left-0 z-10">
                        #
                    </table.th>
                    <table.th
                        class="whitespace-nowrap  text-center bg-white dark:bg-darkmode-700 sticky left-12 z-10">
                        Tên đoạn đường bờ
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Xã
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Huyện
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Chiều dài (km)
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Chiều rộng (m)
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Toạ độ bắt đầu
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Toạ độ kết thúc
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Thông tin mô tả
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Bản đồ
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Hình ảnh
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        Video
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center">
                        HÀNH ĐỘNG
                    </table.th>
                </table.tr>
            </table.thead>
            <table.tbody>
                @foreach ($data as $key => $value)
                    <table.tr class="intro-x">
                        <table.td
                            class="box sticky rounded-l-none rounded-r-none border-x-0 left-0 z-10 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $data->firstItem() + $key }}
                        </table.td>
                        <table.td
                            class="box sticky rounded-l-none rounded-r-none border-x-0 left-12 z-10 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600 ">
                            <a class="whitespace-nowrap font-medium">
                                {{ $value->name }}
                            </a>
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->communes->name ?? '' }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->communes->district->name ?? '' }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->length ?? '' }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->width }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->start_coordinates }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->end_coordinates }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->description }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->map }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            @if (!empty($value->image))
                                <x-base.image-zoom class="w-full rounded-md"
                                    src="{{ asset( $value->image) }}" />
                            @else
                                <span class="text-gray-500 italic">Chưa có hình ảnh</span>
                            @endif
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
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
                        </table.td>
                        <table.td @class([
                            'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                            'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                        ])>
                            <div class="flex items-center justify-center">
                                <a class="mr-3 flex items-center text-blue-700"
                                    href="/geographical/edit-shoreline/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                <a class="flex items-center text-danger" data-tw-toggle="modal"
                                    data-tw-target="#delete-confirmation-modal"
                                    onclick="setDeleteUrl('{{ route('delete-shoreline', ['id' => $value->id, 'type' => 'shoreline']) }}')"
                                    href="javascript:void(0);">
                                    {!! $icons['trash-2'] !!}> Xoá
                                </a>
                            </div>
                        </table.td>
                    </table.tr>
                @endforeach
            </table.tbody>
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
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                {!! $icons['x-circle'] !!}
                <div class="mt-5 text-3xl">Bạn Có Chắc Chắn?</div>
                <div class="mt-2 text-slate-500">
                    Bạn thật sự muốn xoá dữ liệu này? <br />
                    Quá trình sẽ không được hoàn lại.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                    Huỷ Bỏ
                </button>
                <a id="confirm-delete" href="#">
                    <button class="w-24" type="button" variant="danger">
                        Xoá
                    </button>
                </a>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
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
