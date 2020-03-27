<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Calls') - Browser Calls</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- CSS -->
    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="{{ asset('css/bicycle-polo.css', true) }}" rel="stylesheet"> -->
    

    <!-- Bootstrap core CSS -->
    <!-- <link href="{{asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-reset.css')}}" rel="stylesheet">
   
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet" /> -->


    <link href="//res.cloudinary.com/dafvkhky6/raw/upload/v1560010615/TwilioLaravel/bootstrap.css" rel="stylesheet">
    <link href="//res.cloudinary.com/dafvkhky6/raw/upload/v1560010615/TwilioLaravel/bootstrap-reset.css" rel="stylesheet">
   
    <link href="//res.cloudinary.com/dafvkhky6/raw/upload/v1560010638/TwilioLaravel/font-awesome.css" rel="stylesheet" />
    <link href="//res.cloudinary.com/dafvkhky6/raw/upload/v1560010615/TwilioLaravel/style.css" rel="stylesheet">
    <link href="//res.cloudinary.com/dafvkhky6/raw/upload/v1560010615/TwilioLaravel/style-responsive.css" rel="stylesheet" />
    

    @yield('css')
  </head>

  <body>

    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Limited Papers Co.</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
          <!-- <ul class="nav navbar-nav navbar-right">
            <li><a href="{{ route('dashboard') }}">Support dashboard</a></li>
          </ul> -->
          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav ml-auto navbar-right">
            <!-- Authentication Links -->
            @guest
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link" href="{{ route('api_login') }}">{{ __('API Login') }}</a>
              </li> -->
                @if (Route::has('register'))
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                  </li>
                @endif
            @else
              <li class="nav-item">
                <a class="nav-link" href="{{ route('showTicketlist') }}">{{ __('My Requests') }}</a>
              </li>
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->fname }} {{ Auth::user()->lname }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    @yield('content')


    <!-- <div class="container">

      <footer>
        <p>&copy; Limited Papers Co. 2019</p>
      </footer>

    </div>  -->
    <!-- /container -->

    <!-- JavaScript -->
    <!-- <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->


    <script src="//res.cloudinary.com/dafvkhky6/raw/upload/v1560010666/TwilioLaravel/jquery.js"></script>
    <script src="//res.cloudinary.com/dafvkhky6/raw/upload/v1560010666/TwilioLaravel/bootstrap.js"></script>

    <!-- <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script> -->

    <!-- <script class="include" type="text/javascript" src="{{secure_asset('js/jquery.dcjqaccordion.2.7.js')}}"></script>
    <script src="{{secure_asset('js/jquery.scrollTo.min.js')}}"></script>
    <script src="{{secure_asset('js/jquery.nicescroll.js')}}" type="text/javascript"></script>
    <script src="{{secure_asset('js/respond.min.js')}}" ></script> -->

    <!--right slidebar-->
    <!-- <script src="{{secure_asset('js/slidebars.min.js')}}"></script> -->

    <!--common script for all pages-->
    <!-- <script src="{{secure_asset('js/common-scripts.js')}}"></script> -->
    <!-- <script src="{{secure_asset('js/script.js')}}"></script> -->

    <script src="//static.twilio.com/libs/twiliojs/1.2/twilio.min.js"></script>

    @yield('javascript')

    <script src="{{ asset('js/browser-calls.js', true) }}"></script>
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
  </body>

</html>
