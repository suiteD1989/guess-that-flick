@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

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

                            $test_image = Storage::url($filename);
                        ?>
                        
                        <span>{{ $film_title }}</span>
                        <img class="img-fluid" src="{{ $test_image }}"> 
                    
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
