@extends('themes.base')

@section('subhead')
    <title>Danh Sách Xã Phường - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['home'] !!}
            Danh Sách Xã Phường
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-commune') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <x-alert/>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            
            <form action="{{ route('view-commune') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                <select name="district_id"
                    class="h-10 w-40 min-w-[100px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">-- Chọn huyện --</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
                
                <select name="type"
                    class="h-10 w-40 min-w-[150px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">Loại tìm kiếm</option>
                    <option value="name" {{ request('type') == 'name' ? 'selected' : '' }}>Tên</option>
                    <option value="code" {{ request('type') == 'code' ? 'selected' : '' }}>Mã</option>
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
                <a href="{{ route('create-commune') }}">
                    <button class="shadow-md h-10 flex items-center gap-2 bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-blue-800">
                        {!! $icons['plus-circle'] !!} Thêm Mới Xã Phường
                    </button>
                </a>
                <button type="button" onclick="openUploadModal('{{ route('import-communes') }}')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center gap-2 ml-2">
                    {!! $icons['cloud-upload'] !!} Nhập file
                </button>
                <a href="{{ asset('downloads/mau-du-lieu-xa.xlsx') }}" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" download>
                    Tải file mẫu
                </a>
            @endauth
        </div>
        
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số xã/phường: <span class="font-semibold">{{ $data->total() }}</span>
        </div>

       <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            @auth
            <form action="{{ route('delete-multiple-commune') }}" method="POST" id="delete-multiple-form">
                @csrf
                @method('DELETE')
                <button type="button" onclick="openDeleteMultipleModal()" class="bg-red-700 z-1 sticky left-0" id="delete-multiple-btn" disabled>
                {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
            </button>
            </form>
            @endauth
            <table class="mt-2 border-separate border-spacing-y-[10px] table-fixed">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">Xã/Phường</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Quận/Huyện</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Mã</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Toạ Độ</th>
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
                            </div>
                        </td>
                    </tr>
                @else
                @foreach ($data as $key => $value)
                    <tr class="bg-white ">
                        <td class="sticky left-0 z-1 bg-white  w-[40px]" >
                            <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}">

                        </td>
                        <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                        <a class="whitespace-nowrap font-medium" href="/edit-commune/{{ $value->id }}">
                            {{ $value->name }}
                        </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->district->name ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->code }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            {{ $value->coordinates }}
                        </td>
                        @auth
                        <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            <div class="flex gap-3 text-center">
                                <a class="flex items-center text-blue-700" href="/edit-commune/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                <a class="flex items-center text-red-600"
                                onclick="openDeleteModal('{{ route('delete-commune', ['id' => $value->id]) }}')"
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
    
    <x-importExel/>
    <x-delete-modal/>
    <x-delete-multiple-modal/>
    @vite(['resources/js/confirm-delete.js','resources/js/import-exel.js'])
@endsection


