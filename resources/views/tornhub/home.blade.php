@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col align-self-center">
                <h2>Welcome to TornHub</h2>
                <p class="lead">Explore different worlds</p>
                <div class="row justify-content-center">
                    @foreach(\App\Book::all() as $book)
                        <div class="col-md-5 mb-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Title: {{$book->title}}</h4>
                                    By: {{$book->authors->name}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection