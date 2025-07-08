<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfCalamities extends Model
{
    use HasFactory;

    protected $table = 'type_of_calamities';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'created_at',
        'updated_at',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    public function riskLevels()
    {
        return $this->hasMany(RiskLevel::class, 'type_of_calamity_id');
    }

    public function type_of_construction()
    {
        return $this->hasMany(TypeOfConstruction::class, 'type_of_calamity_id');
    }

    public function sub_type_of_calamities()
    {
        return $this->hasMany(SubTypeOfCalamities::class, 'type_of_calamity_id');
    }

    public function calamities()
    {
        return $this->hasManyThrough(
            Calamities::class,        
            RiskLevel::class,        
            'type_of_calamity_id',   
            'risk_level_id',         
            'id',                    
            'id'                     
    );
    }

    public function constructions()
    {
            return $this->hasManyThrough(
            Construction::class,       
            RiskLevel::class,          
            'type_of_calamity_id',     
            'risk_level_id',           
            'id',                      
            'id'                       
    );
    }

    public function calamitiesCount()
    {
        return $this->calamities()->count();
    }

    public function constructionsCount()
    {
        return $this->constructions()->count();
    }

    public function geographical_data()
    {
        return $this->hasMany(GeographicalData::class, 'type_of_calamity_id');
    }

    public function scenarios()
    {
        return $this->hasMany(Scenario::class, 'type_of_calamity_id');
    }
}
