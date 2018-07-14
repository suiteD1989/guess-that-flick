@extends('layouts.app')

@section('content')
@if(Auth::check())
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(!$query->isEmpty())
                            @foreach ($query as $q)
                                <?php 
                                    $filename = $q->filename; 
                                    $film_title = $q->film_title;
                                    $id = $q->item_id;
                                    $image_path = Storage::url($filename);
                                ?>
                                
                                <img class="img-fluid" src="{{ $image_path }}"> 

                                <form action="/guess" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group"> 
                                        <br>
                                        <input type="text" name="film_title" class="form-control"  placeholder="Name of Flick?">  
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="Submit Your Guess!" />    
                                </form>
                            @endforeach
                        @else
                            <h1>Nothing Has Been Added To Guess. Shite.</h1>
                        @endif
                         
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
