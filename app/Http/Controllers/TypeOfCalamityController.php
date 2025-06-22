<?php

namespace App\Http\Controllers;

use App\Models\TypeOfCalamities;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TypeOfCalamityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $query = TypeOfCalamities::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $data = $query->orderByDesc('id')->paginate(10);

        return view('pages/type-of-calamity/list-type-of-calamity', compact('data'));
    }

    public function viewFormTypeOfCalamity()
    {
        return view('pages/type-of-calamity/add-type-of-calamity');
    }

    public function store(Request $request) {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|unique:roles',
            'description' => 'nullable',
        ]);
        $slug = Str::slug($request->name);
        $count = TypeOfCalamities::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $validated['slug'] = $slug;
        $calamity = TypeOfCalamities::create($validated);
        return redirect('/list-type-of-calamity');
    }

    public function show($id) {
        $calamity = TypeOfCalamities::findOrFail($id);
        return view('pages/type-of-calamity/edit-type-of-calamity', compact('calamity'));
    }

    public function update(Request $request) {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:type_of_calamities,name,' . $request->id,
            'description' => 'nullable|string',
        ]);
        $calamity = TypeOfCalamities::findOrFail($request->id);
        $slug = $calamity->slug;
        if ($calamity->name !== $validated['name']) {
            $newSlug = Str::slug($validated['name']);
            $slugCount = TypeOfCalamities::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $calamity->id)->count();
            if ($slugCount > 0) {
                $slug = "{$newSlug}-{$slugCount}";
            } else {
                $slug = $newSlug;
            }
        }
        $calamity->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? $calamity->description,
        
        ]);
        return redirect('/list-type-of-calamity')->with('success',200);
    }

    public function destroy($id) {
        TypeOfCalamities::destroy($id);
        return redirect('/list-type-of-calamity')->with('success',200);
    }
}
