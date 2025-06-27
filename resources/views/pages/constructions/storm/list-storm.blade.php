@extends('themes.base')

@section('subhead')
    <title>Danh Sách Công Trình Bão & ATNĐ - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['cloud-lightning'] !!}
            Danh Sách Công Trình Bão & ATNĐ
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-construction-storm') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-construction-storm') }}" method="GET"
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
                 <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="name" placeholder="Tìm kiếm..." value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <!-- Nút tìm kiếm -->
                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            @auth
                <a href="{{ route('create-construction-storm') }}">
                    <button class="h-10 shadow-md" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Tạo mới công trình
                    </button>
                </a>
            @endauth
        </div>
        <!-- BEGIN: Total Records -->
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng công trình bão: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <!-- END: Total Records -->
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <table class="-mt-2 border-separate border-spacing-y-[10px]">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 pl-4 py-4 min-w-[40px]">#</th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 "> Mã công trình </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Tên công trình </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Loại công trình </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Cấp độ rủi ro thiên tai </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Địa điểm </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Khu vực </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Kích thước </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Trình trạng </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Ngày xây dựng </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Ngày hoàn thành </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Nguồn vốn </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Chi phí </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Tình trạng hoạt động </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Nhà thầu </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Mức độ hiệu quả </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Thời gian cập nhật </th>
                        @auth
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">HÀNH ĐỘNG </th>
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
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach ($data as $key => $value)
                    <tr class="bg-white ">
                        <td class="sticky left-0 z-1 bg-white pl-4 py-4 min-w-[40px]">{{ $data->firstItem() + $key }}</td>
                        <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold ">
                        <a class="whitespace-nowrap font-medium" href="/construction/edit-storm/{{ $value->id }}">
                                {{ $value->construction_code }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->type_of_constructions->name ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->risk_level->name ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->address }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->communes[0]->name ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->size }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ \Carbon\Carbon::parse($value->construction_date)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ \Carbon\Carbon::parse($value->completion_date)->format('d-m-Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->capital_source }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->total_investment }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->operating_status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->contractor }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->efficiency_level }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->updated_at ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            <div class="flex items-center justify-center">
                                <a class="mr-3 flex items-center text-blue-700"
                                    href="/construction/edit-storm/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                <a class="flex items-center text-red-600"
                                onclick="openDeleteModal('{{ route('delete-construction-storm', ['id' => $value->id]) }}')"
                                href="javascript:void(0);">
                                    {!! $icons['trash-2'] !!} Xoá
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
                     <a href="#" id="confirm-delete"
                    class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                        Xoá
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
@endsection
@vite(['resources/js/district-commune.js'])
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
