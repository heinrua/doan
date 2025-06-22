<?php

namespace App\Http\Controllers\ResponsePlan;

use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\District;
use App\Models\Scenario;
use App\Models\TypeOfCalamities;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// PHƯƠNG ÁN ỨNG PHÓ
class ScenarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function viewFormScenarios()
    {
        $calamities = TypeOfCalamities::get();
        $districts = District::all();
        return view('pages.response-plan.add-scenario', compact('calamities', 'districts'));
    }

    public function index(Request $request)
    {
        $typeOfCalamity = $request->input('type_of_calamity_id');
        $districtId = $request->input('district_id');

        $query = Scenario::query();
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if (!empty($typeOfCalamity)) {
            $query->where('type_of_calamity_id', $typeOfCalamity);
        }
        if (!empty($districtId)) {
            $query->where('district_id', $districtId);
        }
        $data = $query->orderByDesc('id')->paginate(10);

        $typeOfCalamities = TypeOfCalamities::all();
        $districts = District::all();
        return view('pages.response-plan.list-scenario', compact('data','typeOfCalamities','districts'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:scenarios',
            'type_of_calamity_id' => 'required',
            'district_id' => 'required',
            'short_description' => 'nullable',
            'document_text' => 'nullable',
            'status' => 'nullable',
            'documents.*' => 'mimes:pdf,doc,docx', // 10MB mỗi file
        ]);
        $calamity = TypeOfCalamities::findOrFail($validated['type_of_calamity_id']);
        if (!$calamity) {
            return redirect('/create-scenarios')->errors('Loại thiên tai không tồn tại !!!');
        }
        $district = District::findOrFail($validated['district_id']);
        if (!$district) {
            return redirect('/create-scenarios')->errors('Quận/Huyện không tồn tại !!!');
        }

        $data = [];

        if ($request->hasFile('documents')) {
            $filePaths = []; // Mảng lưu đường dẫn file
            foreach ($request->file('documents') as $mapFile) {
                // Tạo tên file mới
                $slugName = Str::slug(pathinfo($mapFile->getClientOriginalName(), PATHINFO_FILENAME));
                $timestamp = now()->format('YmdHis');
                $newFileName = "{$slugName}-{$timestamp}.{$mapFile->getClientOriginalExtension()}";
                // Lưu vào thư mục public/uploads/response-plan/documents
                $destinationPath = public_path('uploads/response-plan/documents');
                $mapFile->move($destinationPath, $newFileName);
                // Thêm đường dẫn vào danh sách
                $filePaths[] = "uploads/response-plan/documents/$newFileName";
            }
            $data['document_path'] = json_encode($filePaths);
        }
        $data['name'] = $validated['name'];
        $data['type_of_calamity_id'] = $validated['type_of_calamity_id'];
        $data['district_id'] = $validated['district_id'];
        $data['short_description'] = $validated['short_description'];
        $data['document_text'] = $validated['document_text'];
        $data['status'] = $validated['status'];
        $data['updated_time'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->updated_time)->format('Y-m-d');
        $data['created_by_user_id'] = $user->id;
        Scenario::create($data);
        return redirect('/list-scenarios');
    }

    public function show($id)
    {
        $data = Scenario::findOrFail($id);
        $calamities = TypeOfCalamities::get();
        $districts = District::get();
        return view('pages.response-plan.edit-scenario', compact('data', 'calamities', 'districts'));
    }

    public function update(Request $request)
    {
        $scenario = Scenario::findOrFail($request->id);
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|unique:scenarios,name,' . $request->id,
            'type_of_calamity_id' => 'required',
            'district_id' => 'required',
            'short_description' => 'nullable',
            'document_text' => 'nullable',
            'status' => 'nullable',
            'documents.*' => 'mimes:pdf,doc,docx', // 10MB mỗi file
        ]);
        $calamity = TypeOfCalamities::findOrFail($validated['type_of_calamity_id']);
        if (!$calamity) {
            return redirect()->back()->errors('Loại thiên tai không tồn tại !!!');
        }
        $district = District::findOrFail($validated['district_id']);
        if (!$district) {
            return redirect()->back()->errors('Quận/Huyện không tồn tại !!!');
        }
        $data = [];
        if ($request->input('delete_document') == "1") {
            @unlink(public_path($scenario->document_path)); // Xóa file khỏi server
            $data['document_path'] = null; // Cập nhật DB
        }
        if ($request->has('deleted_documents')) {
            $deletedDocuments = json_decode($request->input('deleted_documents'), true);
            if (!empty($deletedDocuments)) {
                foreach ($deletedDocuments as $deletedFile) {
                    @unlink(public_path($deletedFile)); // Xóa từng file khỏi server
                }
            }
        }
        // Lấy danh sách file cũ (trừ những file đã bị xóa)
        $existingDocuments = !empty($scenario->document_path) ? json_decode($scenario->document_path, true) : [];
        $existingDocuments = array_diff($existingDocuments, $deletedDocuments ?? []); // Loại bỏ file bị xóa
        if ($request->hasFile('documents')) {
            $documentFiles = $request->file('documents');
            $filePaths = [];
            foreach ($documentFiles as $mapFile) {
                $slugName = Str::slug(pathinfo($mapFile->getClientOriginalName(), PATHINFO_FILENAME));
                $timestamp = now()->format('YmdHis');
                $newFileName = "{$slugName}-{$timestamp}.{$mapFile->getClientOriginalExtension()}";
                $destinationPath = public_path('uploads/response-plan/documents');
                $mapFile->move($destinationPath, $newFileName);
                $filePaths[] = "uploads/response-plan/documents/$newFileName";
            }
            // Gộp danh sách file mới với danh sách file còn lại
            $data['document_path'] = json_encode(array_merge($existingDocuments, $filePaths));
        } else {
            $data['document_path'] = json_encode($existingDocuments); // Nếu không có file mới, chỉ lưu lại file còn lại
        }
        $data['name'] = $validated['name'];
        $data['district_id'] = $validated['district_id'];
        $data['short_description'] = $validated['short_description'];
        $data['document_text'] = $validated['document_text'];
        $data['status'] = $validated['status'];
        $data['updated_time'] = Carbon::createFromFormat('d \T\h\á\n\g m, Y', $request->updated_time)->format('Y-m-d');
        $data['updated_by_user_id'] = $user->id;
        $scenario->update($data);
        return redirect('/list-scenarios')->with('success', 200);
    }


    public function destroy($id)
    {
        $data = Scenario::findOrFail($id);
        $data->delete();
        return redirect('/list-scenarios')->with('success', 'Scenarios deleted successfully!');
    }
}
