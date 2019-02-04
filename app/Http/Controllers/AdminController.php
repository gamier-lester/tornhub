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

    public function updateProfilePic(Request $collection){
        $image = $request->file('image');
        $image_name=time(). "." .$image->getClientOriginalExtension();
        $destination = "images/";
        $image->move($destination, $image_name);

        $book->image_path=$destination.$image_name;
    }

}
