<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeographicalData extends Model
{
    use HasFactory;

    protected $table = 'geographical_data';

    protected $fillable = [
        'id',
        'type', 'name', 'category', 'progress', 'start_year', 'end_year',
        'area', 'scale', 'impact_level', 'coordinates', 'total_investment', 'funding_source',
        'length', 'width', 'start_coordinates', 'end_coordinates',
        'survey_year', 'reference_number', 'last_updated',
        'monitoring_position', 'river', 'elevation_z', 'description','type_of_calamity_id','commune_id',
        'video','map','image','population',
        'created_at',
        'updated_at',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    public function type_of_calamities()
    {
        return $this->belongsTo(TypeOfCalamities::class, 'type_of_calamity_id');
    }

    public function communes()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
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
