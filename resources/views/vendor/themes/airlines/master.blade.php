<!DOCTYPE html>
<html lang="en">
<head>
<title>AirLines</title>
<meta charset="utf-8">
<link rel="stylesheet" href="{{ asset('page-assets/css/reset.css') }}" type="text/css" media="all">
<link rel="stylesheet" href="{{ asset('page-assets/css/layout.css') }}" type="text/css" media="all">
<link rel="stylesheet" href="{{ asset('page-assets/css/style.css') }}" type="text/css" media="all">
<script type="text/javascript" src="{{ asset('page-assets/js/jquery-1.5.2.js') }}" ></script>
<script type="text/javascript" src="{{ asset('page-assets/js/cufon-yui.js') }}"></script>
<script type="text/javascript" src="{{ asset('page-assets/js/cufon-replace.js') }}"></script>
<script type="text/javascript" src="{{ asset('page-assets/js/Cabin_400.font.js') }}"></script>
<script type="text/javascript" src="{{ asset('page-assets/js/tabs.js') }}"></script>
<script type="text/javascript" src="{{ asset('page-assets/js/jquery.jqtransform.js') }}" ></script>
<script type="text/javascript" src="{{ asset('page-assets/js/jquery.nivo.slider.pack.js') }}"></script>
<script type="text/javascript" src="{{ asset('page-assets/js/atooltip.jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('page-assets/js/script.js') }}"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="{{ asset('page-assets/js/html5.js') }}"></script>
<style type="text/css">.main, .tabs ul.nav a, .content, .button1, .box1, .top { behavior:url("../js/PIE.htc")}</style>
<![endif]-->
</head>
<body id="page1">
<div class="main">
  <!--header -->
  <header>
    <div class="wrapper">
      <h1><a href="{{ asset('home') }}" id="logo">AirLines</a></h1>
      <span id="slogan">Fast, Frequent &amp; Safe Flights</span>
      <nav id="top_nav">
        <ul>
          <li><a href="{{ asset('home') }}" class="nav1">Home</a></li>
          <li><a href="#" class="nav2">Sitemap</a></li>
          <li><a href="contacts.html" class="nav3">Contact</a></li>
        </ul>
      </nav>
    </div>
    <nav>
      <ul id="menu">
        <li id="menu_active"><a href="{{ asset('about') }}"><span><span>About</span></span></a></li>
        <li><a href="{{ asset('offers') }}"><span><span>Offers</span></span></a></li>
        <li><a href="{{ asset('book') }}"><span><span>Book</span></span></a></li>
        <li><a href="{{ asset('services') }}"><span><span>Services</span></span></a></li>
        <li><a href="{{ asset('safety') }}"><span><span>Safety</span></span></a></li>
        <li class="end"><a href="{{ asset('contacts') }}"><span><span>Contacts</span></span></a></li>
      </ul>
    </nav>
  </header>
  <!-- / header -->
  <!--content -->
  @yield('content')
  <!--content end-->
  <!--footer -->
  <footer>
    <div class="wrapper">
      <ul id="icons">
        <li><a href="#" class="normaltip"><img src="{{ asset('page-assets/images/icon1.jpg') }}" alt=""></a></li>
        <li><a href="#" class="normaltip"><img src="{{ asset('page-assets/images/icon2.jpg') }}" alt=""></a></li>
        <li><a href="#" class="normaltip"><img src="{{ asset('page-assets/images/icon3.jpg') }}" alt=""></a></li>
        <li><a href="#" class="normaltip"><img src="{{ asset('page-assets/images/icon4.jpg') }}" alt=""></a></li>
        <li><a href="#" class="normaltip"><img src="{{ asset('page-assets/images/icon5.jpg') }}" alt=""></a></li>
        <li><a href="#" class="normaltip"><img src="{{ asset('page-assets/images/icon6.jpg') }}" alt=""></a></li>
      </ul>
      <div class="links">Copyright &copy; <a href="#">Domain Name</a> All Rights Reserved<br>
        Design by <a target="_blank" href="http://www.templatemonster.com/">TemplateMonster.com</a></div>
    </div>
  </footer>
  <!--footer end-->
</div>
<script type="text/javascript">Cufon.now();</script>
<script type="text/javascript">
$(document).ready(function () {
    tabs.init();
});
jQuery(document).ready(function ($) {
    $('#form_1, #form_2, #form_3').jqTransform({
        imgPath: 'jqtransformplugin/img/'
    });
});
$(window).load(function () {
    $('#slider').nivoSlider({
        effect: 'fade', //Specify sets like: 'fold,fade,sliceDown, sliceDownLeft, sliceUp, sliceUpLeft, sliceUpDown, sliceUpDownLeft' 
        slices: 15,
        animSpeed: 500,
        pauseTime: 6000,
        startSlide: 0, //Set starting Slide (0 index)
        directionNav: false, //Next & Prev
        directionNavHide: false, //Only show on hover
        controlNav: false, //1,2,3...
        controlNavThumbs: false, //Use thumbnails for Control Nav
        controlNavThumbsFromRel: false, //Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', //Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
        keyboardNav: true, //Use left & right arrows
        pauseOnHover: true, //Stop animation while hovering
        manualAdvance: false, //Force manual transitions
        captionOpacity: 1, //Universal caption opacity
        beforeChange: function () {},
        afterChange: function () {},
        slideshowEnd: function () {} //Triggers after all slides have been shown
    });
});
</script>
</body>
</html>