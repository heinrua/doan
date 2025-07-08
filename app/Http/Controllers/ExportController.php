<?php

namespace App\Http\Controllers;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
   
    public function exportStormCalamity()
    {
        $data = \App\Models\Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')
            ->with(['sub_type_of_calamities', 'communes', 'risk_level'])
            ->get()
            ->map(function ($item) {
                return [
                    'Tên bão' => $item->name,
                    'Loại hình' => $item->sub_type_of_calamities->pluck('name')->implode(', '),
                    'Địa phương ảnh hưởng' => $item->communes->pluck('name')->implode(', '),
                    'Toạ độ' => $item->coordinates,
                    'Mức đầu tư' => $item->investment_level,
                    'Cấp độ rủi ro thiên tai' => optional($item->risk_level)->name,
                    'Thời gian bắt đầu' => $item->time_start,
                    'Thời gian kết thúc' => $item->time_end,
                    'Thiệt hại về người' => $item->human_damage,
                    'Thiệt hại về tài sản' => $item->property_damage,
                    'Biện pháp ứng phó' => $item->mitigation_measures,
                    'Bản đồ' => $item->map,
                    'Hình ảnh' => $item->image,
                    'Video' => $item->video,
                    'Thời gian cập nhật' => $item->updated_at,
                ];
            })->toArray();
        $headers = array_keys($data[0] ?? [
            'Tên bão' => '', 'Loại hình' => '', 'Địa phương ảnh hưởng' => '', 'Toạ độ' => '', 'Mức đầu tư' => '', 'Cấp độ rủi ro thiên tai' => '', 'Thời gian bắt đầu' => '', 'Thời gian kết thúc' => '', 'Thiệt hại về người' => '', 'Thiệt hại về tài sản' => '', 'Biện pháp ứng phó' => '', 'Bản đồ' => '', 'Hình ảnh' => '', 'Video' => '', 'Thời gian cập nhật' => ''
        ]);
        return Excel::download(new GenericExport($data, $headers), 'du-lieu-bao.xlsx');
    }

    public function exportRiverBankCalamity()
    {
        $data = \App\Models\Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')
            ->with(['sub_type_of_calamities', 'communes.district', 'risk_level'])
            ->get()
            ->map(function ($item) {
                return [
                    'Tên vị trí sạt lở' => $item->name,
                    'Loại sạt lở' => $item->sub_type_of_calamities->pluck('name')->implode(', '),
                    'Cấp độ rủi ro thiên tai' => optional($item->risk_level)->name,
                    'Địa điểm' => $item->address,
                    'Phường/Xã' => $item->communes->pluck('name')->implode(', '),
                    'Quận/Huyện' => $item->communes->pluck('district.name')->unique()->implode(', '),
                    'Chiều dài (m)' => $item->length,
                    'Chiều rộng (m)' => $item->width,
                    'Diện tích' => $item->acreage,
                    'Toạ độ vị trí' => $item->coordinates,
                    'Thời gian' => $item->time,
                    'Nguyên nhân' => $item->reason,
                    'Địa chất' => $item->geology,
                    'Đặc điểm thuỷ văn' => $item->watermark_points,
                    'Thiệt hại về người' => $item->human_damage,
                    'Thiệt hại về tài sản' => $item->property_damage,
                    'Mức độ đầu tư' => $item->investment_level,
                    'Biện pháp giảm thiểu' => $item->mitigation_measures,
                    'Chính sách hỗ trợ' => $item->support_policy,
                   
                    'Thời gian cập nhật' => $item->updated_at,
                ];
            })->toArray();
        $headers = array_keys($data[0] ?? [
            'Tên vị trí sạt lở' => '', 'Loại sạt lở' => '', 'Cấp độ rủi ro thiên tai' => '', 'Địa điểm' => '', 'Phường/Xã' => '', 'Quận/Huyện' => '', 'Chiều dài (m)' => '', 'Chiều rộng (m)' => '', 'Diện tích' => '', 'Toạ độ vị trí' => '', 'Thời gian' => '', 'Nguyên nhân' => '', 'Địa chất' => '', 'Đặc điểm thuỷ văn' => '', 'Thiệt hại về người' => '', 'Thiệt hại về tài sản' => '', 'Mức độ đầu tư' => '', 'Biện pháp giảm thiểu' => '', 'Chính sách hỗ trợ' => '', 'Thời gian cập nhật' => ''
        ]);
        return Excel::download(new GenericExport($data, $headers), 'du-lieu-sat-lo.xlsx');
    }

    public function exportFloodingCalamity()
    {
        $data = \App\Models\Calamities::whereRelation('risk_level.type_of_calamities', 'slug', 'ngap-lut')
            ->with(['sub_type_of_calamities', 'communes', 'risk_level'])
            ->get()
            ->map(function ($item) {
                return [
                    'Tên khu vực ngập' => $item->name,
                    'Loại hình ngập' => $item->sub_type_of_calamities->pluck('name')->implode(', '),
                    'Địa phương' => $item->communes->pluck('name')->implode(', '),
                    'Cấp độ rủi ro' => optional($item->risk_level)->name,
                    'Toạ độ' => $item->coordinates,
                    'Khoảng ngập' => $item->flood_range,
                    'Mức độ (m)' => $item->flood_level,
                    'Diện tích (ha)' => $item->flooded_area,
                    'Bắt đầu' => $item->time_start,
                    'Kết thúc' => $item->time_end,
                    'Nước rút (giờ)' => $item->sprint_time,
                    'Nguyên nhân' => $item->reason,
                    'Số hộ ảnh hưởng' => $item->number_of_people_affected,
                    'Thiệt hại người' => $item->human_damage,
                    'Thiệt hại tài sản' => $item->property_damage,
                    'Hạ tầng hư hại' => $item->damaged_infrastructure,
                    'Biện pháp' => $item->mitigation_measures,
                    'Nguồn' => $item->data_source,
                    'Cập nhật' => $item->updated_at,
                ];
            })->toArray();
        $headers = array_keys($data[0] ?? [
            'Tên khu vực ngập' => '', 'Loại hình ngập' => '', 'Địa phương' => '', 'Cấp độ rủi ro' => '', 'Toạ độ' => '', 'Khoảng ngập' => '', 'Mức độ (m)' => '', 'Diện tích (ha)' => '', 'Bắt đầu' => '', 'Kết thúc' => '', 'Nước rút (giờ)' => '', 'Nguyên nhân' => '', 'Số hộ ảnh hưởng' => '', 'Thiệt hại người' => '', 'Thiệt hại tài sản' => '', 'Hạ tầng hư hại' => '', 'Biện pháp' => '', 'Nguồn' => '', 'Cập nhật' => ''
        ]);
        return Excel::download(new GenericExport($data, $headers), 'du-lieu-ngap-lut.xlsx');
    }

    public function exportStormConstruction()
    {
        $data = \App\Models\Construction::whereRelation('risk_level.type_of_calamities', 'slug', 'bao-ap-thap-nhiet-doi')
            ->with(['type_of_constructions', 'risk_level', 'commune'])
            ->get()
            ->map(function ($item) {
                return [
                    'Mã công trình' => $item->construction_code,
                    'Tên công trình' => $item->name,
                    'Loại công trình' => $item->type_of_constructions->name ?? '',
                    'Cấp độ rủi ro thiên tai' => $item->risk_level->name ?? '',
                    'Địa điểm' => $item->address,
                    'Khu vực' => $item->commune->name ?? '',
                    'Kích thước' => $item->size,
                    'Trình trạng' => $item->status,
                    'Ngày xây dựng' => $item->construction_date,
                    'Ngày hoàn thành' => $item->completion_date,
                    'Nguồn vốn' => $item->capital_source,
                    'Chi phí' => $item->total_investment,
                    'Tình trạng hoạt động' => $item->operating_status,
                    'Toạ độ' => $item->coordinates,
                    'Nhà thầu' => $item->contractor,
                    'Mức độ hiệu quả' => $item->efficiency_level,
                    'Thời gian cập nhật' => $item->updated_at,
                ];
            })->toArray();
        $headers = array_keys($data[0] ?? [
            'Mã công trình' => '', 'Tên công trình' => '', 'Loại công trình' => '', 'Cấp độ rủi ro thiên tai' => '', 'Địa điểm' => '', 'Khu vực' => '', 'Kích thước' => '', 'Trình trạng' => '', 'Ngày xây dựng' => '', 'Ngày hoàn thành' => '', 'Nguồn vốn' => '', 'Chi phí' => '', 'Tình trạng hoạt động' => '', 'Toạ độ' => '', 'Nhà thầu' => '', 'Mức độ hiệu quả' => '', 'Thời gian cập nhật' => ''
        ]);
        return Excel::download(new GenericExport($data, $headers), 'du-lieu-cong-trinh-bao.xlsx');
    }

    public function exportFloodingConstruction()
    {
        $data = \App\Models\Construction::whereRelation('risk_level.type_of_calamities', 'slug', 'ngap-lut')
            ->with(['type_of_constructions', 'risk_level', 'commune.district'])
            ->get()
            ->map(function ($item) {
                return [
                    'Tên công trình' => $item->name,
                    'Loại công trình' => $item->type_of_constructions->name ?? '',
                    'Cấp độ' => $item->risk_level->name ?? '',
                    'Vị trí công trình' => $item->address,
                    'Xã' => $item->commune->name ?? '',
                    'Huyện' => $item->commune->district->name ?? '',
                    'Năm xây dựng' => $item->year_of_construction,
                    'Năm hoàn thành' => $item->year_of_completion,
                    'Thời gian cập nhật' => $item->update_time,
                    'Toạ độ' => $item->coordinates,
                    'Quy mô' => $item->scale,
                    'Đặc điểm nhận dạng' => $item->characteristic,
                    'Bề rộng 1 cửa' => $item->width_of_door,
                    'Cao trình đáy' => $item->base_level,
                    'Cao trình đỉnh trụ pin' => $item->pillar_top_level,
                    'Ghi chú' => $item->notes,
                    'Hình thức vận hành' => $item->operation_method,
                    'Hệ thống thuỷ lợi' => $item->irrigation_system,
                    'Vùng thuỷ lợi' => $item->irrigation_area,
                    'Loại cống' => $item->culver_type,
                    'Mã cống' => $item->culver_code,
                    'Đơn vị quản lý' => $item->management_unit,
                    'Hình ảnh' => $item->image,
                    'Video' => $item->video,
                    'Thời gian cập nhật' => $item->updated_at,
                ];
            })->toArray();
        $headers = array_keys($data[0] ?? [
            'Tên công trình' => '', 'Loại công trình' => '', 'Cấp độ' => '', 'Vị trí công trình' => '', 'Xã' => '', 'Huyện' => '', 'Năm xây dựng' => '', 'Năm hoàn thành' => '', 'Thời gian cập nhật' => '', 'Toạ độ' => '', 'Quy mô' => '', 'Đặc điểm nhận dạng' => '', 'Bề rộng 1 cửa' => '', 'Cao trình đáy' => '', 'Cao trình đỉnh trụ pin' => '', 'Ghi chú' => '', 'Hình thức vận hành' => '', 'Hệ thống thuỷ lợi' => '', 'Vùng thuỷ lợi' => '', 'Loại cống' => '', 'Mã cống' => '', 'Đơn vị quản lý' => '', 'Hình ảnh' => '', 'Video' => '', 'Thời gian cập nhật' => ''
        ]);
        return Excel::download(new GenericExport($data, $headers), 'du-lieu-cong-trinh-ngap-lut.xlsx');
    }

    public function exportRiverBankConstruction()
    {
        $data = \App\Models\Construction::whereRelation('risk_level.type_of_calamities', 'slug', 'sat-lo-bo-song-bo-bien')
            ->with(['type_of_constructions', 'risk_level', 'commune.district'])
            ->get()
            ->map(function ($item) {
                return [
                    'Tên công trình' => $item->name,
                    'Loại công trình' => $item->type_of_constructions->name ?? '',
                    'Cấp độ rủi ro thiên tai' => $item->risk_level->name ?? '',
                    'Phường/Xã' => $item->commune->name ?? '',
                    'Quận/Huyện' => $item->commune->district->name ?? '',
                    'Tiến độ thực hiện' => $item->progress,
                    'Năm xây dựng' => $item->year_of_construction,
                    'Năm hoàn thành' => $item->year_of_completion,
                    'Chiều dài (km)' => $item->length,
                    'Chiều rộng (m)' => $item->width,
                    'Quy mô' => $item->scale,
                    'Mức độ ảnh hưởng' => $item->influence_level,
                    'Toạ độ' => $item->coordinates,
                    'Tổng mức đầu tư' => $item->total_investment,
                    'Nguồn vốn' => $item->capital_source,
                    'Hình ảnh' => $item->image,
                    'Video' => $item->video,
                    'Thời gian cập nhật' => $item->updated_at,
                ];
            })->toArray();
        $headers = array_keys($data[0] ?? [
            'Tên công trình' => '', 'Loại công trình' => '', 'Cấp độ rủi ro thiên tai' => '', 'Phường/Xã' => '', 'Quận/Huyện' => '', 'Tiến độ thực hiện' => '', 'Năm xây dựng' => '', 'Năm hoàn thành' => '', 'Chiều dài (km)' => '', 'Chiều rộng (m)' => '', 'Quy mô' => '', 'Mức độ ảnh hưởng' => '', 'Toạ độ' => '', 'Tổng mức đầu tư' => '', 'Nguồn vốn' => '', 'Hình ảnh' => '', 'Video' => '', 'Thời gian cập nhật' => ''
        ]);
        return Excel::download(new GenericExport($data, $headers), 'du-lieu-cong-trinh-sat-lo.xlsx');
    }

}
