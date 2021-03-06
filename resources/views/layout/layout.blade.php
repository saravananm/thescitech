<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">
		<link rel="icon" href="{{ asset('/public/image/sticon.png') }}" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keyword" content="@yield('metakeyword')">
        <meta name="description" content="@yield('metadescription')">

        <meta name="author" content="thescitech">
        <meta name="revisit-after" content="1 days">
        <meta name="distribution" content="web">
        <META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">

        <meta name="thumbnail" content="http://www.thescitech.com/public/image/logo.jpg" />
        <meta name="google-site-verification" content="kOdzEZfwy6FX9GvBnqilDQemYmlktLcSedlhiKeD6Pg" />


        <link rel="stylesheet" href="{{ asset('/public/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('/public/css/bootstrap/4.5.0/css/bootstrap.min.css') }}">
        <script type="text/javascript" src="{{ asset('/public/js/jquery-3.5.1.min.js') }}"></script>
        @stack('head')
    </head>
    <body>  
        <div class="container">
            <header>
                <div class="header-banner">
                    @foreach($advertisementdetails_banner as $advertisements_banner)
                        <a href="{{$advertisements_banner->url}}" target="blank">
                            <div style="position: relative; width:{{$advertisements_banner->width}}px;height:{{$advertisements_banner->height}}px; margin: 0 auto;">
                                <img src= "{{url('public/storage/images/advertisements/'.$advertisements_banner->image_name) }}" style="width:{{$advertisements_banner->width}}px;height:{{$advertisements_banner->height}}px" alt="{{$advertisements_banner->name}}" />
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-3 pr-0">
                        <a href="{{url('/')}}">
                            <img src="{{ asset('/public/image/logo.jpg') }}"   class="header-logo" alt="Logo" />
                        </a>
                    </div>
                    <div class="col-md-12 col-lg-9" >
                        <div class="header-nav">
                            <a href={{url('/')}}  class="{{ (request()->is('/')) ? 'active' : '' }}"> Home</a>
                            <a class="{{ (request()->is('news-and-features')) ? 'active' : '' }}" href="{{url('news-and-features')}}">News&Features</a>
                            <a class="{{ (request()->is('discoveries-and-innovations')) ? 'active' : '' }}" href="{{url('discoveries-and-innovations')}}">Discoveries&Innovations</a>
                            <a class="{{ (request()->is('applications-and-impacts')) ? 'active' : '' }}" href="{{url('applications-and-impacts')}}">Applications&Impacts</a>
                            <a class="{{ (request()->is('science-and-society')) ? 'active' : '' }}" href="{{url('science-and-society')}}">Science&Society</a>
                            <a class="{{ (request()->is('the-scitech-journal')) ? 'active' : '' }}" href="{{url('the-scitech-journal')}}">TheScitechJournal</a>
                        </div>
                    </div>
                </div> 
            </header>
        </div>
		<div class="bottom-line"></div>
		<div class="clearfix pt-1"></div>
        <div class="container">
            <div class="row">
                 @yield('content')
            </div>
        </div>
		<div class="container-fluid pr-0 pl-0">
            <footer>
                <div class="footer-menu">
                  <a href="{{url('/')}}">Home</a>
                  <a href="{{url('about')}}">About</a>
                  <a href="{{url('subscribe')}}">Subscribe</a>
                  <a href="{{url('advertise')}}">Advertise</a>
                  <a href="{{url('contact')}}">Contact</a>
                </div>
                <h4>Samanthi Publications Pvt. Ltd | Phone : +91-44- 28175694</h4>
                <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
            </footer>
        </div>
        <script src="{{ asset('/public/css/bootstrap/4.5.0/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/public/js/custom.js') }}"></script>
    </body>
</html>
