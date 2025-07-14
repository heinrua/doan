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
use PhpOffice\PhpSpreadsheet\IOFactory;

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
                $query->whereRaw('1 = 0'); 
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
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:calamities',
            'type_of_calamity_id' => 'required',
            'risk_level_id' => 'required',
            'type_of_construction_id' => 'required',
        ]);

        $data = [];
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['type_of_construction_id'] = $validated['type_of_construction_id'];
        $data['commune_id'] = $request['commune_id'];
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
        $data['created_by_user_id'] = $user->id;
        $slug = Str::slug($request->name);
        $count = Construction::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $data['slug'] = $slug;
        $construction = Construction::create($data);

        return redirect('/construction/list-storm')->with('success', "Thêm công trình phòng chống thiên tai thành công");
    }

    public function importStormConstruction(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'excelFile' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        $file = $request->file('excelFile');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slugName = Str::slug($originalName);
        $timestamp = now()->format('YmdHis');
        $newFileName = "{$slugName}-{$timestamp}.{$file->getClientOriginalExtension()}";
        $file->move(public_path('uploads/constructions/storm/imports'), $newFileName);
        $filePath = public_path('uploads/constructions/storm/imports/' . $newFileName);
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        foreach ($rows as $row) {
            $data = [
                'name' => $row["Tên công trình"],
                'risk_level_id' => RiskLevel::where('name', $row["Cấp độ"])->first()->id,
                'type_of_construction_id' => TypeOfConstruction::where('name', $row["Loại công trình"])->first()->id,
                'commune_id' => Commune::where('name', $row["Xã"])->first()->id,
                'year_of_construction' => $row["Năm xây dựng"],
                'year_of_completion' => $row["Năm hoàn thành"],
                'scale' => $row["Quy mô"],
                'geology' => $row["Địa chất"],
                'influence_level' => $row["Mức độ ảnh hưởng"],
                'coordinates' => $row["Toạ độ"],
                'total_investment' => $row["Tổng mức đầu tư"],
                'capital_source' => $row["Nguồn vốn"],
                'created_by_user_id' => $user->id,
                'update_time' => Carbon::createFromFormat('d \T\h\á\n\g m, Y', $row["Thời gian cập nhật"])->format('Y-m-d'),
            ];
            $construction = Construction::create($data);
        }
        return redirect('/construction/list-storm')->with('success', "Nhập thành công");
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
        $data['commune_id'] = $request['commune_id'];
        $data['construction_code'] = $request->construction_code;
        $data['name'] = $validated['name'];
        $data['address'] = $request->address;
        $data['size'] = $request->size;

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
        $data['updated_by_user_id'] = $user->id;

        if ($construction->name !== $request->name) {
            $slug = Str::slug($request->name);
            $count = Construction::where('slug', 'like', "{$slug}%")->where('id', '!=', $request->id)->count();
            if ($count > 0) {
                $slug = "{$slug}-{$count}";
            }
            $data['slug'] = $slug;
        }

        $construction->update($data);

        return redirect('/construction/list-storm')->with('success', "Cập nhật công trình phòng chống thiên tai thành công");
    }

    public function destroy($id)
    {
        $calamity = Construction::findOrFail($id);
        $calamity->delete();
        return redirect('/construction/list-storm')->with('success', "Xóa công trình phòng chống thiên tai thành công");
    }   
    public function destroyMultiple(Request $request)
    {
        $ids = $request->ids;
        Construction::whereIn('id', $ids)->delete();
        return redirect('/construction/list-storm')->with('success', "Xóa thành công");
    }
}
