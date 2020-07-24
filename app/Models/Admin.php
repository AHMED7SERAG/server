<?php

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class Admin extends Authenticatable implements JWTSubject ,MustVerifyEmail
    {
        use Notifiable;
        protected $table = 'admins';
        protected $fillable = [
            'name', 'username','email', 'password','photo',
        ];
        protected $hidden = [
            'password',
        ];
        public function getPhotoAttribute($val)
        {
            return ($val !== null) ? asset('assets/' . $val) : "";
    
        }
        public function scopeSelection( $query)
        {
            return $query->select('id','name','username','email','photo');
        }
        public function bank()
       {
        return $this->hasMany('\App\Models\Bank');
       }
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
        public function sendPasswordResetNotification($token)
        {
            $this->notify(new PasswordResetNotification($token));
        }
    }