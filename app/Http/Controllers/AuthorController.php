<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Author;

class AuthorController extends Controller
{
    public function addAuthor(Request $request){
    	$author = new Author;
    	$author->timestamps = false;
    	$author->name = $request->author;
    	$author->save();

		Session::flash("success_message","Author added successfully");
    	return redirect('/dashboard');
    }

    public function updateAuthor(Request $collection){
    	$author = Author::find($collection->author_id);
    	$author->timestamps = false;
    	$author->name = $collection->author;
    	$author->save();

    	Session::flash("success_message", "Author updated successfully");
    	return redirect('/dashboard');
    }

    public function deleteAuthor($id){
    	$author = Author::find($id);
    	$author->delete();

    	Session::flash("success_message", "Author deleted successfully");
    	return redirect('/dashboard');
    }
}
