<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    protected $fillable = [
        'name', 'iban','admin_id'
    ];
    public function scopeSelection( $query)
    {
        return $query->select('id','name','iban','admin_id');
    }
    public function admin()
    {
        return $this->belongsTo('\App\Models\Admin','admin_id');
    }
  
   
    
}
