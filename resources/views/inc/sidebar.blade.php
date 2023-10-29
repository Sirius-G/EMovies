@php 
    $uri = $_SERVER['REQUEST_URI'];
@endphp

<div class="col-sm-12">
    <!-- Admin Navigation Tools -->
    <div class="card" style="margin-top: 50px; padding: 20px !important; height:80vh; background: rgba(100,100,100,0.5);">
    <!-- <span class="text-white">{{$uri}}</span> -->
        <br><br>
        @if($uri === '/add')
            <a href="{{route('admin')}}" class="btn btn-primary" alt="" title="">Edit existing features</a>
        @else
            <a href="{{route('create')}}" class="btn btn-primary" alt="" title="">Upload a new feature</a>
        @endif
        <br><br>
            <a href="{{route('show_all')}}" class="btn btn-primary" alt="" title="">View all records</a>
		<br><br>
        <a href="/" class="btn btn-primary" alt="" title="">Back to user area</a>
        <br><br>
    </div>
</div>