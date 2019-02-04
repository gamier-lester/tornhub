<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function makeAdmin(Request $collection){
    	$user = User::find($collection->user_id);

    	$user->account_role = 1;
    	$user->save();

    	return redirect('/dashboard');
    }

    public function removeAdmin(Request $collection){
    	$user = User::find($collection->user_id);

    	$user->account_role = 2;
    	$user->save();

    	return redirect('/dashboard');
    }

    public function updateProfile(Request $collection){

    }

}
