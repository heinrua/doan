@extends('themes.base')

@section('subhead')
    <title>Danh Sách Quận Huyện - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['home'] !!}
            Danh Sách Quận Huyện
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-district') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <!-- Form tìm kiếm -->
            <form action="{{ route('view-district') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                <!-- Dropdown chọn loại -->
                <select name="type"
                    class="h-10 w-40 min-w-[150px] border-gray-500 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">Loại tìm kiếm</option>
                    <option value="name" {{ request('type') == 'name' ? 'selected' : '' }}>Tên</option>
                    <option value="code" {{ request('type') == 'code' ? 'selected' : '' }}>Mã</option>
                    <option value="coordinates" {{ request('type') == 'coordinates' ? 'selected' : '' }}>Toạ độ</option>
                </select>
                <!-- Ô tìm kiếm -->
                 <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="name" placeholder="Tìm kiếm..." value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <!-- Nút tìm kiếm -->
                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            @auth
                <!-- Nút tạo mới -->
                <a href="{{ route('create-district') }}">
                    <button class="shadow-md h-10" variant="primary">
                        {!! $icons['plus-circle'] !!}
                        Thêm Mới Quận Huyện
                    </button>
                </a>
            @endauth
        </div>
        <!-- BEGIN: Total Records -->
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số quận/huyện: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <!-- END: Total Records -->
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
           
            <table class="w-full min-w-[1200px] text-left text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="sticky left-0 z-20 bg-white px-4 py-2 border-r">#</th>
                        <th class="sticky left-[60px] z-20 bg-white px-4 py-2 border-r">Tên quận, huyện</th>
                        <th class="px-6 py-3">Mã</th>
                        <th class="px-6 py-3">Tỉnh/Thành</th>
                        <th class="px-6 py-3">Toạ độ</th>
                        <th class="px-6 py-3">Sức Chứa</th>
                        <th class="px-6 py-3">Lớp Bản Đồ</th>
                        @auth 
                        <th class="px-6 py-3">Hành động</th> 
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
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="sticky left-0 z-10 bg-white  px-10 py-2 border-r">
                            {{ $data->firstItem() + $key }}
                        </td>
                        <td class="sticky left-[60px] z-10 bg-white px-10 py-2 border-r">
                            <a class="whitespace-normal break-words font-medium block"
                                href="/edit-district/{{ $value->id }}">
                                {{ $value->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4">{{ $value->code }}</td>
                        <td class="px-6 py-4">
                            {{ $value->city->name ?? '' }}
                        </td>

                       <td class="px-6 py-4">
                            {{ $value->coordinates }}
                        </td>
                       <td class="px-6 py-4">
                            {{ number_format($value->population, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
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
                            @endif
                        </td>
                        @auth
                        <td class="px-6 py-4">
                                    <div class="flex gap-3 justify-center">
                                        <a href="/edit-district/{{ $value->id }}" class="text-blue-700 flex items-center">
                                            {!! $icons['edit-2'] !!} Sửa
                                        </a>
                                            <a href="javascript:void(0);" onclick="openDeleteModal('{{ route('delete-district', ['id' => $value->id]) }}')" class="text-red-600 flex items-center">
                                                {!! $icons['trash-2'] !!} Xoá
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
@endsection

<script>
    function setDeleteUrl(url) {
        document.getElementById('confirm-delete').setAttribute('href', url);
    }
</script>
