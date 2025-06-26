@extends('themes.base')

@section('subhead')
    <title>Danh Sách Cấp Độ Thiên Tai - PCTT Cà Mau Dashboard</title>
@endsection

@php
    $userCurrent = auth()->user();
@endphp

@section('subcontent')
    <div class="intro-y mt-5 flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['chevron-right'] !!}
            Danh Sách Cấp Độ Thiên Tai
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-risk-level') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-risk-level') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                <select name="type_of_calamity_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                    <option value="">-- Chọn loại thiên tai --</option>
                    @foreach ($typeOfCalamities as $type)
                        <option value="{{ $type->id }}" {{ request('type_of_calamity_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>

                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="name" placeholder="Tên cấp độ..." value="{{ request('name') }}"
                           class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                        class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>

            @if ($userCurrent->is_master || $userCurrent->hasPermission('create-risk-level'))
                <a href="{{ route('create-risk-level') }}">
                    <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center">
                        {!! $icons['plus-circle'] !!} Tạo mới cấp độ
                    </button>
                </a>
            @endif
        </div>

        <div class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800 bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số cấp độ thiên tai: <span class="font-semibold">{{ $data->total() }}</span>
        </div>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <table class="-mt-2 border-separate border-spacing-y-[10px]">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th scope="col" class="sticky left-0 z-1 bg-blue-100 pl-4 py-4 min-w-[40px]">#</th>
                        <th scope="col" class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">Tên cấp độ</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Thuộc loại</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Mô tả</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hành động</th>
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
                            <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                                <a class="whitespace-nowrap font-medium" href="/edit-risk-level/{{ $value->id }}">
                                    {{ $value->name }}
                                </a>
                               
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                {{ $value->type_of_calamities->name ?? '' }}
                            </td>
                            <td class="px-6 py-4  min-w-[160px]">
                                {{ $value->description }}
                            </td>
                            @auth
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                <div class="flex gap-3 justify-center">
                                    <a class="flex items-center text-blue-700" href="/edit-risk-level/{{ $value->id }}">
                                        {!! $icons['edit-2'] !!} Sửa
                                    </a>
                                    <a class="flex items-center text-red-600"
                                    onclick="openDeleteModal('{{ route('delete-risk-level', ['id' => $value->id]) }}')"
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
        </div>

        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            {{ $data->links() }}
        </div>
    </div>

    <!-- Modal xác nhận xoá -->
    <div class="fixed inset-0 z-50 hidden" id="delete-confirmation-modal" aria-modal="true">
        <div class="fixed inset-0 bg-black/50"></div>
        <div class="flex min-h-screen items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md z-50 p-6">
                <div class="flex items-start space-x-3">
                    <div class="text-red-500">
                        {!! $icons['warning-circle'] !!}
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Xác nhận xoá</h3>
                        <p class="mt-1 text-sm text-gray-600">Xác nhận xóa cấp độ thiên tai này?</p>
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
</script>
