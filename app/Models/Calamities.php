<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calamities extends Model
{
    use HasFactory;

    protected $table = 'calamities';

    protected $fillable = [
        'id',
        'risk_level_id',
        'name',
        'slug',
        'length',
        'address',
        'width',
        'acreage',
        'coordinates',
        'map',
        'image',
        'video',
        'time',
        'reason',
        'geology',
        'watermark_points',
        'human_damage',
        'property_damage',
        'investment_level',
        'mitigation_measures',
        'support_policy',
        'flood_level',
        'flooded_area',
        'time_start',
        'time_end',
        'sprint_time',
        'number_of_people_affected',
        'damaged_infrastructure',
        'data_source',
        'flood_range',
        'created_at',
        'updated_at',
        'created_by_user_id',
        'updated_by_user_id'
    ];

   

    public function sub_type_of_calamities()
    {
        return $this->belongsToMany(SubTypeOfCalamities::class, 'calamity_sub_type_of_calamity', 'calamity_id', 'sub_type_of_calamity_id');

    }

    public function risk_level()
    {
        return $this->belongsTo(RiskLevel::class, 'risk_level_id');
    }

    public function communes()
    {
        return $this->belongsToMany(Commune::class, 'calamity_communes', 'calamity_id','commune_id', );
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
