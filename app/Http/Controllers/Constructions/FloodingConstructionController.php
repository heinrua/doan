<?php

namespace App\Http\Controllers\Constructions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use App\Models\SubTypeOfCalamities;
use App\Models\Commune;
use App\Models\Construction;
use App\Models\District;
use App\Models\TypeOfConstruction;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class FloodingConstructionController extends Controller
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
        $type_of_construction = $request->input('type_of_construction');

        $query = Construction::whereRelation('risk_level.type_of_calamities', 'slug', 'ngap-lut')
            ->with(['type_of_constructions', 'commune']);

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        if (!empty($commune_id) && !empty($district_id)) {
            $validCommune = Commune::where('id', $commune_id)->where('district_id', $district_id)->exists();
            if ($validCommune) {
                $query->whereHas('commune', function ($q) use ($commune_id) {
                    $q->where('id', $commune_id);
                });
            } else {
                $query->whereRaw('1 = 0'); 
            }
        } elseif (!empty($commune_id)) {
            $query->whereHas('commune', function ($q) use ($commune_id) {
                $q->where('id', $commune_id);
            });
        } elseif (!empty($district_id)) {
            $query->whereHas('commune', function ($q) use ($district_id) {
                $q->where('district_id', $district_id);
            });
        }
        if (!empty($type_of_construction)) {
            $query->whereHas('type_of_constructions', function ($q) use ($type_of_construction) {
                $q->where('id', $type_of_construction);
            });
        }
        $data = $query->orderByDesc('id')->paginate(10)->appends([
            'search' => $search,
            'district_id' => $district_id,
            'commune_id' => $commune_id,
            'type_of_construction' => $type_of_construction,
        ]);
        $districts = District::all();
        $typeOfConstructions = TypeOfConstruction::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        return view('pages/constructions/flooding/list-flooding', compact('data', 'typeOfConstructions', 'districts'));
    }

    public function viewFormFlooding()
    {
        $calamities = TypeOfCalamities::where('slug', 'ngap-lut')->get();
        $typeOfConstructions = TypeOfConstruction::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        return view('pages/constructions/flooding/add-flooding', compact('calamities', 'communes', 'typeOfConstructions', 'risk_levels'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:constructions',
            'type_of_construction_id' => 'required',
            'risk_level_id' => 'required',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        $data = [
            'name' => $validated['name'],
            'risk_level_id' => $validated['risk_level_id'],
            'type_of_construction_id' => $validated['type_of_construction_id'],
            'commune_id' => $request['commune_id'],
            'year_of_construction' => $request['year_of_construction'],
            'year_of_completion' => $request['year_of_completion'],
            'scale' => $request['scale'],
            'coordinates' => $request['coordinates'],
            'address' => $request['address'],
            'main_function' => $request['main_function'],
            'characteristic' => $request['characteristic'],
            'width_of_door' => $request['width_of_door'],
            'base_level' => $request['base_level'],
            'pillar_top_level' => $request['pillar_top_level'],
            'total_door_width' => $request['total_door_width'],
            'notes' => $request['notes'],
            'operation_method' => $request['operation_method'],
            'irrigation_system' => $request['irrigation_system'],
            'irrigation_area' => $request['irrigation_area'],
            'culver_type' => $request['culver_type'],
            'culver_code' => $request['culver_code'],
            'management_unit' => $request['management_unit'],
            'update_time' => Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->update_time)->format('Y-m-d'),
            'created_by_user_id' => $user->id
        ];
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $originalName = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoFile->move(public_path('uploads/constructions/flooding/videos'), $newFileName);
            $data['video'] = "uploads/constructions/flooding/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imageFile->move(public_path('uploads/constructions/flooding/images'), $newFileName);
            $data['image'] = "uploads/constructions/flooding/images/$newFileName";
        }
        $slug = Str::slug($request->name);
        $count = Construction::where('slug', 'like', "{$slug}%")->count();
        $data['slug'] = $count > 0 ? "{$slug}-{$count}" : $slug;

        $construction = Construction::create($data);

        
        return redirect('/construction/list-flooding')->with('success', "Thêm thành công");
    }

    public function show($id)
    {
        $calamities = TypeOfCalamities::where('slug', 'ngap-lut')->get();
        $construction = Construction::findOrFail($id);
        $typeOfConstructions = TypeOfConstruction::where('type_of_calamity_id', $construction->risk_level->type_of_calamity_id)->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'ngap-lut')->get();
        return view('pages/constructions/flooding/edit-flooding', compact('calamities', 'construction', 'typeOfConstructions', 'communes', 'risk_levels'));
    }
    public function importFloodingConstruction(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'excelFile' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        $file = $request->file('excelFile');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slugName = Str::slug($originalName);
        $timestamp = now()->format('YmdHis');
        $newFileName = "{$slugName}-{$timestamp}.{$file->getClientOriginalExtension()}";
        $file->move(public_path('uploads/constructions/flooding/imports'), $newFileName);
        $filePath = public_path('uploads/constructions/flooding/imports/' . $newFileName);
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        
        // Bỏ qua dòng đầu tiên (dòng tiêu đề)
        $header = array_shift($rows);
        
        foreach ($rows as $row) {
            // Tạo mảng associative từ header và data
            $rowData = array_combine($header, $row);
            
            $requiredKeys = [
                'Tên công trình',
                'Loại công trình',
                'Cấp độ',
                
            ];
            foreach ($requiredKeys as $key) {
                if (!isset($rowData[$key]) || $rowData[$key] === null || $rowData[$key] === '') {
                    return redirect()->back()->with('error', "Thiếu hoặc để trống cột '$key' trong file Excel!");
                }
            }
            // Kiểm tra trùng lặp theo tên công trình
            $exists = Construction::where('name', $rowData["Tên công trình"])->exists();
            if ($exists) {
                \Log::info("Bỏ qua do trùng tên công trình: " . $rowData["Tên công trình"]);
                continue;
            }
            $data = [
                'name' => $rowData["Tên công trình"],
                'slug' => $this->generateUniqueSlug($rowData["Tên công trình"]),
                'risk_level_id' => RiskLevel::where('name', $rowData["Cấp độ"])->first()->id,
                'type_of_construction_id' => TypeOfConstruction::where('name', $rowData["Loại công trình"])->first()->id,
                'commune_id' => Commune::where('name', $rowData["Xã"])->first()->id,
                'year_of_construction' => $rowData["Năm xây dựng"],
                'year_of_completion' => $rowData["Năm hoàn thành"],
                'scale' => $rowData["Quy mô"],
                'coordinates' => $rowData["Toạ độ"],
                'address' => $rowData["Vị trí công trình"],
                'main_function' => $rowData["Chức năng chính"],
                'characteristic' => $rowData["Đặc điểm nhận dạng"],
                'width_of_door' => $rowData["Bề rộng 1 cửa"],
                'base_level' => $rowData["Cao trình đáy"],
                'pillar_top_level' => $rowData["Cao trình đỉnh trụ pin"],
                'total_door_width' => $rowData["Tổng bề rộng cửa"],
                'notes' => $rowData["Ghi chú"],
                'operation_method' => $rowData["Hình thức vận hành"],
                'irrigation_system' => $rowData["Hệ thống thuỷ lợi"],
                'irrigation_area' => $rowData["Vùng thuỷ lợi"],
                'culver_type' => $rowData["Loại cống"],
                'culver_code' => $rowData["Mã cống"],
                'management_unit' => $rowData["Đơn vị quản lý"],
                'update_time' => $this->parseDate($rowData["Thời gian cập nhật"]),
                'created_by_user_id' => $user->id
            ];
            
            try {
                $construction = Construction::create($data);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == 23000 && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    return redirect()->back()->with('error', "Công trình '{$rowData['Tên công trình']}' đã tồn tại trong hệ thống!");
                }
                return redirect()->back()->with('error', "Lỗi khi thêm công trình: " . $e->getMessage());
            }
        }
        return redirect('/construction/list-flooding')->with('success', "Nhập thành công");
    }

    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }
        
        // Thử các format khác nhau
        $formats = [
            'd \T\h\á\n\g m, Y',  // 10 tháng 7, 2025
            'd/m/Y',               // 10/7/2025
            'Y-m-d',               // 2025-07-10
            'd-m-Y',               // 10-7-2025
            'm/d/Y',               // 7/10/2025
        ];
        
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }
        
        // Nếu không parse được, trả về null
        return null;
    }

    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Construction::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        return $slug;
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $construction = Construction::findOrFail($request->id);
        $validated = $request->validate([
            'name' => 'required|unique:constructions,name,' . $request->id,
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'type_of_construction_id' => 'required',
            'commune_id' => 'required',
            'risk_level_id' => 'required',
        ]);

        $data = [
            'name' => $validated['name'],
            'type_of_construction_id' => $validated['type_of_construction_id'],
            'risk_level_id' => $validated['risk_level_id'],
            'commune_id' => $request['commune_id'],
            'year_of_construction' => $request['year_of_construction'],
            'year_of_completion' => $request['year_of_completion'],
            'scale' => $request['scale'],
            'coordinates' => $request['coordinates'],
            'address' => $request['address'],
            'main_function' => $request['main_function'],
            'characteristic' => $request['characteristic'],
            'width_of_door' => $request['width_of_door'],
            'base_level' => $request['base_level'],
            'pillar_top_level' => $request['pillar_top_level'],
            'total_door_width' => $request['total_door_width'],
            'notes' => $request['notes'],
            'operation_method' => $request['operation_method'],
            'irrigation_system' => $request['irrigation_system'],
            'irrigation_area' => $request['irrigation_area'],
            'culver_type' => $request['culver_type'],
            'culver_code' => $request['culver_code'],
            'management_unit' => $request['management_unit'],
            'update_time' => Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->update_time)->format('Y-m-d'),
            'updated_by_user_id'=>$user->id
        ];
        if ($request->hasFile('video')) {
            if ($construction->video) {
                @unlink(public_path($construction->video));
            }
            $videoFile = $request->file('video');
            $slugName = Str::slug(pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoPath = $videoFile->move(public_path('uploads/constructions/flooding/videos'), $newFileName);
            $data['video'] = "uploads/constructions/flooding/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            if ($construction->image) {
                @unlink(public_path($construction->image));
            }
            $imageFile = $request->file('image');
            $slugName = Str::slug(pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imagePath = $imageFile->move(public_path('uploads/constructions/flooding/images'), $newFileName);
            $data['image'] = "uploads/constructions/flooding/images/$newFileName";
        }

        $slug = Str::slug($request->name);
        $count = Construction::where('slug', 'like', "{$slug}%")->where('id', '!=', $request->id)->count();
        $data['slug'] = $count > 0 ? "{$slug}-{$count}" : $slug;

        $construction->update($data);

        return redirect('/construction/list-flooding')->with('success', "Cập nhật thành công");
    }

    public function destroy($id)
    {
        $construction = Construction::findOrFail($id);
        $construction->commune()->detach();
        $construction->delete();
        return redirect('/construction/list-flooding')->with('success', "Xóa thành công");
    }
    public function destroyMultiple(Request $request)
    {
        $ids = $request->ids;
        Construction::whereIn('id', $ids)->delete();
        return redirect('/construction/list-flooding')->with('success', "Xóa thành công");
    }
}
