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
    	$transaction->transaction_status = 7; //returned status id
    	$transaction->save();

    	return redirect('/dashboard');
    }

    public function approveRequest(Request $collection){
        $transaction = Transaction::find($collection->transaction_id);
        $transaction->transaction_status = 4; // id of approved status;
        $transaction->save();

        return redirect('/dashboard');
    }

        public function sortTransactionByApproved(){
            $transactions = Transaction::where('transaction_status', 4)->paginate(10);
            $collection = ['transactions' => $transactions];

            return view('admin.index', compact('collection'));
        }

        public function sortTransactionByPending(){
            $transactions = Transaction::where('transaction_status', 3)->paginate(10);
            $collection = ['transactions' => $transactions];

            return view('admin.index', compact('collection'));
        }

        public function sortTransactionByReturned(){
            $transactions = Transaction::where('transaction_status', 7)->paginate(10);
            $collection = ['transactions' => $transactions];

            return view('admin.index', compact('collection'));
        }

}
