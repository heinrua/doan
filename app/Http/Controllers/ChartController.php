<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Calamities;
use App\Models\TypeOfCalamities;
use App\Models\RiskLevel;
use App\Models\SubTypeOfCalamities;

class ChartController extends Controller
{
    public function index() {
        $calamities = Calamities::all();
        $typeOfCalamities = TypeOfCalamities::all();
        $risk_levels =RiskLevel::all();
        $subTypeOfCalamities = SubTypeOfCalamities::all();
        
        return view('pages.chart', compact('calamities','typeOfCalamities','risk_levels','subTypeOfCalamities'));
}

}
