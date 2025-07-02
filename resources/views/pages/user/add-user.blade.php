@extends('themes.base')

@section('subhead')
    <title>Tạo Người Dùng - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-5 text-lg font-medium uppercase flex items-center">
        {!! $icons['user'] !!}
        Tạo Người Dùng
    </h2>
    <div class="mt-5 grid grid-cols-1 gap-x-6 pb-20"> {{-- Chỉnh thành grid-cols-1 để tối ưu mobile --}}
        <div class="intro-y">
            <!-- BEGIN: User Information -->
            <form class="validate-form" action="/create-user" method="post">
                @csrf
                <div class="intro-y box mt-5 p-5">
                    <div class="rounded-md border border-slate-200/60 p-5">
                        <div
                            class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium">
                            Thông Tin Người Dùng
                        </div>
                        <div class="mt-5">
                            <div>
                                <label class="md:w-64">
                                    <div class="text-left">

                                        <div class="flex items-center">
                                            <div class="font-medium">Tên</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="name" id="name" type="text" placeholder="Tên" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                        </div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Tên Đăng Nhập</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="user_name" id="user_name" type="text" placeholder="Tên Đăng Nhập" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                    @error('user_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Email</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>
                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="email" id="email" type="email" placeholder="Email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <div>
                                <label class="md:w-64">
                                    <div class="text-left">
                                        <div class="flex items-center">
                                            <div class="font-medium">Mật Khẩu</div>
                                           <div class="ml-2 text-red-500 text-xl font-bold">*</div>
                                        </div>

                                    </div>
                                </label>
                                <div class="w-full">
                                    <input name="password" id="password" type="text" placeholder="Mật Khẩu" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                    
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                </div>
                <!-- END: User Information -->
                <div class="mt-5 flex flex-col justify-end gap-2 md:flex-row">
                    <a href="{{ route('view-user') }}">
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
