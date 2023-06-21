@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-sm-12 col-md-2">
        <!-- Sidebar --> 
        @include('inc.sidebar')
    </div>
    <div class="col-sm-12 col-md-10">
        <!-- Main Page - Show features by thumbnail --> 
        <div class="row" style="margin-top: 100px">
            @if(count($thumbs)>0)
                @foreach($thumbs as $t)
                    <div class="col-12 col-sm-12 col-md-3 mt-4">
                        <span class="d-flex justify-content-evenly">
                            <img src="{{asset('assets/thumbnails/'.$t->thumbnail)}}" title="{{$t->title}}" alt="{{$t->title}}">
                        </span>
                        <span class="d-flex justify-content-center mt-2 mb-4">
                            <a href="{{route('edit', $t->id)}}" class="btn btn-primary" title="Edit Feature" alt="Edit Feature Button">
                                <i class="fa fa-edit fa-lg"></i> Edit
                            </a>
                        </span>
                    </div>
                @endforeach
            @else 
                <p class="text-white">No features found</p>
            @endif
        </div>
    </div>
</div>
@endsection