<?php

namespace App\Http\Controllers\Constructions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use App\Models\Commune;
use App\Models\Construction;
use App\Models\District;
use App\Models\TypeOfConstruction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class StormConstructionController extends Controller
{
    public function __construct()
    {
        
    }
    public function index(Request $request)
    {
        $type = $request->input('type');
        $search = $request->input('search');
        $district_id = $request->input('district_id');
        $commune_id = $request->input('commune_id');
        $risk_level_id = $request->input('risk_level_id');

        $query = Construction::whereRelation('risk_level.type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')
            ->with(['risk_level', 'commune']);

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        if (!empty($commune_id) && !empty($district_id)) {
            $validCommune = Commune::where('id', $commune_id)->where('district_id', $district_id)->exists();
            if ($validCommune) {
                $query->whereHas('commune', function ($q) use ($commune_id) {
                    $q->where('id', $commune_id);
                });
            } else {
                $query->whereRaw('1 = 0'); // Tạo điều kiện luôn sai để không có dữ liệu nào
            }
        } elseif (!empty($commune_id)) {
            $query->whereHas('commune', function ($q) use ($commune_id) {
                $q->where('id', $commune_id);
            });
        } elseif (!empty($district_id)) {
            $query->whereHas('commune', function ($q) use ($district_id) {
                $q->where('district_id', $district_id);
            });
        }
        if (!empty($risk_level_id)) {
            $query->whereHas('risk_level', function ($q) use ($risk_level_id) {
                $q->where('id', $risk_level_id);
            });
        }
        $data = $query->orderByDesc('id')->paginate(10)->appends([
            'search' => $search,
            'district_id' => $district_id,
            'commune_id' => $commune_id,
            'risk_level_id' => $risk_level_id,
        ]);
        $districts = District::all();
        $riskLevels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->get();
        return view('pages/constructions/storm/list-storm', compact('data', 'riskLevels', 'districts'));
    }

    public function viewFormStorm()
    {
        $calamities = TypeOfCalamities::where('slug', 'bao-ap-thap-nhiet-doi')->get();
        $typeOfConstructions = TypeOfConstruction::whereRelation('type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->get();
        return view('pages/constructions/storm/add-storm', compact('calamities', 'typeOfConstructions', 'communes', 'risk_levels'));
    }

    public function store(Request $request)
    {
    
        $validated = $request->validate([
            'name' => 'required|unique:calamities',
            'type_of_calamity_id' => 'required',
            'risk_level_id' => 'required',
            'type_of_construction_id' => 'required',
        ]);

        $data = [];
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['type_of_calamity_id'] = $validated['type_of_calamity_id'];
        $data['type_of_construction_id'] = $validated['type_of_construction_id'];
        $data['construction_code'] = $request['construction_code'];
        $data['name'] = $validated['name'];
        $data['address'] = $request['address'];
        $data['size'] = $request['size'];
        $data['construction_date'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->construction_date)->format('Y-m-d');
        $data['completion_date'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->completion_date)->format('Y-m-d');
        $data['status'] = $request['status'];
        $data['capital_source'] = $request['capital_source'];
        $data['operating_status'] = $request['operating_status'];
        $data['coordinates'] = $request['coordinates'];
        $data['contractor'] = $request['contractor'];
        $data['efficiency_level'] = $request['efficiency_level'];
        $data['total_investment'] = $request['total_investment'];
          
        $slug = Str::slug($request->name);
        $count = Construction::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $data['slug'] = $slug;
        $data['commune_id'] = $request['commune_id'] ?? null;
        $construction = Construction::create($data);

        return redirect('/construction/list-storm')->with('success', 200);
    }

    public function show($id)
    {
        $calamities = TypeOfCalamities::where('slug', 'bao-ap-thap-nhiet-doi')->get();
        $construction = Construction::findOrFail($id);
        $typeOfConstructions = TypeOfConstruction::where('type_of_calamity_id', $construction->risk_level->type_of_calamity_id)->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->get();
        return view('pages/constructions/storm/edit-storm', compact('calamities', 'construction', 'typeOfConstructions', 'communes', 'risk_levels'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $construction = Construction::findOrFail($request->id);
        $validated = $request->validate([
            'name' => 'required|unique:calamities,name,' . $request->id,
            'type_of_construction_id' => 'required',
            'risk_level_id' => 'required',
        ]);

        $data = [];
        $data['type_of_construction_id'] = $validated['type_of_construction_id'];
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['construction_code'] = $request->construction_code;
        $data['name'] = $validated['name'];
        $data['address'] = $request->address;
        $data['size'] = $request->size;

        // Kiểm tra nếu ngày tháng không rỗng mới chuyển đổi định dạng
        if (!empty($request->construction_date)) {
            $data['construction_date'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->construction_date)->format('Y-m-d');
        }
        if (!empty($request->completion_date)) {
            $data['completion_date'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->completion_date)->format('Y-m-d');
        }

        $data['status'] = $request->status;
        $data['capital_source'] = $request->capital_source;
        $data['operating_status'] = $request->operating_status;
        $data['contractor'] = $request->contractor;
        $data['efficiency_level'] = $request->efficiency_level;
        $data['total_investment'] = $request->total_investment;
        

        // Xử lý slug (nếu thay đổi name thì cập nhật slug)
        if ($construction->name !== $request->name) {
            $slug = Str::slug($request->name);
            $count = Construction::where('slug', 'like', "{$slug}%")->where('id', '!=', $request->id)->count();
            if ($count > 0) {
                $slug = "{$slug}-{$count}";
            }
            $data['slug'] = $slug;
        }

        $construction->update($data);

        if (isset($request['commune_id'])) {
            $construction->commune()->sync($request['commune_id']);
        }

        return redirect('/construction/list-storm')->with('success', 200);
    }



    public function destroy($id)
    {
        $calamity = Construction::findOrFail($id);
        $calamity->delete();
        return redirect('/construction/list-storm')->with('success', 200);
    }
}
