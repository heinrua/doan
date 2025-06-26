<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="email" name="email" required placeholder="Email" value="{{ old('email') }}" />
    <input type="password" name="password" required placeholder="Mật khẩu mới" />
    <input type="password" name="password_confirmation" required placeholder="Nhập lại mật khẩu" />
    <button type="submit">Đặt lại mật khẩu</button>
</form>
