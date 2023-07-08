<div class="right">
    <div class="top">
        <button id="menu-btn">
        <span class="material-icons-sharp">menu</span>
        </button>
        
        <div class="theme-toggler">
        <span class="material-icons-sharp active">light_mode</span>
        <span class="material-icons-sharp">dark_mode</span>
        </div>
        <div class="loginbtn">
            @if(Auth::check())
                @php($name = explode(' ', Auth::user()->fullname))
                <a>{{(Auth::user()->role == "user")? $name[0]: "Admin"}}</a>
            @else
                <a href="{{route('login')}}">Sign in</a>
            @endif
        
            <!-- <a href="KDI EPT Dashboard Login/Login.html">Sign up</a> -->
        </div>
        <div class="profile-photo">
        <img src="/assets/images/user2.png" alt="profile picture" />
        </div>
        <!-- <div class="profile">
        <div class="info">
            <p>Hey, <b>Kimpact</b></p>
            <small class="text-muted">Admin</small>
            <a href="KDI EPT Dashboard Login/Login.html" class="primary">Sign in</a>
            <a href="KDI EPT Dashboard Login/Login.html">Sign up</a>
        </div>
        
        </div> -->
    </div>
    <!-- END OF TOP  -->
    <div class="countDown">
        <h3>Countdown to End of Presidential/National Assembly EPT</h3>
        <script>
        (function (d, s, id) {
            var js,
            pjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//www.tickcounter.com/static/js/loader.js";
            pjs.parentNode.insertBefore(js, pjs);
        })(document, "script", "tickcounter-sdk");
        </script>
        <a
        data-type="countdown"
        data-id="3960520"
        class="tickcounter"
        style="
            display: block;
            width: 100%;
            position: relative;
            padding-bottom: 15%;
        "
        title="Countdown"
        href="//www.tickcounter.com/"
        >Countdown</a
        >
    </div>
    
    <h2>EPT Top Stories</h2>
    <div class="EPT-updates">
        
        
        <div class="updates">
        <!-- <h3>Top Stories</h3> -->
        @foreach(\App\Models\EPTStories::all()->sortByDesc('created_at') as $story)
        <div class="update">
            <div class="profile-photo">
            <img src="/storage{{$story->image}}" alt="Bukola Idowu" />
            </div>
            <a href="{{route('story', $story->id)}}">
            <div class="message blog_sample">
                <p>{{$story->title}}</p>
                <small class="text-muted">Read more</small>
            </div>
            </a>
        </div>
        @endforeach
        <div class="update">
            <div class="profile-photo">
            <img src="/assets/images/Eholor-talking.webp" alt="Bukola Idowu" />
            </div>
            <a href="{{route('blog')}}">
            <div class="message blog_sample">
                <p>Televise presidential election tribunal to restore confidence in judiciary – <br>Eholor</br></p>
                <small class="text-muted">Read more</small>
            </div>
            </a>
        </div>
        
        <div class="update">
            <div class="profile-photo">
            <img src="/assets/images/adeleke.jpg" alt="Bukola Idowu" />
            </div>
            <a href="{{route('story_1')}}">
            <div class="message blog_sample">
                <p><b>Appeal court</b> affirms Adeleke as Osun governor</p>
                <small class="text-muted">Read more</small>
            </div>
            </a>
        </div>

        <div class="update">
            <div class="profile-photo">
            <img src="/assets/images/appealcourt.jpg" alt="Bukola Idowu" />
            </div>
            <a href="{{route('story_2')}}">
            <div class="message blog_sample">
                <p>
                <b>600 </b> pre-election appeals in appellate court, says
                president court of appeal
                </p>
                <small class="text-muted">Read more</small>
            </div>
            </a>
        </div>
        </div>
    </div>

    {{-- remove for admin on resources page --}}
    @if(!($title == "resources" && Auth::check() && Auth::user()->role != "user"))
    <div class="disclaimer">
    <span class="material-icons-sharp error-icon primary" width="4">error</span>
        <small><span class="primary"><b>Disclaimer: </b></span>  This platform provides information to 
        improve citizens' election petition tribunal knowledge and it is also for research purposes. </small>
    </div>
    @endif

    <!-- ========== ADD NEW PETITION FEATURE (FOR ADMIN - DISABLED FOR USER) =============== -->
    @if($title == "petitions" || $title == "judgements")
        @if(Auth::check() && Auth::user()->role != 'user')
        <div data-modal-target="#modal" class="addNewPetition">
            <div>
                <span class="material-icons-sharp">add</span>
                <h3>Add New Petition</h3>
            </div>
        </div>
        @endif
    @endif
       
    @if($title == "resources")
        @if(Auth::check() && Auth::user()->role != 'user')
        <!-- ============================  ADD NEW EPT STORY  ===================================== -->
        <div data-modal-target="#stories-modal" class="addNewStory">
            <div>
                <span class="material-icons-sharp">add</span>
                <h3>Upload New EPT Story</h3>
            </div>    
        </div>

        <!-- =======================   ADD RESOURCES MODAL ==================================== -->
        <div data-modal-target="#resources-modal" class="addNewResources">
            <div>
                <span class="material-icons-sharp">add</span>
                <h3>Upload New Resources</h3>
            </div>    
        </div>
        @endif
    @endif
   
    <!-- END OF EPT UPDATES   -->
    <div class="MostRecentPetitions">
        <h2>Most Recent Petitions</h2>
        <div class="PetitionTitle">
        <div class="icon">
            <span class="material-symbols-outlined">gavel</span>
        </div>
        <div class="right">
            <div class="info">
            <h3>Mr Peter Obi files petetion against APC</h3>
            <small class="text-muted">Last 1 Minute</small>
            </div>
            <h5 class="success">+13</h5>
        </div>
        </div>
        <div class="PetitionTitle">
        <div class="icon">
            <span class="material-symbols-outlined">gavel</span>
        </div>
        <div class="right">
            <div class="info">
            <h3>Mr Atiku Abubakar files petetion against APC</h3>
            <small class="text-muted">Last 2 Hours</small>
            </div>
            <h5 class="success">+13</h5>
        </div>
        </div>
    </div>
</div>