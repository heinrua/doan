<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $table = 'communes';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'code',
        'coordinates',
        'district_id',
        'created_at',
        'updated_at',
       
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function calamities()
    {
        return $this->belongsToMany(Calamities::class, 'calamity_communes', 'commune_id', 'calamity_id');
    }

    public function constructions()
    {
        return $this->belongsToMany(Construction::class, 'construction_communes', 'commune_id', 'construction_id');
    }

    public function geographical_data()
    {
        return $this->hasMany(GeographicalData::class, 'commune_id');
    }
}
