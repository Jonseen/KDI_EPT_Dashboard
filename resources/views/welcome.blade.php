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
  <body onload="redirect_Page(this)">
    <div class="landing-container">
      <div class="welcome-box">
        <div class="gavel">
          <img src="/assets/images/Judge_gavel.svg" alt="kdi logo" />
          <!-- <span class="material-icons-sharp">lock</span> -->
        </div>
        <div>
          <h1 class="welcome">
            Nigeria Election Petition Tribunal Monitoring Dashboard
          </h1>
          <!-- <div><img src="/assets/images/loading-gif.gif" alt="loading..."></div> -->
          <!-- <div class="btn-field"> -->
            <!-- <a href="{{route('dashboard')}}">Loading Dashboard </a> -->
            <!-- <span class="material-icons-sharp"> login </span> -->
            
          <!-- </div> -->
          
            
        </div>
        
      </div>
      <div class="welcome-loading">
            <img class="loaderImage" id="loader" src="/assets/images/loader5.gif" alt="loading...">
            <h2>Loading Dashboard..</h2>
      </div>
      <div class="branding">
            <div class="usaid"><img src="/assets/images/usaid.jpg" alt="usaid logo" srcset=""></div>
            <div class="ifes"><img src="/assets/images/ifes-logo.png" alt="ifes logo" srcset=""  ></div>
            <div class="cepps"><img src="/assets/images/cepps.jpg" alt="cepps logo" srcset=""></div>
            <div class="ukaid"><img src="/assets/images/ukaid.png" alt="ukaid logo" srcset="" ></div>
            <div class="kdi"><img src="/assets/images/Kimpact Dev.png" alt="KDI logo" srcset=""></div>
      </div>
      <div class="mobile-branding">
      <img src="/assets/images/mobile-branding.png" alt="usaid logo" srcset="">
      </div>
    </div>

    <script src="/assets/js/landing.js"></script>
  </body>
</html>
