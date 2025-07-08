<?php

namespace App\Http\Controllers\Calamities;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use Illuminate\Http\Request;
use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use App\Models\SubTypeOfCalamities;
use App\Models\Calamities;
use App\Models\District;
use App\Models\DisasterSubscription;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class RiverBankCalamityController extends Controller
{
    public function __construct()
    {
       
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $district_id = $request->input('district_id');
        $commune_id = $request->input('commune_id');
        $risk_level_id = $request->input('risk_level_id');
        $year_id = $request->input('year_id');

        $query = Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')
            ->with(['risk_level', 'communes']);

        if (!empty($year_id)) {
            $query->whereYear('time', $year_id);
        }
        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
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
        $riskLevels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->get();
        $years = Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->selectRaw('YEAR(time) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
        return view('pages/calamities/river-bank/list-river-bank', compact('data', 'sub_typeCalamities', 'riskLevels', 'districts','years'));
    }

    public function viewFormRiverbank()
    {
        $calamities = TypeOfCalamities::where('slug', 'sat-lo-bo-song-bo-bien')->get();
        $sub_calamities = SubTypeOfCalamities::whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->get();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->get();
        $communes = Commune::all();
        return view('pages/calamities/river-bank/add-river-bank', compact('calamities', 'sub_calamities', 'risk_levels', 'communes'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:calamities',
            'type_of_calamity_id' => 'required',
            'risk_level_id' => 'required',
            'map' => 'nullable|max:51200',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
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
                
                $destinationPath = public_path('uploads/calamities/river-bank/maps');
                $mapFile->move($destinationPath, $newFileName);
                
                $filePaths[] = "uploads/calamities/river-bank/maps/$newFileName";
            }
            
            $data['map'] = json_encode($filePaths);
        }
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $originalName = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoFile->move(public_path('uploads/calamities/river-bank/videos'), $newFileName);
            $data['video'] = "uploads/calamities/river-bank/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imageFile->move(public_path('uploads/calamities/river-bank/images'), $newFileName);
            $data['image'] = "uploads/calamities/river-bank/images/$newFileName";
        }
        $data['type_of_calamity_id'] = $validated['type_of_calamity_id'];
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['name'] = $validated['name'];

        $data['address'] = $request['address'];
        $data['length'] = $request['length'];
        $data['width'] = $request['width'];
        $data['acreage'] = $request['acreage'];
        $data['coordinates'] = $request['coordinates'];
        $data['time'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->selected_date)->format('Y-m-d');
        $data['reason'] = $request['reason'];
        $data['geology'] = $request['geology'];
        $data['watermark_points'] = $request['watermark_points'];
        $data['human_damage'] = $request['human_damage'];
        $data['property_damage'] = $request['property_damage'];
        $data['investment_level'] = $request['investment_level'];
        $data['mitigation_measures'] = $request['mitigation_measures'];
        $data['support_policy'] = $request['support_policy'];
        $data['created_by_user_id'] = $user->id;

        $slug = Str::slug($request->name);
        $count = Calamities::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $data['slug'] = $slug;
        $calamities = Calamities::create($data);

        if (isset($request['commune_id'])) {
            $calamities->communes()->sync($request['commune_id']);
        }

        if ($request->has('sub_type_of_calamity_id')) {
            $calamities->sub_type_of_calamities()->sync($request->sub_type_of_calamity_id);
        }
        
        $subscribers = DisasterSubscription::all();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(
                new CalamityCreated($calamity, $subscriber->name)
            );
        }
        
        return redirect('/calamity/list-river-bank')->with('success', 200);
    }
    public function importRiverbank(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);
        $file = $request->file('file');
        $data = Excel::toArray([], $file)[0];
        $header = array_map('trim', $data[0]);
        unset($data[0]);
        foreach ($data as $row) {
            $row = array_combine($header, $row);
            $calamity = Calamities::create([
                'name' => $row['Tên thiên tai'],
                'type_of_calamity_id' => TypeOfCalamities::where('name', $row['Loại thiên tai'])->first()->id,
                'risk_level_id' => RiskLevel::where('name', $row['Mức độ nguy hiểm'])->first()->id,
                'time' => $row['Thời gian'],
                'address' => $row['Địa chỉ'],
                'length' => $row['Chiều dài'],
                'width' => $row['Chiều rộng'],
                'acreage' => $row['Diện tích'],
                'coordinates' => $row['Toạ độ'],
                'reason' => $row['Lý do'],
                'geology' => $row['Địa chất'],
                'watermark_points' => $row['Điểm đánh dấu'],
                'human_damage' => $row['Thiệt hại con người'],
                'property_damage' => $row['Thiệt hại tài sản'],
                'investment_level' => $row['Mức đầu tư'],
                'mitigation_measures' => $row['Biện pháp khắc phục'],
                'support_policy' => $row['Chính sách hỗ trợ'],
                'created_by_user_id' => $user->id,
            ]); 
            $calamity->communes()->sync(Commune::where('name', $row['Xã'])->first()->id);
            $calamity->sub_type_of_calamities()->sync(SubTypeOfCalamities::where('name', $row['Loại thiên tai'])->first()->id);
            $calamity->save();
            
        }   
        return back()->with('success', 'Import thành công!');
        return back()->with('error', 'Import thất bại!');
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
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->get();
        $calamities = TypeOfCalamities::where('slug', 'sat-lo-bo-song-bo-bien')->get();

        return view('pages/calamities/river-bank/edit-river-bank', compact('calamities', 'calamity', 'typeOfCalamities', 'subTypeOfCalamities', 'communes', 'risk_levels'));
    }

    public function update(Request $request)
    {
        $calamity = Calamities::findOrFail($request->id);
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:calamities,name,' . $request->id,
            'risk_level_id' => 'required',
            'map' => 'nullable|file|mimes:kml,kmz,json',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'map' => 'nullable|max:51200',
        ]);
        $data = $validated;
        if ($request->input('delete_map') == "1") {
            @unlink(public_path($calamity->map)); 
            $data['map'] = null; 
        }
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
                $destinationPath = public_path('uploads/calamities/river-bank/maps');
                $mapFile->move($destinationPath, $newFileName);
                $filePaths[] = "uploads/calamities/river-bank/maps/$newFileName";
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
            $videoPath = $videoFile->move(public_path('uploads/calamities/river-bank/videos'), $newFileName);
            $data['video'] = "uploads/calamities/river-bank/videos/$newFileName";
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
            $imagePath = $imageFile->move(public_path('uploads/calamities/river-bank/images'), $newFileName);
            $data['image'] = "uploads/calamities/river-bank/images/$newFileName";
        }
        $data['address'] = $request['address'];
        $data['length'] = $request['length'];
        $data['width'] = $request['width'];
        $data['acreage'] = $request['acreage'];
        $data['coordinates'] = $request['coordinates'];
        $data['time'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->selected_date)->format('Y-m-d');
        $data['reason'] = $request['reason'];
        $data['geology'] = $request['geology'];
        $data['watermark_points'] = $request['watermark_points'];
        $data['human_damage'] = $request['human_damage'];
        $data['property_damage'] = $request['property_damage'];
        $data['investment_level'] = $request['investment_level'];
        $data['mitigation_measures'] = $request['mitigation_measures'];
        $data['support_policy'] = $request['support_policy'];
        $data['update_by_user_id'] = $user->id;

        $slug = Str::slug($request->name);
        $count = Calamities::where('slug', 'like', "$slug%")
            ->where('id', '!=', $request->id)
            ->count();
        if ($count > 0) {
            $slug = "$slug-$count";
        }
        $data['slug'] = $slug;

        $calamity->update($data);

        if (isset($request['commune_id'])) {
            $calamity->communes()->sync($request['commune_id']);
        }
        if (isset($request->sub_type_of_calamity_id)) {
            $calamity->sub_type_of_calamities()->sync($request->sub_type_of_calamity_id);
        }

        return redirect('/calamity/list-river-bank')->with('success', 200);
    }

    public function destroy($id)
    {
        $calamity = Calamities::findOrFail($id);
        $calamity->sub_type_of_calamities()->detach();
        $calamity->communes()->detach();
        $calamity->delete();
        return redirect('/calamity/list-river-bank')->with('success', 200);
    }

    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Không có mục nào được chọn.');
        }

        Calamities::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Đã xoá các mục đã chọn.');
    }

}
