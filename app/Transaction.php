<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function books(){
    	return $this->belongsTo("\App\Book");
    }

    public function statuses(){
    	return $this->belongsTo("\App\Status");
    }

    public function users(){
    	return $this->belongsTo("\App\User");
    }
}
