<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" required placeholder="Nhập email" />
    <button type="submit">Gửi link khôi phục mật khẩu</button>
</form>
