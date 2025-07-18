<?php

namespace App\Http\Controllers\Constructions;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use Illuminate\Http\Request;
use App\Models\RiskLevel;
use App\Models\TypeOfCalamities;
use App\Models\TypeOfConstruction;
use App\Models\Construction;
use App\Models\District;
use App\Models\SubTypeOfCalamities;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
class RiverBankConstructionController extends Controller
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

        $query = Construction::whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')
            ->with(['risk_level', 'commune']);

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
        if (!empty($risk_level_id)) {
            $query->whereHas('risk_level', function ($q) use ($risk_level_id) {
                $q->where('id', $risk_level_id);
            });
        }
        $data = $query->orderByDesc('id')->paginate(10)->appends([
            'search' => $search,
            'district_id' => $district_id,
            'commune_id' => $commune_id,
            'risk_level_id' => $risk_level_id,
        ]);
        $districts = District::all();
        $riskLevels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->get();
        return view('pages/constructions/river-bank/list-river-bank', compact('data', 'riskLevels', 'districts'));
    }
    public function viewFormRiverbank()
    {
        $calamities = TypeOfCalamities::where('slug', 'sat-lo-bo-song-bo-bien')->get();
        $typeOfConstructions = TypeOfConstruction::whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->get();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->get();
        $communes = Commune::all();
        return view('pages/constructions/river-bank/add-river-bank', compact('calamities', 'risk_levels', 'communes', 'typeOfConstructions'));
    }

    public function store(Request $request)
    {

        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:constructions',
            'risk_level_id' => 'required',
            'type_of_construction_id' => 'required',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
        ]);

        $data = [];
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $originalName = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoFile->move(public_path('uploads/constructions/river-bank/videos'), $newFileName);
            $data['video'] = "uploads/constructions/river-bank/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $slugName = Str::slug($originalName);
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imageFile->move(public_path('uploads/constructions/river-bank/images'), $newFileName);
            $data['image'] = "uploads/constructions/river-bank/images/$newFileName";
        }
       
        $data['type_of_construction_id'] = $validated['type_of_construction_id'];
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['commune_id'] = $request['commune_id'];
        $data['name'] = $validated['name'];
        $data['progress'] = $request['progress'];
        $data['year_of_construction'] = $request['year_of_construction'];
        $data['year_of_completion'] = $request['year_of_completion'];
        $data['length'] = $request['length'];
        $data['width'] = $request['width'];
        $data['scale'] = $request['scale'];
        $data['geology'] = $request['geology'];
        $data['influence_level'] = $request['influence_level'];
        $data['coordinates'] = $request['coordinates'];
        $data['total_investment'] = $request['total_investment'];
        $data['capital_source'] = $request['capital_source'];
        $data['created_by_user_id'] = $user->id;

        $slug = Str::slug($request->name);
        $count = Construction::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $data['slug'] = $slug;
        $construction = Construction::create($data);
        
        return redirect('/construction/list-river-bank')->with('success', "Thêm thành công");
    }
    public function importRiverBankConstruction(Request $request)
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
        $file->move(public_path('uploads/constructions/river-bank/imports'), $newFileName);
        $filePath = public_path('uploads/constructions/river-bank/imports/' . $newFileName);
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
                'Cấp độ rủi ro thiên tai',
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
                'risk_level_id' => RiskLevel::where('name', $rowData["Cấp độ rủi ro thiên tai"])->first()->id,
                'type_of_construction_id' => TypeOfConstruction::where('name', $rowData["Loại công trình"])->first()->id,
                'commune_id' => Commune::where('name', $rowData["Phường/Xã"])->first()->id,
                'year_of_construction' => $rowData["Năm xây dựng"],
                'year_of_completion' => $rowData["Năm hoàn thành"],
                'length' => $rowData["Chiều dài (km)"],
                'width' => $rowData["Chiều rộng (m)"],
                'scale' => $rowData["Quy mô"],
                'influence_level' => $rowData["Mức độ ảnh hưởng"],
                'coordinates' => $rowData["Toạ độ"],
                'total_investment' => $rowData["Tổng mức đầu tư"],
                'capital_source' => $rowData["Nguồn vốn"],
                'progress' => $rowData["Tiến độ thực hiện"],
                'created_by_user_id' => $user->id,
                'update_time' => $this->parseDate($rowData["Thời gian cập nhật"]),
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
        return redirect('/construction/list-river-bank')->with('success', "Nhập thành công");
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

    public function show($id)
    {
        $calamities = TypeOfCalamities::where('slug', 'sat-lo-bo-song-bo-bien')->get();
        $construction = Construction::findOrFail($id);
        $typeOfConstructions = TypeOfConstruction::where('type_of_calamity_id', $construction->risk_level->type_of_calamity_id)->get();
        $communes = Commune::all();
        $risk_levels = RiskLevel::whereRelation('type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')->get();

        return view('pages/constructions/river-bank/edit-river-bank', compact('calamities', 'construction', 'typeOfConstructions', 'communes', 'risk_levels'));
    }

    public function update(Request $request)
    {
        
        $user = auth()->user();
        $construction = Construction::findOrFail($request->id);

        $validated = $request->validate([
            'name' => 'required|unique:constructions,name,' . $request->id,
            'type_of_construction_id' => 'required',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'risk_level_id' => 'required',
        ]);

        $data = $validated;
        if ($request->hasFile('video')) {
            if ($construction->video) {
                @unlink(public_path($construction->video));
            }
            $videoFile = $request->file('video');
            $slugName = Str::slug(pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$videoFile->getClientOriginalExtension()}";
            $videoPath = $videoFile->move(public_path('uploads/constructions/river-bank/videos'), $newFileName);
            $data['video'] = "uploads/constructions/river-bank/videos/$newFileName";
        }
        if ($request->hasFile('image')) {
            if ($construction->image) {
                @unlink(public_path($construction->image));
            }
            $imageFile = $request->file('image');
            $slugName = Str::slug(pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME));
            $timestamp = now()->format('YmdHis');
            $newFileName = "{$slugName}-{$timestamp}.{$imageFile->getClientOriginalExtension()}";
            $imagePath = $imageFile->move(public_path('uploads/constructions/river-bank/images'), $newFileName);
            $data['image'] = "uploads/constructions/river-bank/images/$newFileName";
        }
        $data['type_of_construction_id'] = $validated['type_of_construction_id'];
        $data['risk_level_id'] = $validated['risk_level_id'];
        $data['commune_id'] = $request['commune_id'];
        $data['progress'] = $request['progress'];
        $data['year_of_construction'] = $request['year_of_construction'];
        $data['year_of_completion'] = $request['year_of_completion'];
        $data['length'] = $request['length'];
        $data['width'] = $request['width'];
        $data['scale'] = $request['scale'];
        $data['geology'] = $request['geology'];
        $data['influence_level'] = $request['influence_level'];
        $data['coordinates'] = $request['coordinates'];
        $data['total_investment'] = $request['total_investment'];
        $data['capital_source'] = $request['capital_source'];
        $data['updated_by_user_id'] = $user->id;

        $slug = Str::slug($request->name);
        $count = Construction::where('slug', 'like', "{$slug}%")->where('id', '!=', $request->id)->count();
        if ($count > 0) {
            $slug = "{$slug}-{$count}";
        }
        $data['slug'] = $slug;

        $construction->update($data);
        
        return redirect('/construction/list-river-bank')->with('success', "Cập nhật thành công");
    }

    public function destroy($id)
    {
        $calamity = Construction::findOrFail($id);
        $calamity->communes()->detach();
        $calamity->delete();
        return redirect('/construction/list-river-bank')->with('success', "Xóa thành công");
    }
    public function destroyMultiple(Request $request)
    {
        $ids = $request->ids;
        Construction::whereIn('id', $ids)->delete();
        return redirect('/construction/list-river-bank')->with('success', "Xóa thành công");
    }
}
