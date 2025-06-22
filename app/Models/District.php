<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'code',
        'coordinates',
        'map',
        'city_id',
        'population',
        'created_at',
        'updated_at',
     
    ];

    public function communes()
    {
        return $this->hasMany(Commune::class, 'district_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id','id');
    }

    public function scenarios()
    {
        return $this->hasMany(Scenario::class, 'district_id');
    }
}
