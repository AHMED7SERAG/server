<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service_Catgory extends Model
{
    protected $table = 'salon_service';
    protected $fillable = [
        'salon_id', 'service_id'
    ];

    public function scopeSelection( $query)
    {
        return $query->select( 'salon_id', 'service_id');
    }
}
