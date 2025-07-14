<?php

namespace App\Http\Controllers;

use App\Models\Administrative;
use App\Models\Calamities;
use App\Models\District;
use App\Models\TypeOfConstruction;
use App\Models\Construction;

class MapController extends Controller
{
    public function viewRiverBank()
    {
        $years_has_riverbank = Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->selectRaw('YEAR(time) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $locations_river_bank = [];

        foreach ($years_has_riverbank as $year) {
            $locations_river_bank[$year] = District::with([
                'communes' => function ($query) use ($year) {
                    $query->with(['calamities' => function ($query) use ($year) {
                        $query->whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')
                            ->whereYear('time', $year)
                            ->select('id', 'address', 'coordinates', 'name', 'length', 'width', 'acreage');
                    }]);
                }
            ])
                ->get()
                ->mapWithKeys(function ($district) {
                    $totalCalamities = $district->communes->sum(fn($commune) => $commune->calamities->count());

                    return [
                        $district->name => [
                            'total' => $totalCalamities,
                            'communes' => $district->communes->mapWithKeys(function ($commune) {
                                return [
                                    $commune->name => [
                                        'count' => $commune->calamities->count(),
                                        'calamities' => $commune->calamities->map(function ($calamity) {
                                            return [
                                                'name' => $calamity->name,
                                                'latitude' => explode(',', $calamity->coordinates)[0] ?? ' ',
                                                'longitude' => explode(',', $calamity->coordinates)[1] ?? ' ',
                                                'length' => $calamity->length,
                                                'width' => $calamity->width,
                                                'acreage' => ($calamity->acreage)
                                                    ? $calamity->acreage
                                                    : (($calamity->length && $calamity->width) ? $calamity->length * $calamity->width : ' '),
                                                'address' => $calamity->address,
                                                'commune' => $calamity->communes->first()->name ?? '',
                                                'district' => $calamity->communes->first()->district->name ?? '',

                                            ];
                                        })->toArray()
                                    ]
                                ];
                            })->toArray()
                        ]
                    ];
                });
        }
        $districts = District::all()->map(function ($district) {
            return [
                'id'=>$district->id,
                'name' => $district->name,
                'coordinates'=>$district->coordinates,
                'map' => json_decode($district->map, true) 
            ];
        });

        $constructionTypes = TypeOfConstruction::select('id', 'name')->get();

        $constructions = Construction::with(['risk_level', 'commune.district'])
            ->select('id', 'name', 'coordinates', 'type_of_construction_id', 'risk_level_id', 'address', 'year_of_construction')
            ->get()
            ->map(function ($construction) {
                return [
                    'id' => $construction->id,
                    'type_id' => $construction->type_of_construction_id,
                    'name' => $construction->name,
                    'risk_level_name' => $construction->risk_level->name ?? '',
                    'address' => $construction->address,
                    'population'=>$construction->population,
                    'commune' => $construction->commune->name ?? '',
                    'district' => $construction->commune->district->name ?? '',
                    'year_of_construction' => $construction->year_of_construction ?? '',
                    'latitude' => explode(',', $construction->coordinates)[0] ?? '',
                    'longitude' => explode(',', $construction->coordinates)[1] ?? '',
                ];
            })
            ->groupBy('type_id');

        $types = ['school', 'medical', 'center'];
        $classifies = ['Cấp xã', 'Cấp huyện']; 

        $administratives = Administrative::whereIn('type', $types)
            ->when($classifies, function ($query) use ($classifies) {
                    return $query->where(function ($q) use ($classifies) {
                        $q->where('type', 'center')->whereIn('classify', $classifies);
                    })
                    ->orWhere('type', 'school')
                    ->orWhere('type', 'medical');
                })
            ->get()
            ->map(function ($item) {
                $coordinates = explode(',', $item->coordinates ?? '');
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'type' => $item->type,
                    'classify' => $item->classify,
                    'address' => $item->address,
                    'population'=>$item->population,
                    'commune' => optional($item->communes)->name,
                    'district' => optional(optional($item->communes)->district)->name,
                    'description' => $item->description,
                    'latitude' => $coordinates[0] ?? null,
                    'longitude' => $coordinates[1] ?? null,
                ];
            });

        $duongSoTanFiles = [];
        $duongSoTanPath = public_path('uploads/calamities/flooding/DuongSoTan');

        if (file_exists($duongSoTanPath)) {
            $files = scandir($duongSoTanPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $duongSoTanFiles[] = asset("uploads/calamities/flooding/DuongSoTan/$file");
                }
            }
        }

        $sortedLevels = ['all', '0-0.5m', '0.5-1m', '1-1.5m', '1.5-2m', '>2m'];

        $levels = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
            $query->where('slug', 'ngap-lut');
        })
            ->whereNotNull('flood_range')
            ->selectRaw('TRIM(flood_range) as flood_range')
            ->distinct()
            ->pluck('flood_range')
            ->map(fn($level) => trim($level))
            ->toArray(); 

        usort($levels, function ($a, $b) use ($sortedLevels) {
            return array_search($a, $sortedLevels) - array_search($b, $sortedLevels);
        });

        $floodByRange = [];

        $floodByRange['all'] = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
            $query->where('slug', 'ngap-lut');
        })
            ->whereNotNull('flood_range')
            ->select('id', 'name', 'coordinates', 'map')
            ->get()
            ->map(fn($calamity) => [
                'id' => $calamity->id,
                'name' => $calamity->name,
                'latitude' => explode(',', $calamity->coordinates)[0] ?? null,
                'longitude' => explode(',', $calamity->coordinates)[1] ?? null,
                'map' => $calamity->map,
            ])->toArray();

        foreach ($levels as $level) {
            $floodByRange[$level] = Calamities::whereRaw("TRIM(flood_range) = ?", [$level])
                ->whereHas('risk_level.type_of_calamities', function ($query) {
                    $query->where('slug', 'ngap-lut');
                })
                ->select('id', 'name', 'coordinates', 'map')
                ->get()
                ->map(fn($calamity) => [
                    'id' => $calamity->id,
                    'name' => $calamity->name,
                    'latitude' => explode(',', $calamity->coordinates)[0] ?? null,
                    'longitude' => explode(',', $calamity->coordinates)[1] ?? null,
                    'map' => $calamity->map,
                ])->toArray();
        }

        $years_has_storm = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
            $query->where('slug', 'bao-ap-thap-nhiet-doi');
        })
            ->whereNotNull('time_start')
            ->selectRaw('YEAR(time_start) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
        $stormsByYear = [];

        $stormsByYear['all'] = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
            $query->where('slug', 'bao-ap-thap-nhiet-doi');
        })
            ->select('id', 'name', 'coordinates', 'map')
            ->get()
            ->map(fn($calamity) => [
                'id' => $calamity->id,
                'name' => $calamity->name,
                'latitude' => explode(',', $calamity->coordinates)[0] ?? null,
                'longitude' => explode(',', $calamity->coordinates)[1] ?? null,
                'map' => $calamity->map,
            ])->toArray();
        foreach ($years_has_storm as $year) {
            $stormsByYear[$year] = Calamities::whereYear('time_start', $year)
                ->whereHas('risk_level.type_of_calamities', function ($query) {
                    $query->where('slug', 'bao-ap-thap-nhiet-doi');
                })
                ->select('id', 'name', 'coordinates', 'map')
                ->get()
                ->map(fn($calamity) => [
                    'id' => $calamity->id,
                    'name' => $calamity->name,
                    'latitude' => explode(',', $calamity->coordinates)[0] ?? null,
                    'longitude' => explode(',', $calamity->coordinates)[1] ?? null,
                    'map' => $calamity->map,
                ])->toArray();
        }

        return view('pages.map', compact('locations_river_bank', 'districts','constructionTypes','duongSoTanFiles' ,'constructions', 'administratives','floodByRange','stormsByYear'));
    }

    public function getCategoryData()
    {
        $districts = District::all()->map(function ($district) {
            return [
                'name' => $district->name,
                'map' => json_decode($district->map, true) 
            ];
        });

        return response()->json($districts);
    }
}
