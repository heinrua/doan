<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DistrictController extends Controller
{

    public function __construct()
    {
      
        
    }

    public function viewFormDistrict()
    {
        $cities = City::all();
        return view('pages/district/add-district', compact('cities'));
    }

    public function index(Request $request)
    {
       
        $type = $request->input('type');
        $search = $request->input('search');
        $query = District::query();
        if (!empty($search) && in_array($type, ['name', 'code','coordinates'])) {
            $query->where($type, 'LIKE', "%{$search}%");
        }
        $data = $query->orderByDesc('id')->paginate(10)->appends([
            'type' => $type,
            'search' => $search
        ]);
        return view('pages.district.list-district', compact('data', 'type', 'search'));
    }


    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|unique:districts',
            'code' => 'required|unique:districts',
            'city_id' => 'required',
            'coordinates' => 'required',
            'map' => 'nullable',
            'population' => 'required',
        ]);
        $slug = Str::slug($request->name);
        $count = District::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $validated['slug'] = $slug;
        
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
                $slugName = Str::slug(pathinfo($mapFile->getClientOriginalName(), PATHINFO_FILENAME)); // Tạo tên file mới
                $timestamp = now()->format('YmdHis');
                $newFileName = "{$slugName}-{$timestamp}.{$mapFile->getClientOriginalExtension()}";
                $destinationPath = public_path('uploads/districts/maps'); // Lưu vào thư mục public/uploads/districts/map
                $mapFile->move($destinationPath, $newFileName);
                $filePaths[] = "uploads/districts/maps/$newFileName"; // Thêm đường dẫn vào danh sách
            }
            $validated['map'] = json_encode($filePaths); // Lưu vào DB dưới dạng JSON
        }
        District::create($validated);
        return redirect('/list-district');
    }

    public function show($id)
    {
        $district = District::findOrFail($id);
        $cities = City::all();
        return view('pages/district/edit-district', compact('district', 'cities'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|unique:districts,name,' . $request->id . ',id',
            'code' => 'required|unique:districts,code,' . $request->id . ',id',
            'city_id' => 'required',
            'coordinates' => 'required',
            'map' => 'nullable',
            'population' => 'required'
        ]);

        $district = District::findOrFail($request->id);
        $city = City::findOrFail($request->city_id);

        $slug = $district->slug;
        if ($district->name !== $validated['name']) {
            $newSlug = Str::slug($validated['name']);
            $slugCount = District::where('slug', 'like', "{$newSlug}%")->where('id', '!=', $district->id)->count();
            if ($slugCount > 0) {
                $slug = "{$newSlug}-{$slugCount}";
            } else {
                $slug = $newSlug;
            }
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
        $existingMaps = !empty($district->map) ? json_decode($district->map, true) : [];
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
                $destinationPath = public_path('uploads/districts/maps');
                $mapFile->move($destinationPath, $newFileName);
                $filePaths[] = "uploads/districts/maps/$newFileName";
            }
            // Gộp danh sách file mới với danh sách file còn lại
            $validated['map'] = json_encode(array_merge($existingMaps, $filePaths));
        } else {
            $validated['map'] = json_encode($existingMaps); // Nếu không có file mới, chỉ lưu lại file còn lại
        }
        $district->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'code' => $validated['code'],
            'coordinates' => $validated['coordinates'],
            'map' => $validated['map'],
            'population' => $validated['population'],
            'city_id' => $validated['city_id'],
            
        ]);

        return redirect('/list-district')->with('success', 'District updated successfully.');
    }


    public function destroy($id)
    {
        $district = District::findOrFail($id);
        $district->delete();
        return redirect('/list-district')->with('success', 'District deleted successfully!');
    }
}
