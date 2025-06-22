<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class AuthController extends Controller
{
    public function viewRegister(): View
    {
        return view('pages/register');
    }

    public function viewLogin(): View
    {
        return view('pages/login');
    }
    public function viewEditProfile()
    {
        $user = Auth::user(); // lấy thông tin người dùng đang đăng nhập
        return view('pages/edit_profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->full_name = $request->full_name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('edit_profile')->with('success', 'Cập nhật thông tin thành công!');
    }

    // public function register(Request $request) {
    //     $validated = $request->validate([
    //         'user_name' => 'required|unique:users',
    //         'password' => 'required|min:8',
    //         'full_name' => 'required',
    //         'email' => 'required',
    //     ]);
        
    //     $user = User::create([
    //         'user_name' => $validated['user_name'],
    //         'password' => Hash::make($validated['password']),
    //         'full_name' => $validated['full_name'],
    //         'email' => $validated['email'],
    //         'role_id' => 1
    //     ]);

    //     return redirect('/login')->with(['message' => 'User registered successfully', 'user' => $user]);
    // }

    public function login(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
            
        ]);
        
        $credentials = $request->only('user_name', 'password');

        if (!auth()->attempt($credentials)) {
            return redirect('/login')->withErrors(['error' => 'Invalid credentials']);
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
