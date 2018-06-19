@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Drawing</div>

                <div class="card-body">
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
                            <input type="submit" class="btn btn-primary" value="Upload" />    
                        </form>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
