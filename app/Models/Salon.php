<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    protected $table = 'salons';
    protected $fillable = [
        'name', 'username','email','password','home_service', 'payment','Latitude','Longitude'
        ,'booking','logo','city_id'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function scopeSelection( $query)
    {
        return $query->select( 'id','name', 'username','email','home_service', 'payment','Latitude'
        ,'Longitude','booking','logo','city_id',);
    }
   
    public function city()
    {
       return $this->belongsTo('\App\Models\City','city_id');
    }
    public function services()
    {
       return $this->belongsToMany('\App\Models\Service', 'salon_service', 'salon_id', 'service_id');
    }
    public function offer()
    {
        return $this->hasMany('\App\Models\Offer');
    }
    public function photo()
    {
        return $this->hasMany('\App\Models\Photos_gallery');
    }
    public function order()
    {
        return $this->hasMany('\App\Models\Order');
    }
    
}
