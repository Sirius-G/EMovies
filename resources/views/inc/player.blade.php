@if(count($current_video)>0)
@foreach($current_video as $v)
    @php $video_source = '/assets/videos/'.$v->feature; @endphp
<!-- <h3 class="mt-4 p-4">{{$v->title}}</h3> -->
<!-- Add video player here --> 
<div style="margin-top: 0px;">
    <video style="margin: 2.5% 0px 0px 10%; width: 80%; height: calc(80vw*0.5625)px;" controls autoplay>
    <source src="{{asset($video_source)}}" type="video/mp4">
    Your browser does not support the video tag.
    </video>

    @endforeach
    @else 
    <h2>There was a problem loading the video. Please go back and try again....</h2>
    @endif
</div>