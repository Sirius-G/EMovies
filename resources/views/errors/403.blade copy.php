@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row m-4">
        <div class="col-sm-12 m-4 p-4">
            <!-- 404 Card --> 
            <div class="card">
                <div class="card-header text-danger">
                    <h1>403 Error - Access to this content is forbidden</h1>
                </div>
                <div class="card-body">
                    <h3>Your user ID and details of this transaction have been sent to ElevationMovies.com. Repeated attempts to access content in this way may result in your account being deleted.</h3>
                </div>
                <div class="card-footer">
                    {{date('d-m-Y h:m:s')}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection