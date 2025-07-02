@extends('themes.base')

@section('subhead')
    <title>Danh Sách Tỉnh Thành - PCTT Cà Mau Dashboard</title>
@endsection


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
                <a href="{{ route('create-city') }}">
                    <button type="button" 
                        class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                        {!! $icons['plus-circle'] !!}
                        Thêm Mới Tỉnh Thành
                    </button>
                </a>
            @endauth
        </div>
        <!-- BEGIN: Total Records -->
        <div
            class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800  bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số tỉnh/thành: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <!-- END: Total Records -->
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <form action="{{ route('delete-multiple-city') }}" method="POST">
            @csrf
            @method('DELETE')
            @auth
            <button type="submit" class="bg-red-700" id="delete-multiple-btn" disabled>
                {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
            </button>
            @endauth
            <table class="mt-2 border-separate border-spacing-y-[10px] table-fixed">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">Tên Tỉnh Thành</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            Mã
                        </th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            Toạ Độ
                        </th>
                        @auth
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                            HÀNH ĐỘNG
                        </th>
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
                                <a class="whitespace-nowrap font-medium" href="/edit-city/{{ $value->id }}">
                                    {{ $value->name }}
                                </a>
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
                                    <a class="flex items-center text-blue-700" href="/edit-city/{{ $value->id }}">
                                        {!! $icons['edit-2'] !!}
                                        Sửa
                                    </a>
                                    <a class="flex items-center text-red-600"
                                        onclick="openDeleteModal('{{ route('delete-city', ['id' => $value->id]) }}')"
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
    <!-- END: Delete Confirmation Modal -->
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
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const countSpan = document.getElementById('selected-count');
        const deleteBtn = document.getElementById('delete-multiple-btn');

        function updateCount() {
            const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
            countSpan.textContent = selectedCount;
            deleteBtn.disabled = selectedCount === 0;
        }

        // Khi checkbox "Chọn tất cả" được click
        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateCount();
        });

        // Khi checkbox từng dòng được click
        checkboxes.forEach(cb => cb.addEventListener('change', updateCount));

        // Khởi tạo giá trị ban đầu (trường hợp reload giữ lại checkbox đã chọn)
        updateCount();
    });
</script>
