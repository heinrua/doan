@extends('themes.base')

@section('subhead')
    <title>Danh Sách Tỉnh Thành - PCTT Cà Mau Dashboard</title>
@endsection

@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['home'] !!}
            Danh Sách Tỉnh Thành
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-city') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <!-- Form tìm kiếm -->
            <form  action="{{ route('view-city') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                <!-- Ô tìm kiếm -->
                <div class="relative w-56">
                    <input type="text" name="name" placeholder="Tìm kiếm..."
                        class="h-10 w-full border-gray-300 rounded-md px-4 pl-10 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ request('name') }}">
                    {!! $icons['search'] !!}
                </div>
                <!-- Nút tìm kiếm -->
                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            @if ($userCurrent->is_master || $userCurrent->hasPermission('create-city'))
                
                <a href="{{ route('create-city') }}">
                    <button type="button" 
                        class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        {!! $icons['plus-circle'] !!}
                        Thêm Mới Tỉnh Thành
                    </button>
                </a>
            @endif
        </div>
        <!-- BEGIN: Total Records -->
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số tỉnh/thành: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <!-- END: Total Records -->
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
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
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky left-0 z-10">
                        #
                    </table.th>
                    <table.th
                        class="whitespace-normal text-center bg-white dark:bg-darkmode-700 sticky left-12 z-10 w-[250px] max-w-[350px] uppercase">
                        Tên Tỉnh Thành
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Mã
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        Toạ Độ
                    </table.th>
                    <table.th class="whitespace-nowrap bg-white dark:bg-darkmode-700 sticky text-center uppercase">
                        HÀNH ĐỘNG
                    </table.th>
                </table.tr>
            </table.thead>
            <table.tbody>
                @foreach ($data as $key => $value)
                    <table.tr class="intro-x">

                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $data->firstItem() + $key }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            <a class="whitespace-nowrap font-medium" href="/edit-city/{{ $value->id }}">
                                {{ $value->name }}
                            </a>
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->code }}
                        </table.td>
                        <table.td
                            class="box rounded-l-none rounded-r-none border-x-0 text-center shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600">
                            {{ $value->coordinates }}
                        </table.td>
                        <table.td @class([
                            'box w-56 rounded-l-none rounded-r-none border-x-0 shadow-[5px_3px_5px_#00000005] first:rounded-l-[0.6rem] first:border-l last:rounded-r-[0.6rem] last:border-r dark:bg-darkmode-600',
                            'before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 before:dark:bg-darkmode-400',
                        ])>
                            <div class="flex items-center justify-center">
                                <a class="mr-3 flex items-center text-blue-700" href="/edit-city/{{ $value->id }}">
                                    {!! $icons['edit-2'] !!}
                                    Sửa
                                </a>
                                @if ($userCurrent->is_master || $userCurrent->hasPermission('delete-city'))
                                    <a class="flex items-center text-danger" data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal"
                                        onclick="setDeleteUrl('{{ route('delete-city', ['id' => $value->id]) }}')"
                                        href="javascript:void(0);">
                                        {!! $icons['trash-2'] !!}> Xoá
                                    </a>
                                @endif
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
@endsection

<script>
    function setDeleteUrl(url) {
        document.getElementById('confirm-delete').setAttribute('href', url);
    }
</script>
