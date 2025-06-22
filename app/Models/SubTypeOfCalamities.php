<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTypeOfCalamities extends Model
{
    use HasFactory;

    protected $table = 'sub_type_of_calamities';

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
        return $this->belongsToMany(Calamities::class, 'calamity_sub_type_of_calamity', 'calamity_id', 'sub_type_of_calamity_id');
    }
}
