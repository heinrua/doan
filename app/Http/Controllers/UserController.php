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
        $request->validate([
            'fileImport' => 'required|file|mimes:xlsx,csv,txt|max:2048',
        ]);

        $file = $request->file('fileImport');

        try {
            $rows = Excel::toArray([], $file)[0]; 

            $header = array_map('trim', $rows[0]); 
            $count = 0;
            $skipped = 0;

            foreach (array_slice($rows, 1) as $row) {
                if (count($row) !== count($header)) {
                    Log::warning('⚠️ Dòng sai số cột: ' . json_encode($row));
                    $skipped++;
                    continue;
                }

                $data = array_combine($header, $row);

                if (!isset($data['name'], $data['user_name'], $data['email'], $data['password'])) {
                    Log::warning('⚠️ Thiếu trường bắt buộc:', $data);
                    $skipped++;
                    continue;
                }

                if (
                    User::where('user_name', $data['user_name'])->exists() ||
                    User::where('email', $data['email'])->exists()
                ) {
                    Log::info('⚠️ Trùng user_name/email:', $data);
                    $skipped++;
                    continue;
                }

                try {
                    User::create([
                        'full_name' => $data['name'],
                        'user_name' => $data['user_name'],
                        'email'     => $data['email'],
                        'password'  => Hash::make($data['password']),
                    ]);
                    $count++;
                } catch (\Exception $e) {
                    Log::error('❌ Lỗi khi tạo user: ' . $e->getMessage(), $data);
                    $skipped++;
                }
            }

            return redirect('/list-user')->with('success', "Đã import $count người dùng, bỏ qua $skipped dòng.");
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi đọc file Excel: ' . $e->getMessage());
        }
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
