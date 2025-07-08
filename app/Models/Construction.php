<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Construction extends Model
{
    use HasFactory;

    protected $table = 'constructions';

    protected $fillable = [
        'id',
        'type_of_construction_id',
        'risk_level_id',
        'commune_id',
        'name',
        'slug',
        'construction_code',
        'address',
        'construction_date',
        'completion_date',
        'year_of_construction',
        'year_of_completion',
        'length',
        'width',
        'scale',
        'characteristic',
        'total_investment',
        'main_function',
        'update_time',
        'influence_level',
        'efficiency_level',
        'capital_source',
        'progress',
        'size',
        'status',
        'operating_status',
        'contractor',
        'coordinates',
        'width_of_door',
        'base_level',
        'pillar_top_level',
        'total_door_width',
        'notes',
        'operation_method',
        'irrigation_system',
        'irrigation_area',
        'culver_type',
        'culver_code',
        'management_unit',
        'map',
        'image',
        'video',
        'created_at',
        'updated_at',
        'created_by_user_id',
        'updated_by_user_id'
    ];


    public function type_of_constructions()
    {
        return $this->belongsTo(TypeOfConstruction::class, 'type_of_construction_id');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }


    public function risk_level()
    {
        return $this->belongsTo(RiskLevel::class, 'risk_level_id');
    }
     public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }
}
