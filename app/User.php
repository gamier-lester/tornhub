<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'firstname', 'lastname', 'address', 'image_path', 'password', 'account_status', 'account_role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function transactions(){
        return $this->hasMany("\App\Transaction", 'user_id');
    }

    public function statuses(){
        return $this->belongsTo("\App\Status", 'account_status');
    }

    public function roles(){
        return $this->belongsTo("\App\Role", 'account_role');
    }
}
