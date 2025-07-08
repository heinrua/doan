<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Models\User;
class PasswordResetLinkController extends Controller
{
    
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'user_name' => ['required'],
        'email' => ['required', 'email'],
        ]);

        $user = User::where('user_name', $request->user_name)
                    ->where('email', $request->email)
                    ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Kiểm tra lại tên đăng nhập và email.']);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return redirect()->route('login')->with('status', 'Chúng tôi đã gửi link khôi phục mật khẩu đến email của bạn.');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);

    }
}
