<?php

namespace App\Http\Controllers\Constructions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use App\Models\SubTypeOfCalamities;
use App\Models\Commune;
use App\Models\Construction;
use App\Models\District;
use App\Models\TypeOfConstruction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FloodingConstructionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $district_id = $request->input('district_id');
        $commune_id = $request->input('commune_id');
        $type_of_construction = $request->input('type_of_construction');

        $query = Construction::whereRelation('type_of_calamities', 'slug', 'ngap-lut')
            ->with(['type_of_constructions', 'communes']);

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        if (!empty($commune_id) && !empty($district_id)) {
            $validCommune = Commune::where('id', $commune_id)->where('district_id', $district_id)->exists();
            if ($validCommune) {
                $query->whereHas('communes', function ($q) use ($commune_id) {
                    $q->where('id', $commune_id);
                });
            } else {
                $query->whereRaw('1 = 0'); // Tạo điều kiện luôn sai để không có dữ liệu nào
            }
        } elseif (!empty($commune_id)) {
            $query->whereHas('communes', function ($q) use ($commune_id) {
                $q->where('id', $commune_id);
            });
        } elseif (!empty($district_id)) {
            $query->whereHas('communes', function ($q) use ($district_id) {
                $q->where('district_id', $district_id);
            });
        }
        if (!empty($type_of_construction)) {
            $query->whereHas('type_of_constructions', function ($q) use ($type_of_construction) {
                $q->where('id', $type_of_construction);
            });
        }
        $data = $query->orderByDesc('id')->paginate(10)->appends([
            'search' => $search,
            'district_id' => $district_id,
            'commune_id' => $commune_id,
            'type_of_construction' => $type_of_construction,
        ]);
        $districts = District::all();
        $typeOfConstructions = TypeOfConstruction::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        return view('pages/constructions/flooding/list-flooding', compact('data', 'typeOfConstructions', 'districts'));
    }

    public function viewFormFlooding()
    {
        $calamities = TypeOfCalamities::where('slug', 'ngap-lut')->get();
        $typeOfConstructions = TypeOfConstruction::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        return view('pages/constructions/flooding/add-flooding', compact('calamities', 'communes', 'typeOfConstructions', 'risk_levels'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:constructions',
            'type_of_calamity_id' => 'required',
            'type_of_construction_id' => 'required',
            'risk_level_id' => 'required',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        $data = [
            'name' => $validated['name'],
            'risk_level_id' => $validated['risk_level_id'],
            'type_of_calamity_id' => $validated['type_of_calamity_id'],
            'type_of_construction_id' => $validated['type_of_construction_id'],
            'year_of_construction' => $request['year_of_construction'],
            'year_of_completion' => $request['year_of_completion'],
            'scale' => $request['scale'],
            'coordinates' => $request['coordinates'],
            'address' => $request['address'],
            'main_function' => $request['main_function'],
            'characteristic' => $request['characteristic'],
            'width_of_door' => $request['width_of_door'],
            'base_level' => $request['base_level'],
            'pillar_top_level' => $request['pillar_top_level'],
            'total_door_width' => $request['total_door_width'],
            'notes' => $request['notes'],
            'operation_method' => $request['operation_method'],
            'irrigation_system' => $request['irrigation_system'],
            'irrigation_area' => $request['irrigation_area'],
            'culver_type' => $request['culver_type'],
            'culver_code' => $request['culver_code'],
            'management_unit' => $request['management_unit'],
            'update_time' => Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->update_time)->format('Y-m-d'),
            'created_by_user_id' => $user->id,
        ];
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $originalName = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoFile->move(public_path('uploads/constructions/flooding/videos'), $newFileName);
            $data['video'] = "uploads/constructions/flooding/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imageFile->move(public_path('uploads/constructions/flooding/images'), $newFileName);
            $data['image'] = "uploads/constructions/flooding/images/$newFileName";
        }
        $slug = Str::slug($request->name);
        $count = Construction::where('slug', 'like', "{$slug}%")->count();
        $data['slug'] = $count > 0 ? "{$slug}-{$count}" : $slug;

        $construction = Construction::create($data);

        if (isset($request['commune_id'])) {
            $construction->communes()->sync($request['commune_id']);
        }
        return redirect('/construction/list-flooding')->with('success', 200);
    }

    public function show($id)
    {
        $calamities = TypeOfCalamities::where('slug', 'ngap-lut')->get();
        $construction = Construction::findOrFail($id);
        $typeOfConstructions = TypeOfConstruction::where('type_of_calamity_id', $construction->type_of_calamity_id)->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        return view('pages/constructions/flooding/edit-flooding', compact('calamities', 'construction', 'typeOfConstructions', 'communes', 'risk_levels'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $construction = Construction::findOrFail($request->id);
        $validated = $request->validate([
            'name' => 'required|unique:constructions,name,' . $request->id,
            'type_of_construction_id' => 'required',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'risk_level_id' => 'required',
        ]);

        $data = [
            'name' => $validated['name'],
            'risk_level_id' => $validated['risk_level_id'],
            'type_of_construction_id' => $validated['type_of_construction_id'],
            'year_of_construction' => $request['year_of_construction'],
            'year_of_completion' => $request['year_of_completion'],
            'scale' => $request['scale'],
            'coordinates' => $request['coordinates'],
            'address' => $request['address'],
            'main_function' => $request['main_function'],
            'characteristic' => $request['characteristic'],
            'width_of_door' => $request['width_of_door'],
            'base_level' => $request['base_level'],
            'pillar_top_level' => $request['pillar_top_level'],
            'total_door_width' => $request['total_door_width'],
            'notes' => $request['notes'],
            'operation_method' => $request['operation_method'],
            'irrigation_system' => $request['irrigation_system'],
            'irrigation_area' => $request['irrigation_area'],
            'culver_type' => $request['culver_type'],
            'culver_code' => $request['culver_code'],
            'management_unit' => $request['management_unit'],
            'update_time' => Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->update_time)->format('Y-m-d'),
            'updated_by_user_id' => $user->id,
        ];
        if ($request->hasFile('video')) {
            if ($construction->video) {
                @unlink(public_path($construction->video));
            }
            $videoFile = $request->file('video');
            $slugName = Str::slug(pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoPath = $videoFile->move(public_path('uploads/constructions/flooding/videos'), $newFileName);
            $data['video'] = "uploads/constructions/flooding/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            if ($construction->image) {
                @unlink(public_path($construction->image));
            }
            $imageFile = $request->file('image');
            $slugName = Str::slug(pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imagePath = $imageFile->move(public_path('uploads/constructions/flooding/images'), $newFileName);
            $data['image'] = "uploads/constructions/flooding/images/$newFileName";
        }

        $slug = Str::slug($request->name);
        $count = Construction::where('slug', 'like', "{$slug}%")->where('id', '!=', $request->id)->count();
        $data['slug'] = $count > 0 ? "{$slug}-{$count}" : $slug;

        $construction->update($data);

        if (isset($request['commune_id'])) {
            $construction->communes()->sync($request['commune_id']);
        }

        return redirect('/construction/list-flooding')->with('success', 200);
    }


    public function destroy($id)
    {
        $construction = Construction::findOrFail($id);
        $construction->communes()->detach();
        $construction->delete();
        return redirect('/construction/list-flooding')->with('success', 200);
    }
}
