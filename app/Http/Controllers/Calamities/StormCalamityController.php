<?php

namespace App\Http\Controllers\Calamities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use App\Models\SubTypeOfCalamities;
use App\Models\Calamities;
use App\Models\Commune;
use App\Models\District;
use Carbon\Carbon;
use Illuminate\Support\Str;

class StormCalamityController extends Controller
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
        $risk_level_id = $request->input('risk_level_id');
        $year_id = $request->input('year_id');

        $query = Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')
            ->with(['risk_level', 'communes']);

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        if (!empty($year_id)) {
            $query->whereYear('time_start', $year_id);
        }
        if (!empty($risk_level_id)) {
            $query->whereHas('risk_level', function ($q) use ($risk_level_id) {
                $q->where('id', $risk_level_id);
            });
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

        $data = $query->orderByDesc('id')->paginate(10)->appends([
            'search' => $search,
            'district_id' => $district_id,
            'commune_id' => $commune_id,
            'risk_level_id' => $risk_level_id,
            'year_id' => $year_id,
        ]);
        $districts = District::all();
        $riskLevels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->get();
        $years = Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->selectRaw('YEAR(time_start) as year')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');
        return view('pages/calamities/storm/list-storm', compact('data', 'riskLevels', 'districts','years'));
    }

    public function viewFormStorm()
    {
        $calamities = TypeOfCalamities::where('slug', 'bao-ap-thap-nhiet-doi')->get();
        $sub_calamities = SubTypeOfCalamities::whereRelation('type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->get();

        return view('pages/calamities/storm/add-storm', compact('calamities', 'communes', 'sub_calamities', 'risk_levels'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:calamities',
            'type_of_calamity_id' => 'required',
            'risk_level_id' => 'required',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'sub_type_of_calamity_ids' => 'required',
            'commune_ids' => 'required',
            'map' => 'nullable|max:51200',
        ]);
        $data = [];
        if ($request->hasFile('map')) {
            $mapFiles = $request->file('map');
            $allowedMimeTypes = [
                'application/vnd.google-earth.kmz', // KMZ
                'application/vnd.google-earth.kml+xml', // KML
                'application/octet-stream', // Một số server nhận KML/KMZ là kiểu này
                'application/zip', // Một số server nhận diện KMZ là ZIP
                'text/xml'  // Một số server nhận diện KML là XML
            ];
            $filePaths = []; // Mảng lưu đường dẫn file
            foreach ($mapFiles as $mapFile) {
                if (!in_array($mapFile->getMimeType(), $allowedMimeTypes)) {
                    return back()->withErrors(['map' => 'Định dạng file không hợp lệ. Chỉ chấp nhận KML hoặc KMZ.']);
                }
                // Tạo tên file mới
                $slugName = Str::slug(pathinfo($mapFile->getClientOriginalName(), PATHINFO_FILENAME));
                $timestamp = now()->format('YmdHis');
                $newFileName = "{$slugName}-{$timestamp}.{$mapFile->getClientOriginalExtension()}";
                // Lưu vào thư mục public/uploads/calamities/storm/maps
                $destinationPath = public_path('uploads/calamities/storm/maps');
                $mapFile->move($destinationPath, $newFileName);
                // Thêm đường dẫn vào danh sách
                $filePaths[] = "uploads/calamities/storm/maps/$newFileName";
            }
            // Lưu vào DB dưới dạng JSON
            $data['map'] = json_encode($filePaths);
        }
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $originalName = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoFile->move(public_path('uploads/calamities/storm/videos'), $newFileName);
            $data['video'] = "uploads/calamities/storm/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imageFile->move(public_path('uploads/calamities/storm/images'), $newFileName);
            $data['image'] = "uploads/calamities/storm/images/$newFileName";
        }
        $data['type_of_calamity_id'] = $validated['type_of_calamity_id'];
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['name'] = $validated['name'];
        $data['coordinates'] = $request['coordinates'];
        $data['investment_level'] = $request['investment_level'];
        $data['time_start'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->time_start)->format('Y-m-d');
        $data['time_end'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->time_end)->format('Y-m-d');
        $data['human_damage'] = $request['human_damage'];
        $data['property_damage'] = $request['property_damage'];
        $data['mitigation_measures'] = $request['mitigation_measures'];
        

        $slug = Str::slug($request->name);
        $count = Calamities::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $data['slug'] = $slug;
        $calamities = Calamities::create($data);

        if (isset($validated['commune_ids'])) {
            $calamities->communes()->sync($validated['commune_ids']);
        }
        if (isset($validated['sub_type_of_calamity_ids'])) {
            $calamities->sub_type_of_calamities()->sync($validated['sub_type_of_calamity_ids']);
        }
        return redirect('/calamity/list-storm')->with('success', 200);
    }

    public function show($id)
    {
        $calamities = TypeOfCalamities::where('slug', 'bao-ap-thap-nhiet-doi')->get();
        $calamity = Calamities::with(['communes','communes.district'])->findOrFail($id);
        $typeOfCalamities = TypeOfCalamities::all();
        $subTypeOfCalamities = SubTypeOfCalamities::where('type_of_calamity_id', $calamity->type_of_calamity_id)->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')->get();

        return view('pages/calamities/storm/edit-storm', compact('calamities','calamity', 'typeOfCalamities', 'subTypeOfCalamities', 'communes', 'risk_levels'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $calamity = Calamities::findOrFail($request->id);
        $validated = $request->validate([
            'name' => 'required|unique:calamities,name,' . $request->id,
            'risk_level_id' => 'required',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'sub_type_of_calamity_ids' => 'required',
            'commune_ids' => 'required',
            'map' => 'nullable|max:51200',
        ]);
        $data = $validated;
        if ($request->input('delete_map') == "1" ) {
            @unlink(public_path($calamity->map)); // Xóa file khỏi server
            $data['map'] = null; // Cập nhật DB
        }
        if ($request->has('deleted_maps')) {
            $deletedMaps = json_decode($request->input('deleted_maps'), true);
            if (!empty($deletedMaps)) {
                foreach ($deletedMaps as $deletedFile) {
                    @unlink(public_path($deletedFile)); // Xóa từng file khỏi server
                }
            }
        }
        // Lấy danh sách file cũ (trừ những file đã bị xóa)
        $existingMaps = !empty($calamity->map) ? json_decode($calamity->map, true) : [];
        $existingMaps = array_diff($existingMaps, $deletedMaps ?? []); // Loại bỏ file bị xóa
        if ($request->hasFile('map')) {
            $mapFiles = $request->file('map');
            $allowedMimeTypes = [
                'application/vnd.google-earth.kmz', // KMZ
                'application/vnd.google-earth.kml+xml', // KML
                'application/octet-stream',
                'application/zip',
                'text/xml'
            ];
            $filePaths = [];
            foreach ($mapFiles as $mapFile) {
                if (!in_array($mapFile->getMimeType(), $allowedMimeTypes)) {
                    return back()->withErrors(['map' => 'Định dạng file không hợp lệ. Chỉ chấp nhận KML hoặc KMZ.']);
                }
                $slugName = Str::slug(pathinfo($mapFile->getClientOriginalName(), PATHINFO_FILENAME));
                $timestamp = now()->format('YmdHis');
                $newFileName = "{$slugName}-{$timestamp}.{$mapFile->getClientOriginalExtension()}";
                $destinationPath = public_path('uploads/calamities/storm/maps');
                $mapFile->move($destinationPath, $newFileName);
                $filePaths[] = "uploads/calamities/storm/maps/$newFileName";
            }
            // Gộp danh sách file mới với danh sách file còn lại
            $data['map'] = json_encode(array_merge($existingMaps, $filePaths));
        } else {
            $data['map'] = json_encode($existingMaps); // Nếu không có file mới, chỉ lưu lại file còn lại
        }
        if ($request->input('delete_video') == "1") {
            if ($calamity->video) {
                @unlink(public_path($calamity->video));
                $calamity->video = null;
            }
        }
        if ($request->hasFile('video')) {
            if ($calamity->video) {
                @unlink(public_path($calamity->video));
            }
            $videoFile = $request->file('video');
            $slugName = Str::slug(pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoPath = $videoFile->move(public_path('uploads/calamities/storm/videos'), $newFileName);
            $data['video'] = "uploads/calamities/storm/videos/$newFileName";
        }
        if ($request->input('delete_image') == "1") {
            @unlink(public_path($calamity->image));
            $calamity->image = null;
        }
        if ($request->hasFile('image')) {
            if ($calamity->image) {
                @unlink(public_path($calamity->image));
            }
            $imageFile = $request->file('image');
            $slugName = Str::slug(pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imagePath = $imageFile->move(public_path('uploads/calamities/storm/images'), $newFileName);
            $data['image'] = "uploads/calamities/storm/images/$newFileName";
        }
        $data['coordinates'] = $request->coordinates;
        $data['investment_level'] = $request->investment_level;
        $data['time_start'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->time_start)->format('Y-m-d');
        $data['time_end'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->time_end)->format('Y-m-d');
        $data['human_damage'] = $request->human_damage;
        $data['property_damage'] = $request->property_damage;
        $data['mitigation_measures'] = $request->mitigation_measures;
       
        if ($calamity->name !== $request->name) {
            $slug = Str::slug($request->name);
            $count = Calamities::where('slug', 'like', "{$slug}%")->where('id', '!=', $request->id)->count();
            if ($count > 0) {
                $slug = "{$slug}-{$count}";
            }
            $data['slug'] = $slug;
        }
        $calamity->update($data);
        if (isset($validated['commune_ids'])) {
            $calamity->communes()->sync($validated['commune_ids']);
        }
        if (isset($validated['sub_type_of_calamity_ids'])) {
            $calamity->sub_type_of_calamities()->sync($validated['sub_type_of_calamity_ids']);
        }

        return redirect('/calamity/list-storm')->with('success', 'Cập nhật thành công!');
    }


    public function destroy($id)
    {
        $calamity = Calamities::findOrFail($id);
        $calamity->sub_type_of_calamities()->detach();
        $calamity->communes()->detach();
        $calamity->delete();
        return redirect('/calamity/list-storm')->with('success', 200);
    }
}
