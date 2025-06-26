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
        $years = Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->selectRaw('YEAR(time) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $locations = [];

        foreach ($years as $year) {
            $locations[$year] = District::with([
                'communes' => function ($query) use ($year) {
                    $query->with(['calamities' => function ($query) use ($year) {
                        $query->whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')
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
                                                'latitude' => explode(',', $calamity->coordinates)[0],
                                                'longitude' => explode(',', $calamity->coordinates)[1],
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
                'name' => $district->name,
                'map' => json_decode($district->map, true) // Chuyển chuỗi JSON thành mảng
            ];
        });

        $locationsConstructions = District::with([
            'communes' => function ($query) {
                $query->with([
                    'constructions' => function ($query) {
                        $query->whereHas('type_of_constructions', function ($subQuery) {
                            $subQuery->where('slug', 'cong'); // Lọc theo slug 'cong' trong bảng type_of_constructions
                        })->with('risk_level'); // <-- Thêm eager load risk_level
                    }
                ]);
            }
        ])
            ->get()
            ->mapWithKeys(function ($district) {
                $totalConstructions = $district->communes->sum(fn($commune) => $commune->constructions->count());

                return [
                    $district->name => [
                        'total' => $totalConstructions,
                        'communes' => $district->communes->mapWithKeys(function ($commune) {
                            return [
                                $commune->name => [
                                    'count' => $commune->constructions->count(),
                                    'constructions' => $commune->constructions->map(function ($construction) {
                                        return [
                                            'name' => $construction->name,
                                            'risk_level_name' => $construction->risk_level->name ?? '',
                                            'address' => $construction->address,
                                            'commune' => $construction->communes->first()->name ?? '',
                                            'district' => $construction->communes->first()->district->name ?? '',
                                            'year_of_construction' => $construction->year_of_construction ?? '',
                                            'latitude' => explode(',', $construction->coordinates)[0],
                                            'longitude' => explode(',', $construction->coordinates)[1],
                                        ];
                                    })->toArray()
                                ]
                            ];
                        })->toArray()
                    ]
                ];
            });

        $constructionTypes = TypeOfConstruction::select('id', 'name')->get();

        $constructions = Construction::with(['risk_level', 'communes.district'])
            ->select('id', 'name', 'coordinates', 'type_of_construction_id', 'risk_level_id', 'address', 'year_of_construction')
            ->get()
            ->map(function ($construction) {
                return [
                    'id' => $construction->id,
                    'type_id' => $construction->type_of_construction_id,
                    'name' => $construction->name,
                    'risk_level_name' => $construction->risk_level->name ?? '',
                    'address' => $construction->address,
                    'commune' => $construction->communes->first()->name ?? '',
                    'district' => $construction->communes->first()->district->name ?? '',
                    'year_of_construction' => $construction->year_of_construction ?? '',
                    'latitude' => explode(',', $construction->coordinates)[0],
                    'longitude' => explode(',', $construction->coordinates)[1],
                ];
            });
        $schools = Administrative::where('type', 'school')->get()->map(function ($school) {
            return [
                'id' => $school->id,
                'name' => $school->name,
                'type' => $school->type,
                'address' => $school->address,
                'commune' => $school->communes->name,
                'district' => $school->communes->district->name,
                'description' => $school->description,
                'latitude' => explode(',', $school->coordinates)[0],
                'longitude' => explode(',', $school->coordinates)[1],
            ];
        });

        $medicals = Administrative::where('type', 'medical')->get()->map(function ($medical) {
            return [
                'id' => $medical->id,
                'name' => $medical->name,
                'type' => $medical->type,
                'option' => $medical->option,
                'classify' => $medical->classify,
                'address' => $medical->address,
                'commune' => $medical->communes->name,
                'district' => $medical->communes->district->name,
                'address' => $medical->address,
                'description' => $medical->description,
                'latitude' => explode(',', $medical->coordinates)[0],
                'longitude' => explode(',', $medical->coordinates)[1],
            ];
        });

        $center_communes = Administrative::where('type', 'center')->where('option', 'Cấp xã')->get()->map(function ($center_commune) {
            return [
                'id' => $center_commune->id,
                'name' => $center_commune->name,
                'type' => $center_commune->type,
                'option' => $center_commune->option,
                'address' => $center_commune->address,
                'commune' => $center_commune->communes->name,
                'district' => $center_commune->communes->district->name,
                'address' => $center_commune->address,
                'description' => $center_commune->description,
                'latitude' => explode(',', $center_commune->coordinates)[0],
                'longitude' => explode(',', $center_commune->coordinates)[1],
            ];
        });

        $center_districts = Administrative::where('type', 'center')->where('option', 'Cấp huyện')->get()->map(function ($center_district) {
            return [
                'id' => $center_district->id,
                'name' => $center_district->name,
                'type' => $center_district->type,
                'option' => $center_district->option,
                'address' => $center_district->address,
                'commune' => $center_district->communes->name,
                'district' => $center_district->communes->district->name,
                'address' => $center_district->address,
                'description' => $center_district->description,
                'latitude' => explode(',', $center_district->coordinates)[0],
                'longitude' => explode(',', $center_district->coordinates)[1],
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

        return view('pages/map/river-bank-map', compact('locations', 'districts', 'locationsConstructions', 'constructions','constructionTypes', 'schools', 'medicals', 'center_communes', 'center_districts', 'duongSoTanFiles'));
    }

    public function viewFlooding()
    {
        $sortedLevels = ['all', '0-0.5m', '0.5-1m', '1-1.5m', '1.5-2m', '>2m'];

        // Lấy danh sách mức ngập thực tế từ database, loại bỏ khoảng trắng
        $levels = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
            $query->where('slug', 'ngap-lut');
        })
            ->whereNotNull('flood_range')
            ->selectRaw('TRIM(flood_range) as flood_range')
            ->distinct()
            ->pluck('flood_range')
            ->map(fn($level) => trim($level))
            ->toArray(); // Chuyển về mảng để sắp xếp

        // Sắp xếp theo thứ tự mong muốn
        usort($levels, function ($a, $b) use ($sortedLevels) {
            return array_search($a, $sortedLevels) - array_search($b, $sortedLevels);
        });

        // Khởi tạo danh sách dữ liệu ngập theo mức độ
        $calamitiesByFloodRange = [];

        // Thêm 'all' vào đầu danh sách
        $calamitiesByFloodRange['all'] = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
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

        // Duyệt qua từng mức ngập và lấy dữ liệu tương ứng
        foreach ($levels as $level) {
            $calamitiesByFloodRange[$level] = Calamities::whereRaw("TRIM(flood_range) = ?", [$level])
                ->whereHas('type_of_calamities', function ($query) {
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


      
       return view('pages/map/flooding-map', compact('duongSoTanFiles', 'calamitiesByFloodRange', 'districts', 'locationsConstructions', 'constructions', 'schools', 'medicals', 'center_communes', 'center_districts'));
    }

    public function viewStorm()
    {
        $years = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
            $query->where('slug', 'bao-ap-thap-nhiet-doi');
        })
            ->whereNotNull('time_start')
            ->selectRaw('YEAR(time_start) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
        $calamitiesByYear = [];

        $calamitiesByYear['all'] = Calamities::whereHas('risk_level.type_of_calamities', function ($query) {
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
        foreach ($years as $year) {
            $calamitiesByYear[$year] = Calamities::whereYear('time_start', $year)
                ->whereHas('type_of_calamities', function ($query) {
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

       

    

      

        return view('pages/map/storm-map', compact('duongSoTanFiles', 'calamitiesByYear', 'districts', 'locationsConstructions', 'constructions', 'schools', 'medicals', 'center_communes', 'center_districts'));
    }


    // API trả về dữ liệu con theo danh mục
    public function getCategoryData()
    {
        $districts = District::all()->map(function ($district) {
            return [
                'name' => $district->name,
                'map' => json_decode($district->map, true) // Chuyển chuỗi JSON thành mảng
            ];
        });

        return response()->json($districts);
    }
}
