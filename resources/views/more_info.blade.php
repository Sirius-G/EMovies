@extends('layouts.app')


@section('content')
<div class="row" style="margin-top: 80px;">
    @include('inc.details')
</div>
<div class="row">
    @if($fid > 0)
        <h3 class="mb-3 text-white">Other Episodes</h3>
    @else 
        <h3 class="mb-3 text-white">Other features</h3>
    @endif         
    
    <!-- Get  the ID from the URL -->
    <?php $feature_id =  request()->route('id'); ?>
    <iframe src="{{route('inc.series_link', $feature_id)}}" id="action" scrolling="no" class="thumbnails_banner"></iframe>

</div>


@endsection