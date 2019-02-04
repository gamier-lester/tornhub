<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Book;

class BookController extends Controller
{
    public function addAsset(Request $request){
    	$book = new Book;
    	// $book->timestamps = false;
    	$book->title = $request->title;
    	$book->year_published = $request->publishYear;
    	// $book->image_path = $request->image;
    	$book->category_id = $request->category;
    	$book->author_id = $request->author;
        $book->description = $request->description;
        $book->status_id = 8;
        $book->quantity = 0;

        $image = $request->file('image');
        $image_name=time(). "." .$image->getClientOriginalExtension();
        $destination = "images/";
        $image->move($destination, $image_name);

        $book->image_path=$destination.$image_name;

    	$book->save();

    	Session::flash("success_message","Asset added successfully");
    	return redirect('/dashboard');
        // dd($request);
    }

    public function updateAsset(Request $collection){
        $book = Book::find($collection->new_book_id);
        // $book->timestamps = false;
        $book->title = $collection->new_title;
        $book->year_published = $collection->new_publishYear;
        // $book->image_path = $collection->new_image;
        $book->category_id = $collection->new_category;
        $book->author_id = $collection->new_author;
        $book->description = $collection->new_description;

        $image = $request->file('image');
        $image_name=time(). "." .$image->getClientOriginalExtension();
        $destination = "images/";
        $image->move($destination, $image_name);

        $book->image_path=$destination.$image_name;

        $book->save();

        Session::flash("success_message","Asset updated successfully");
        return redirect('/dashboard');
        // dd($collection);
    }

    public function deleteAsset($id){
        $book = Book::find($id);
        $book->delete();

        Session::flash("success_message","Asset deleted successfully");
        return redirect('/dashboard');
    }

    public function restoreAsset($id){
        $item = Item::withTrashed()->find($id);
        // We need to use withTrashed to include "soft-deleted" items in the query
        $item->restore();
        return redirect("/catalog");
    }

    public function showAssets($id){
        
    }

    public function bookRestore($id, Request $collection){
        $book = Book::withTrashed()->find($collection->book_id);
        $book->restore();
        // echo $id;
        // $book->save();
        return redirect('/AuthorWorks/'.$id);
    }

    public function bookForceRemove($id, Request $collection){
        $book = Book::withTrashed()->find($collection->book_id);
        $book->forceDelete();
        // echo $id;
        return redirect('/AuthorWorks/'.$id);
    }

}
