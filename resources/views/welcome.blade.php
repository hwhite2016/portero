<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Portero </title>
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
                  <a href="#" class="nav-link-item drop-trigger">M??dulos <i class="fas fa-angle-down"></i>
                  </a>
                  <ul class="sub-menu" id="submenu-9">
                    <li class="sub-menu--item">
                      <a href="#">M??dulo Administrativo</a>
                    </li>
                    <li class="sub-menu--item">
                      <a href="#">M??dulo Residentes</a>
                    </li>
                    <li class="sub-menu--item">
                      <a href="#">M??dulo Seguridad</a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="#pricing" class="nav-link-item">Precios</a>
                </li>
                {{-- <li class="nav-item">
                  <a href="{{ url('/register') }}" class="nav-link-item">Registrarme</a>
                </li> --}}
              </ul>
            </nav>
          </div>
          <!-- Menu block wrapper-->
          <div class="header-btns  header-btn-l-17 ms-auto  d-xs-inline-flex align-items-center">
                @if (Route::has('login'))
                    @if (Auth::user())
                        {{-- <a class="btn sign-in-btn focus-reset"
                            href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off" style="color: #50E3C2"></i>&nbsp; {{Auth::user()->name}}
                        </a>

                        <form id="logout-form" action="{{ config('adminlte.logout_url', 'logout') }}" method="POST" style="display: none;">
                            @if(config('adminlte.logout_method'))
                                {{ method_field(config('adminlte.logout_method')) }}
                            @endif
                            {{ csrf_field() }}
                        </form> --}}

                        <a class="btn sign-in-btn focus-reset" href="{{ route('admin.index') }}">
                            <i class="fas fa-sign-in-alt" style="color: #50E3C2"></i>&nbsp; {{Auth::user()->name}}
                        </a>

                    @else
                        <a class="btn sign-in-btn focus-reset" href="{{ route('admin.index') }}">
                            <i class="fas fa-sign-in-alt" style="color: #50E3C2"></i>&nbsp; Iniciar Sesi??n
                        </a>
                    @endif
                @endif
                <div class="header-btns  header-btn-l-17 ms-auto d-none d-xs-inline-flex align-items-center">
                    <a class="start-trail-btn btn btn-sm focus-reset attention" href="{{ route('contactanos.index') }}">
                        Cont??ctanos
                    </a>
                </div>
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
              <h1>Sistema integral para el control de acceso para edificios y condominios.</h1>
              <p>Integra un software que permite gestionar los servicios prestados a los residentes.</p>
              <a href="{{ route('contactanos.index') }}" class="btn">Solicitar una demostraci??n</a>
              <span>No requiere tarjeta de cr??dito</span>
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
              <h4>Plataforma Administrativa</h4>
              <p>Software para facilitar la gesti??n administrativa en las copropiedades, integrando los diferentes servicios que requiere la comunidad.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="single-features single-border position-relative">
              <div class="circle-dot-2">
                <i class="fas fa-circle"></i>
              </div>
              <h4>Propietarios y Residentes</h4>
              <p>Servicios que permiten mejorar las relaciones con la administraci??n, y estar bien informado de todo lo que sucede alrededor.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-9">
            <div class="single-features">
              <div class="circle-dot-3">
                <i class="fas fa-circle"></i>
              </div>
              <h4>Seguridad - Control de Acceso</h4>
              <p>Controla el ingreso al interior de la copropiedad y zonas comunes, integrando sistemas de control de acceso biom??tricos y/o tarjetas inteligentes.</p>
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
                    <img src="image/l8/content-image-5.png" alt="">
                  </div>
                  <div class="image-2">
                    <img src="image/l8/content-image-6.png" alt="">
                  </div>
                </div>
              </div>
              <div class="offset-xxl-1 col-xxl-5 col-xl-6 col-lg-6 col-md-8" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                <div class="content section-heading-11">
                  <h2> Gesti??n y log??stica en copropiedades.</h2>
                  <p>Es la herramienta que permite a un Administrador de Propiedad Horizontal optimizar y centralizar toda la informaci??n
                      de la copropiedad y as?? gestionar de manera efectiva y segura toda la informaci??n de sus clientes.

                  </p>
                  <a href="{{ route('contactanos.index') }}" class="btn focus-reset">Solicitar una demostraci??n</a>
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
                  <h2> Reserva de zonas comunes.</h2>
                  <p>Si eres administrador, ya no volveras a gestionar el calendario de reservaciones en papel, ya que todas seran autom??ticas o que usted puede rechazar en un instante.</p>
                  <p>Si eres residente, haz las reservaciones desde tu telefono movil en la comodidad de tu hogar sin filas ni esperas.</p>
                  <a href="{{ route('contactanos.index') }}" class="btn focus-reset">Solicitar una demostraci??n</a>
                </div>
              </div>
              <div class="offset-xxl-1 col-xxl-6 col-xl-6 col-lg-6 col-md-8 order-lg-1 order-0" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <div class="content-img position-relative">
                  <div class="image-1">
                    <img src="image/l8/zona.png" alt="">
                  </div>
                  <div class="image-2">
                    <img src="image/l8/calendar.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Video Area-->
    {{-- <div class="video-area-l-17">
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
    </div> --}}
    <!--Pricing Area-->
    <div id="pricing" class="pricing-area-l-17 position-relative overflow-hidden">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-8 text-center" data-aos="fade-down" data-aos-duration="800" data-aos-once="true">
            <div class="content section-heading-11">
              <h2>Seleccione un plan para comenzar</h2>
              {{-- <p>Wireframes are generally created by business analysts, user experience designers, developers, visual
                designers, and by those with expertise</p> --}}
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
                <span>B??sico</span><br>Desde (COP)
              </div>
              <div class="main-price">
                <div class="price d-flex position-relative ">
                  <span class="d-inline-block dynamic-value">$</span>
                  <h2 class="d-inline-block dynamic-value" data-active="15" data-monthly="199" data-yearly="1.990"><span
                  class="dynamic-value" data-active="" data-monthly=" | por vivienda" data-yearly=" | por vivienda"></span></h2>
                </div>
              </div>
              <p>Administraci??n</p>
              <div class="price-body pt-8">
                <ul class="pricing-list list-unstyled">
                  <li> <i class="icon icon-check-2-2"></i> Bloques, Unidades y Propietarios</li>
                  <li> <i class="icon icon-check-2-2"></i> Residentes, Vehiculos y Mascotas</li>
                  <li> <i class="icon icon-check-2-2"></i> Parqueaderos</li>
                  <li> <i class="icon icon-check-2-2"></i> Estructura Org??nica</li>
                  <li> <i class="icon icon-check-2-2"></i> Documentos en Linea</li>
                </ul>
              </div>
              <p>Recepci??n</p>
              <div class="price-body pt-8">
                <ul class="pricing-list list-unstyled">
                  <li> <i class="icon icon-check-2-2"></i> Entrada y salida de personas<br><small class="mx-4">(Control de Visitantes)</small></li>
                  <li> <i class="icon icon-check-2-2"></i> Entrada y salida de veh??culos</li>
                  <li> <i class="icon icon-check-2-2"></i> Asignaci??n de parqueaderos</li>
                </ul>
              </div>
              <div class="price-btn">
                <a class="btn" href="#">Cont??ctenos</a>
                <!-- <p>No credit card required</p> -->
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
            <div class="single-price  popular-pricing popular-pricing-3" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
              <div class="price-top justify-content-between">
                <span>Estandar (Recomendado)</span><br>Desde (COP)
              </div>
              <div class="main-price">
                <div class="price d-flex position-relative ">
                  <span class="d-inline-block dynamic-value">$</span>
                  <h2 class="d-inline-block dynamic-value" data-active="15" data-monthly="399" data-yearly="3.990"><span
                  class="dynamic-value" data-active="" data-monthly=" | por vivienda" data-yearly=" | por vivienda"></span></h2>
                </div>
              </div>
              <p>Administraci??n (+ B??sico)</p>
              <div class="price-body pt-8">
                <ul class="pricing-list list-unstyled">
                    <li> <i class="icon icon-check-2-2"></i> Noticias y Anuncios</li>
                    <li> <i class="icon icon-check-2-2"></i> Configuraci??n de zonas comunes</li>
                    <li> <i class="icon icon-check-2-2"></i> Gesti??n de Tickets (PQRS)</li>
                </ul>
              </div>
              <p>Recepci??n (+ B??sico)</p>
              <div class="price-body pt-8">
                <ul class="pricing-list list-unstyled">
                  <li> <i class="icon icon-check-2-2"></i> Recibo de facturas de servicio</li>
                  <li> <i class="icon icon-check-2-2"></i> Recibo de correspondencia</li>
                </ul>
              </div>
              <p>Residentes (+ B??sico)</p>
              <div class="price-body pt-8">
                <ul class="pricing-list list-unstyled">
                  <li> <i class="icon icon-check-2-2"></i> Noticias y Anuncios</li>
                  <li> <i class="icon icon-check-2-2"></i> Reserva de zonas comunes</li>
                  <li> <i class="icon icon-check-2-2"></i> Programaci??n de Visitantes</li>
                  <li> <i class="icon icon-check-2-2"></i> Gesti??n de Tickets (PQRS)</li>
                  <li> <i class="icon icon-check-2-2"></i> Notificaci??n de correspondencia</li>
                </ul>
              </div>
              <div class="price-btn">
                <a class="btn" href="#">Cont??ctenos</a>
                {{-- <p>No requiere tarjeta de credito</p> --}}
              </div>
            </div>
          </div>
          {{-- <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
            <div class="single-price position-relative" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
              <div class="price-top justify-content-between">
                <span>Premium</span>
              </div>
              <div class="main-price">
                <div class="price d-flex position-relative">
                  <span class="d-inline-block dynamic-value ">$</span>
                  <h2 class="d-inline-block dynamic-value" data-active="15" data-monthly="" data-yearly=""> <span
                  class="dynamic-value" data-active="" data-monthly=" | Consultar" data-yearly=" | Consultar"></span></h2>
                </div>
              </div>
              <p>Plataforma administrativa y Control de Acceso</p>
              <div class="price-body">
                <ul class="pricing-list list-unstyled">
                    <li> <i class="icon icon-check-2-2"></i> Plan Estandar incluido</li>
                    <li> <i class="icon icon-check-2-2"></i> Integraci??n dispositivos biom??tricos</li>
                    <li> <i class="icon icon-check-2-2"></i> Gesti??n de cartera</del></li>
                </ul>
              </div>
              <div class="price-btn">
                <a class="btn" href="#">Cont??ctenos</a>
              </div>
            </div>
          </div> --}}
        </div>
      </div>
    </div>
    <!--Brand Area-->
    {{-- <div class="brand-area-l-17">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-9 col-lg-11 col-md-12">
            <div class="content text-center">
              <p>Ellos ya usan PORTERO, ??y T???</p>
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
    </div> --}}
    <!--Testimonial Area-->

    {{-- <div class="testimonial-area-l-17">
      <div class="container">
        <div class="row justify-content-center no-gutters border-collapse-1">

            <div class="col-12 col-lg-12 text-center aos-init aos-animate mb-4" data-aos="fade-down" data-aos-duration="800" data-aos-once="true">
                <div class="content section-heading-11">
                  <h2>Casos de ??xito</h2>
                  <p>Conoce algunos Administradores que ya usan PORTERO y nos cuentan sus experiencias:</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-9 p-0">
            <div class="testimonial-card border h-100">
              <img src="image/l8/quote.png" alt="">
              <p>
                ???La mejor plataforma que he conocido, permite una mejor interacci??n a los residentes con los diferentes beneficios que brindan los conjuntos.???
              </p>
              <div class="d-flex align-items-center">
                <div class="customer-img mr-4">
                  <img src="image/l8/client-img-1.png" alt="">
                </div>
                <div class="user-identity">
                  <h5>Ricardo Solipa</h5>
                  <span>Administrador Sorrento</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-9 p-0">
            <div class="testimonial-card border h-100">
              <img src="image/l8/quote.png" alt="" class="mb-12">
              <p>
                ???Excelente aplicativo, ahorra tiempo, le permite al residente estar informado las actividades del conjunto y as?? mismo mantener una comunicaci??n m??s directa y eficaz con el administrador.???
              </p>
              <div class="d-flex align-items-center">
                <div class="customer-img">
                  <img src="image/l8/client-img-2.png" alt="">
                </div>
                <div class="user-identity">
                  <h5>Eliana Zambrano</h5>
                  <span>Administrador Siena</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-9 p-0">
            <div class="testimonial-card border h-100">
              <img src="image/l8/quote.png" alt="" class="mb-12">
              <p>
                ???Ha sido de gran ayuda contar con esta herramienta, ya que en linea y desde cualquier lugar como administradora puedo acceder a publicar y socializar con los residentes informaciones de la copropiedad.???
              </p>
              <div class="d-flex align-items-center">
                <div class="customer-img mr-4">
                  <img src="image/l8/client-img-3.png" alt="">
                </div>
                <div class="user-identity">
                  <h5>Joel Ferrer</h5>
                  <span>Administrador Olivenza</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}
    <!--CTA Area-->
    <div class="cta-area-l-17">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="d-md-flex justify-content-between text-align-lg-start text-center align-items-center">
              <h2>Gestiona la copropiedad desde un solo lugar</h2>
              <a href="{{ route('contactanos.index') }}" class="btn">Solicitar una demostraci??n</a>
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
        {{-- <div class="row footer-area-l-17-items justify-content-between" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
          <div class="col">
            <div class="footer-widget widget2">
              <p class="widget-title">Store</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>

              </ul>
            </div>
          </div>
          <div class="col">
            <div class="footer-widget widget3">
              <p class="widget-title">About</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>

              </ul>
            </div>
          </div>
          <div class="col">
            <div class="footer-widget widget4">
              <p class="widget-title">Policy</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>

              </ul>
            </div>
          </div>
          <div class="col">
            <div class="footer-widget widget4">
              <p class="widget-title">Team</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>

              </ul>
            </div>
          </div>
          <div class="col">
            <div class="footer-widget widget4">
              <p class="widget-title">Support</p>
              <ul class="widget-links pl-0 list-unstyled ">
                <li><a href="">Catalog</a></li>

              </ul>
            </div>
          </div>
        </div> --}}
      </div>
      <!-- footer-bottom start -->
      <div class="copyright-area-l-17 text-center text-md-start">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-4 col-md-4">
              <div class="copyright">
                <p> &copy; Grayic 2021 Todos los derechos reservados. </p>
              </div>
            </div>
            <div class="col-lg-5 col-md-6">
              <div class="footer-menu">
                <ul class="list-unstyled d-flex flex-wrap justify-content-center">
                  <li><a href="/privacidad">Politica de privacidad</a></li>
                  <li> <a href="/terminos">Terminos & Condiciones</a> </li>
                  {{-- <li><a href="#features"> Mapa del sitio</a></li> --}}
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

