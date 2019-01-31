<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
    	$category = new Category;
    	$category->timestamps = false;
    	$category->name = $request->category;
    	$category->save();

    	Session::flash("success_message","Category added successfully");
    	return redirect('/dashboard');
    }

    public function updateCategory(Request $collection) {
    	$category = Category::find($collection->category_id);
    	$category->timestamps = false;
    	$category->name = $collection->category;
    	$category->save();

    	Session::flash("success_message","Category updated successfully");
    	return redirect('/dashboard');
    }

    public function deleteCategory($id){
    	$category = Category::find($id);
    	$category->delete();

    	Session::flash("success_message","Category deleted successfully");
    	return redirect('/dashboard');
    }

    public function showCategory($id){
        $category = Category::find($id);
        $books = $category->books;

        return view('tornhub.index', compact('books'));
    }
}
