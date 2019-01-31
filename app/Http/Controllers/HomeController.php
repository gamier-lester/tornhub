<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//test data
use App\User;
use App\Book;
use App\Author;
use App\Status;
use App\Category;
use App\Transaction;
//end test data

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test(){
        // return view('sandbox.test');
        // $testdatas = User::find(1)->statuses;
        // return view('sandbox.test', compact('testdatas'));
        $users = User::all();
        return view('sandbox.test', compact('users'));
    }
}
