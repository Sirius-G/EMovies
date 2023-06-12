<div id="ThumbnailsCarousel2" class="carousel slide" data-bs-ride="carousel">
  <h3 class="text-white mx-4" style="z-index: 10; margin-top: -100px;">Watch list</h3>
  <div class="carousel-inner">
  @if(count($thumbs)>0)
  <div class="row">

    <div class="carousel-item active" style="display: flex;">
        @foreach($thumbs as $t)
            @php $thumb_image = 'assets/thumbnails/'.$t->thumbnail; @endphp
            <div class="card col-sm-12 col-md-3 col-lg-2">
                <a href="/more_info/{{$t->id}}" title="{{$t->title}}" alt="{{$t->title}}">
                    <img src="{{asset($thumb_image)}}" class="card-img-top" alt="{{$t->title}}">
                    <div class="card-img-overlay text-white">
                        <h5 class="card-title" style="border-bottom: solid 1px #aaa;">{{$t->title}}</h5>
                        <p class="card-text" style="margin-top: -8px;">{{$t->short_description}}</p>
                    </div>
                </a>
            </div>
        @endforeach 
    </div>

    <div class="carousel-item"  style="display: flex;">
      @foreach($thumbs as $t)
        @php $thumb_image = 'assets/thumbnails/'.$t->thumbnail; @endphp
        <div class="card col-sm-12 col-md-3 col-lg-2">
            <a href="/more_info/{{$t->id}}" title="{{$t->title}}" alt="{{$t->title}}">
                <img src="{{asset($thumb_image)}}" class="card-img-top" alt="{{$t->title}}">
                <div class="card-img-overlay text-white">
                    <h5 class="card-title" style="border-bottom: solid 1px #aaa;">{{$t->title}}</h5>
                    <p class="card-text" style="margin-top: -8px;">{{$t->short_description}}</p>
                </div>
            </a>
        </div>
      @endforeach 
    </div> 
  </div>
  @endif  
     
  <button class="carousel-control-prev" type="button" data-bs-target="#ThumbnailsCarousel2" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#ThumbnailsCarousel2" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>    
  </div>
</div>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

