<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class IncidentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reporter_name',
        'contact_number',
        'coordinates',
        'commune_id',
        'sub_type_of_calamity_id', 
        'description',
        'attachment'
    ];

    
    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

   
    public function sub_type_of_calamity()
    {
        return $this->belongsTo(SubTypeOfCalamities::class, 'sub_type_of_calamity_id');
    }
}
