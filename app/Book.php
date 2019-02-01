<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    public function authors(){
    	return $this->belongsTo("\App\Author", 'author_id');
    }

    public function categories(){
    	return $this->belongsTo("\App\Category", 'category_id');
    }

    public function transactions(){
    	return $this->hasMany("\App\Transaction");
    }

    public function statuses(){
        return $this->hasOne("\App\Status", 'id');
    }
}
