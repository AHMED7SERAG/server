<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service_Salon extends Model
{
    protected $table = 'salon_service';
    protected $fillable = [
        'salon_id', 'service_id'
    ];

  
}
