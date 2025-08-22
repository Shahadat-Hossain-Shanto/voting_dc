<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <title>Sports Mate</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('frontend/assets/images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('frontend/assets/images/icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('frontend/assets/images/icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('frontend/assets/images/icons/site.html') }}">
    <link rel="mask-icon" href="{{ asset('frontend/assets/images/icons/safari-pinned-tab.svg') }}" color="#666666">
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/icons/favicon.ico') }}">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{ asset('frontend/assets/images/icons/browserconfig.xml') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">


    @yield('head')


</head>

<body>
    <div class="page-wrapper">
        <header class="header header-22">

            <div class="wrap-container sticky-header">
                <div class="header-bottom">
                    <div class="container">

                        <div class="header-center">
                            <nav class="main-nav">
                                <ul class="menu sf-arrows">
                                    <li>
                                        <a href="/">Home</a>

                                    </li>

                                    <li>
                                        <a href="/match" class="sf-with-ul">Matches</a>
                                        <div class="megamenu megamenu-md">
                                            <div class="row no-gutters">
                                                <div class="col-md-12">
                                                    <div class="menu-col">
                                                        <div class="row">
                                                            <div class="col-md-4">

                                                                <!-- End .menu-title -->
                                                                <ul>
                                                                    @foreach ($category as $cate)

                                                                    <li><a href="/match/{{ $cate->name }}">{{ $cate->name }}</a></li>
                                                                        
                                                                    @endforeach
                                                                    
                                                                </ul>

                                                            </div><!-- End .row -->


                                                        </div><!-- End .menu-col -->
                                                    </div><!-- End .col-md-8 -->
                                                    <!-- End .col-md-4 -->
                                                </div><!-- End .row -->
                                            </div><!-- End .megamenu megamenu-md -->
                                    </li>
                                    <li>
                                        <a href="/highlights-all" class="sf-with-ul">highLights</a>
                                        <div class="megamenu megamenu-md">
                                            <div class="row no-gutters">
                                                <div class="col-md-12">
                                                    <div class="menu-col">
                                                        <div class="row">
                                                            <div class="col-md-4">

                                                                <!-- End .menu-title -->
                                                                <ul>
                                                                    @foreach ($category as $cate)

                                                                    <li><a href="/highlights-all/{{ $cate->name }}">{{ $cate->name }}</a></li>
                                                                        
                                                                    @endforeach
                                                                </ul>

                                                            </div><!-- End .row -->


                                                        </div><!-- End .menu-col -->
                                                    </div><!-- End .col-md-8 -->
                                                    <!-- End .col-md-4 -->
                                                </div><!-- End .row -->
                                            </div><!-- End .megamenu megamenu-md -->

                                    </li>
                                    <li>
                                        <a href="/news-all" class="sf-with-ul">News</a>
                                        <div class="megamenu megamenu-md">
                                            <div class="row no-gutters">
                                                <div class="col-md-12">
                                                    <div class="menu-col">
                                                        <div class="row">
                                                            <div class="col-md-4">

                                                                <!-- End .menu-title -->
                                                                <ul>
                                                                    @foreach ($category as $cate)

                                                                    <li><a href="/news-all/{{ $cate->name }}">{{ $cate->name }}</a></li>
                                                                        
                                                                    @endforeach
                                                                </ul>

                                                            </div><!-- End .row -->


                                                        </div><!-- End .menu-col -->
                                                    </div><!-- End .col-md-8 -->
                                                    <!-- End .col-md-4 -->
                                                </div><!-- End .row -->
                                            </div><!-- End .megamenu megamenu-md -->
                                    </li>
                                    <li>
                                        <a href="/tv"><i style='color: red;' class="fa fa-circle"
                                                aria-hidden="true"></i>TV</a>
                                    </li>
                                    <li>
                                        <a href="/live-now" class="sf-with-ul">Live</a>
                                        <div class="megamenu megamenu-md">
                                            <div class="row no-gutters">
                                                <div class="col-md-12">
                                                    <div class="menu-col">
                                                        <div class="row">
                                                            <div class="col-md-4">

                                                                <!-- End .menu-title -->
                                                                <ul>
                                                                    @foreach ($category as $cate)

                                                                    <li><a href="/live-now/{{ $cate->name }}">{{ $cate->name }}</a></li>
                                                                        
                                                                    @endforeach

                                                                    
                                                                    
                                    </li>
                                </ul>
                        </div><!-- End .row -->
                    </div><!-- End .menu-col -->
                </div><!-- End .col-md-8 -->
                <!-- End .col-md-4 -->
            </div><!-- End .row -->
    </div><!-- End .megamenu megamenu-md -->
    </li>
    </ul><!-- End .menu -->
    </nav><!-- End .main-nav -->
    </div><!-- End .header-left -->

    <div style="margin-left: 20%;" class="header-right">
        <div class="header-text">
            <ul class="top-menu top-link-menu">
                <li>
                    <ul>
                        {{-- <a href="/login"><i class="icon-user"></i>Login / Registration</a> --}}
                    </ul>
                </li>
            </ul>
        </div><!-- End .header-text -->
    </div><!-- End .header-right -->
    </div><!-- End .container -->
    </div><!-- End .header-bottom -->
    </div><!-- End .wrap-container -->
    </header><!-- End .header -->



    @yield('content')

    <footer class="footer footer-dark">
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="widget widget-about">
                            <h3 style="color: white">SportsMad</h3>
                            <p>Sportsmad is a live sports watching app. Watch Cricket, Football, Badminton or any
                                others game live on SportsMad.</p>

                            <div class="social-icons">
                                <a href="https://www.facebook.com/sportsmad69" class="social-icon" title="Facebook"
                                    target="_blank"><i class="icon-facebook-f"></i></a>
                                <a href="https://www.youtube.com/@inovexideasolutionlimited7969/featured"
                                    class="social-icon" title="Youtube" target="_blank"><i
                                        class="icon-youtube"></i></a>
                                <a href="https://play.google.com/store/apps/details?id=com.inovex.sportsmad"><img
                                        src="https://scontent.fdac22-1.fna.fbcdn.net/v/t39.30808-6/316680084_110618675207378_138753815011159280_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=09cbfe&_nc_eui2=AeGtYkX88EGWvgpkz3uQZAr3fup5TuPAcDJ-6nlO48BwMuUuubu1PZbAsBw_YxHksTGlcOBnCQH0s-IQq7tEdFru&_nc_ohc=tW3ZDK0NHRYAX9Nxk5y&_nc_ht=scontent.fdac22-1.fna&oh=00_AfD1U9ve33RHVMrIxdOuBHTrAdt_jReOr4XfL0wCVe4gxQ&oe=63F8455C"
                                        width="30px" height="30px" class="rounded" alt="Cinque Terre"></a>
                            </div><!-- End .soial-icons -->
                        </div><!-- End .widget about-widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->

                    <div class="col-sm-6 col-lg-3">
                        <div class="widget">
                            <h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

                            <ul class="widget-list">
                                <li><a href="/">Home</a></li>
                                {{-- <li><a href="#">How to shop on Molla</a></li> --}}
                                <li>FAQ</li>
                                <li>Contact us</li>

                            </ul><!-- End .widget-list -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->

                    <div class="col-sm-6 col-lg-3">
                        <div class="widget">
                            <h4 class="widget-title">Matches</h4><!-- End .widget-title -->

                            <ul class="widget-list">

                                <li><a href="/match/football">FootBall</a></li>
                                <li><a href="/match/cricket">Cricket</a></li>
                                <li><a href="/match/tennis"><span>Tennis</a></li>
                                <li><a href="/privacy">Privacy Policy</a></li>
                            </ul><!-- End .widget-list -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->

                    <div class="col-sm-6 col-lg-3">
                        <div class="widget">
                            <h4 class="widget-title">My Apps</h4><!-- End .widget-title -->

                            <ul class="widget-list">
                                <li><a href="/match">Match</a></li>
                                <li><a href="/highlights-all">Highlights</a></li>
                                <li><a href="/news-all">News</a></li>
                                <li><a href="/tv">Tv</a></li>
                                <li><a href="/live-now">Live</a></li>
                                <li>Help</li>

                            </ul><!-- End .widget-list -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-sm-6 col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .footer-middle -->

        <div class="footer-bottom">
            <div class="container">
                <p class="footer-copyright">Copyright © 2019 Inovex Idea Solution Limited. All Rights Reserved.</p>
                <!-- End .footer-copyright -->

            </div><!-- End .container -->
        </div><!-- End .footer-bottom -->
    </footer><!-- End .footer -->

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>



    </div><!-- End .page-wrapper -->

    <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/superfish.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "/front-end-category",
                contentType: false,
                processData: false,
                success: function(response) {



                },
            });


        });
    </script>

    @yield('script')



</body>

</html>
