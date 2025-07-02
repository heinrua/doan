<?php

namespace App\Http\Controllers;

use App\Models\Calamities;
use App\Models\Commune;
use App\Models\RiskLevel;
use App\Models\SubTypeOfCalamities;
use App\Models\TypeOfCalamities;
use App\Models\DisasterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CalamityCreated;


class AdminController extends Controller
{
    public function __construct()
    {
       
    }

    public function dashboard()
    {
        
        $typeOfCalamities = TypeOfCalamities::withCount(['calamities', 'constructions'])->get();

        $calamities = DB::table('calamities')
            ->join('risk_levels', 'calamities.risk_level_id', '=', 'risk_levels.id')
            ->join('type_of_calamities', 'risk_levels.type_of_calamity_id', '=', 'type_of_calamities.id')
            ->select('calamities.*', 'type_of_calamities.name as calamity_type') // Giả sử cột tên là "name"
            ->orderBy('calamities.created_at', 'desc')
            ->limit(5)
            ->get();

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
            ->with(['risk_level','sub_type_of_calamities','risk_level.type_of_calamities', 'communes.district'])
            ->get();

        // Lấy dữ liệu ngập lụt & bão theo `time_start`
        $recentFloodingsAndStorms = Calamities::where('time_start', '>=', $sevenDaysAgo)
            ->whereHas('risk_level.type_of_calamities', function ($query) {
                $query->whereIn('slug', ['ngap-lut', 'bao-ap-thap-nhiet-doi']);
            })
            ->with(['risk_level','sub_type_of_calamities','risk_level.type_of_calamities', 'communes.district'])
            ->get()
            ->groupBy('risk_level.type_of_calamities.slug'); // Gom nhóm theo loại thiên tai

        // Chuyển dữ liệu về định dạng mong muốn
        $data7Days = [
            ['type' => 'Sạt Lở', 'data' => $recentLandslides],
            ['type' => 'Ngập Lụt', 'data' => $recentFloodingsAndStorms['ngap-lut'] ?? collect()],
            ['type' => 'Bão', 'data' => $recentFloodingsAndStorms['bao-ap-thap-nhiet-doi'] ?? collect()]
        ];
        

        // dd($data7Days);
        return view('pages.dashboard', compact( 'typeOfCalamities', 'calamities', 'disasters', 'data7Days', 'communes'));
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
        $subTypeOfCalamities = SubTypeOfCalamities::where('type_of_calamity_id', $calamityId)->get();

        return response()->json($subTypeOfCalamities);
    }

    public function createDisaster(Request $request)
    {
        // dd($request->all());
        
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
        
        $validated['time'] =now();
        $validated['time_start'] =now();
        $calamities = Calamities::create($validated);
        if (isset($request['commune_id'])) {
            $calamities->communes()->sync($request['commune_id']);
        }

        if ($request->has('sub_type_of_calamity_id')) {
            $calamities->sub_type_of_calamities()->sync($request->sub_type_of_calamity_id);
        }

        // ✅ GỬI EMAIL ĐẾN TOÀN BỘ NGƯỜI ĐĂNG KÝ
        $emails = DisasterSubscription::pluck('email'); // bảng disaster_subscriptions có cột email

        foreach ($emails as $email) {
            Mail::to($email)->send(new CalamityCreated($calamities));
        }
        return redirect('/')->with('success', 'Tạo mới thành công!');

    }

    
}
