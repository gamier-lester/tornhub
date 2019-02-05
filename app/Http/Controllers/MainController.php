<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Book;
use App\Author;
use App\Status;
use App\Category;
use App\Transaction;
use Session;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	if(Auth::user()->roles->name == "admin"){
    		$users = User::all();
    		$books = Book::all();
    		$authors = Author::all();
    		$statuses = Status::all();
    		$categories = Category::all();
            // $transactions = Transaction::all();
            // $transactions = DB::table('transactions')->paginate(2);
            $transactions = Transaction::paginate(10);
    		$collection = [
    			'users' => $users,
    			'books' => $books,
    			'authors' => $authors,
    			'statuses' => $statuses,
    			'categories' => $categories,
    			'transactions' => $transactions
    		];
        	return view('admin.index', compact('collection'));
    	} else {
            $books = Book::all();
    		return view('tornhub.index', compact('books'));
    	}
    }

    public function showAuthorAndBook($id){
        if(Auth::user()->roles->name === "admin"){
            $author = Author::find($id);
            $collection = ['authors' => $author];
            return view('admin.books_author', compact('collection'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function updateMyProfile(Request $collection){
        $user = User::find($collection->user_id);
        // dd($user);
        $user->firstname = $collection->firstname;
        $user->lastname = $collection->lastname;
        $user->address = $collection->address;
        $user->save();

        return redirect('/dashboard');
    }

    public function updateProfile(Request $collection){
        $user = User::find($collection->user_id);
        // dd($user);
        $user->firstname = $collection->firstname;
        $user->lastname = $collection->lastname;
        $user->address = $collection->address;
        $user->save();

        return redirect('/dashboard');
    }


    public function updateMyProfilePic(Request $collection){
        //var_dump($collection->file('image'));
        if($collection->file('image') === NULL){
            Session::flash("error_message","Error in updating image");
            return redirect('/dashboard');
        }
        $user = User::find($collection->user_id);
        // dd($user);
        $image = $collection->file('image');
        $image_name=time(). "." .$image->getClientOriginalExtension();
        $destination = "images/";
        $image->move($destination, $image_name);

        $user->image_path=$destination.$image_name;

    	$user->save();
        Session::flash("success_message","Success in updating image");
        return redirect('/dashboard');
    }

}
