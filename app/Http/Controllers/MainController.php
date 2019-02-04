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

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	if(Auth::user()->account_role===1){
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
        if(Auth::user()->account_role === 1){
            $author = Author::find($id);
            $collection = ['authors' => $author];
            return view('admin.books_author', compact('collection'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function updateProfile(Request $collection){
        $user = User::find($collection->user_id);
        // dd($user);
        $user->firstname = $collection->user_firstname;
        $user->lastname = $collection->user_lastname;
        $user->address = $collection->user_address;
        $user->save();

        return redirect('/dashboard');
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

}
