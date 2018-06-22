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
                                    <label for="Film Title">Guess the flick!</label>
                                    <input type="text" name="film_title" class="form-control"  placeholder="Name of Flick?">  
                                </div>
                                <input type="submit" class="btn btn-primary" value="Upload" />    
                            </form>
                        @endforeach

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
