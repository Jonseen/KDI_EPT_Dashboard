<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EPT Data Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.svg">
    
    <!-- STYLE SHEET  -->
    <link rel="stylesheet" href="/assets/css/style.css" />
    <!-- MATERIAL CDN -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0"
    />
    
    <script src="/assets/js/config.js"></script>
    <script src="/assets/js/data-filter.js"></script>
  </head>

  <body>
    <script>
      config.isAuth = {{(Auth::check())? "true":"false"}};
      config.isAdmin = {{(Auth::check() && Auth::user()->role != "user")? "true":"false"}};
    </script>
    
    <div class="container">
    
      @include('components.nav-panel')

      <!-- E N D OF A S I D E -->
      <main>
        <div class="title">
          <h1>
            <span>Election Petition Tribunal Monitoring -</span> @yield('title')
          </h1>
        </div>
        
        <div class="filter_pane">
          <div class="left-break">
          <a href="{{route('dashboard')}}" class="backbtn">
            <div><span class="material-icons-sharp">chevron_left</span></div>
            <div><h3>Home</h3></div>
          </a>

  
  <!-- ====================== SEARCH BAR ============================== -->
          <!-- <form action="" class="search-bar">
                <input type="text" name="search" placeholder="Search for petitioner.." id="">
                <button type="submit"><span class="material-icons-sharp">search</span></button>
          </form> -->

          </div>
          @if(array_search($title, ['dashboard', 'petitions-map', 'petitions', 'judgements']) !== false)

          <!-- =========================== END OF SEARCH BAR ======================= -->
          <div>
            <div class="dropdown">
            
              <button class="dropbtn">
                <div><span class="material-icons-sharp">expand_more</span></div>
                <div id="year">2023</div>
              </button>
              <div class="dropdown-content">
                <a href="#" data-filter-type='year' data-value="none">No Filter</a>
                <a href="#" data-filter-type='year' data-value="1999">1999</a>
                <a href="#" data-filter-type='year' data-value="2003">2003</a>
                <a href="#" data-filter-type='year' data-value="2007">2007</a>
                <a href="#" data-filter-type='year' data-value="2011">2011</a>
                <a href="#" data-filter-type='year' data-value="2015">2015</a>
                <a href="#" data-filter-type='year' data-value="2019">2019</a>
                <a href="#" data-filter-type='year' data-value="2023">2023</a>
              </div>
            </div>
            <div class="dropdown">
              <button class="dropbtn">
                <div><span class="material-icons-sharp">expand_more</span></div>
                <div id="election_type">Election Type</div>
              </button>
              <div class="dropdown-content">
                <a href="#" data-filter-type='election_type' data-value="none">No Filter</a>
                @foreach(\App\Models\PetitionLog::$electionTypes as $type)
                  <a href="#" data-filter-type='election_type' data-value="{{$type}}">{{$type}}</a>
                @endforeach
              </div>
            </div>

            @if($title != "judgements")
              <div class="dropdown">
                <button class="dropbtn">
                  <div><span class="material-icons-sharp">expand_more</span></div>
                  <div id="stage">Stage</div>
                </button>
                <div class="dropdown-content">
                  <a href="#" data-filter-type='stage' data-value="none" >No Filter</a>
                  @foreach(\App\Models\PetitionLog::$petitionStages as $stage)
                    <a href="#" data-filter-type='stage' data-value="{{$stage}}">{{$stage}}</a>
                  @endforeach                
                </div>
              </div>
            @endif

            <div class="dropdown">
              <button class="dropbtn">
                <div><span class="material-icons-sharp">expand_more</span></div>
                <div id="state">State</div>
              </button>
              <div class="dropdown-content">
                <a href="#" data-filter-type='state' data-value="none">No Filter</a>
                @forelse(\App\Http\Services\PetitionLogService::getStates() as $s)
                <a href="#"class="state-dropdown" data-filter-type='state' data-value="{{$s->state}}">{{$s->state}}</a>
                @empty
                <a href="">No Data</a>
                @endforelse
              </div>

            </div>
          </div>
          @endif
        </div>        
        
        @yield('content')
        
      </main>
      <!-- END OF MAIN  -->

      @include('components.right-side-panel')

    </div>

    @include('components.footer')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" 
      integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" 
      crossorigin="anonymous"></script>
    <script src="/assets/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"
      integrity="sha512-v3ygConQmvH0QehvQa6gSvTE2VdBZ6wkLOlmK7Mcy2mZ0ZF9saNbbk19QeaoTHdWIEiTlWmrwAL4hS8ElnGFbA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <!-- My Js file -->
    <script src="/assets/js/charts.js"></script>
    <script>
      window.addEventListener('load', ()=> { initModalElements(); });
    </script>
    @include('sweetalert::alert')
    <script src="/vendor/sweetalert/sweetalert.all.js"></script>
  </body>
</html>
