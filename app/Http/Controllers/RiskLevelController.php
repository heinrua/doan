<?php

namespace App\Http\Controllers;

use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RiskLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $typeOfCalamity = $request->input('type_of_calamity_id');

        $query = RiskLevel::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if (!empty($typeOfCalamity)) {
            $query->where('type_of_calamity_id', $typeOfCalamity);
        }
        $data = $query->orderByDesc('id')->paginate(10);

        $typeOfCalamities = TypeOfCalamities::all();
        return view('pages/risk-level/list-risk-level', compact('data', 'typeOfCalamities'));
    }

    public function viewFormRiskLevel()
    {
        $calamities = TypeOfCalamities::all();
        return view('pages/risk-level/add-risk-level', compact('calamities'));
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
        $count = RiskLevel::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $validated['slug'] = $slug;
        $data = RiskLevel::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'type_of_calamity_id' => $validated['type_of_calamity_id'],
             
        ]);
        return redirect('/list-risk-level')->with('success', 200);
    }

    public function show($id)
    {
        $risk_level = RiskLevel::findOrFail($id);
        $calamities = TypeOfCalamities::all();
        return view('pages/risk-level/edit-risk-level', compact('calamities', 'risk_level'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:risk_levels,name,' . $request->id,
            'description' => 'nullable|string',
            'type_of_calamity_id' => 'required',
        ]);
        $riskLevel = RiskLevel::findOrFail($request->id);
        $calamity = TypeOfCalamities::findOrFail($request->type_of_calamity_id);
        $slug = $riskLevel->slug;
        if ($riskLevel->name !== $validated['name']) {
            $newSlug = Str::slug($validated['name']);
            $slugCount = RiskLevel::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $riskLevel->id)->count();
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
            
        ]);
        return redirect('/list-risk-level')->with('success', 200);
    }

    public function destroy($id)
    {
        RiskLevel::destroy($id);
        return redirect('/list-risk-level')->with('success', 200);
    }
}
