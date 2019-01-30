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

    public function updateStatus(Request $request){
    	$status = Status::find($request->status_id);
    	// dd($status);
    	$status->timestamps = false;
    	$status->name = $request->status;
    	$status->save();

    	Session::flash("success_message","Status updated successfully");
    	return redirect('/dashboard');
    }

    public function deleteStatus($id){
    	$status = Status::find($id);
    	$status->delete();

    	Session::flash("success_message","Status deleted successfully");
    	return redirect('/dashboard');
    }
}
