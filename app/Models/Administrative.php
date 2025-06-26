<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrative extends Model
{
    use HasFactory;

    protected $table = 'administratives';

    protected $fillable = [
        'id',
        'type',
        'name',
        'code',
        'address',
        'coordinates',
        'description',
        'option',
        'classify',
        'commune_id',
        'population',
        'created_at',
        'updated_at',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    protected $casts = [
        'commune_id' => 'integer',
        'district_id' => 'integer'
    ];

    public function communes()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
