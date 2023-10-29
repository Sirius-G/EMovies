<nav class="navbar fixed-top navbar-expand-lg top-bar">
  <div class="container-fluid">
    <a class="navbar-brand" href="/"><img src="{{asset('images/em.png')}}" style="height: 30px; margin: -30px 0px -20px 0px;"><img src="{{asset('images/logo2.png')}}" style="height: 35px; margin: -30px 0px -20px 0px;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        @guest 
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Welcome</a>
        </li>
        @else  
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        @endguest
      </ul>
    </div>      
    @guest
      <ul class="navbar-nav d-flex justify-content-end">
        
            <li class="nav-item">
                <a class="nav-link" href="/login" tabindex="-1">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/register" tabindex="-1">Register</a>
            </li>

      </ul>
      @else 
        @if(Auth()->User()->id < 4)
          <li class="nav-link">
                  <a class="nav-link" href="/admin" tabindex="-1">Admin Panel</a>
            </li>
        @endif
        <li class="nav-link">
            <a href="{{ route('logout') }}"  alt="Logout of Elevation Movies"
                onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out"> </i> Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>       
      @endguest
   
  </div>
</nav>