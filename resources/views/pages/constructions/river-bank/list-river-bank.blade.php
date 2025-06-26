@extends('themes.base')

@section('subhead')
    <title>Danh Sách Công Trình Sạt Lở Bờ Sông & Bờ Biển - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['cloud-rain'] !!}
            Danh Sách Công Trình Sạt Lở Bờ Sông & Bờ Biển
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-construction-river-bank') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-construction-river-bank') }}" method="GET"
                class="flex flex-wrap items-center gap-3 grow">
                <!-- Dropdown chọn loại -->
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
                {{-- Chọn cấp độ thiên tai --}}
                <select id="riskLevelSelect" name="risk_level_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">Cấp độ</option>
                    @foreach ($riskLevels as $riskLevel)
                        <option value="{{ $riskLevel->id }}" data-fulltext="{{ $riskLevel->name }}"
                            {{ request('risk_level_id') == $riskLevel->id ? 'selected' : '' }}>
                            {{ request('risk_level_id') == $riskLevel->id ? Str::limit($riskLevel->name, 20, '...') : $riskLevel->name }}
                        </option>
                    @endforeach
                </select>
                <!-- Ô tìm kiếm -->
                <div class="relative w-56">
                    <input type="text" name="search" placeholder="Tìm kiếm..."
                        class="h-10 w-full border-gray-300 rounded-md px-4 pl-10 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ request('search') }}">
                    {!! $icons['search'] !!}
                </div>
                <!-- Nút tìm kiếm -->
                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            @if ($userCurrent->is_master || $userCurrent->hasPermission('create-construction-river-bank'))
                <a href="{{ route('create-construction-river-bank') }}">
                    <button class="h-10 shadow-md" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Tạo mới công trình
                    </button>
                </a>
            @endif
        </div>
        <!-- BEGIN: Total Records -->
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng công trình sạt lở: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <!-- END: Total Records -->
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
                        class="whitespace-nowrap  text-center bg-white sticky left-12 z-10 uppercase">
                        Tên công trình
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Loại công trình
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Cấp độ rủi ro thiên tai
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Phường/Xã
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Quận/Huyện
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Tiến độ thực hiện
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Năm xây dựng
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Năm hoàn thành
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Chiều dài (km)
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Chiều rộng (m)
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Quy mô
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Mức độ ảnh hưởng
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Toạ độ
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Tổng mức đầu tư
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Nguồn vốn
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Hình ảnh
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Video
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
                        Thời gian cập nhật
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white sticky text-center uppercase">
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
                            <a class="whitespace-nowrap font-medium"
                                href="/construction/edit-river-bank/{{ $value->id }}">
                                {{ $value->name }}
                            </a>
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->type_of_constructions->name ?? '' }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->risk_level->name ?? '' }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->communes[0]->name ?? '' }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->communes[0]->district->name ?? '' }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->progress }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->year_of_construction }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->year_of_completion }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->length }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->width }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->scale }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->influence_level }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->coordinates }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->total_investment }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-left shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->capital_source }}
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            @if (!empty($value->image))
                                <x-base.image-zoom class="w-full rounded-md" src="{{ asset($value->image) }}" />
                            @else
                                <span class="text-gray-500 italic">Chưa có hình ảnh</span>
                            @endif
                        </td>
                        <td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
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
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r">
                            {{ $value->updated_at ?? '' }}
                        </td>
                        <td @class([
                            'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r',
                            'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                        ])>
                            <div class="flex items-center justify-center">
                                <a class="mr-3 flex items-center text-blue-700"
                                    href="/construction/edit-river-bank/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                @if ($userCurrent->is_master || $userCurrent->hasPermission('delete-construction-river-bank'))
                                    <a class="flex items-center text-red-700" data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal"
                                        onclick="setDeleteUrl('{{ route('delete-construction-river-bank', ['id' => $value->id]) }}')"
                                        href="javascript:void(0);">
                                        {!! $icons['trash-2'] !!}> Xoá
                                    </a>
                                @endif
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
    document.addEventListener("DOMContentLoaded", function() {
        let districtSelect = document.querySelector("#districtSelect");
        let communeSelect = document.querySelector("#communeSelect");
        if (districtSelect && communeSelect) {
            let districtTS = districtSelect.tomselect;
            let communeTS = communeSelect.tomselect;
            //  Hàm lấy giá trị từ URL
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }
            // Lấy giá trị từ URL
            let selectedDistrictId = getQueryParam("district_id") || "";
            let selectedCommuneId = getQueryParam("commune_id") || "";
            //  Hàm tải danh sách xã
            function loadCommunes(districtId = "", selectedCommune = "") {
                communeTS.clear();
                communeTS.clearOptions();

                let url = `{{ route('get-communes') }}`;
                if (districtId) {
                    url += `?district_id=${districtId}`;
                }
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        communeTS.clearOptions();
                        data.forEach(commune => {
                            communeTS.addOption({
                                value: commune.id,
                                text: commune.name
                            });
                        })
                        // Nếu có xã đã chọn từ URL, đặt lại giá trị
                        if (selectedCommune && data.some(c => c.id == selectedCommune)) {
                            communeTS.setValue(selectedCommune);
                        }
                    })
                    .catch(() => {
                        communeTS.clearOptions();
                        communeTS.addOption({
                            value: "",
                            text: "Lỗi tải dữ liệu"
                        });
                    });
            }
            //  Khi tải trang, luôn luôn load danh sách xã
            loadCommunes(selectedDistrictId, selectedCommuneId);
            //  Khi chọn huyện, load lại danh sách xã
            districtTS.on("change", function() {
                let districtId = this.getValue();
                loadCommunes(districtId);
            });
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        let select = document.getElementById("riskLevelSelect");
        let selectedOption = select.options[select.selectedIndex]; // Lấy option đã chọn sau reload
        let maxLength = 15; // Giới hạn ký tự
        function updateDisplayText(option) {
            let fullText = option.getAttribute("data-fulltext") || option.textContent;
            let displayText = fullText.length > maxLength ? fullText.substring(0, maxLength) + "..." : fullText;
            select.nextElementSibling.querySelector(".ts-control").textContent = displayText;
        }
        if (selectedOption && selectedOption.value !== "") {
            updateDisplayText(selectedOption);
        }
        select.addEventListener("change", function() {
            updateDisplayText(this.options[this.selectedIndex]);
        });
    });
</script>
