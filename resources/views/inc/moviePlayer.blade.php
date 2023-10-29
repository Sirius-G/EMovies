`<div class="video_section">
    
    <!-- Video Section -->
    <div class="margin-top: 0px;" id="video_wrapper">
        @if(count($current_video)>0)
        @foreach($current_video as $v)
        <div class="video_title" style="position: absolute; top: 80px; left: 50px; color: #fff; font-size: 25px; font-famly: tahoma, sans-serif;">{{$v->title}}</div>
        @if(strpos($v->feature, "https://") !==false)
            @php $video_source = $v->feature; $poster = '/assets/posters/'.$v->poster; @endphp
            <video id="elevationmovies" style="margin: 2.5% 0px 0px 10%; width: 80%; height: calc(80vw*0.5625)px;" playsinline poster="{{asset($poster)}}">
              <source id="source_id" src="{{asset($video_source)}}" type="video/mp4">
                Your browser does not support HTML5 Video.
            </video>
        @else
          @php $video_source = '/assets/videos/'.$v->feature; $poster = '/assets/posters/'.$v->poster; @endphp
            <video id="elevationmovies" style="margin: 2.5% 0px 0px 10%; width: 80%; height: calc(80vw*0.5625)px;" playsinline poster="{{asset($poster)}}">
              <source id="source_id" src="{{asset($video_source)}}" type="video/mp4">
                Your browser does not support HTML5 Video.
            </video>
        @endif
        @endforeach
        @endif

        <div class="security_layer"></div>
    <!--  ============== Video Control Bar - FOOTER ================= -->
<div class="video_controls">
<div class="row text-white" id="video_controls">
    
    @if(count($current_video)>0)
    @foreach($current_video as $v)
    <div class="col-xs-6 col-sm-5 col-md-5 col-lg-5 d-flex justify-content-evenly">
	   <!-- Determine what type of media is playing - Audio or Video -->

		<script>			
			var ev = document.getElementById("elevationmovies");
			let rp = {id: {{$v->id}}, tp: "Video", curTime: ev.currentTime};
			//console.log(rp);
		</script>
       <!-- Control Icons -->
        <a id="link" onclick="play_video(rp.id)" href="#/" class="btn btn-secondary btn-sm p-2">
            <i style="color: #fff; font-size: 30px;" class="fa fa-play-circle fa-lg"> </i>
        </a>
        <!-- Stop -->
        <!-- <a onclick="stop(rp.id, rp.tp)" href="#/" class="btn btn-secondary btn-sm p-2"><i style="color: #fff; font-size: 30px;" class="fa fa-stop fa-lg"> </i></a> -->
        <!-- Display times -->
        <span style="color: #fff; margin-left: 30px;">
            <span id="curtimetext">00:00</span> / <span id="durtimetext">00:00</span>
        </span> 
</div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 d-flex justify-content-center">
        <!--Seek Bar-->
        <input type="range" id="rangeInput" name="rangeInput" min="0" max="100" value="0" oninput="amount.value=rangeInput.value, setVid(rp.id)" style="color: #fff; width: 80%; font-size: 30px;">                                                       
        <output id="amount" name="amount" for="rangeInput" onchange="setVid(rp.id)" >0</output>%	

  
      </div>
      <!-- <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 d-flex justify-content-center"> -->
          <!-- Volume Controls -->
          <!-- <a onclick="vol_up(rp.id)" href="#/">
            <i style="color: #fff; font-size: 30px;" class="fa fa-volume-up fa-lg"> </i>
          </a>
          <span style="color: #fff; margin-left: 20px;" id="v">1.0</span>
          <a onclick="vol_down(rp.id)" href="#/">
            <i style="color: #fff; margin-left: 20px; font-size: 30px;" class="fa fa-volume-down fa-lg"> </i>
          </a>
      </div> -->
      <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1 d-flex justify-content-end">
        <a href="#/" onclick="openFullscreen();" id="ofs" class="btn btn-secondary btn-sm p-2 mx-2" style="display: block;">
          <i class="fa fa-expand fa-lg text-white"></i>
        </a>
        <a href="#/" onclick="closeFullscreen();" id="cfs" class="btn btn-secondary btn-sm p-2 mx-2" style="display: none;">
          <i class="fa fa-close fa-lg text-white"></i>
        </a>
      </div>
      </div>
      @endforeach
    @endif
  
    </div></div>
    
    
    </div>
    <!-- <div id="tracking"></div> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
//Bespoke Video/Music Player Controls

    function vol_up(el){
      var ev = document.getElementById("elevationmovies");
      if(ev.volume < 0.95){
        ev.volume+=0.1;
      }
      get_volume(el);
    }
    function vol_down(el){
      var ev = document.getElementById("elevationmovies");
      if(ev.volume > 0.05){
        ev.volume-=0.1;
      }
      get_volume(el);
    }
    function get_volume(el){
      var ev = document.getElementById("elevationmovies");
      var v = document.getElementById("v");
      v.innerHTML =  parseFloat(ev.volume).toFixed(1);
    }
    function get_time(el){
      var ev = document.getElementById("elevationmovies");
      var getsrc = document.getElementById("source_id");
      var xxx = ev.getAttribute("src");
      if(xxx === null){ 
        xxx = getsrc.getAttribute("src");
      }
      var zzz = xxx.split(".").pop();
      if(zzz === "mp4" || zzz === "avi" || zzz === "mov"){ 
        t = "Video"; 
      } else if (zzz === "mp3" || zzz === "wav"){
        t = "SFX";
      } 

      var curtimetext = document.getElementById("curtimetext");
      var durtimetext = document.getElementById("durtimetext");
      var tm = ev.currentTime * (100 / ev.duration);
      var curmins = Math.floor(ev.currentTime / 60);
      var cursecs = Math.floor(ev.currentTime - curmins * 60);
      var durmins = Math.floor(ev.duration / 60);
      var dursecs = Math.floor(ev.duration - durmins * 60);
      if(cursecs < 10){ cursecs = "0"+cursecs; }
      if(dursecs < 10){ dursecs = "0"+dursecs; }
      if(curmins < 10){ curmins = "0"+curmins; }
      if(durmins < 10){ durmins = "0"+durmins; }

      if(!ev.paused){
        
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

      //if(curtime === 30){ //***** if current time = 30 increment plays --- TODO discuss with Lisa
        //incPlays(el)
      //}
      updateTracker(el, ev.currentTime, 'Video', ev.duration);
    }
    function playing_now(el,){
      var ev = document.getElementById("elevationmovies");			 
      ev.ontimeupdate = function() {
      get_time(el);
      };
    }
    // function stop(el, t){
    //   var ev = document.getElementById("elevationmovies");
    //   var link = document.getElementById("link");			   
    //   ev.currentTime = 0;

    //   ev.pause();
    //   link.innerHTML = "<i class=\"fa fa-play-circle fa-lg\" style=\"color: #fff; font-size: 30px;\"> </i>";			 
    //   ev.load();
    // }

    function setVid(el){
      var ev = document.getElementById("elevationmovies");
      var amt = document.getElementById("amount").value;
      ev.currentTime = (ev.duration/100)*amt;
      ev.ontimeupdate = function() { 
        get_time(el); 
      };
    }				  

    function play_video(el){
      var ev = document.getElementById("elevationmovies");
      var link = document.getElementById("link");
      if (ev.paused){
        ev.play();
        playing_now(el);
        link.innerHTML = "<i class=\"fa fa-pause fa-lg\" style=\"color: #fff; font-size: 30px;\"> </i>";
      } else if(!ev.paused) {
        ev.pause();
        link.innerHTML = "<i class=\"fa fa-play-circle fa-lg\" style=\"color: #fff; font-size: 30px;\"> </i>";
      } 
      //If video ends, go back to more info page
      ev.onended = function(){					
        link.innerHTML = "<i class=\"fa fa-play-circle fa-lg\" style=\"color: #fff; font-size: 30px;\"> </i>";
        location.replace('/more_info/'+ el);
        updateTracker(el, ev.currentTime, 'Video', ev.duration);
      }
    } 		

    function updateTracker(el, ctime, t, dtime){
      $.ajax({
          type: "GET",
          url: "/tracker_update?id=" + el + "&ctm=" + ctime+ "&t=" + t + "&dtm=" + dtime,
          cache: false,
          success: function(data){
              //Do something here if desired
          }
      });
    }


          //Hide or Show Black Controls based on Mouse Activity
          var idleTime = 0;
					$(document).ready(function () {
            //Increment the idle time counter every minute.
            var idleInterval = setInterval(timerIncrement, 5000); // 5 seconds

            //Zero the idle timer on mouse movement.
            $(this).mousemove(function (e) {
              idleTime = 0;
              $(".video_controls").fadeIn();
              $(".video_title").fadeIn();
            });
            $(this).click(function (e) {
              idleTime = 0;
              $(".video_controls").fadeIn();
              $(".video_title").fadeIn();
            });
            $(this).keypress(function (e) {
              idleTime = 0;
              $(".video_controls").fadeIn();
              $(".video_title").fadeIn();
            });
            });

            function timerIncrement() {
            idleTime = idleTime + 1;
            if (idleTime > 1) { // 5 Seconds
              // fade out div
              $(".video_controls").fadeOut();
              $(".video_title").fadeOut();
            }
					}
  
          var elem = document.getElementById("video_wrapper");
          var ev = document.getElementById("elevationmovies");
          var ofs = document.getElementById("ofs");
          var cfs = document.getElementById("cfs");
          function openFullscreen() {
            if (elem.requestFullscreen) {
              elem.requestFullscreen();
              ev.style.width = '100%';
              ev.style.margin = '0px 0px 0px 0px';
              ofs.style.display = 'none';
              cfs.style.display = 'block';
            } else if (elem.webkitRequestFullscreen) { /* Safari */
              elem.webkitRequestFullscreen();
              ev.style.width = '100%';
              ev.style.margin = '0px 0px 0px 0px';
              ofs.style.display = 'none';
              cfs.style.display = 'block';
            } else if (elem.msRequestFullscreen) { /* IE11 */
              elem.msRequestFullscreen();
              ev.style.width = '100%';
              ev.style.margin = '0px 0px 0px 0px';
              ofs.style.display = 'none';
              cfs.style.display = 'block';
            }
          }

          function closeFullscreen() {
            if (document.exitFullscreen) {
              document.exitFullscreen();
              ev.style.width = '80%';
              ev.style.margin = '2.5% 0px 0px 10%';
              ofs.style.display = 'block';
              cfs.style.display = 'none';
            } else if (document.webkitExitFullscreen) { /* Safari */
              document.webkitExitFullscreen();
              ev.style.width = '80%';
              ev.style.margin = '2.5% 0px 0px 10%';
              ofs.style.display = 'block';
              cfs.style.display = 'none';
            } else if (document.msExitFullscreen) { /* IE11 */
              document.msExitFullscreen();
              ev.style.width = '80%';
              ev.style.margin = '2.5% 0px 0px 10%';
              ofs.style.display = 'block';
              cfs.style.display = 'none';
            }
          }

  </script>