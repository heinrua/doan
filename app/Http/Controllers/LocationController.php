<?php

namespace App\Http\Controllers;
use App\Models\Commune;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCommunes($district_id)
    {
        $communes = Commune::where('district_id', $district_id)->get();
        return response()->json($communes);
    }
}
