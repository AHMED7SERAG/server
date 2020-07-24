<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';
    protected $fillable = [
         'title','salon_id','service_id','discount', 'banner',
       
    ];
    public function getBannerAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }
    public function scopeSelection( $query)
    {
        return $query->select('id','title','salon_id','service_id','discount', 'banner');
    }
    public function service()
    {
       return $this->belongsTo('\App\Models\Service','service_id');
    }
    public function salons()
    {
       return $this->belongsTo('\App\Models\Salon','salon_id');
    }
}
