@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-sm-12 col-md-2">
        <!-- Sidebar --> 
        @include('inc.sidebar')
    </div>
    <div class="col-sm-12 col-md-10">
        <!-- Main Page --> 
        <div class="row" style="margin-top: 100px">
            <div class="col-12 col-sm-12 mt-4">
                <div class="card">
                    <form action="" method="post" enctype="">
                        {{csrf_field}}
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label class="form-label">Title</label><br>
                                <input type="text" name="title" class="form-control" placeholder="Title" required />
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection