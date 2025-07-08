@extends('themes.base')

@section('subhead')
    <title>Danh Sách Loại Hình Thiên Tai - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-5 flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['chevron-right'] !!} Danh Sách Loại Hình Thiên Tai
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-type-of-calamity') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-type-of-calamity') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="name" placeholder="Tìm kiếm..." value="{{ request('name') }}"
                        class="block w-full p-4 ps-10 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>

            @auth
                <a href="{{ route('create-type-of-calamity') }}">
                    <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                        {!! $icons['plus-circle'] !!} Tạo Mới Loại Hình Thiên Tai
                    </button>
                </a>
            @endauth
        </div>

        <div class="intro-y col-span-3 text-base text-gray-800 bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số loại thiên tai: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
        <form action="{{ route('delete-multiple-type-of-calamity') }}" class=" col-span-2" method="POST">
            @csrf
            @method('DELETE')
            @auth
            <button type="submit" class="bg-red-700 z-1 sticky left-0" id="delete-multiple-btn" disabled>
                {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
            </button>
            @endauth
</form>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <table class="mt-2 border-separate border-spacing-y-[10px]">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">Tên loại thiên tai</th>
                        <th class="px-6 py-4  min-w-[200px]  max-w-[300px]">Mô tả</th>
                        @auth <th class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hành động</th> @endauth
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
                                <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                                    <a href="/edit-type-of-calamity/{{ $value->id }}">{{ $value->name }}</a>
                                </td>
                                <td class="px-6 py-4 min-w-[200px] max-w-[300px] ">{{ $value->description }}</td>
                                @auth
                                <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                                    <div class="flex gap-3 text-center">
                                        <a href="/edit-type-of-calamity/{{ $value->id }}" class="text-blue-700 flex items-center">
                                            {!! $icons['edit-2'] !!} Sửa
                                        </a>
                                        
                                        <a href="javascript:void(0);"
                                            onclick="openDeleteModal('{{ route('delete-type-of-calamity', ['id' => $value->id]) }}')"
                                            class="text-red-600 flex items-center">
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

        <div class="intro-y col-span-12">
            {{ $data->links() }}
        </div>
    </div>

    <div class="fixed inset-0 z-50 hidden" id="delete-confirmation-modal" aria-modal="true">
        <div class="fixed inset-0 bg-black/50"></div>
        <div class="flex min-h-screen items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md z-50 p-6">
                <div class="flex items-start space-x-3">
                    <div class="text-red-500">{!! $icons['warning-circle'] !!}</div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Xác nhận xoá</h3>
                        <p class="mt-1 text-sm text-gray-600">Bạn có chắc chắn muốn xoá dữ liệu này?</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button" onclick="closeDeleteModal()"
                            class="bg-white px-4 py-2 rounded border text-gray-700 hover:bg-gray-100">Hủy</button>
                    <a href="#" id="confirm-delete" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
                        Xoá
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function openDeleteModal(url) {
        document.getElementById('delete-confirmation-modal').classList.remove('hidden');
        setDeleteUrl(url);
    }

    function closeDeleteModal() {
        document.getElementById('delete-confirmation-modal').classList.add('hidden');
    }

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

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('confirm-delete').addEventListener('click', closeDeleteModal);
    });
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

        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateCount();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', updateCount));

        updateCount();
    });
</script>
