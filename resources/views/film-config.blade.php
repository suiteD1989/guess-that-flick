@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Guess That Flick!</div>
                @if(Auth::check())
                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::check() && Auth::user()->type  == "admin")
                        <form action="/upload" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                             
                            <div class="form-group"> 
                                <label for="Product Name">Film Title</label>
                                <input type="text" name="name" class="form-control"  placeholder="Film Title" >  
                            </div>
                             
                            <label for="Product Name">Image</label>
                            <input type="file" class="form-control" name="photos[]" multiple /> 
                            <br>
                            <input type="submit" class="btn btn-primary" value="Upload" />    
                        </form>

                    @endif
                </div>

                <div class="card-body open-films text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!$query->isEmpty())
                        <h1>Open Films</h1>
                        @foreach ($query as $q)
                
                            <?php 
                                $filename = $q->filename; 
                                $film_title = $q->film_title;
                                $id = $q->item_id;
                                $image_path = Storage::url($filename);
                            ?>
                            
                            <div class="film-title">
                                <span>Film Title: </span>
                                <span>{{ $film_title }}</span>
                            </div>
                            <br>
                            <img class="img-fluid" src="{{ $image_path }}"> 
                            <br>
                            @if(Auth::check() && Auth::user()->type  == "admin")
                            <br>
                            <form action="/solved" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $id }}"/>
                                <input type="hidden" name="title" value="{{ $film_title }}"/>
                                <button class="btn btn-primary" type="submit">Mark as Solved</button>
                            </form>

                            @endif
                        @endforeach
                    @else
                        <h1>If you can see this you should probably add a film</h1>
                    @endif

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
