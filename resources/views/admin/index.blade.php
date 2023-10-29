@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-sm-12 col-md-2">
        <!-- Sidebar --> 
        @include('inc.sidebar')
    </div>
    <div class="col-sm-12 col-md-10">
        <!-- Main Page - Show features by thumbnail --> 
        <div style="margin-top: 100px">
            <br>
            <form action="{{route('search.movies')}}" method="post" class="px-4 my-4">
                @csrf 
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <input type="text" name="search" placeholder="Search by title" class="form-control m-2">
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <button type="submit" class="btn btn-primary m-2">
                            <i class="fa fa-search fa-lg"></i> Search
                        </button>
                        <button type="submit" class="btn btn-secondary m-2">
                            <i class="fa fa-retweet fa-lg"></i> Reset
                        </button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
            @if(count($thumbs)>0)
                @foreach($thumbs as $t)
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3 mt-4"> 
                    @if($t->billboard == 1)
                    <form action="{{route('billboard.show')}}" method="post" id="myForm" class="d-flex justify-content-center">
                            @csrf
                            <input type="hidden" name="id" id="id" />
                            <input type="hidden" name="billbox" id="billbox" />
                            <input type="checkbox" class="text-white m-4" onclick="myFunction({{$t->id}})" style="transform: scale(2);" name="billbo" id="billbo" checked />
                            <span class="text-white m-4">: Billboard</span>
                    </form>
                    @else
                    <form action="{{route('billboard.show')}}" method="post" id="myForm2" class="d-flex justify-content-center">
                            @csrf
                            <input type="hidden" name="id" id="id2" />
                            <input type="hidden" name="billboy" id="billboy" />
                            <input type="checkbox" class="text-white m-4" onclick="myFunction2({{$t->id}})" style="transform: scale(2);" name="billbo" id="billbo2" />
                            <span class="text-white m-4">: Billboard</span>
                    </form>
                    @endif
                        <script>
                            function myFunction(a) {
                            document.getElementById('id').value = a;
                            document.getElementById('billbox').value = '0';
                            document.getElementById("myForm").submit();
                            }
                            function myFunction2(b) {
                            document.getElementById('id2').value = b;
                            document.getElementById('billboy').value = '1';
                            document.getElementById("myForm2").submit();
                            }
                        </script>                    
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