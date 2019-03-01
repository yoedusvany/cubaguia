<!--==========================
    Header
  ============================-->
<header id="header">
    <div class="container-fluid">

        <div id="logo" class="pull-left">
            <h1><a href="#intro" class="scrollto">CubaGuia</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="#intro"><img src="img/logo.png" alt="" title="" /></a>-->
        </div>

        <nav id="nav-menu-container">
            <ul class="nav-menu">
                <li class="menu-active"><a href="#intro"> {{ __('Home') }}</a></li>
                <li><a href="#about">{{ __('About Us') }}</a></li>
                <li><a href="#services">{{ __('Services') }}</a></li>
                <li><a href="#portfolio">{{ __('Excursions') }}</a></li>
                <li><a href="#contact">{{ __('Contact Us') }}</a></li>

                <li><a href="{{ url('/locale') ."/".$locale }}">{{ $locale }}</a></li>

                <li><a href="{{ url('login') }}">{{ __("Login") }}</a></li>

            </ul>
        </nav><!-- #nav-menu-container -->
    </div>
</header><!-- #header -->
