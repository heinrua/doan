@extends('themes.base')

@section('subhead')
    <title>Danh Sách Người Dùng - PCTT Cà Mau Dashboard</title>
@endsection
@php
    $userCurrent = auth()->user();
@endphp
@section('subcontent')
    <div class="intro-y mt-5  flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['user'] !!}
            Danh Sách CÁN BỘ
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-user') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <!-- Form tìm kiếm -->
            <form action="{{ route('view-user') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="name" placeholder="Tên người dùng..." value="{{ request('name') }}"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" />
                </div>
               
                <!-- Nút tìm kiếm -->
                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>
            <a href="{{ route('create-user') }}">
                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2">
                    {!! $icons['plus-circle']!!} Thêm mới người dùng
                </button>
            </a>
            <form action="{{ route('import-users') }}" method="POST" enctype="multipart/form-data" formInline>
                @csrf

               <div class="flex items-center gap-2">
                <label for="fileImport"
                    class="flex items-center cursor-pointer bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                    {!! $icons['cloud-upload'] !!}
                    <input type="file" id="fileImport" name="fileImport" />
                </label>

                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                    Import
                </button>
            </div>
            </form>



            
        </div>
        <!-- BEGIN: Total Records -->
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số người dùng: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <!-- END: Total Records -->
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible w-full overflow-x-auto">
            <table class="w-full text-left rtl:text-right text-gray-500 ">
                <thead class="text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Tên người dùng</th>
                        <th scope="col" class="px-6 py-3">Tên đăng nhập</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-6">
                                <div class="flex flex-col items-center justify-center text-slate-500">
                                    {!! $icons['frown'] !!}
                                    <div class="mt-2 text-lg">Hiện tại không có dữ liệu</div>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach ($data as $key => $value)
                            <tr class="bg-white border-b border-gray-200">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $data->firstItem() + $key }}
                                </td>
                                <td class="px-6 py-4">
                                    <a class="whitespace-nowrap font-medium" href="/edit-user/{{ $value->id }}">
                                        {{ $value->full_name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">{{ $value->user_name }}</td>
                                 <td class="px-6 py-4">{{ $value->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <a class="mr-3 flex items-center text-blue-700" href="/edit-user/{{ $value->id }}">
                                            {!! $icons['edit-2'] !!} Sửa
                                        </a>
                                        <a class="flex items-center text-red-600"
                                        onclick="openDeleteModal('{{ route('delete-user', ['id' => $value->id]) }}')"
                                        href="javascript:void(0);">
                                            {!! $icons['trash-2'] !!} Xoá
                                        </a>
                                       
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>


    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        {{ $data->links() }}
    </div>
    <!-- END: Pagination -->
    </div>
    

   
@endsection
<!-- Modal xác nhận xoá -->
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
</script>
