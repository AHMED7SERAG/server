<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = [
        'name', 'details','icon','booking_before','home_service', 'price','bonus','payment',
        'estimated_time','category_id',
    ];
    public function getIconAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }
    public function scopeSelection( $query)
    {
        return $query->select('id','name', 'details','icon','booking_before','home_service', 'price','bonus','payment',
        'estimated_time','category_id');
    }
    public function category()
    {
       return $this->belongsTo('\App\Models\Category','category_id');
    }
   public function salons()
    {
        return $this->belongsToMany('\App\Models\Salon', 'salon_service', 'service_id', 'salon_id');
    }
    public function offer()
    {
        return $this->hasMany('\App\Models\Offer');
    }
    public function order()
    {
        return $this->hasMany('\App\Models\Order');
    }
}
