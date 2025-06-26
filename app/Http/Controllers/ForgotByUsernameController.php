<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgotByUsernameController extends Controller
{
     public function send(Request $request)
    {
        $request->validate([
            'user_name' => 'required|exists:users,user_name',
        ]);

        $user = User::where('user_name', $request->user_name)->first();

        if (!$user || !$user->email) {
            return back()->with('status', 'Không thể gửi link đặt lại mật khẩu.');
        }

        $status = Password::sendResetLink(['email' => $user->email]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Đã gửi link đặt lại mật khẩu đến email của tài khoản "' . $user->user_name . '"')
            : back()->withErrors(['email' => __($status)]);
    }
}
