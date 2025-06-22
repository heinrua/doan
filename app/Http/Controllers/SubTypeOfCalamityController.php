<?php

namespace App\Http\Controllers;

use App\Models\SubTypeOfCalamities;
use App\Models\TypeOfCalamities;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubTypeOfCalamityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $typeOfCalamity = $request->input('type_of_calamity_id');

        $query = SubTypeOfCalamities::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if (!empty($typeOfCalamity)) {
            $query->where('type_of_calamity_id', $typeOfCalamity);
        }
        $data = $query->orderByDesc('id')->paginate(10);

        $typeOfCalamities = TypeOfCalamities::all();

        return view('pages/sub-type-of-calamity/list-sub-type-of-calamity', compact('data','typeOfCalamities'));
    }

    public function viewFormTypeOfCalamity()
    {
        $calamities = TypeOfCalamities::all();
        return view('pages/sub-type-of-calamity/add-sub-type-of-calamity',compact('calamities'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:risk_levels',
            'description' => 'required|string',
            'type_of_calamity_id' => 'required',
        ]);
        $calamityId = TypeOfCalamities::findOrFail($request->type_of_calamity_id);
        $slug = Str::slug($request->name);
        $count = SubTypeOfCalamities::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $validated['slug'] = $slug;
        $data = SubTypeOfCalamities::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'type_of_calamity_id' => $validated['type_of_calamity_id'],
            'created_by_user_id' =>  $user->id
        ]);
        return redirect('/list-sub-type-of-calamity')->with('success',200);
    }

    public function show($id)
    {
        $risk_level = SubTypeOfCalamities::findOrFail($id);
        $calamities = TypeOfCalamities::all();
        return view('pages/sub-type-of-calamity/edit-sub-type-of-calamity', compact('calamities','risk_level'));

    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:risk_levels,name,' . $request->id,
            'description' => 'nullable|string',
            'type_of_calamity_id' => 'required',
        ]);
        $riskLevel = SubTypeOfCalamities::findOrFail($request->id);
        $calamity = TypeOfCalamities::findOrFail($request->type_of_calamity_id);
        $slug = $riskLevel->slug;
        if ($riskLevel->name !== $validated['name']) {
            $newSlug = Str::slug($validated['name']);
            $slugCount = SubTypeOfCalamities::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $riskLevel->id)->count();
            if ($slugCount > 0) {
                $slug = "{$newSlug}-{$slugCount}";
            } else {
                $slug = $newSlug;
            }
        }
        $riskLevel->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? $riskLevel->description,
            'type_of_calamity_id' => $validated['type_of_calamity_id'],
            'updated_by_user_id' => $user->id,
        ]);
        return redirect('/list-sub-type-of-calamity')->with('success',200);
    }

    public function destroy($id) {
        SubTypeOfCalamities::destroy($id);
        return redirect('/list-sub-type-of-calamity')->with('success',200);
    }
}
