<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
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
        $validated['created_by_user_id'] = $user->id;
        City::create($validated);
        return redirect('/list-city');
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
            'updated_by_user_id' => $user->id,
        ]);
        return redirect('/list-city')->with('success',200);
    }


    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return redirect('/list-city')->with('success', 'Role deleted successfully!');
    }
}
