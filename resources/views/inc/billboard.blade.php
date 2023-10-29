<div id="BillboardCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    @if(count($billboard)>0)
    @foreach($billboard as $b)
      @php $c_image = 'assets/posters/'.$b->poster; @endphp
      <div class="carousel-item @if($loop->first) active @endif"  style="min-height: 500px !important; background: rgba(255,255,255,0.05);">
          <img src="{{$c_image}}" class="d-block w-100 mt-1" alt="{{$b->title}}">
        <div class="carousel-caption billboard_caption">
        <span class="feature"><img src="{{asset('images/emw.png')}}"> {{$b->feature_type}}</span>
          <h1 style="font-size: calc(2.5 * (1.5vw + 1.1vh));">{{$b->title}}</h1>
          <p>{{$b->sub_title}}</p>
          <br>
              <a href="{{route('play', $b->id)}}" class="btn btn-primary btn-lg mt-2" style="width: 150px;"> <i class="fa fa-play fa-lg"></i> Play </a>
              <a href="#" class="btn btn-secondary btn-lg mt-2" style="width: 180px;" data-bs-toggle="modal" data-bs-target="#more-info" onclick="showInfo(`{{$b->title}}`,`{{$b->sub_title}}`, `{{$b->long_description}}`, `{{$b->cast_names}}`, `{{$b->certificate}}`, `{{$b->certificate_reasons}}`, `{{$b->director_names}}`)"> <i class="fa fa-info-circle fa-lg" ></i> More Info... </a>
              @if($b->trailer)
                <a href="{{route('playtrailer', $b->id)}}" class="btn btn-secondary btn-lg mt-2" style="width: 180px;"> <i class="fa fa-eye fa-lg"></i> Watch Trailer </a>
              @endif
        </div>
      </div>
    @endforeach
    @endif
    <button class="carousel-control-prev" type="button" data-bs-target="#BillboardCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#BillboardCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>




<!-- Add modals here -->

<div class="modal fade" id="more-info">
    <div class="modal-dialog modal-lg" style="padding: 10px;">
      <div class="modal-content information text-white">
        <div class="modal-header">
        <h4 class="modal-title fs-6"><i class="fa fa-info fa-lg"></i> More Information</h4>
        <button type="button" class="btn-close-white text-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 m-2 text-center">
                <h3 id="t"></h3>
                <h5 id="st"></h5>
                <div id="d" style="text-align: left;"></div>
            </div>                       
          </div>
          <script>
            function showInfo(ttl, sttl, descr, cst, cert, res, direc){
              console.log(ttl);
              document.getElementById("t").innerHTML = ttl;
              document.getElementById("st").innerHTML = sttl;
              document.getElementById("d").innerHTML = descr + '<br><hr>' + `Cast: ${cst}` + '<br><hr><br>' + `This feature has a certificate of ${cert}` + '<br>' + `The feature contains ${res}` + '<br><span class="pull-right mx-4">' + `Director(s): ${direc}` + "</span>";
            }
          </script>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





</div>