<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function viewFormUser()
    {
        
        return view('pages/user/add-user');
    }

    public function index(Request $request)
    {
       
        $query = User::query()
            ->select('users.*');

        if ($request->filled('name')) {
            $query->where('users.user_name', 'like', '%' . $request->name . '%');
        }

        $data = $query->orderByDesc('users.id')->paginate(10);

        return view('pages.user.list-user', compact('data'));

    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required',
            'user_name' => 'required|unique:users',
            'password' => 'required',
            'email'=>'nullable|unique:users'
        ]);
        $data = User::create([
            'full_name' => $validated['name'],
            'user_name' => $validated['user_name'],
            'password' => Hash::make($validated['password']),
            'email' => $validated['email'] ?? null,
            'is_master' => $request->has('is_master') ? 1 : 0, 
        ]);
        return redirect('/list-user');
    }

    public function show($id)
    {
        $userData = User::findOrFail($id);

        return view('pages/user/edit-user', compact('userData'));
    }

    public function update(Request $request)
    {
        $userCreate = auth()->user();
        $user = User::findOrFail($request->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'user_name' => 'required|unique:users,user_name,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updated = $user->update([
            'full_name' => $request->name,
            'user_name' => $request->user_name,
            
        ]);
        return redirect('/list-user');
    }
    public function importUsers(Request $request)
    {
        $file = $request->file('excelFile');
        $data = Excel::toArray(new UsersImport(), $file);
        foreach ($data as $row) {
            $validated = $row[0];
            $requiredKeys = [
                'Tên đầy đủ',
                'Tên đăng nhập',
                'Email',
            ];
            foreach ($requiredKeys as $key) {
                if (!isset($validated[$key]) || $validated[$key] === null || $validated[$key] === '') {
                    return redirect()->back()->with('error', "Thiếu hoặc để trống cột '$key' trong file Excel!");
                }
            }
        }
        $user = User::where('user_name', $validated['user_name'])->first();
        if ($user) {
            return back()->with('error', 'Người dùng đã tồn tại!');
        }
        $user = User::where('email', $validated['email'])->first();
        if ($user) {
            return back()->with('error', 'Email đã tồn tại!');
        }
        $user = User::create([
            'full_name' => $validated['Tên đầy đủ'],    
            'user_name' => $validated['Tên đăng nhập'],
            'password' => Hash::make(12345678),
            'email' => $validated['Email'],
            'is_master' => 0,
        ]);
        return back()->with('success', 'Import thành công!');

    }

    public function destroy(Request $request)
    {
        User::destroy($request->id);
        return redirect('/list-user');
    }
    public function destroyMultipleUsers(Request $request)
    {
        User::whereIn('id', $request->ids)->delete();
        return back()->with('success', 'Đã xoá người dùng được chọn');
    }

}
