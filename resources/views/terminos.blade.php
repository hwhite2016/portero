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

          <!-- Menu block wrapper-->
          <div class="header-btns  header-btn-l-17 ms-auto  d-xs-inline-flex align-items-center">
                @if (Route::has('login'))
                    @if (Auth::user())
                        <a class="btn sign-in-btn focus-reset"
                            href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off" style="color: #50E3C2"></i>&nbsp; {{Auth::user()->name}}
                        </a>

                        <form id="logout-form" action="{{ config('adminlte.logout_url', 'logout') }}" method="POST" style="display: none;">
                            @if(config('adminlte.logout_method'))
                                {{ method_field(config('adminlte.logout_method')) }}
                            @endif
                            {{ csrf_field() }}
                        </form>

                        {{-- <a class="btn sign-in-btn focus-reset" href="{{ url('logout') }}">
                            <i class="fas fa-power-off" style="color: #50E3C2"></i>&nbsp; {{Auth::user()->name}}
                        </a> --}}

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
              <div class="content text-center">
                <h1>T??rminos y condiciones del Servicio</h1>
              </div>
          </div>
        </div>
      </div>

    <!--Content Area 1-->


    <div class="content" style="padding-top:80px">
        <div class="container">
            <p class="h4"><strong>T??rminos del servicio</strong></p>
            <p class="mt-4"><strong>Entre las Partes</strong></p>
            <p>
                <span style="font-weight:400">Los t??rminos expresados en este contrato constituyen las condiciones de uso y privacidad para todos los servicios prestados en la actualidad y los a??adidos en el futuro, Portero en su sitio web</span>
                <a href="https://www.portero.com.co"><span style="font-weight:400">www.portero.com.co.</span></a>
            </p>
            <p>
                <span style="font-weight:400">El usuario acepta, al momento de empezar a utilizar el servicio, respetar todas las condiciones impuestas por este contrato.</span>
            </p>
            <p>
                <strong>T??rminos y condiciones</strong>
            </p>
            <p>
                <strong>Aceptaci??n</strong>
            </p>
            <p>
                <span style="font-weight:400">El usuario de este sitio, acepta por simple causal de uso del sistema Portero lo dispuesto en este contrato y en sus T??rminos y Condiciones, susceptible de cambio sin previo aviso por parte de Portero. Si el usuario representa una organizaci??n, est?? dando por entendido que la organizaci??n acepta ce??irse a este contrato y que tiene las facultades para actuar en nombre de aquella y por lo tanto obligarla frente a Portero y aceptar las obligaciones establecidas en el presente contrato. El usuario que no est?? de acuerdo con esto, no podr?? hacer uso de los servicios prestados por Portero.</span>
            </p>
            <p>
                <strong>Capacidad de Celebraci??n de Contratos</strong>
            </p>
            <p>
                <span style="font-weight:400">Seg??n la ley de Colombia, el usuario que acepte este acuerdo de t??rminos y condiciones, debe ser legalmente apto para celebrar un contrato seg??n lo permita su autonom??a de la voluntad y las leyes que le sean aplicables. Refi??rase entonces, el que quiera celebrar este contrato a la teor??a general de celebraci??n de contratos de la ley que aplica en su pa??s.</span>
            </p>
            <p>
                <span style="font-weight:400">Portero da por entendido que aquel usuario que acepte este acuerdo de t??rminos y condiciones conoce previamente si est?? o no en capacidad de celebrar contratos a nombre de la persona que se determine como Usuario. Quienes sean considerados incapaces absolutos o relativos o parciales deber??n tener autorizaci??n de sus representantes legales para celebrar este contrato, y ser??n estos ??ltimos considerados responsables de cualquier conducta de sus apoderados.</span>
            </p>
            <p>
                <strong>Registro de Cuentas y Usuarios</strong>
            </p>
            <p>
                <span style="font-weight:400">Portero presta un servicio de software que se accede a trav??s de su sitio web </span><a href="http://www.portero.com.co"><span style="font-weight:400">www.portero.com.co</span></a>.<span style="font-weight:400"> Los usuarios que accedan a este servicio deber??n registrar una cuenta y brindar la informaci??n solicitada en los formularios que se habilitan a la hora de registrar una cuenta. Portero da por entendido que cualquier informaci??n ingresada en estos formularios es hecha bajo juramento y por lo tanto exonera a Portero de poseer informaci??n falsa sobre cualquier usuario.</span>
            </p>
            <p>
                <span style="font-weight:400">Portero permite el ingreso de una cantidad limitada de usuarios seg??n el plan que cada titular o usuario de cuenta haya elegido al momento de registrar su cuenta. Portero no permite, bajo ninguna circunstancia, que estos usuarios sean distintos de aquellos que el titular de la cuenta haya decidido habilitar como tales para el uso de la plataforma y estos no podr??n ser reemplazados por otras personas que conozcan las credenciales para ingresar a la plataforma. De suceder una situaci??n como ??sta, Portero no se hace responsable por el uso pernicioso de la informaci??n de la cuenta en contra del titular de la misma ni frente al usuario ni frente a terceros.</span>
            </p>
            <p>
                <strong>Descripci??n del Servicio</strong>
            </p>
            <p>
                <span style="font-weight:400">Portero presta el servicio de su aplicaci??n web en dos modalidades, gratis y pago. Portero podr?? dejar de ofrecer el plan Gratis para usuarios nuevos, pero el usuario que lo adquiri?? antes podr?? seguir us??ndolo indefinidamente siempre y cuando no realice cambios posteriores en su plan.  El usuario adquiere una licencia no-exclusiva, mundial y temporal e intransferible para usar el sistema Portero seg??n las condiciones del plan que haya elegido al momento de pagar por el servicio, o si es el caso acepta las condiciones que tiene al ser un usuario gratis pero en ning??n momento adquiere propiedad sobre la plataforma.</span>
            </p>
            <p>
                <span style="font-weight:400">Los derechos de autor sobre las obras de software que componen la plataforma y los Servicios ser??n de titularidad de Portero y bajo ninguna interpretaci??n de ??stos t??rminos de servicio se entender??n transferidos al usuario. </span>
            </p>
            <p>
                <span style="font-weight:400">El servicio de Portero se inicia al momento de registrar una cuenta en el sitio web de Portero, tras haber aceptado las condiciones expresadas en este contrato. El servicio consiste en el uso del software Portero disponible en </span><a href="https://www.portero.com.co"><span style="font-weight:400">www.portero.com.co</span></a>.
            </p>
            <p>
                <span style="font-weight:400">El usuario se hace conocedor de los servicios por los que est?? pagando a la hora de usar alguno de los planes que ofrece Portero. Portero no se har?? responsable en ning??n caso por los errores cometidos por el usuario a la hora de elegir su plan, as?? como tampoco al momento de digitar o ingresar su informaci??n tanto personal como de la operaci??n y marcha de su actividad empresarial ni tampoco de la clasificaci??n que realice de la misma lo que afectar?? irremediablemente los resultados arrojados por el Software.</span>
            </p>
            <p>
                <span style="font-weight:400">Portero da por entendido que el titular de la cuenta y los usuarios conocen cualquier cambio que se haga en la configuraci??n de ??sta, as?? como que realizar?? los cambios que considere pertinentes. Portero no se responsabilizar?? por la p??rdida de informaci??n que ocurra por fuerza mayor, caso fortuito o hecho de un tercero tal y como se explica bajo el t??tulo ???Operaci??n del Sitio???.</span>
            </p>
            <p>
                <span style="font-weight:400">Portero garantiza al Usuario el libre acceso al sitio web </span><a href="http://www.portero.com.co"><span style="font-weight:400">www.portero.com.co</span></a><span style="font-weight:400"> para ver la informaci??n all?? disponible, bajo condiciones normales, sin embargo el usuario acepta que existan circunstancias t??cnicas por las que ??sta informaci??n puede llegar a estar inaccesible de manera temporal y por lo tanto exonera a Portero de cualquier tipo de responsabilidad por este hecho, bajo el entendido de que esto puede obedecer a limitaciones inherentes al estado de la tecnolog??a en la actualidad.</span>
            </p>
            <p>
                <strong>Informaci??n de la cuenta</strong>
            </p>
            <p>
                <span style="font-weight:400">Portero es un aplicativo Web, el cual proporciona un sitio donde se alojan datos que el usuario administra bajo su cuenta y riesgo. Portero vela por mantener la informaci??n de los usuarios, segura y toma las precauciones a su juicio necesarias para ello, m??s no se responsabiliza por actos mal intencionados de terceros y las consecuencias de ello frente al usuario o frente a terceros. </span>
            </p>
            <p>
                <span style="font-weight:400">Portero pone en conocimiento de sus usuarios, que la informaci??n que suministre se albergar?? en servidores de terceros, que cumplen con los m??s altos est??ndares de seguridad e idoneidad. </span>
            </p>
            <p>
                <span style="font-weight:400">Portero tampoco se hace responsable por el tipo de informaci??n ingresada por cada usuario en su cuenta ni por los resultados inadecuados si la misma se ingres?? de manera inadecuada de acuerdo con los par??metros contables y fiscales aplicables a la materia en cada caso. Se da a entender que el usuario, al usar los servicios de Portero, har?? un uso sano y legal de todas las herramientas que se ponen a su disposici??n y esto exonera a Portero de cualquier uso indebido de su informaci??n por parte de cualquier usuario, entendi??ndose por ello el usar informaci??n para evadir obligaciones tributarias, entre otras.</span>
            </p>
            <p>
                <span style="font-weight:400">Portero no estar?? obligada a velar por la legalidad del contenido e informaci??n que los usuarios alberguen en su cuenta a trav??s de los Servicios prestados, sin embargo, podr?? tomar los correctivos en contra de informaci??n ilegal, cuando lo considere pertinente.</span>
            </p>
            <p>
                <span style="font-weight:400">El usuario se obliga a la hora de usar cualquiera de los servicios de Portero a (i) no causar da??o f??sico, moral o mental a otros usuarios del servicio (ii) no utilizar el servicio con fines maliciosos o de mala voluntad, ni para beneficiarse en perjuicio de terceros y mucho menos del Estado entendiendo por ??ste, aquel que de acuerdo con la normatividad que le sea aplicable, sea quien deba recibir dinero por concepto de impuestos bajo cualquier denominaci??n por el resultado de la operaci??n mercantil del usuario. (iii) no usar el servicio con fines criminales o ilegales ni para sacar provecho o beneficio il??cito para s?? o para terceros, bien sea remunerado o no, (iv) no publicar informaci??n que vulnere derechos de terceros, tales como derechos de propiedad intelectual, secretos industriales o cualquier otro que sea de propiedad de terceros y respecto de los cuales no se encuentre autorizado (v) publicar informaci??n sensible que ya no es vigente o que pueda inducir a error a terceros o al Estado</span>
            </p>
            <p>
                <span style="font-weight:400">El usuario de Portero manifiesta ser due??o de la informaci??n que ingresa en el sistema y bajo ninguna circunstancia esta informaci??n pasar?? a ser propiedad de Portero SAS., y de manera inversa, esta ??ltima sociedad es la ??nica due??a de la plataforma sobre la cual el usuario ingresa la informaci??n , sin que respecto de ??sta se considera surtida transferencia alguna en raz??n de ??ste contrato. Si el usuario da por terminado el contrato tendr?? la informaci??n a su alcance, pero en ning??n momento Portero se obliga a entregar la misma en formato alguno ni a llevar a cabo ning??n tipo de proceso de migraci??n, ni mucho menos a efectuar un desarrollo para que la informaci??n pueda ser analizada, ingresada o digitalizada en cualquier otro software, pues s??lo se ingresan datos, para su consulta y procesamiento en aras de su funcionamiento y uso.</span>
            </p>
            <p>
                <span style="font-weight:400">Adicional a lo anterior, Portero no se responsabiliza por el mal diligenciamiento de un formulario o por la informaci??n que err??neamente suministre el USUARIO al momento de realizar un tr??mite o de ingresar la informaci??n al software. </span>
            </p>
            <p>
                <strong>Pol??tica de privacidad</strong>
            </p>
            <p>
                <strong>Funciones publicitarias de Google Analytics implementadas en Portero</strong> <span style="font-weight:400"><br/></span><span style="font-weight:400">Portero utiliza las audiencias de remarketing de Google Analytics para su uso en Google AdWords y DoubleClick Bid Manager, esto con el fin de publicar campa??as de remarketing dirigidas a sus usuarios. El usuario acepta que su informaci??n sea tratada para efectos de Big Data y por lo tanto permite que Portero utilice estas herramientas con fines estad??sticos.</span>
            </p>
            <p>
                <strong>Modo de uso de las cookies</strong>
            </p>
            <p>
                <span style="font-weight:400">Portero, Mediante la instalaci??n de </span><a href="https://www.google.com/policies/privacy/key-terms/#toc-terms-cookie"><span style="font-weight:400">cookies </span></a><span style="font-weight:400">e</span><a href="https://www.google.com/policies/privacy/key-terms/#toc-terms-identifier"><span style="font-weight:400"> identificadores propios</span></a><span style="font-weight:400"> y de terceros y a trav??s de herramientas para el an??lisis de uso de cuenta, podr?? realizar actividades de seguimiento a los usuarios que utilizan su aplicaci??n. Con estas herramientas, Portero podr?? recopilar informaci??n de cada usuario para el an??lisis de estad??sticas e implementaci??n de estrategias de comunicaci??n y publicidad. Estas herramientas podr??n realizar seguimiento de la configuraci??n del usuario y hacen que su experiencia en la aplicaci??n sea m??s pr??ctica, reconociendo y recordando sus preferencias y ajustes.</span>
            </p>
            <p>
                <span style="font-weight:400">En esta medida, Portero podr?? recopilar datos de uso, como la duraci??n de uso, o datos demogr??ficos como el origen, el sexo y la edad. Portero usa esta informaci??n para fines anal??ticos. El usuario de Portero podr?? deshabilitar estas herramientas.</span>
            </p>
            <p>
                <span style="font-weight:400">Las actividades de seguimiento adelantadas por Portero tambi??n podr??n realizarse dentro de la aplicaci??n, para an??lisis interno, ejemplo, pero no exclusivamente para determinar tendencias y participaci??n en la aplicaci??n, tiempo de uso, preferencia, entre otros. Estas herramientos podr??n ser desactivadas por el usuario ???para conservar su privacidad.</span>
            </p>
            <p>
                <strong>An??lisis de datos</strong>
            </p>
            <p>
                <span style="font-weight:400">El usuario al crear su cuenta y hacer uso de la aplicaci??n Portero, acepta que LA EMPRESA puede suministrar, transferir, compartir y analizar los datos del giro ordinario de su negocio, con empresas aliadas, fililales, vinculadas o subordinadas de LA EMPRESA en Colombia o cualquier otro pa??s, esta informaci??n podr?? ser usada para fines comerciales por parte de los terceros.</span>
            </p>
            <p>
                <span style="font-weight:400">El usuario en cualquier momento puede solicitar a LA EMPRESA que detenga de forma indefinida el proceso de compartir sus datos con terceros, para esto debe realizar su solicitud al correo </span><span style="font-weight:400">soporte@portero.com.co</span>.
            </p>
            <p>
                <strong>Seguridad de la Cuenta</strong>
            </p>
            <p>
                <span style="font-weight:400">Portero vela por la seguridad de la contrase??a que provea el titular de cuenta y los usuarios a la hora de registrar una cuenta con Portero y garantiza que tomar?? las medidas que se encuentren a su alcance para que esta contrase??a no sea vista por terceros, mas no puede arrogarse la responsabilidad de garantizar su confidencialidad. Por otro lado Portero no se responsabiliza por el mal uso de la contrase??a por parte del usuario ni por el uso de contrase??as que sean f??ciles de descifrar, asumiendo que siempre que se acceda al sistema, lo hace el usuario directamente.</span>
            </p>
            <p>
                <strong>Operaci??n del Sitio</strong>
            </p>
            <p>
                <span style="font-weight:400">Portero llevar?? a cabo las gestiones que a su juicio estime conducentes, tendientes a que los sitios webs asociados siempre est??n disponibles para el usuario, pero no garantiza lo anterior, tanto por los da??os en las comunicaciones, por actos de terceros, mantenimiento o reestructuraci??n de los sitios u otro tipo de actos que se escapen del alcance y responsabilidad directa de Portero. No obstante lo anterior, Portero garantiza a los usuarios que pagan por el servicio, que el software estar?? disponible en </span><a href="http://www.portero.com.co"><span style="font-weight:400">www.portero.com.co</span></a><span style="font-weight:400"> desde cualquier lugar del mundo que permita una conexi??n a internet, siempre y cuando el usuario recuerde las credenciales de su cuenta y las condiciones de prestaci??n del servicio de conexi??n a Internet por parte de cada proveedor, lo permitan, lo cual escapa de las obligaciones de Portero, de manera tal que si no se pudiera acceder por el tipo de conexi??n y las caracter??sticas que le sean propias, por fallas en la comunicaci??n o por el deficiente servicio del mencionado proveedor, ello no implica en ning??n momento incumplimiento de la prestaci??n del servicio contratado por parte de Portero. En cuanto al mantenimiento y reestructuraci??n del sitio, Portero se reserva el derecho de hacerlo sin previo aviso a los usuarios, pero procurar?? que se les brinde un aviso con la antelaci??n que a su juicio considere conveniente o prudente para evitar incomodidades o eventuales perjuicios en el procesamiento de datos o de informaci??n.</span>
            </p>
            <p>
                <strong>Limitaciones</strong>
            </p>
            <p>
                <span style="font-weight:400">EL CLIENTE no podr?? aplicar t??cnicas de ingenier??a inversa, descompilar o desensamblar el software, ni realizar cualquier otra operaci??n que tienda a descubrir el c??digo fuente. Adem??s queda prohibida la separaci??n de los componentes. Portero autoriza el uso del software como un producto ??nico. Las partes que lo componen no se podr??n separar para utilizarlas en m??s de aquellas unidades o estaciones de trabajo en las que lo instale LA EMPRESA, ni hacer uso de ellas por separado. El usuario comprende que faltar a lo dispuesto en ??sta cl??usula constituye un delito de acuerdo al art??culo 272 del C??digo Penal Colombiano.</span>
            </p>
            <p>
                <strong>Interrupci??n y Terminaci??n del Servicio</strong>
            </p>
            <p>
                <span style="font-weight:400">Portero se reserva el derecho de terminar el servicio en cualquier momento, tanto de manera permanente como temporal, para aquellos casos en los que se deban realizar pagos sucesivos. </span>
            </p>
            <p>
                <span style="font-weight:400">Portero podr?? terminar de manera unilateral la cuenta de un usuario en los siguientes escenarios: (i) En caso de que el USUARIO utilice los servicios prestados por Portero para fines contrarios a la ley, especialmente aquellos que contrar??en derechos de propiedad intelectual de terceros y sobre todo de Portero y de otros usuarios; (ii) En caso de que Portero encuentre que el USUARIO est?? haciendo uso de su cuenta para la transmisi??n de programas malignos como virus, malwares, spywares, troyanos o similares, que puedan comprometer el debido funcionamiento de la plataforma de Portero o que perjudiquen a terceros; (iii) Cuando existan elementos que permitan inferir a Portero que el USUARIO no cuenta con la edad m??nima para contratar los Servicios, en los t??rminos del art??culo segundo de estas Condiciones.</span>
            </p>
            <p>
                <span style="font-weight:400">Portero se reserva el derecho a decidir si el contenido publicado por los usuarios, al igual que el material de texto o fotogr??fico que sea cargado a la p??gina web de Portero resulta apropiado y se ajusta a las Condiciones. En ??ste sentido, Portero podr?? impedir la publicaci??n y comercializaci??n de contenido que infrinja derechos de imagen, de habeas data y de privacidad de terceros, as?? como aquellos que resulten ofensivos, difamatorios o que constituyan infracciones a la ley. </span>
            </p>
            <p>
                <strong>Par??grafo: Suspensi??n Del Servicio.</strong>
            </p>
            <p>
                <span style="font-weight:400">LA EMPRESA se reserva el derecho de suspender la prestaci??n de los servicios al USUARIO y de inhabilitar su acceso al Software, as?? como a cualquiera de los m??dulos creados para EL USUARIO si luego de dos intentos de cobro del servicio el recaudo resulta fallido, o en caso de no recibir el pago del servicio en la forma acordada.</span>
            </p>
            <p>
                <span style="font-weight:400">Se dar?? la suspensi??n del servicio al USUARIO con aviso anticipado.</span>
            </p>
            <p>
                <strong>Legislaci??n Aplicable y Jurisdicci??n</strong>
            </p>
            <p>
                <span style="font-weight:400">Este contrato se rige por las leyes de la Rep??blica de Colombia. Si cualquier parte de este contrato se declara nula o contraria a la ley, entonces la provisi??n inv??lida o no exigible se considerar?? sustituida por una disposici??n v??lida y aplicable que m??s se acerque a la intenci??n del contrato original y el resto del acuerdo entre Portero y el usuario continuar?? en efecto. A menos que se especifique lo contrario en este documento, estas Condiciones constituyen el acuerdo completo entre usted y Portero con respecto a los Servicios de Portero  y reemplaza a todas las comunicaciones previas y propuestas, tanto de manera electr??nica, oral o escrita, entre el usuario y Portero con respecto a los Servicios de Portero. </span>
            </p>
            <p>
                <strong>Derecho de retracto.</strong>
            </p>
            <p>
                <span style="font-weight:400">El USUARIO podr?? ejercer su derecho al retracto en los t??rminos del art??culo 47 de la Ley 1480 de 2011, es decir, podr?? solicitar que se reverse la transacci??n perdiendo el dominio sobre su cuenta y recibiendo la devoluci??n de lo pagado. Para efectos de poder ejercer el derecho de retracto ser?? necesario que el USUARIO lo ejerza dentro de la oportunidad legal, es decir durante los cinco (5) d??as posteriores a la celebraci??n del contrato.</span>
            </p>
            <p></p>
            <p>
                <span style="font-weight:400">Fecha ??ltima modificaci??n: 12 de agosto de 2021</span>
            </p>
            <p>
                <strong>Versiones:</strong>
            </p>
            <ul>
                <li style="font-weight:400"><span style="font-weight:400">Actual (12 de agosto de 2021)</span></li>
            </ul>

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

  <!-- Activation Script -->
  <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>

