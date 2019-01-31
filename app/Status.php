<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function status(){
    	return Status::all();
    }

    public function transactions(){
    	return $this->hasMany("\App\Transaction");
    }

    public function users(){
    	return $this->hasMany("\App\User");
    }
}
