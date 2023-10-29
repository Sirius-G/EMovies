@extends('layouts.app2')


@section('content')


    <!-- Video Section -->
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" id="leftdiv">
    @if(count($current_video)>0)
    @foreach($current_video as $v)
        <video id="elevationmovies" width="100%" style="margin: 2.5% 0px 0px 10%; width: 80%; height: calc(80vw*0.5625)px;" controls autoplay playsinline>
            <source id="source_id" src="{{asset('/assets/videos/$v->feature}}" type="video/mp4">
            Your browser does not support HTML5 Video.
        </video>
    @endforeach
    @endif
        <img src="{{asset('/images/video-security.png')}}" class="security_cover">
    </div>

    <!--  ============== Video Control Bar - FOOTER ================= -->
<div class="row red_controls" id="red_controls">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    @if(count($current_video)>0)
    @foreach($current_video as $v)

	   <!-- Determine what type of media is playing - Audio or Video -->
		<script>			
			var tun = document.getElementById("elevationmovies");
			window.rp = {id: {{$v->vid}}, tp: "Video", curTime: tun.currentTime};
			console.log(window.rp);
		</script>
       <!-- Control Icons -->
        <a id="link" onclick="play_video(window.rp.id)" href="#/">
            <i style="color: #fff; font-size: 30px;" class="fa fa-play-circle fa-lg"> </i>
        </a>

        <!-- Rewind -->
        <a onmousedown="rewind(window.rp.id)" touchstart="rewind(window.rp.id)" onmouseup="end(window.rp.id)" touchend="end(window.rp.id)" href="#/"><i style="color: #fff; margin-left: 20px; font-size: 30px;" class="fa fa-backward fa-lg"> </i></a>
        <!-- Forward -->
        <a onmousedown="forward(window.rp.id)" touchstart="forward(window.rp.id)" onmouseup="end(window.rp.id)" touchend="end(window.rp.id)" href="#/"><i style="color: #fff; margin-left: 20px; font-size: 30px;" class="fa fa-forward fa-lg"> </i></a>
		
        <!-- Stop -->
        <a onclick="stop(window.rp.id, window.rp.tp)" href="#/"><i style="color: #fff; margin-left: 20px; font-size: 30px;" class="fa fa-stop fa-lg"> </i></a>

        <!-- Display times -->
        <span style="color: #fff; margin-left: 30px;">
            <span id="curtimetext">00:00</span> / <span id="durtimetext">00:00</span>
        </span> 
		
		
		
		
		<!--Seek Bar-->
		<input type="range" id="rangeInput" name="rangeInput" min="0" max="100" value="0" oninput="amount.value=rangeInput.value, setVid(window.rp.id)" style="color: #fff; margin-left: 20px; font-size: 30px;">                                                       
		<output id="amount" name="amount" for="rangeInput">0</output>%	

  
	
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

        <!-- Volume Controls -->
        <a onclick="vol_up(window.rp.id)" href="#/"><i style="color: #fff; font-size: 30px;" class="fa fa-volume-up fa-lg"> </i></a>
        <span style="color: #fff; margin-left: 20px;" id="v">1.0</span>
        <a onclick="vol_down(window.rp.id)" href="#/"><i style="color: #fff; margin-left: 20px; font-size: 30px;" class="fa fa-volume-down fa-lg"> </i></a>
        <!-- Full Screen Option --> 
</div>
<script>
//Bespoke Video/Music Player Controls

              function vol_up(el){
                var vsong = document.getElementById("elevationmovies");
                if(vsong.volume < 0.95){
                  vsong.volume+=0.1;
                }
                get_volume(el);
              }
              function vol_down(el){
                var vsong = document.getElementById("elevationmovies");
                if(vsong.volume > 0.05){
                  vsong.volume-=0.1;
                }
                get_volume(el);
              }
              function get_volume(el){
                var vsong = document.getElementById("elevationmovies");
                var v = document.getElementById("v");
                v.innerHTML =  parseFloat(vsong.volume).toFixed(1);
              }
              function get_time(el){
 
                var tun = document.getElementById("elevationmovies");
				var getsrc = document.getElementById("source_id");
				var xxx = tun.getAttribute("src");
				if(xxx === null){ 
					xxx = getsrc.getAttribute("src");
				}
				var zzz = xxx.split('.').pop();
					if(zzz === "mp4" || zzz === "avi"){ 
						t = "Video"; 
					} else if (zzz === "mp3" || zzz === "wav"){
						t = "SFX";
					} 
				  
				  console.log(el, t);

				trackerCheck(el, t);
				  if(window.rp.curTime < tun.currentTime){
                  	updateTracker(el, tun.currentTime, t); 
				  }
		
					getTrackerData(el, t);
		
				  
				var curtimetext = document.getElementById("curtimetext");
                var durtimetext = document.getElementById("durtimetext");
                var tm = tun.currentTime * (100 / tun.duration);
                var curmins = Math.floor(tun.currentTime / 60);
                var cursecs = Math.floor(tun.currentTime - curmins * 60);
                var durmins = Math.floor(tun.duration / 60);
                var dursecs = Math.floor(tun.duration - durmins * 60);
                if(cursecs < 10){ cursecs = "0"+cursecs; }
                if(dursecs < 10){ dursecs = "0"+dursecs; }
                if(curmins < 10){ curmins = "0"+curmins; }
                if(durmins < 10){ durmins = "0"+durmins; }
                if(!tun.paused){

                } else {
                  curtimetext.style.color = "#fff";
                  curtimetext.style.fontWeight = "300";
                  durtimetext.style.color = "#fff";
                  durtimetext.style.fontWeight = "300";
                }
                curtimetext.innerHTML = curmins+":"+cursecs;
				document.getElementById("amount").value = Math.round(tm);
				document.getElementById("rangeInput").value = Math.round(tm);
				
                if(isNaN(durmins) && isNaN(dursecs)){
                  durtimetext.innerHTML = "00:00";
				  document.getElementById("amount").value = 0;
				  document.getElementById("rangeInput").value = 0;
                } else {
                  durtimetext.innerHTML = durmins+":"+dursecs;
                }
                if(cursecs === 30.00){
                  //incPlays(el)
                }
				  
				trackerCheck(el, t);
              }
              function playing_now(el){
                var tun = document.getElementById("elevationmovies");			 
                tun.ontimeupdate = function() {get_time(el)};
              }
              function stop(el, t){
                var tun = document.getElementById("elevationmovies");
                var link = document.getElementById("link");			   
                tun.currentTime = 0;
				
                tun.pause();
                link.innerHTML = "<i class=\"fa fa-play-circle fa-lg\" style=\"color: #fff; font-size: 30px;\"> </i>";				 
                tun.load();

              }
		  
		  	  function setVid(el){
                var tun = document.getElementById("elevationmovies");
				var amt = document.getElementById("amount").value; //$('#amount').val();
				tun.currentTime = (tun.duration/100)*amt;
				tun.ontimeupdate = function() {get_time(el)};
              }				  

              function forward(el){
                var tun = document.getElementById("elevationmovies");
                seeker = setInterval(function() {
                tun.currentTime+=1;
				tun.ontimeupdate = function() {get_time(el)};
                },30);
              }
              function rewind(el){
                var tun = document.getElementById("elevationmovies");
                seeker = setInterval(function() {
                tun.currentTime-=1;
				tun.ontimeupdate = function() {get_time(el)};
              },30);
              }
              function end(el){
                clearInterval(seeker)
              }

              function play_video(el){//, vtrack
                var tun = document.getElementById("elevationmovies");
                var link = document.getElementById("link");

                if (tun.paused){

                  tun.play();
                  playing_now(el);
                  link.innerHTML = "<i class=\"fa fa-pause fa-lg\" style=\"color: #fff; font-size: 30px;\"> </i>";
				  
                } else if(!tun.paused) {
                  tun.pause();
                  link.innerHTML = "<i class=\"fa fa-play-circle fa-lg\" style=\"color: #fff; font-size: 30px;\"> </i>";
                  
                } 
                
                tun.onended = function(){					
                  tun.currentTime = 0;
                  link.innerHTML = "<i class=\"fa fa-play-circle fa-lg\" style=\"color: #fff; font-size: 30px;\"> </i>";
                }
                
				
              }

            </script>


@endsection