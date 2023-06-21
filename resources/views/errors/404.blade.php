@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row m-4">
        <div class="col-sm-12 m-4 p-4">
            <!-- 404 Card --> 
            <div class="card">
                <div class="card-header text-danger">
                    <h1>404 Error - Page not found</h1>
                </div>
                <div class="card-body">
                    <h3>The page you are looking for does not exist. Please use the navigation menu and choose another option.</h3>
                </div>
                <div class="card-footer">
                    {{date('d-m-Y h:m:s')}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection