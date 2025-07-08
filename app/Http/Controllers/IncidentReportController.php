<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncidentReport;
use App\Models\TypeOfCalamities;
use App\Models\SubTypeOfCalamities;
use App\Models\Commune;
use Illuminate\Support\Str;

class IncidentReportController extends Controller
{
    public function index()
    {
       
        $typeOfCalamities = TypeOfCalamities::all();
        $communes = Commune::all();
        $data = IncidentReport::with(['sub_type_of_calamity.type_of_calamities', 'commune'])->orderByDesc('id')->paginate(10);
        return view('pages.incident_report', compact('data','typeOfCalamities','communes'));
    }

    public function create()
    {
        $typeOfCalamities = TypeOfCalamities::all();
        $communes = Commune::all();
        return view('pages.incident_report', compact('typeOfCalamities','communes'));
    }
    
   public function getSubTypeOfCalamities(Request $request)
    {
        $calamityId = $request->query('calamity_id');
        
        if (!$calamityId) {
            return response()->json([]);
        }
        
        $subTypes = SubTypeOfCalamities::where('type_of_calamity_id', $calamityId)->get();
        
        return response()->json($subTypes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporter_name'         => 'required|string|max:255',
            'contact_number'        => 'nullable|string|max:20',
            'coordinates'           => 'required|string|max:255',
            'commune_id'            => 'required|exists:communes,id',
            'sub_type_of_calamity_id'  => 'required|integer|exists:sub_type_of_calamities,id', 
            'description'           => 'nullable|string',
            'attachment.*'          => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:20480', 
        ]);

        $attachments = [];
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $slugName = Str::slug($originalName);
                $timestamp = now()->format('YmdHis');
                $newFileName = "{$slugName}-{$timestamp}.{$file->getClientOriginalExtension()}";
                $file->move(public_path('uploads/incident-reports'), $newFileName);
                $attachments[] = "uploads/incident-reports/$newFileName";
            }
        }

        $validated['attachment'] = !empty($attachments) ? json_encode($attachments) : null;

        $report = IncidentReport::create($validated);

        return redirect()->back()->with('success', 'Báo cáo sự cố đã được gửi thành công!');
    }
    public function destroy($id)
    {
        $report = IncidentReport::findOrFail($id);

        if ($report->attachment) {
            $attachments = json_decode($report->attachment, true);
            if (is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    \Storage::disk('public')->delete($attachment);
                }
            } else {
                
                \Storage::disk('public')->delete($report->attachment);
            }
        }

        $report->delete();

        return response()->json([
            'message' => 'Đã xoá báo cáo sự cố.',
        ]);
    }
}
