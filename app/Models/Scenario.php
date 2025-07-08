<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
   
    use HasFactory;

    protected $table = 'scenarios';

    protected $fillable = [
        'id',
        'type_of_calamity_id',
        'district_id',
        'commune_ids',
        'name',
        'short_description',
        'updated_time',
        'status',
        'document_path',
        'document_text',
        'created_at',
        'updated_at',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    public function type_of_calamities()
    {
        return $this->belongsTo(TypeOfCalamities::class, 'type_of_calamity_id');
    }
    public function districts()
    {
        return $this->belongsTo(District::class, 'district_id');
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
