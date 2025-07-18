@extends('themes.base')

@section('subhead')
    <title>Danh Sách Phương Án Ứng Phó - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-5 flex items-center justify-between">
        <div class="flex items-center text-lg font-medium uppercase">
            {!! $icons['home'] !!} Danh Sách Phương Án Ứng Phó
        </div>
        <a class="flex items-center text-primary" href="{{ route('view-scenarios') }}">
            {!! $icons['refresh-ccw'] !!} Tải lại dữ liệu
        </a>
    </div>
    <x-alert/>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 flex flex-wrap items-start gap-3">
            <form action="{{ route('view-scenarios') }}" method="GET" class="flex flex-wrap items-center gap-3 grow">
                <select name="type_of_calamity_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                    <option value="">--Chọn loại thiên tai--</option>
                    @foreach ($typeOfCalamities as $type)
                        <option value="{{ $type->id }}" {{ request('type_of_calamity_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>

                <select name="district_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                    <option value="">--Chọn huyện--</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>

                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        {!! $icons['search'] !!}
                    </div>
                    <input type="text" name="name" placeholder="Tên phương án..." value="{{ request('name') }}"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <button type="submit"
                    class="h-10 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition-all">
                    Tìm kiếm
                </button>
            </form>

           @auth
                <a href="{{ route('create-scenarios') }}">
                    <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
                        {!! $icons['plus-circle'] !!} Thêm mới phương án
                    </button>
                </a>
            @endauth
        </div>

        <div class="intro-y col-span-3 overflow-auto lg:overflow-visible text-base text-gray-800 bg-gray-300 rounded-md px-4 py-2 shadow-sm text-center">
            Tổng số phương án: <span class="font-semibold">{{ $data->total() }}</span>
        </div>
         
        <div class="intro-y col-span-12 overflow-auto lg:overflow-x-auto">
            <form action="{{ route('delete-multiple-scenarios') }}" class=" col-span-2" method="POST">
            @csrf
            @method('DELETE')
            @auth
            <button type="button" onclick="openDeleteMultipleModal()" class="bg-red-700 z-1 sticky left-0" id="delete-multiple-btn" disabled>
                {!! $icons['trash-2'] !!} Xoá (<span id="selected-count">0</span>)
            </button>
            @endauth
            <table class="mt-2 border-separate border-spacing-y-[10px] min-w-max table-auto ">
                <thead class="text-gray-700 uppercase bg-blue-100">
                    <tr>
                        <th class="sticky left-0 z-1 bg-blue-100 w-[40px] min-w-[40px] max-w-[40px] px-1 text-center"><input type="checkbox" id="selectAll" class="block mx-auto"></th>
                        <th class="sticky left-[40px] z-1 bg-blue-100 px-4 py-4 ">Tên phương án</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Mô tả ngắn</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Loại thiên tai</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Quận/Huyện</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Cập nhật</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Trạng thái</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Mô tả văn bản</th>
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Tệp tin</th>
                        @auth
                        <th scope="col"class="px-6 py-4 whitespace-nowrap min-w-[160px]">Hành động</th>
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
                        @if($value->status !== 'Hoạt động' && !auth()->check())
                            @continue
                        @endif
                        <tr class="bg-white ">
                            <th class="sticky left-0 z-1 bg-white w-[40px] min-w-[40px] max-w-[40px]  text-center"><input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $value->id }}"></th>                
                            <td class="sticky left-[40px] z-1 bg-white px-4 py-4 font-bold">
                                <a class="whitespace-nowrap font-medium" href="/edit-scenarios/{{ $value->id }}">
                                    {{ $value->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->short_description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->type_of_calamities->name ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->districts->name ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ \Carbon\Carbon::parse($value->updated_time)->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                <span class="inline-block px-2 py-1 text-sm font-semibold rounded
                                    {{ $value->status === 'Hoạt động' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $value->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">{{ $value->document_text }}</td>
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px] ">
                                @php $files = json_decode($value->document_path, true); @endphp
                                @if (!empty($files) && is_array($files))
                                    <ul class="list-disc pl-5 space-y-1 max-h-32 overflow-y-auto">
                                        @foreach ($files as $file)
                                            <li>
                                                <a href="#" onclick="openFileModal('{{ asset($file) }}'); return false;" class="text-blue-500 hover:underline">
                                                    {{ basename($file) }}
                                                </a>

                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">Không có tệp tin</span>
                                @endif
                            </td>
                                    
                            @auth
                            <td class="px-6 py-4 whitespace-nowrap min-w-[160px]">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="/edit-scenarios/{{ $value->id }}" class="text-blue-600 flex items-center">
                                        {!! $icons['edit-2'] !!} Sửa
                                    </a>    
                                    <a class="flex items-center text-red-600"   
                                    onclick="openDeleteModal('{{ route('delete-scenarios', ['id' => $value->id]) }}')"
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



<div id="file-modal" class="hidden fixed inset-0 bg-black/50  z-50 flex items-center justify-center">

    <div class="bg-white p-4 rounded w-[80%] max-h-[90%] overflow-y-auto relative">
        <button onclick="closeFileModal()" class="absolute top-2 right-2 bg-gray-300">Đóng</button>
        <div id="file-content" class="mt-8 space-y-4"></div>
    </div>
</div>

<x-delete-modal/>
<x-delete-multiple-modal/>
@vite(['resources/js/confirm-delete.js', 'resources/js/delete-multiple.js'])
@endsection

<script>
    
    
    function openFileModal(fileUrl) {
        const fileExt = fileUrl.split('.').pop().toLowerCase();
        const container = document.getElementById("file-content");
        container.innerHTML = "";

        if (fileExt === 'docx') {
            fetch(fileUrl)
                .then(response => response.arrayBuffer())
                .then(arrayBuffer => mammoth.convertToHtml({ arrayBuffer }))
                .then(result => {
                    container.innerHTML = result.value;
                    document.getElementById("file-modal").classList.remove("hidden");
                })
                .catch(error => {
                    console.error("Lỗi đọc DOCX:", error);
                    alert("Không thể hiển thị nội dung file DOCX.");
                });

        } else if (fileExt === 'pdf') {
            pdfjsLib.getDocument(fileUrl).promise.then(function (pdf) {
                for (let i = 1; i <= pdf.numPages; i++) {
                    pdf.getPage(i).then(function (page) {
                        const scale = 1.2;
                        const viewport = page.getViewport({ scale });

                        const canvas = document.createElement("canvas");
                        const context = canvas.getContext("2d");
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        page.render({ canvasContext: context, viewport }).promise.then(() => {
                            container.appendChild(canvas);
                        });
                    });
                }
                document.getElementById("file-modal").classList.remove("hidden");
            }).catch(error => {
                console.error("Lỗi đọc PDF:", error);
                alert("Không thể hiển thị nội dung file PDF.");
            });

        } else {
            alert("Định dạng file không hỗ trợ.");
        }
    }

    function closeFileModal() {
        document.getElementById("file-modal").classList.add("hidden");
        document.getElementById("file-content").innerHTML = "";
    }
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.0.0/mammoth.browser.min.js"></script>

