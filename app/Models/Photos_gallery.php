<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photos_gallery extends Model
{
    protected $table = 'photos_gallery';
    protected $fillable = [
         'photo','salon_id',
       
    ];
    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }
    public function scopeSelection( $query)
    {
        return $query->select('id','photo','salon_id');
    }
   
    public function salons()
    {
       return $this->belongsTo('\App\Models\Salon','salon_id');
    }
}
