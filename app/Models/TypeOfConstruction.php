<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfConstruction extends Model
{
    use HasFactory;

    protected $table = 'type_of_constructions';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'type_of_calamity_id',
        'created_at',
        'updated_at',
    ];


    public function type_of_calamities()
    {
        return $this->belongsTo(TypeOfCalamities::class, 'type_of_calamity_id');
    }
}
