<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $fillable = [
        'name', 'location'
    ];
   
    public function scopeSelection( $query)
    {
        return $query->select('id','name','location');
    }
    public function salons()
    {
       return $this->hasMany('\App\Models\Salon');
    }
}