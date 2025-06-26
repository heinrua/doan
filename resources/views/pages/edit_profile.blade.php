@extends('themes.base')

@section('subhead')
    <title>Cập Nhật Hồ Sơ - PCTT Cà Mau Dashboard</title>
@endsection

@section('subcontent')

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
  <h2 class="text-xl font-semibold mb-4">Chỉnh sửa hồ sơ</h2>

  @if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('update-profile') }}" method="POST">
    @csrf

    <div class="mb-4">
      <label for="full_name" class="block mb-1 font-medium">Họ tên</label>
      <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
             class="w-full p-3 border border-gray-300 rounded" required>
      @error('full_name')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror

    </div>
    <div class="mb-4">
      <label for="user_name" class="block mb-1 font-medium">Tên đăng nhập</label>
      <input type="text" name="user_name" value="{{ old('user_name', $user->user_name) }}"
             class="w-full p-3 border border-gray-300 rounded" required>
        @error('user_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror

    <div class="mb-4">
      <label for="email" class="block mb-1 font-medium">Email</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}"
             class="w-full p-3 border border-gray-300 rounded" required>
        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror

    <div class="mb-4">
      <label for="password" class="block mb-1 font-medium">Mật khẩu mới (nếu đổi)</label>
      <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded">
    </div>

    <div class="mb-4">
      <label for="password_confirmation" class="block mb-1 font-medium">Xác nhận mật khẩu</label>
      <input type="password" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded">
    </div>
      @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
    <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
      Cập nhật
    </button>
    <a href="{{ route('dashboard-overview') }}">
                        <button type="button"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                            Huỷ Bỏ</button>
                    </a>
  </form>
</div>
@endsection
