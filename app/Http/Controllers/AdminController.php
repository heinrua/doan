<?php

namespace App\Http\Controllers;

use App\Models\Calamities;
use App\Models\Commune;
use App\Models\RiskLevel;
use App\Models\SubTypeOfCalamities;
use App\Models\TypeOfCalamities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:sanctum');
        $this->middleware('auth:sanctum')->except([
        'dashboard',
        'faq',
        'getRiskLevels',
        'getSubTypeOfCalamities',
    ]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        $typeOfCalamities = TypeOfCalamities::withCount(['calamities', 'constructions'])->get();
        $calamities = DB::table('calamities')->orderBy('created_at', 'desc')->limit(5)->get();

        $totals = Calamities::count();
        $rivers = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
        $query->where('slug', 'sat-lo-bo-song-bo-bien');
        })->count();
        
        $floodings = Calamities::whereHas('risk_level', function ($q) {
    $q->whereHas('type_of_calamities', function ($q2) {
        $q2->where('slug', 'ngap-lut');
    });
})->count();
         $storms = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
            $query->where('slug', 'bao-ap-thap-nhiet-doi');
        })->count();
        $communes = Commune::all();

        $data = [
            ['type' => 'Sạt Lở', 'count' => $rivers],
            ['type' => 'Ngập Lụt', 'count' => $floodings],
            ['type' => 'Bão', 'count' => $storms]
        ];
        if ($totals > 0) {
            foreach ($data as &$disaster) {
                $disaster['percentage'] = round(($disaster['count'] / $totals) * 100, 2);
            }
        } else {
            foreach ($data as &$disaster) {
                $disaster['percentage'] = 0;
            }
        }
        $disasters = collect($data);

        // Lấy tất cả thiên tai trong 7 ngày gần nhất bằng 1 query
        $sevenDaysAgo = now()->subDays(7);

        // Lấy dữ liệu sạt lở theo `time`
        $recentLandslides = Calamities::where('time', '>=', $sevenDaysAgo)
            ->whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')
            ->with(['risk_level','sub_type_of_calamities','type_of_calamities', 'communes.district'])
            ->get();

        // Lấy dữ liệu ngập lụt & bão theo `time_start`
        $recentFloodingsAndStorms = Calamities::where('time_start', '>=', $sevenDaysAgo)
            ->whereHas('risk_level.type_of_calamities', function ($query) {
                $query->whereIn('slug', ['ngap-lut', 'bao-ap-thap-nhiet-doi']);
            })
            ->with(['risk_level','sub_type_of_calamities','type_of_calamities', 'communes.district'])
            ->get()
            ->groupBy('type_of_calamities.slug'); // Gom nhóm theo loại thiên tai

        // Chuyển dữ liệu về định dạng mong muốn
        $data7Days = [
            ['type' => 'Sạt Lở', 'data' => $recentLandslides],
            ['type' => 'Ngập Lụt', 'data' => $recentFloodingsAndStorms['ngap-lut'] ?? collect()],
            ['type' => 'Bão', 'data' => $recentFloodingsAndStorms['bao-ap-thap-nhiet-doi'] ?? collect()]
        ];
        

        // dd($data7Days);
        return view('pages.dashboard', compact('user', 'typeOfCalamities', 'calamities', 'disasters', 'data7Days', 'communes'));
    }

    public function getRiskLevels(Request $request)
    {
        $calamityId = $request->query('calamity_id');
        // Lấy danh sách cấp độ rủi ro theo loại thiên tai
        $riskLevels = RiskLevel::where('type_of_calamity_id', $calamityId)->get();

        return response()->json($riskLevels);
    }

    public function getSubTypeOfCalamities(Request $request)
    {
        $calamityId = $request->query('calamity_id');
        // Lấy danh sách cấp độ rủi ro theo loại thiên tai
        $subTypeOfCalamities = SubTypeOfCalamities::where('type_of_calamity_id', $calamityId)->get();

        return response()->json($subTypeOfCalamities);
    }

    public function createDisaster(Request $request)
    {
        // dd($request->all());
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:calamities',
            'risk_level_id' => 'required',
            'sub_type_of_calamity_id' => 'required',
            'coordinates' => 'required',
            'address' => 'required',
            'commune_id' => 'required',
        ]);
        $slug = Str::slug($request->name);
        $count = Calamities::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $validated['slug'] = $slug;
        $validated['created_by_user_id'] = $user->id;
        $validated['time'] =now();
        $validated['time_start'] =now();
        $calamities = Calamities::create($validated);
        if (isset($request['commune_id'])) {
            $calamities->communes()->sync($request['commune_id']);
        }

        if ($request->has('sub_type_of_calamity_id')) {
            $calamities->sub_type_of_calamities()->sync($request->sub_type_of_calamity_id);
        }
        return redirect('/')->with('success', 'Tạo mới thành công!');

    }

    public function faq(){
        return view('pages.faq.faq');
    }
}
