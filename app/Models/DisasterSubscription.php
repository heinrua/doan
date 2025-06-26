<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterSubscription extends Model
{
      protected $table = 'disaster_subscriptions';
    protected $fillable = ['email', 'full_name'];
    public $timestamps = false; 
}
