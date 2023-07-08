<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KDI - EPT Data Dashboard</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.svg">
    <link rel="stylesheet" href="/assets/css/landing.css" />
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
  </head>
  <body>
    <div class="landing-container">
      
      <div class="form-box">
        <div><img src="/assets/images/Kimpact Dev.png" alt="kdi logo"><h2>EPT Dashboard - <span id="title"> Sign in</span></h2></div>
        <!-- <h1 >Sign Up</h1> -->
        <form id="authForm" method="post" action="{{route('auth')}}">
          @csrf

          {{-- auth error section --}}
          <div>
            @if($errors->any())
              @foreach($errors->all() as $e)
                <div>{{$e}}</div>
              @endforeach
            @endif
          </div>
          {{-- end auth error section --}}

          <div class="input-group">
            <div class="input-field" id="nameField">
              <span class="material-icons-sharp">person</span>
              <input type="text" name="fullname" placeholder="Name" disabled/>
            </div>
            <div class="input-field">
              <span class="material-icons-sharp">email</span>
              <input type="email" name="email" placeholder="Email"/>
            </div>

            <div class="input-field">
              <span class="material-icons-sharp">lock</span>
              <input type="password" name="password" placeholder="Password"/>
            </div>
            <p class="showp">Forgot password? <a href="#">Click Here!</a></p>
          </div>
          <div class="btn-field">
            <button type="button" id="signupBtn" class="disable">Sign up</button>
            <button type="button" id="signinBtn">
              Sign in
            </button>
          </div>
        </form>
        {{--
        <p class="googleLogin">Or Sign in with &nbsp; 
          <a><img src="/assets/images/google.svg" alt="">
          </a>&nbsp;<a href="#"><img src="/assets/images/facebook.svg" alt=""></a>
        </p>
        --}}
        <div class="return-dashboard">
        <span class="material-icons-sharp">keyboard_backspace</span>
        <a href="{{route('dashboard')}}">Back</a>
        </div>
      </div>
      
    </div>

    <script src="/assets/js/landing.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" 
      integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" 
      crossorigin="anonymous"></script>
    @include('sweetalert::alert')
  </body>
</html>
