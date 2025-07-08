<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommuneController extends Controller
{
    public function __construct()
    {
       
    }

    public function viewFormCommune()
    {
        $districts = District::all();
        return view('pages/commune/add-commune', compact('districts'));
    }

    public function index(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $districtId = $request->input('district_id');

        $query = Commune::query()->with('district');
        if (!empty($search) && in_array($type, ['name', 'code'])) {
            $query->where($type, 'LIKE', "%{$search}%");
        }
        if (!empty($districtId)) {
            $query->where('district_id', $districtId);
        }
        $data = $query->orderByDesc('id')->paginate(10)->appends([
            'type' => $type,
            'search' => $search
        ]);
        $districts = District::all();

        return view('pages.commune.list-commune', compact('data', 'type', 'search','districts'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:communes',
            'code' => 'required|unique:communes',
            'district_id' => 'required',
            'coordinates' => 'required',
        ]);
        $slug = Str::slug($request->name);
        $count = Commune::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $validated['slug'] = $slug;
        
        Commune::create($validated);
        return redirect('/list-commune');
    }

    public function show($id)
    {
        $commune = Commune::findOrFail($id);
        $districts = District::all();
        return view('pages/commune/edit-commune', compact('districts', 'commune'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:communes,name,' . $request->id . ',id',
            'code' => 'required|unique:communes,code,' . $request->id . ',id',
            'district_id' => 'required',
            'coordinates' => 'required',
        ]);
        $commune = Commune::findOrFail($request->id);
        $district = District::findOrFail($request->district_id);
        $slug = $commune->slug;
        if ($commune->name !== $validated['name']) {
            $newSlug = Str::slug($validated['name']);
            $slugCount = Commune::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $commune->id)->count();
            if ($slugCount > 0) {
                $slug = "{$newSlug}-{$slugCount}";
            } else {
                $slug = $newSlug;
            }
        }
        $commune->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'code' => $validated['code'] ?? $commune->code,
            'coordinates' => $validated['coordinates'] ?? $commune->coordinates,
            'district_id' => $validated['district_id'],
            
        ]);
        return redirect('/list-commune')->with('success', 200);
    }

    public function destroy($id)
    {
        $commune = Commune::findOrFail($id);
        $commune->delete();
        return redirect('/list-commune')->with('success', 'Xóa thành công!');
    }

    public function getCommunesByDistrict(Request $request)
    {
        $districtId = $request->input('district_id');
        if (!$districtId) {
            $communes = Commune::all();
            return response()->json($communes);
        }
        $communes = Commune::where('district_id', $districtId)->get();
        return response()->json($communes);
    }
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Không có mục nào được chọn.');
        }

        Commune::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Đã xoá các mục đã chọn.');
    }
}
