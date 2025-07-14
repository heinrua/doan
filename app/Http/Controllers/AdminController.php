<?php

namespace App\Http\Controllers;

use App\Models\Calamities;

use App\Models\TypeOfCalamities;
use App\Models\DisasterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CalamityCreated;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function __construct()
    {
       
    }

    public function dashboard(Request $request)
    {
        
        $typeOfCalamities = TypeOfCalamities::withCount(['calamities', 'constructions'])->get();

        $calamities = DB::table('calamities')
            ->join('risk_levels', 'calamities.risk_level_id', '=', 'risk_levels.id')
            ->join('type_of_calamities', 'risk_levels.type_of_calamity_id', '=', 'type_of_calamities.id')
            ->select('calamities.*', 'type_of_calamities.name as calamity_type') 
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

        $sevenDaysAgo = now()->subDays(7);

        $recentLandslides = Calamities::where('time', '>=', $sevenDaysAgo)
            ->whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')
            ->with(['risk_level','sub_type_of_calamities','risk_level.type_of_calamities', 'communes.district'])
            ->get();

        $recentFloodingsAndStorms = Calamities::where('time_start', '>=', $sevenDaysAgo)
            ->whereHas('risk_level.type_of_calamities', function ($query) {
                $query->whereIn('slug', ['ngap-lut', 'bao-ap-thap-nhiet-doi']);
            })
            ->with(['risk_level','sub_type_of_calamities','risk_level.type_of_calamities', 'communes.district'])
            ->get()
            ->groupBy('risk_level.type_of_calamities.slug'); 

        $data7Days = [
            ['type' => 'Sạt Lở', 'data' => $recentLandslides],
            ['type' => 'Ngập Lụt', 'data' => $recentFloodingsAndStorms['ngap-lut'] ?? collect()],
            ['type' => 'Bão', 'data' => $recentFloodingsAndStorms['bao-ap-thap-nhiet-doi'] ?? collect()]
        ];

        $citizenCount = DisasterSubscription::count();

        
       
    
        return view('pages.dashboard', compact(
            'typeOfCalamities', 'calamities', 'disasters', 'data7Days',
            'citizenCount'
        ));
    }

   

}
