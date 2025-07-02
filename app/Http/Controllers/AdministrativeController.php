<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Administrative;
use App\Models\District;
use App\Models\TypeOfCalamities;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdministrativeController extends Controller
{
    protected $paths = [
        'school'       => 'administrative/school',
        'medical'     => 'administrative/medical',
        'center'    => 'administrative/center',
    ];

    protected $redirectRoutes = [
        'school'       => 'view-school',
        'medical'     => 'view-medical',
        'center'    => 'view-center',
    ];

    public function index(Request $request, $type)
    {
        $district_id = $request->input('district_id');
        $commune_id = $request->input('commune_id');
        $query = Administrative::query()->with('communes');
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
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
        $data = $query->where('type', $type)->orderByDesc('id')->paginate(10)->appends([
            'district_id' => $district_id,
            'commune_id' => $commune_id,
        ]);
        $districts = District::all();
        return view("pages/administrative/{$type}/list-{$type}", compact('data', 'type', 'districts'));
    }


    public function viewForm($type)
    {
        $communes = Commune::all();
        $districts = District::all();
        return view("pages/administrative/{$type}/add-{$type}", compact('communes', 'districts'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        Administrative::create($validated);
        return redirect()->route($this->redirectRoutes[$validated['type']])->with('success', 'Dữ liệu đã được lưu thành công!');
    }

    public function show($id)
    {
        $data = Administrative::findOrFail($id);
        $districts = District::all();
        $communes = Commune::all();
        return view("pages/administrative/{$data->type}/edit-{$data->type}", compact('data', 'communes', 'districts'));
    }

    public function update(Request $request)
    {
        $administrative = Administrative::findOrFail($request->id);
        $validated = $this->validateRequest($request, $administrative->id);

        $administrative->update($validated);
        return redirect()->route($this->redirectRoutes[$validated['type']])->with('success', 'Dữ liệu đã được cập nhật thành công!');
    }

    public function destroy($id, Request $request)
    {
        $type = $request->query('type'); // Lấy type từ query string (nếu có)

        Administrative::destroy($id);

        return redirect()->route("view-$type")->with('success', 'Xóa thành công!');
    }
    

    private function validateRequest($request, $id = null)
    {
        return $request->validate([
            'name' => "required|string|unique:administratives,name,$id,id",
            'type' => 'required|string|in:school,medical,center',
            'commune_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'coordinates' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'code' => 'nullable|string',
            'classify' => 'nullable|string',
            'population' => 'nullable',
        ]);
    }
}
