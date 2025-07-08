<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{

    public function viewLogin(): View
    {
        return view('pages/login');
    }
    public function viewEditProfile()
    {
        $user = Auth::user(); 
        return view('pages/edit_profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {   
    $userId = Auth::user()->id; 

       $request->validate([
            'full_name' => 'required|string|max:255',
            'user_name' => "required|string|max:255|unique:users,user_name,{$userId},id",
            'email' => "nullable|email|max:255|unique:users,email,{$userId},id",
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->full_name = $request->full_name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('edit-profile')->with('success', 'Cập nhật thông tin thành công!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
            
        ]);
        
        $credentials = $request->only('user_name', 'password');

        if (!auth()->attempt($credentials)) {
            return redirect('/login')->with('error', 'Tài khoản hoặc mật khẩu không đúng.');
        }

        $user = $user = User::where('user_name', $request->user_name)->first();
        $token = $user->createToken('authToken')->plainTextToken;

        return redirect('/')->with([
            'user' => $user,
            'token' => $token,
        ]);

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
