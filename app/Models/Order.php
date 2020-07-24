<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
         'title','salon_id','service_id', 'employee_id',
         'address','type', 'payment',
    ];
    public function scopeSelection( $query)
    {
        return $query->select('id' ,'title','salon_id','service_id','employee_id','address',
        'type','payment');
    }
    public function salon()
    {
       return $this->belongsTo('\App\Models\Salon','salon_id');
    }
    public function service()
    {
       return $this->belongsTo('\App\Models\Service','service_id');
    }
}

