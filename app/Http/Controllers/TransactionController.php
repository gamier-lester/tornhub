<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class TransactionController extends Controller
{
    public function bookBorrow(Request $collection){
    	$transaction = new Transaction;
    	$transaction->user_id = $collection->user_id;
    	$transaction->book_id = $collection->book_id;
    	$transaction->transaction_status = 3;
    	$transaction->save();

    	return redirect('/dashboard');
    }

    public function bookReturn(Request $collection){
    	$transaction = Transaction::find($collection->transaction_id);
    	// $transaction->transaction_status = ; returned status id
    	$transaction->save();

    	return redirect('/dashboard');
    }

    public function approveRequest(Request $collection){
        $transaction = Transaction::find($collection->transaction_id);
        $transaction->transaction_status = // id of approved status;
        $transaction->save();

        return redirect('/dashboard');
    }
}
