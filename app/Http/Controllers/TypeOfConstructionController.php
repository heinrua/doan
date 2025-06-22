<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\TypeOfCalamities;
use App\Models\TypeOfConstruction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TypeOfConstructionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $typeOfCalamity = $request->input('type_of_calamity_id');

        $query = TypeOfConstruction::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if (!empty($typeOfCalamity)) {
            $query->where('type_of_calamity_id', $typeOfCalamity);
        }
        $data = $query->orderByDesc('id')->paginate(10);

        $typeOfCalamities = TypeOfCalamities::all();
        return view('pages/type-of-construction/list-type-of-construction', compact('data', 'typeOfCalamities'));
    }

    public function viewFormTypeOfConstruction()
    {
        $calamities = TypeOfCalamities::all();
        return view('pages/type-of-construction/add-type-of-construction', compact('calamities'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|unique:type_of_calamities',
            'description' => 'nullable',
            'type_of_calamity_id' => 'required',
        ]);
        $calamityId = TypeOfCalamities::findOrFail($request->type_of_calamity_id);
        $slug = Str::slug($request->name);
        $count = TypeOfConstruction::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $validated['slug'] = $slug;
        $construction = TypeOfConstruction::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'type_of_calamity_id' => $validated['type_of_calamity_id'],
            'created_by_user_id' =>  $user->id
        ]);
        return redirect('/list-type-of-construction');
    }

    public function show($id)
    {
        $construction = TypeOfConstruction::findOrFail($id);
        $calamities = TypeOfCalamities::all();
        return view('pages/type-of-construction/edit-type-of-construction', compact('construction', 'calamities'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:type_of_calamities,name,' . $request->id,
            'description' => 'nullable|string',
            'type_of_calamity_id' => 'required',
        ]);
        $construction = TypeOfConstruction::findOrFail($request->id);
        $calamity = TypeOfCalamities::findOrFail($request->type_of_calamity_id);
        $slug = $construction->slug;
        if ($construction->name !== $validated['name']) {
            $newSlug = Str::slug($validated['name']);
            $slugCount = TypeOfConstruction::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $construction->id)->count();
            if ($slugCount > 0) {
                $slug = "{$newSlug}-{$slugCount}";
            } else {
                $slug = $newSlug;
            }
        }
        $construction->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? $construction->description,
            'type_of_calamity_id' => $validated['type_of_calamity_id'],
            'updated_by_user_id' => $user->id,
        ]);
        return redirect('/list-type-of-construction')->with('success', 200);
    }

    public function destroy($id)
    {
        TypeOfConstruction::destroy($id);
        return redirect('/list-type-of-construction')->with('success', 200);
    }
}
