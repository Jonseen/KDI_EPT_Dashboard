<aside>
    <div class="top">
        <a href="https://www.kdi.org.ng/">
        <img
            class="logo"
            src="/assets/images/kdi_logo_white.png"
            alt="Kimpact Logo"
        />
        </a>
        <div class="close" id="close-btn">
        <span class="material-icons-sharp">close</span>
        </div>
    </div>
    <div class="sidebar">
        <a href="{{route('home')}}">
        <span class="material-icons-sharp">home</span>
        <h3>Home</h3>
        </a>
        <a href="{{route('dashboard')}}" class="{{$title == 'dashboard'? 'active':''}}">
        <span class="material-icons-sharp">dashboard</span>
        <h3>Dashboard</h3>
        </a>
        <a href="{{route('petitionLog')}}" class="{{$title == 'petitions'? 'active':''}}">
        <span class="material-icons-sharp">web_stories</span>
        <h3>Petition Log</h3>
        </a>
        <a href="{{route('judgementLog')}}" class="{{$title == 'judgements'? 'active':''}}">
        <span class="material-icons-sharp">balance</span>
        <h3>Judgement Log</h3>
        </a>
        <a href="{{route('analytics')}}" 
            class="{{$title == 'analytics' || $title == 'petitions-map'? 'active':''}}">
        <span class="material-icons-sharp"> stacked_line_chart </span>
        <h3>Analytics</h3>
        </a>

        <a href="{{route('resources')}}" class="{{$title == 'resources'? 'active':''}}">
        <span class="material-icons-sharp">article</span>
        <h3>Resources</h3>
        </a>
        <a href="{{route('community')}}" class="{{$title == 'community'? 'active':''}}">
        <span class="material-icons-sharp">groups</span>
        <h3>Communities <span class="activity-count">0</span></h3>
        </a>

        <a href="{{route('about')}}" class="{{$title == 'about'? 'active':''}}">
        <span class="material-icons-sharp">edit_note</span>
        <h3>About</h3>
        </a>

        {{-- available for all logged in users 
        @if(Auth::check())
            <a href="{{route('user.profile')}}" class="{{$title == 'user-profile'? 'active':''}}">
            <span class="material-icons-sharp">person</span>
            <h3>My Profile</h3>
            </a>
        @endif
        --}}

        @if(Auth::check())
            <a href="{{route('logout')}}">
            <span class="material-icons-sharp">logout</span>
            <h3>Logout</h3>
            </a>
        @endif
    </div>
</aside>