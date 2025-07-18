<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CityController extends Controller
{

    public function __construct()
    {
        
    }

    public function viewFormCity()
    {
        return view('pages/city/add-city');
    }

    public function index(Request $request)
    {
        $query = City::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $data = $query->orderByDesc('id')->paginate(10);
        return view('pages/city/list-city', compact('data'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:cities',
            'code' => 'required|unique:cities',
            'coordinates' => 'required',
        ]);
        $slug = Str::slug($request->name);
        $count = City::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $validated['slug'] = $slug;
        
        City::create($validated);
        return redirect('/list-city');
    }
    public function importCity(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|file|mimes:xlsx,csv'
        ]);
        $file = $request->file('excelFile');
        $data = Excel::toArray([], $file)[0];
        $header = array_map('trim', $data[0]);
        unset($data[0]);
                
        $requiredHeaders = ['Tên', 'Mã', 'Tọa độ'];
        foreach ($requiredHeaders as $col) {
            if (!in_array($col, $header)) {
                return back()->with('error', 'Thiếu cột bắt buộc: ' . $col);
            }
        }

        foreach ($data as $row) {
            $row = array_combine($header, $row);
            $requiredKeys = [
                'Tên',
                'Mã',
                'Tọa độ',
            ];
            foreach ($requiredKeys as $key) {
                if (!isset($row[$key]) || $row[$key] === null || $row[$key] === '') {
                    return redirect()->back()->with('error', "Thiếu hoặc để trống cột '$key' trong file Excel!");
                }
            }
            if (empty($row['Tên']) || empty($row['Mã']) || empty($row['Tọa độ'])) {
                continue;
            }
            $city = City::create([
                'name' => $row['Tên'],
                'code' => $row['Mã'],
                'slug' => Str::slug($row['Tên']),
                'coordinates' => $row['Tọa độ'],
            ]);
            
            $city->save();
        }
        return back()->with('success', 'Import thành công!');
        return back()->with('error', 'Import thất bại!');
    }   

    public function show($id)
    {
        $city = City::findOrFail($id);
        return view('pages/city/edit-city', compact('city'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:cities,name,' . $request->id,
            'code' => 'required|unique:cities,code,' .$request->id,
            'coordinates' => 'required',
        ]);

        $city = City::findOrFail($request->id);
        $slug = $city->slug;
        if ($city->name !== $validated['name']) {
            $newSlug = Str::slug($validated['name']);
            $slugCount = City::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $city->id)->count();
            if ($slugCount > 0) {
                $slug = "{$newSlug}-{$slugCount}";
            } else {
                $slug = $newSlug;
            }
        }
        $city->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'code' => $validated['code'] ?? $city->code,
            'coordinates' => $validated['coordinates'] ?? $city->coordinates,
            
        ]);
        return redirect('/list-city')->with('success',200);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return redirect('/list-city')->with('success', 'Xóa thành công!');
    }
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Không có mục nào được chọn.');
        }

        City::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Đã xoá các mục đã chọn.');
    }
}
