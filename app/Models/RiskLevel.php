<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskLevel extends Model
{
    use HasFactory;

    protected $table = 'risk_levels';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'type_of_calamity_id',
        'created_at',
        'updated_at',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    public function type_of_calamities()
    {
        return $this->belongsTo(TypeOfCalamities::class, 'type_of_calamity_id');
    }

    public function calamities()
    {
        return $this->hasMany(Calamities::class, 'risk_level_id');
    }

    public function constructions()
    {
        return $this->hasMany(Construction::class, 'risk_level_id');
    }
}
