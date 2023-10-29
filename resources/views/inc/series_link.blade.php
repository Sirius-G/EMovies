
    <div class="row mx-auto my-auto justify-content-center">
        <!-- <div class="col-12 pt-2">
            <h3 class="mb-3 text-white">Other episodes in the series</h3>
        </div> -->
        <div id="other" class="carousel2 slide" data-bs-touch="false" data-bs-interval="false">
            <div class="carousel-inner" role="listbox">
                @if(count($series_thumbs)>0)
                    <div style="position: absolute; bottom: 0px; left: 50%; width: 200px; text-align: center; color: #fff; font-weight: bold; margin-left: -100px; padding: 3px; background-color: #000; border: #333 solid 1px; z-index: 99;">
                        Total features: {{count($series_thumbs)}}
                    </div> 
                @foreach($series_thumbs as $t)
                    <div class="carousel-item @if($loop->first) active @endif" style="border: solid #333 2px;">
                        <div class="col-6 col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="card feature_card">
                                <a href="/more_info/{{$t->id}}" target="parent" title="{{$t->title}}" alt="{{$t->title}}">
                                    <div class="card-img">
                                        <img src="{{asset('assets/thumbnails/'.$t->thumbnail)}}" class="card-img-top" alt="{{$t->title}}">
                                    </div>
                                    <div class="card-img-overlay text-white">
                                        <h5 class="card-title" style="border-bottom: solid 1px #aaa;">{{$t->title}}</h5>
                                        @if($t->series_id > 0)
                                            <p class="card-text" style="margin-top: -8px;">{{$t->sub_title}}</p>                                       
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>     
               
            <div class="col-12 d-flex justify-content-between bt_top">
                <a class="btn btn-primary" class="carousel-control-prev" onclick="advance()" role="button" data-bs-target="#other" data-bs-slide="prev">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <a class="btn btn-primary" class="carousel-control-next" onclick="back()" role="button" data-bs-target="#other" data-bs-slide="next">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
let items = document.querySelectorAll('.carousel2 .carousel-item')

items.forEach((el) => {
    const minPerSlide = 6
    let next = el.nextElementSibling
    for (var i=1; i<minPerSlide; i++) {
        if (!next) {
            // wrap carousel by using first child
        	next = items[0]
      	}
        let cloneChild = next.cloneNode(true)
        el.appendChild(cloneChild.children[0])
        next = next.nextElementSibling
    }
})

function advance(){
    $("#other").carousel('prev');
}

function back(){
    $("#other").carousel('next');
}
</script>