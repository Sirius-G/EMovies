@if(count($details)>0)
  @foreach($details as $d)   
    <div class="col-12 col-sm-12 col-md-4 p-4 text-white" style="border-right: 2px #fff solid; padding: 40px;"">
      <span class="feature"><img src="{{asset('images/emw.png')}}"> {{$d->feature_type}}</span>
      <h2>{{$d->title}}</h2>
      <br>
      <a href="{{route('play', $d->id)}}" class="btn btn-primary btn-lg" style="width: 150px;"> <i class="fa fa-play fa-lg"></i> Play </a>
      @if($d->trailer)
        <a href="{{route('playtrailer', $d->id)}}" class="btn btn-secondary btn-lg mx-2" style="width: 180px;"> <i class="fa fa-eye fa-lg"></i> Watch Trailer </a>
      @endif
      <br><br>
      <h4 class="modal-title fs-6"><i class="fa fa-info fa-lg"></i> More Information</h4>
      <h5>{{$d->sub_title}}</h5>
      <span style="text-align: left;">{{$d->long_description}}</span>
      <br><hr>Cast: {{$d->cast_names}}<br><hr>
      <br><span class="pull-right mx-4">Director(s): {{$d->director_names}}</span>
    </div>                       
    <div class="col-12 col-sm-12 col-md-8 p-4 text-white">
        <img src="{{asset('assets/posters/'.$d->poster)}}" class="d-block w-100" alt="{{$d->title}}">
        <hr><br>This feature has a certificate of {{$d->certificate}}
        <br>The feature contains {{$d->certificate_reasons}}
    </div> 
  @endforeach
@endif
</div>
</div>


