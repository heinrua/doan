<?php

namespace App\Http\Controllers\Calamities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use App\Models\SubTypeOfCalamities;
use App\Models\Commune;
use App\Models\Calamities;
use App\Models\District;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\DisasterSubscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\CalamityCreated;
use Maatwebsite\Excel\Facades\Excel;

class FloodingCalamityController extends Controller
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
        $year_id = $request->input('year_id');

        $query = Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'ngap-lut')
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
                $query->whereRaw('1 = 0'); 
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
        $sub_typeCalamities = SubTypeOfCalamities::all();
        $districts = District::all();
        $riskLevels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        $years = Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'ngap-lut')->selectRaw('YEAR(time_start) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
        return view('pages/calamities/flooding/list-flooding', compact('years', 'data', 'sub_typeCalamities', 'riskLevels', 'districts'));
    }

    public function viewFormFlooding()
    {
        $calamities = TypeOfCalamities::where('slug', 'ngap-lut')->get();
        $sub_calamities = SubTypeOfCalamities::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        return view('pages/calamities/flooding/add-flooding', compact('calamities', 'sub_calamities', 'communes', 'risk_levels'));
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
        ]);
        $data = [];
        if ($request->hasFile('map')) {
            $mapFiles = $request->file('map');
            $allowedMimeTypes = [
                'application/vnd.google-earth.kmz', 
                'application/vnd.google-earth.kml+xml', 
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
                
                $destinationPath = public_path('uploads/calamities/flooding/maps');
                $mapFile->move($destinationPath, $newFileName);
                
                $filePaths[] = "uploads/calamities/flooding/maps/$newFileName";
            }
            
            $data['map'] = json_encode($filePaths);
        }
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $originalName = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoFile->move(public_path('uploads/calamities/flooding/videos'), $newFileName);
            $data['video'] = "uploads/calamities/flooding/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imageFile->move(public_path('uploads/calamities/flooding/images'), $newFileName);
            $data['image'] = "uploads/calamities/flooding/images/$newFileName";
        }
        $data['type_of_calamity_id'] = $validated['type_of_calamity_id'];
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['name'] = $validated['name'];

        $data['coordinates'] = $request['coordinates'];
        $data['flood_level'] = $request['flood_level'];
        $data['flood_range'] = $request['flood_range'];
        $data['flooded_area'] = $request['flooded_area'];
        $data['time_start'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->time_start)->format('Y-m-d');
        $data['time_end'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->time_end)->format('Y-m-d');
        $data['sprint_time'] = $request['sprint_time'];
        $data['reason'] = $request['reason'];
        $data['number_of_people_affected'] = $request['number_of_people_affected'];
        $data['human_damage'] = $request['human_damage'];
        $data['property_damage'] = $request['property_damage'];
        $data['damaged_infrastructure'] = $request['damaged_infrastructure'];
        $data['mitigation_measures'] = $request['mitigation_measures'];
        $data['data_source'] = $request['data_source'];
        $data['created_by_user_id'] = $user->id;
        
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
        
        $subscribers = DisasterSubscription::all();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(
                new CalamityCreated($calamities, $subscriber->name)
            );
        }

        return redirect('/calamity/list-flooding')->with('success', 'Thêm thành công!');
    }
    public function importFlooding(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'excelFile' => 'required|file|mimes:xlsx,csv'
        ]);
        $file = $request->file('excelFile');
        $data = Excel::toArray([], $file)[0];
        $header = array_map('trim', $data[0]);
        unset($data[0]);
        
        $requiredHeaders = ['Tên khu vực ngập'];
        foreach ($requiredHeaders as $col) {
            if (!in_array($col, $header)) {
                return back()->with('error', 'Thiếu cột bắt buộc: ' . $col);
            }
        }
        
        foreach ($data as $row) {
            $row = array_combine($header, $row);
            if (empty($row['Tên khu vực ngập']) || empty($row['Loại hình ngập']) ) {
                continue;
            }
            $calamity = Calamities::create([
                'name' => $row['Tên khu vực ngập'],
                'sub_type_of_calamity_ids' => SubTypeOfCalamities::where('name', $row['Loại hình ngập'])->first()->id,
                'risk_level_id' => RiskLevel::where('name', $row['Cấp độ rủi ro'])->first()->id,
                'coordinates' => $row['Tọa độ'],
                'flood_level' => $row['Mức độ (m)'],
                'flood_range' => $row['Khoảng ngập'],
                'flooded_area' => $row['Diện tích (ha)'],
                'time_start' => Carbon::createFromFormat('d \T\h\á\n\g m, Y', $row['Bắt đầu'])->format('Y-m-d'),
                'time_end' => Carbon::createFromFormat('d \T\h\á\n\g m, Y', $row['Kết thúc'])->format('Y-m-d'),
                'sprint_time' => $row['Nước rút (giờ)'],
                'reason' => $row['Nguyên nhân'],
                'number_of_people_affected' => $row['Số hộ ảnh hưởng'],
                'human_damage' => $row['Thiệt hại người'],
                'property_damage' => $row['Thiệt hại tài sản'],
                'damaged_infrastructure' => $row['Hạ tầng hư hại'],
                'mitigation_measures' => $row['Biện pháp'],
                'data_source' => $row['Nguồn'],
                'created_by_user_id' => $user->id,
            ]);
            $calamity->sub_type_of_calamities()->sync($row['Loại hình ngập']);
            $calamity->communes()->sync($row['Địa phương']);    
            $calamity->save();
        }
        return back()->with('success', 'Import thành công!');
    }

    public function show($id)
    {
        $calamity = Calamities::with([
        'communes',
        'communes.district',
        'sub_type_of_calamities',
        'risk_level.type_of_calamities'
        ])->findOrFail($id);

        $typeId = $calamity->risk_level?->type_of_calamities?->id;

        $subTypeOfCalamities = $typeId
            ? SubTypeOfCalamities::where('type_of_calamity_id', $typeId)->get()
            : collect();

        $typeOfCalamities = TypeOfCalamities::all();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        $calamities = TypeOfCalamities::where('slug', 'ngap-lut')->get();

        return view('pages/calamities/flooding/edit-flooding', compact('calamities', 'calamity', 'typeOfCalamities', 'subTypeOfCalamities', 'communes', 'risk_levels'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $calamity = Calamities::findOrFail($request->id);
        $validated = $request->validate([
            'name' => 'required|unique:calamities,name,' . $request->id . ',id',
            'risk_level_id' => 'required',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'sub_type_of_calamity_ids' => 'required',
            'commune_ids' => 'required',
            'map' => 'nullable|max:51200', 
        ]);
        $data = [];
        if ($request->has('deleted_maps')) {
            $deletedMaps = json_decode($request->input('deleted_maps'), true);
            if (!empty($deletedMaps)) {
                foreach ($deletedMaps as $deletedFile) {
                    @unlink(public_path($deletedFile)); 
                }
            }
        }
        
        $existingMaps = !empty($calamity->map) ? json_decode($calamity->map, true) : [];
        $existingMaps = array_diff($existingMaps, $deletedMaps ?? []); 
        if ($request->hasFile('map')) {
            $mapFiles = $request->file('map');
            $allowedMimeTypes = [
                'application/vnd.google-earth.kmz', 
                'application/vnd.google-earth.kml+xml', 
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
                $destinationPath = public_path('uploads/calamities/flooding/maps');
                $mapFile->move($destinationPath, $newFileName);
                $filePaths[] = "uploads/calamities/flooding/maps/$newFileName";
            }
            
            $data['map'] = json_encode(array_merge($existingMaps, $filePaths));
        } else {
            $data['map'] = json_encode($existingMaps); 
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
            $videoPath = $videoFile->move(public_path('uploads/calamities/flooding/videos'), $newFileName);
            $data['video'] = "uploads/calamities/flooding/videos/$newFileName";
        }
        if ($request->input('delete_video') == "1") {
            if ($calamity->video) {
                @unlink(public_path($calamity->video));
                $calamity->video = null;
            }
        }
        if ($request->hasFile('image')) {
            if ($calamity->image) {
                @unlink(public_path($calamity->image));
            }
            $imageFile = $request->file('image');
            $slugName = Str::slug(pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imagePath = $imageFile->move(public_path('uploads/calamities/flooding/images'), $newFileName);
            $data['image'] = "uploads/calamities/flooding/images/$newFileName";
        }
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['name'] = $validated['name'];
        $data['coordinates'] = $request['coordinates'];
        $data['flood_level'] = $request['flood_level'];
        $data['flood_range'] = $request['flood_range'];
        $data['flooded_area'] = $request['flooded_area'];
        $data['time_start'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->time_start)->format('Y-m-d');
        $data['time_end'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->time_end)->format('Y-m-d');
        $data['sprint_time'] = $request['sprint_time'];
        $data['reason'] = $request['reason'];
        $data['number_of_people_affected'] = $request['number_of_people_affected'];
        $data['human_damage'] = $request['human_damage'];
        $data['property_damage'] = $request['property_damage'];
        $data['damaged_infrastructure'] = $request['damaged_infrastructure'];
        $data['mitigation_measures'] = $request['mitigation_measures'];
        $data['data_source'] = $request['data_source'];
        $data['updated_by_user_id'] = $user->id;

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

       

        return redirect('/calamity/list-flooding')->with('success', 200);
    }

    public function destroy($id)
    {
        RiskLevel::destroy($id);
        $calamity = Calamities::findOrFail($id);
        $calamity->sub_type_of_calamities()->detach();
        $calamity->communes()->detach();
        $calamity->delete();
        return redirect('/calamity/list-flooding')->with('success', 200);
    }
   
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids)) {
            Calamities::whereIn('id', $ids)->delete();

            return back()->with('success', 'Xóa thành công!');
        }

        return back()->with('error', 'Không có mục nào được chọn.');
    }

}
