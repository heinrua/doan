@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Trường Học - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['aperture'] !!}
        Cập Nhật Trường Học
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> 
        <div class="intro-y">
            <form enctype="multipart/form-data" class="validate-form" action="{{ route('update-school') }}" method="post">
                <input type="hidden" name="id" value="{{ $data->id }}">
                @csrf
                <input type="hidden" name="type" value="school">
                
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            {!! $icons['chevron-down'] !!} Thông Tin Trường Học
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Trường Học</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="name" id="name" type="text"
                                        value="{{ $data->name }}" placeholder="Tên Trường Học" />
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mã</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="code" id="code" type="text"
                                        value="{{ $data->code }}" placeholder="Mã" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Địa Điểm</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="address" id="address" type="text"
                                        value="{{ $data->address }}" placeholder="Địa Điểm" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Xã</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <select class="w-full" id="crud-form-2" name="commune_id">
                                        @foreach ($communes as $commune)
                                            <option value="{{ $commune->id }}"
                                                {{ $data->commune_id == $commune->id ? 'selected' : '' }}>
                                                {{ $commune->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Toạ độ</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="coordinates" id="coordinates" type="text"
                                        value="{{ $data->coordinates }}" placeholder="Toạ độ" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Sức chứa</div>
                                            <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="population" id="population" type="number"
                                        placeholder="Sức chứa"
                                        value="{{ number_format($data->population, 0, ',', '.') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div class="flex-col md:flex-row items-start pt-5 first:mt-0 first:pt-0"
                                formInline>
                                <label class="md:w-80">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mô tả</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="description" id="description" type="text"
                                        value="{{ $data->description }}" placeholder="Mô tả" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-school') }}">
                        <button type="button"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                            Huỷ Bỏ</button>
                    </a>
                       <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
