@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-sm-12 col-md-2">
        <!-- Sidebar --> 
        @include('inc.sidebar')
    </div>
    <div class="col-sm-12 col-md-10">
        <!-- Main Page --> 

        <table class="card table table-striped table-responsive table-hover overflow-y-scroll p-2" style="font-size: 10px; font-family: tahoma, sans-serif; margin: 100px 20px 0px -10px; max-width: 100% !important; word-break: break-all;">
        @if(count($all)>0)
        @foreach($all as $a)
        <tr>
                <td class="fw-bold" style="width: 10% !important">ID</td>
                <td class="fw-bold" style="width: 20% !important">Title</td> 
                <td class="fw-bold" style="width: 30% !important">Subtitle</td>
                <td class="fw-bold" style="width: 20% !important">Thumbnail</td>
                <td class="fw-bold" style="width: 20% !important">Billboard Poster</td>
            </tr>
            <tr>
            <td>{{$a->fid}}</td> 
                <td>{{$a->title}}</td> 
                <td>{{$a->sub_title}}</td>
                <td>{{$a->thumbnail}}</td>
                <td>{{$a->poster}}</td>
            </tr>
            <tr>
                <td class="fw-bold">Trailer</td>
                <td class="fw-bold">Main Feature</td>
                <td class="fw-bold">Certificate</td>
                <td class="fw-bold">Certifcate Reasons</td>
                <td class="fw-bold">Feature Type</td>
                </tr>
            <tr>
                <td>{{$a->trailer}}</td>
                <td>{{$a->feature}}</td>
                <td>{{$a->certificate}}</td>
                <td>{{$a->certificate_reasons}}</td>
                <td>{{$a->feature_type}}</td>
            </tr>
            <tr>
                <td class="fw-bold">Feature Length</td>
                <td class="fw-bold">Short Description</td>
                <td class="fw-bold">Long Description</td>
                <td class="fw-bold">Charges ID and Price</td>
                <td class="fw-bold">Subscription Y/N</td>
                </tr>
            <tr>
                <td>{{$a->feature_length}}</td>
                <td>{{$a->short_description}}</td>
                <td>{{$a->long_description}}</td>
                <td>{{$a->charges_id}} : {{$a->price}}</td>
                <td>{{$a->subscription}}</td>
            </tr>
            <tr>
                <td class="fw-bold">Genre</td>
                <td class="fw-bold">Cast List</td>
                <td class="fw-bold">Director(s)</td>
                <td class="fw-bold">Producer(s)</td>
                <td class="fw-bold">Writer(s)</td>
            </tr>
            <tr>
                <td>{{$a->genre}}</td>
                <td>{{$a->cast_names}}</td>
                <td>{{$a->director_names}}</td>
                <td>{{$a->producer_names}}</td>
                <td>{{$a->writer_names}}</td>
            </tr>
            <tr>
                <td class="fw-bold">Show on billboard (1 = yes 0 = no)</td>
                <td class="fw-bold">Active (show to users - 1 = yes 0 = no)</td>
                <td class="fw-bold">Series ID</td>
                <td class="fw-bold">Last Update Date</td>
                <td class="fw-bold">Edit this record</td>
            </tr>
            <tr>
                <td>{{$a->billboard}}</td>
                <td>{{$a->active}}</td>
                <td>{{$a->series_id}}</td>
                <td>{{$a->updated_at}}</td>
                <td><a href="{{route('edit', $a->fid)}}" class="btn btn-secondary btn-sm" title="Edit Feature" alt="Edit Feature Button">
                        <i class="fa fa-edit fa-lg"></i> Edit
                    </a>
                </td>
            </tr>
            <tr><td colspan="5" class="bg-secondary"></td></tr>
        @endforeach 
        @endif
        </table>
    </div>
</div>
@endsection