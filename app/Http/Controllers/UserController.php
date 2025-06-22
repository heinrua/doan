<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function viewFormUser()
    {
        $roles = Role::all();
        return view('pages/user/add-user', compact('roles'));
    }

    public function index(Request $request)
    {
       
        $query = User::query()
            ->select('users.*')
            ->where('users.is_master', '!=', true);

        if ($request->filled('name')) {
            $query->where('users.user_name', 'like', '%' . $request->name . '%');
        }

        $data = $query->orderByDesc('users.id')->paginate(10);

        return view('pages.user.list-user', compact('data'));

    }


    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required',
            'user_name' => 'required|unique:users',
            'password' => 'required',
        ]);
        $data = User::create([
            'full_name' => $validated['name'],
            'user_name' => $validated['user_name'],
            'password' => Hash::make($validated['password']),
        ]);
        return redirect('/list-user');
    }

    public function show($id)
    {
        $userData = User::findOrFail($id);
        $roles = Role::all();

        return view('pages/user/edit-user', compact('userData', 'roles'));
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
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect()->back()->with('success', 'Import thành công!');
    }
    
    public function destroy(Request $request)
    {
        User::destroy($request->id);
        return redirect('/list-user');
    }
}
