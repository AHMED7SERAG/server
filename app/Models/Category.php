<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name', 'icon','details'
    ];
    public function getIconAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";

    }
    public function scopeSelection( $query)
    {
        return $query->select('id','name','icon','details');
    }
    public function services()
    {
       return $this->hasMany('\App\Models\Service');
    }
}

