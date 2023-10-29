@extends('layouts.app')


@section('content')

    @include('inc.billboard')
    <h3 class="mb-3 text-white">Watch List</h3>
    <iframe src="{{route('inc.watchers')}}" id="watchers" scrolling="no" class="thumbnails_banner"></iframe>

@if(count($genres)>0) 
    @foreach($genres as $g)
        <h3 class="mb-3 text-white">{{$g->genre}}</h3>
        <iframe src="{{route('inc.thumbnails', $g->id)}}" id="action" scrolling="no" class="thumbnails_banner"></iframe>
    @endforeach 
@else 
    <h3>No features found</h3>
@endif

@endsection