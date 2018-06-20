@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Guess That Flick!</div>

                @if(Auth::check())
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
                        
                        <span>{{ $film_title }}</span>
                        <br>
                        <img class="img-fluid" src="{{ $image_path }}"> 
                        <br>
                        @if(Auth::check() && Auth::user()->type  == "admin")

                            <form action="/solved" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $id }}"/>
                                <button type="submit">Solved</button>
                            </form>

                        @endif
                    @endforeach

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
