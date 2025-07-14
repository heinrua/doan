<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\GeographicalData;
use App\Models\TypeOfCalamities;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GeographicalDataController extends Controller
{
    protected $paths = [
        'erosion'       => 'geographical/erosion',
        'shoreline'     => 'geographical/shoreline',
        'cross-section' => 'geographical/cross-section',
        'monitoring'    => 'geographical/monitoring',
    ];

    protected $redirectRoutes = [
        'erosion'       => 'view-erosion',
        'shoreline'     => 'view-shoreline',
        'cross-section' => 'view-cross-section',
        'monitoring'    => 'view-monitoring',
    ];

    public function index($type)
    {
        $data = GeographicalData::where('type', $type)->orderByDesc('id')->paginate(10);
        return view("pages/geographical/{$type}/list-{$type}", compact('data'));
    }

    public function viewForm($type)
    {
        $calamities = TypeOfCalamities::all();
        $communes = Commune::all();
        return view("pages/geographical/{$type}/add-{$type}", compact('calamities', 'communes'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $this->validateRequest($request);
        $validated['last_updated'] = $this->formatDate($request->last_updated);
        $validated['created_by_user_id'] = $user->id;
        foreach (['map', 'video', 'image'] as $fileType) {
            $validated[$fileType] = $this->saveFile($request, $fileType, $validated['type']);
        }

        GeographicalData::create($validated);
        return redirect()->route($this->redirectRoutes[$validated['type']])->with('success', 'Dữ liệu đã được lưu thành công!');
    }

    public function show($id)
    {
        $data = GeographicalData::findOrFail($id);
        $calamities = TypeOfCalamities::all();
        $communes = Commune::all();
        return view("pages/geographical/{$data->type}/edit-{$data->type}", compact('data', 'calamities', 'communes'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $geographicalData = GeographicalData::findOrFail($request->id);
        $validated = $this->validateRequest($request, $geographicalData->id);
        $validated['last_updated'] = $this->formatDate($request->last_updated);
        $validated['updated_by_user_id'] = $user->id();

        foreach (['map', 'video', 'image'] as $fileType) {
            $validated[$fileType] = $this->saveFile($request, $fileType, $validated['type'], $geographicalData->$fileType);
        }

        $geographicalData->update($validated);
        return redirect()->route($this->redirectRoutes[$validated['type']])->with('success', 'Dữ liệu đã được cập nhật thành công!');
    }

    public function destroy($id, Request $request)
    {
        $type = $request->query('type'); 

        GeographicalData::destroy($id);

        return redirect()->route("view-$type")->with('success', 'Xóa thành công!');
    }

    public function destroyMultiple(Request $request)
    {
        $type = $request->input('type');
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return back()->with('error', 'Vui lòng chọn ít nhất một bản ghi để xóa');
        }

        foreach ($ids as $id) {
            $geographicalData = GeographicalData::find($id);

            if ($geographicalData && $geographicalData->type === $type) {
                // Xóa file nếu có
                foreach (['image', 'video', 'map'] as $field) {
                    if (!empty($geographicalData->$field) && file_exists(public_path($geographicalData->$field))) {
                        unlink(public_path($geographicalData->$field));
                    }
                }

                $geographicalData->delete();
            }
        }

        return back()->with('success', 'Đã xóa các bản ghi đã chọn!');
    }


    private function validateRequest($request, $id = null)
    {  
        return $request->validate([
            'name' => "required|string|unique:geographical_data,name,$id,id",
            'type' => 'required|string|in:erosion,shoreline,cross-section,monitoring',
            'type_of_calamity_id' =>'required',
            'commune_id' => 'required',
            'category' => 'nullable|string',
            'progress' => 'nullable|string',
            'start_year' => 'nullable|integer',
            'end_year' => 'nullable|integer',
            'area' => 'nullable|numeric',
            'scale' => 'nullable|string',
            'impact_level' => 'nullable|string',
            'coordinates' => 'nullable',
            'total_investment' => 'nullable',
            'funding_source' => 'nullable|string',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'start_coordinates' => 'nullable',
            'end_coordinates' => 'nullable',
            'survey_year' => 'nullable|integer',
            'reference_number' => 'nullable|string',
            'monitoring_position' => 'nullable|string',
            'river' => 'nullable|string',
            'elevation_z' => 'nullable|numeric',
            'description' => 'nullable|string',
            'last_updated'=> 'nullable|string',
            'video' => 'nullable|file|mimes:mp4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'map' => 'nullable|max:51200',
            'population'=>'nullable|numeric',
        ]);
    }

    private function formatDate($date)
    {
        return $date ? Carbon::createFromFormat('d \T\h\á\n\g m, Y', $date)->format('Y-m-d') : null;
    }

    private function saveFile($request, $field, $type, $oldFile = null)
    {
        if (!$request->hasFile($field)) {
            return $oldFile;
        }

        $file = $request->file($field);
        $slugName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $timestamp = now()->format('YmdHis');
        $newFileName = "{$slugName}-{$timestamp}.{$file->getClientOriginalExtension()}";

        $folderPath = public_path("uploads/geographical/{$type}/{$field}s");

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $filePath = "uploads/geographical/{$type}/{$field}s/{$newFileName}";

        $file->move($folderPath, $newFileName);

        if ($oldFile && file_exists(public_path($oldFile))) {
            unlink(public_path($oldFile));
        }

        return $filePath;
    }
}
