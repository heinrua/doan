@extends('themes.base')

@section('subhead')
    <title>Danh Sách Công Trình Bão & ATNĐ - PCTT Cà Mau Dashboard</title>
@endsection

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
    <x-alert/>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-construction-storm') }}" method="GET"
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
                <a href="{{ route('create-construction-storm') }}">
                    <button class="h-10 shadow-md" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Tạo mới công trình
                    </button>
                </a>
                <a href="{{ route('export-storm-construction') }}">
                    <button class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    {!! $icons['download'] !!}Tải dữ liệu
                    </button>
                </a> 
                <button type="button" onclick="openUploadModal('{{ route('import-storm-construction') }}')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                    {!! $icons['cloud-upload'] !!} Nhập file
                </button>
                <a href="{{ asset('downloads/mau-du-lieu-cong-trinh-bao.xlsx') }}" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" download>
                    Tải file mẫu
                </a>
            @endauth
        </div>
        
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng công trình bão: <span class="font-semibold">{{ $data->total() }}</span>
        </div>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            @auth
            <form action="{{ route('delete-multiple-construction-storm') }}" method="POST" id="delete-multiple-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="openDeleteMultipleModal()" class="bg-red-700 z-1 sticky left-0" id="delete-multiple-btn" disabled>
                    {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
                </button>
            </form>
            @endauth
        </div>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <table class="mt-2 border-separate border-spacing-y-[10px] ">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">Mã công trình </th>
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
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Tọa độ</th>
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
                       <td class="sticky left-0 z-1 bg-white w-[40px] min-w-[40px] max-w-[40px]  text-center">
                            <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}">
                        </td>
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
                            {{ $value->commune->name ?? '' }}
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
                            {{ $value->coordinates }}
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

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        {{ $data->links() }}
    </div>
    
    </div>
    
    <x-importExel/>
    <x-delete-modal/>
    <x-delete-multiple-modal/>
    @vite(['resources/js/confirm-delete.js','resources/js/district-commune.js','resources/js/import-exel.js'])
@endsection
        
<script>
  
    document.addEventListener("DOMContentLoaded", function() {
        let select = document.getElementById("riskLevelSelect");
        let selectedOption = select.options[select.selectedIndex]; 
        let maxLength = 15; 
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
