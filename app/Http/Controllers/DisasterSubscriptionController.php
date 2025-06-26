<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisasterSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'full_name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:disaster_subscriptions,email',
        ]);

        DisasterSubscription::create([
            'full_name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Bạn đã đăng ký nhận cảnh báo thiên tai thành công!');
    }
}
