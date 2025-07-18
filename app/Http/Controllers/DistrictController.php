<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
                'application/vnd.google-earth.kmz', 
                'application/vnd.google-earth.kml+xml', 
                'application/octet-stream', 
                'application/zip', 
                'text/xml',
                'text/html'
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
            $validated['map'] = json_encode($filePaths); 
        }
        District::create($validated);
        return redirect('/list-district');
    }

    public function importDistricts(Request $request)
    {
        $request->validate([
            'excelFile' => 'required|file|mimes:xlsx,csv'
        ]);
        $file = $request->file('excelFile');
        $data = Excel::toArray([], $file)[0];
        $header = array_map('trim', $data[0]);
        unset($data[0]);
                
        $requiredHeaders = ['Tên', 'Mã', 'Thành phố'];
        foreach ($requiredHeaders as $col) {
            if (!in_array($col, $header)) {
                return back()->with('error', 'Thiếu cột bắt buộc: ' . $col);
            }
        }

        foreach ($data as $row) {
            $rowData = array_combine($header, $row);
            $requiredKeys = ['Tên', 'Mã', 'Thành phố'];
            foreach ($requiredKeys as $key) {
                if (!isset($rowData[$key]) || $rowData[$key] === null || $rowData[$key] === '') {
                    return redirect()->back()->with('error', "Thiếu hoặc để trống cột '$key' trong file Excel!");
                }
            }
            if(District::where('name', $rowData['Tên'])->exists()){
                return back()->with('error', 'Huyện đã tồn tại: ' . $rowData['Tên']);
            }
            if(District::where('code', $rowData['Mã'])->exists()){
                return back()->with('error', 'Mã huyện đã tồn tại: ' . $rowData['Mã']);
            }
            $city = City::where('name', $rowData['Thành phố'])->first();
            if (!$city) {
                return back()->with('error', 'Thành phố của huyện không tồn tại: ' . $rowData['Thành phố']);
            }
            $district = District::create([
                'name' => $rowData['Tên'],
                'code' => $rowData['Mã'],
                'slug' => Str::slug($rowData['Tên']),
                'coordinates' => $rowData['Tọa độ'] ?? "0,0",
                'city_id' => $city->id,
                'population' => $rowData['Dân số'] ?? 0,
                'map' => "[]",
            ]);
            
            $district->save();
        }
        return back()->with('success', 'Import thành công!');
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
                    @unlink(public_path($deletedFile)); 
                }
            }
        }
        
        $existingMaps = !empty($district->map) ? json_decode($district->map, true) : [];
        $deletedMaps = $deletedMaps ?? [];
        $existingMaps = is_array($existingMaps) ? array_diff($existingMaps, $deletedMaps) : [];
        if ($request->hasFile('map')) {
            $mapFiles = $request->file('map');
            $allowedMimeTypes = [
                'application/vnd.google-earth.kmz', 
                'application/vnd.google-earth.kml+xml', 
                'application/octet-stream',
                'application/zip',
                'text/xml',
                'text/html'
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
            
            $validated['map'] = json_encode(array_merge($existingMaps, $filePaths));
        } else {
            $validated['map'] = json_encode($existingMaps); 
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
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Không có mục nào được chọn.');
        }

        District::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Đã xoá các mục đã chọn.');
    }

}
