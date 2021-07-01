<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Desktop App </title>
  <link rel="shortcut icon" href="{{ asset('image/favicon.png') }}" type="image/x-icon">
  <!-- Bootstrap , fonts & icons  -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('fonts/icon-font/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('fonts/typography-font/typo.css') }}">
  <link rel="stylesheet" href="{{ asset('fonts/fontawesome-5/css/all.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Gothic+A1:wght@400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <!-- Plugin'stylesheets  -->
  <link rel="stylesheet" href="{{ asset('plugins/aos/aos.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.min.css') }}">
  <!-- Vendor stylesheets  -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <!-- Custom stylesheet -->
</head>

<body data-theme-mode-panel-active data-theme="light" style="font-family: 'Mazzard H';">
  <div class="site-wrapper overflow-hidden position-relative">
    <!-- Site Header -->
    <!-- Preloader -->
    <!-- <div id="loading">
    <div class="preloader">
     <img src="./image/preloader.gif" alt="preloader">
   </div>
   </div>    -->
    <!--Site Header Area -->
    <header class="site-header site-header--menu-center dark-mode-texts landing-17-menu  site-header--absolute site-header--sticky">
      <div class="container">
        <nav class="navbar site-navbar">
          <!-- Brand Logo-->
          <div class="brand-logo">
            <a href="#">
              <!-- light version logo (logo must be black)-->
              <img src="{{ asset('image/logo/logo-black.png') }}" alt="" class="light-version-logo">
              <!-- Dark version logo (logo must be White)-->
              <img src="{{ asset('image/logo/logo-white.png') }}" alt="" class="dark-version-logo">
            </a>
          </div>
          <div class="menu-block-wrapper">
            <div class="menu-overlay"></div>
            <nav class="menu-block" id="append-menu-header">
              <div class="mobile-menu-head">
                <div class="go-back">
                  <i class="fa fa-angle-left"></i>
                </div>
                <div class="current-menu-title"></div>
                <div class="mobile-menu-close">&times;</div>
              </div>
              <ul class="site-menu-main">
                <li class="nav-item nav-item-has-children">
                  <a href="#" class="nav-link-item drop-trigger">Servicios <i class="fas fa-angle-down"></i>
                  </a>
                  <ul class="sub-menu" id="submenu-9">
                    <li class="sub-menu--item">
                      <a href="#">Dropdown 01</a>
                    </li>
                    <li class="sub-menu--item">
                      <a href="#">Dropdown 02</a>
                    </li>
                    <li class="sub-menu--item">
                      <a href="#">Dropdown 03</a>
                    </li>
                    <li class="sub-menu--item">
                      <a href="#">Dropdown 04</a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="#pricing" class="nav-link-item">Precios</a>
                </li>
                <li class="nav-item">
                  <a href="https://uxtheme.net/product-support/" class="nav-link-item">Contactenos</a>
                </li>
              </ul>
            </nav>
          </div>
          <div class="header-btns  header-btn-l-17 ms-auto d-none d-xs-inline-flex align-items-center">
                @if (Route::has('login'))
                        @if (Auth::check())
                            <a class="btn sign-in-btn focus-reset" href="{{ url('/home') }}">Home</a>
                        @else
                            <a class="btn sign-in-btn focus-reset" href="{{ route('admin.index') }}">Iniciar Sesión</a>
                        @endif
                @endif
            <a class="start-trail-btn btn focus-reset" href="{{ url('/register') }}">
              Prueba 15 dias gratis
            </a>
          </div>
          <!-- mobile menu trigger -->
          <div class="mobile-menu-trigger">
            <span></span>
          </div>
          <!--/.Mobile Menu Hamburger Ends-->
        </nav>
      </div>
    </header>
    <!-- navbar- -->
    <!-- Hero Area -->
    <div class="hero-area-l-17 position-relative">
      <div class="container">
        <div class="row position-relative justify-content-center">
          <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-11 order-lg-1 order-1" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
            <div class="content text-center">
              <h1>Software para propiedad horizontal</h1>
              <p>Optimiza tu tiempo y automatiza las actividades diarias. Enfoca tu atención en el bienestar de los residentes.</p>
              <a href="#" class="btn">Comience la prueba gratuita de 15 días</a>
              <span>No requiere tarjeta de crédito</span>
            </div>
          </div>
          <!-- <div class="col-xl-8 col-lg-9 order-lg-1 order-0">
            <div class="hero-area-image">
              <img src="image/l8/hero-img.png" alt="" class="w-100">
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <!--Feature Area -->
    <div class="feature-area-l-17 position-relative">
      <div class="container">
        <div class="row feature-area-l-17-items justify-content-center text-center">
          <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="single-features single-border position-relative">
              <div class="circle-dot-1">
                <i class="fas fa-circle"></i>
              </div>
              <h4>Los residentes</h4>
              <p>Mejoramos las relaciones y servicios para los residentes por medio de un único canal de comunicación para recibir y compartir información.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="single-features single-border position-relative">
              <div class="circle-dot-2">
                <i class="fas fa-circle"></i>
              </div>
              <h4>Reduce la cartera</h4>
              <p>Reduce la cartera con un sistema de notificaciones y canales de pago, para que los residentes estén siempre al día.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="single-features">
              <div class="circle-dot-3">
                <i class="fas fa-circle"></i>
              </div>
              <h4>Pago oportuno</h4>
              <p>Notificamos a los residentes de las cuotas de administración y de sus responsabilidades a tiempo.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Content Area 1-->
    <div class="content-area-l-17-1">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-xl-10 col-lg-12">
            <div class="row align-items-center justify-content-center">
              <div class="col-lg-6 col-md-8" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="content-img position-relative">
                  <div class="image-1">
                    <img src="image/l8/content-image-1.png" alt="">
                  </div>
                  <div class="image-2">
                    <img src="image/l8/content-image-2.png" alt="">
                  </div>
                </div>
              </div>
              <div class="offset-xxl-1 col-xxl-5 col-xl-6 col-lg-6 col-md-8" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                <div class="content section-heading-11">
                  <h2> Lider en gestión y logística.</h2>
                  <p>Propiedata es la plataforma mas completa para la administración de propiedad horizontal.
                    Con Propiedata tienes modulos de gestión, comunicación, asambleas, citofonia, control de ingreso,
                    contabilidad, reportes y mucho más.

                  </p>
                  <a href="#" class="btn focus-reset">Comience la prueba gratuita de 15 días</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Content Area 2-->
    <div class="content-area-l-17-2">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-xl-10 col-lg-12">
            <div class="row align-items-center justify-content-center">
              <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-8 order-lg-1 order-1" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                <div class="content section-heading-11">
                  <h2> Reservas de las zonas comunes</h2>
                  <p>Cambie el calendario de reservaciones en papel por reservas automáticas o que usted puede aprobar o rechazar en un instante.</p>
                  <a href="#" class="btn focus-reset">Comience la prueba gratuita de 15 días</a>
                </div>
              </div>
              <div class="offset-xxl-1 col-xxl-6 col-xl-6 col-lg-6 col-md-8 order-lg-1 order-0" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="content-img position-relative">
                  <div class="image-1">
                    <img src="image/l8/content-image-3.png" alt="">
                  </div>
                  <div class="image-2">
                    <img src="image/l8/content-image-4.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Video Area-->
    <div class="video-area-l-17">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-7 col-xl-8 col-lg-9 col-md-12">
            <div class="video-content text-center">
              <a data-fancybox="" href="https://www.youtube.com/embed/9yc1lfFZX-I"><i
              class="fas fa-play font-size-7"></i></a>
              <h2>We help you to be successful</h2>
              <p>Create custom landing pages with
                Shade that convert more visitors than any website. With lots of unique blocks, you can easily build a page
                without coding.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Pricing Area-->
    <div id="pricing" class="pricing-area-l-17 position-relative overflow-hidden">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-8 text-center" data-aos="fade-down" data-aos-duration="800" data-aos-once="true">
            <div class="content section-heading-11">
              <h2>Seleccione un plan para comenzar</h2>
              <p>Wireframes are generally created by business analysts, user experience designers, developers, visual
                designers, and by those with expertise</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-center" id="table-price-value" data-pricing-dynamic data-value-active="monthly">
          <div class="col-md-12 pricing-main-area-l-17 text-center">
            <div class="toggle-btn d-inline-block  justify-content-center">
              <a class="btn-toggle btn-toggle-2 d-flex price-deck-trigger" data-pricing-trigger data-target="#table-price-value" href="javascript:">
                <span class="round"></span>
              </a>
            </div>
          </div>

          <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
            <div class="single-price" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
              <div class="price-top justify-content-between">
                <span>Gratis</span>
              </div>
              <div class="main-price">
                <div class="price d-flex position-relative ">
                  <span class="d-inline-block dynamic-value">$</span>
                  <h2 class="d-inline-block dynamic-value" data-active="15" data-monthly="0" data-yearly="0"><span
                  class="dynamic-value" data-active="" data-monthly="" data-yearly=""></span></h2>
                </div>
              </div>
              <p>Good for small business launching their products less then once a year</p>
              <div class="price-body pt-8">
                <ul class="pricing-list list-unstyled">
                  <li> <i class="icon icon-check-2-2"></i> Unlimited Blocks</li>
                  <li> <i class="icon icon-check-2-2"></i> 5GB Clould Storages</li>
                  <li><del> <i class="icon icon-check-2-2"></i> Custom Domain Names</del></li>
                  <li><del> <i class="icon icon-check-2-2"></i>Unlimited Emails</del></li>
                </ul>
              </div>
              <div class="price-btn">
                <a class="btn" href="#">Comenzar</a>
                <!-- <p>No credit card required</p> -->
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
            <div class="single-price  popular-pricing popular-pricing-3" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
              <div class="price-top justify-content-between">
                <span>Basico</span>
              </div>
              <div class="main-price">
                <div class="price d-flex position-relative ">
                  <span class="d-inline-block dynamic-value">$</span>
                  <h2 class="d-inline-block dynamic-value" data-active="15" data-monthly="1.500" data-yearly="15.000"><span
                  class="dynamic-value" data-active="/ por Unidad" data-monthly="/ por Unidad" data-yearly="/ por Unidad"></span></h2>
                </div>
              </div>
              <p>Good for small business launching their products less then once a year</p>
              <div class="price-body pt-8">
                <ul class="pricing-list list-unstyled">
                  <li> <i class="icon icon-check-2-2"></i> Unlimited Blocks</li>
                  <li> <i class="icon icon-check-2-2"></i> 5GB Clould Storages</li>
                  <li><del> <i class="icon icon-check-2-2"></i> Custom Domain Names</del></li>
                  <li><del> <i class="icon icon-check-2-2"></i>Unlimited Emails</del></li>
                </ul>
              </div>
              <div class="price-btn">
                <a class="btn" href="#">Comience la prueba gratuita de 15 días</a>
                <p>No requiere tarjeta de credito</p>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
            <div class="single-price position-relative" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
              <div class="price-top justify-content-between">
                <span>Pro</span>
              </div>
              <div class="main-price">
                <div class="price d-flex position-relative">
                  <span class="d-inline-block dynamic-value ">$</span>
                  <h2 class="d-inline-block dynamic-value" data-active="15" data-monthly="750.000" data-yearly="7.500.000"> <span
                  class="dynamic-value" data-active="/  mensual" data-monthly="/ mensual" data-yearly="/ anual"></span></h2>
                </div>
              </div>
              <p>Good for small business launching their products less then once a year</p>
              <div class="price-body">
                <ul class="pricing-list list-unstyled">
                  <li> <i class="icon icon-check-2-2"></i> Unlimited Blocks</li>
                  <li> <i class="icon icon-check-2-2"></i> 5GB Clould Storages</li>
                  <li> <i class="icon icon-check-2-2"></i> Custom Domain Names</li>
                  <li> <i class="icon icon-check-2-2"></i>Unlimited Emails</li>
                </ul>
              </div>
              <div class="price-btn">
                <a class="btn" href="#">Start free 14 days trial</a>
                <p>No credit card required</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Brand Area-->
    <div class="brand-area-l-17">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-9 col-lg-11 col-md-12">
            <div class="content text-center">
              <p>We are proud to have some big brands as our customer</p>
            </div>
            <div class="brand-area-l-17-items d-flex justify-content-center justify-content-xl-between align-items-center flex-wrap ">
              <div class="single-brand " data-aos="fade-right" data-aos-duration="500" data-aos-once="true">
                <img src="image/l8/brand-logo-1.svg" alt="">
              </div>
              <div class="single-brand " data-aos="fade-right" data-aos-duration="700" data-aos-once="true">
                <img src="image/l8/brand-logo-2.svg" alt="">
              </div>
              <div class="single-brand " data-aos="fade-right" data-aos-duration="900" data-aos-once="true">
                <img src="image/l8/brand-logo-3.svg" alt="">
              </div>
              <div class="single-brand " data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
                <img src="image/l8/brand-logo-4.svg" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Testimonial Area-->
    <div class="testimonial-area-l-17">
      <div class="container">
        <div class="row justify-content-center no-gutters border-collapse-1">
          <div class="col-lg-4 col-md-6 col-sm-9 p-0">
            <div class="testimonial-card border h-100">
              <img src="image/l8/quote.png" alt="">
              <p>
                “You made it so simple. My new site is so much faster and
                easier to work with than my old site. I just choose the page, make the change and click save. ”
              </p>
              <div class="d-flex align-items-center">
                <div class="customer-img mr-4">
                  <img src="image/l8/client-img-1.png" alt="">
                </div>
                <div class="user-identity">
                  <h5>Sallie Lawson</h5>
                  <span>Founder of Crips</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-9 p-0">
            <div class="testimonial-card border h-100">
              <img src="image/l8/quote.png" alt="" class="mb-12">
              <p>
                “Simply the best. Better than all the rest. I’d recommend this product to beginners and advanced users.”
              </p>
              <div class="d-flex align-items-center">
                <div class="customer-img">
                  <img src="image/l8/client-img-2.png" alt="">
                </div>
                <div class="user-identity">
                  <h5>Sallie Lawson</h5>
                  <span>Founder of Crips</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-9 p-0">
            <div class="testimonial-card border h-100">
              <img src="image/l8/quote.png" alt="" class="mb-12">
              <p>
                “This is a top quality product. No need to think twice before purchasing, you simply could not go wrong”
              </p>
              <div class="d-flex align-items-center">
                <div class="customer-img mr-4">
                  <img src="image/l8/client-img-3.png" alt="">
                </div>
                <div class="user-identity">
                  <h5>Sallie Lawson</h5>
                  <span>Founder of Crips</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--CTA Area-->
    <div class="cta-area-l-17">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="d-md-flex justify-content-between text-align-lg-start text-center align-items-center">
              <h2>Manage your team in one place</h2>
              <a href="#" class="btn">Start free 14 days trial</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Footer Area-->
    <footer class="footer-area-l-17 position-relative">
      <div class="footer-shape">
        <img src="image/l8/footer-shape.svg" alt="">
      </div>
      <div class="container pt-lg-23 pt-15 pb-12">
        <div class="row footer-area-l-17-items justify-content-between" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
          <div class="col">
            <div class="footer-widget widget2">
              <p class="widget-title">Store</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>
                <li><a href="">Popular</a></li>
                <li><a href="">Features</a></li>
                <li><a href="">F.a.q.</a></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="footer-widget widget3">
              <p class="widget-title">About</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>
                <li><a href="">Popular</a></li>
                <li><a href="">Features</a></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="footer-widget widget4">
              <p class="widget-title">Policy</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>
                <li><a href="">Popular</a></li>
                <li><a href="">Features</a></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="footer-widget widget4">
              <p class="widget-title">Team</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>
                <li><a href="">Popular</a></li>
                <li><a href="">Features</a></li>
              </ul>
            </div>
          </div>
          <div class="col">
            <div class="footer-widget widget4">
              <p class="widget-title">Support</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>
                <li><a href="">Popular</a></li>
                <li><a href="">Features</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- footer-bottom start -->
      <div class="copyright-area-l-17 text-center text-md-start">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-4 col-md-4">
              <div class="copyright">
                <p> &copy; Grayic 2020 All right reserved. </p>
              </div>
            </div>
            <div class="col-lg-5 col-md-6">
              <div class="footer-menu">
                <ul class="list-unstyled d-flex flex-wrap justify-content-center">
                  <li><a href="#">Privacy Policy</a></li>
                  <li> <a href="#features">Terms & Conditions</a> </li>
                  <li><a href="#features"> Site map</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-2">
              <div class="social-icons text-md-end">
                <ul class="pl-0 list-unstyled">
                  <li class="d-inline-block"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                  <li class="d-inline-block"><a href="#"><i class="fab fa-twitter"></i></a></li>
                  <li class="d-inline-block"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <!-- Vendor Scripts -->
  <script src="{{ asset('js/vendor.min.js') }}"></script>
  <!-- Plugin's Scripts -->
  <script src="{{ asset('plugins/fancybox/jquery.fancybox.min.js') }}"></script>
  <script src="{{ asset('plugins/aos/aos.min.js') }}"></script>
  <script src="{{ asset('plugins/menu/menu.js') }}"></script>
  <!-- Activation Script -->
  <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>

