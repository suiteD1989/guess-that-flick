@extends('layouts.app')

@section('content')
@if(Auth::check())
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Score</th>
                                </tr>
                            </thead>
                            <tbody>

                        @foreach ($results as $r)
                            <?php 
                               $name = $r->name;
                               $score = $r->score;
                            ?>

                            <tr>
                                <td>{{$name}}</td>
                                <td>{{$score}}</td>
                            </tr>
                            
                        @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <span>You gotta log in to guess the flick, bro!</span>
            </div>
        </div>
    </div>
@endif
@endsection
