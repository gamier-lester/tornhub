<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Status;

class StatusController extends Controller
{
    public function addStatus(Request $collection){
    	$status = new Status;
    	$status->name = $collection->status;
    	$status->timestamps = false;
    	$status->save();

    	Session::flash("success_message","Status added successfully");
    	return redirect('/dashboard');
    }
}
