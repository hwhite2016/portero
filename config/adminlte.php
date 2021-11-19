<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Portero',
    'title_prefix' => 'Portero | ',
    'title_postfix' => '',
    'enviar_credenciales' => 'Generar credenciales de acceso y enviarlas al correo.',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<label>Portero</label>',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img2' => 'vendor/adminlte/dist/img/AdminLTELogo2.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Portero.com.co',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-info',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,
    'usermenu_rol_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-info',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => 'text-info',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-block btn-info',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '../',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'password_rol_url' => 'password/rol',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => false,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'text'        => 'Mi Conjunto',
            'route'         => 'admin.index',
            'icon'        => 'fas fa-home',
            'can'          => 'admin.conjuntos.index',
            'submenu' => [
                [
                    'text' => 'Home',
                    'route'  => 'admin.index',
                    'can'  => 'admin.conjuntos.index',
                ],
                [
                    'text' => 'Estructura',
                    'route'  => 'admin.organos.estructura',
                    'can'  => 'admin.conjuntos.index',
                ],
                [
                    'text' => 'Documentos',
                    'route'  => 'admin.normas.index',
                    'can'  => 'admin.conjuntos.index',
                ],
            ],
        ],
        [
            'text'        => 'Pqrs',
            'route'       => 'admin.pqrs.index',
            'icon'        => 'far fa-envelope',
            'can'         => 'admin.pqrs.index',
        ],
        [
            'text'        => 'Comunicados',
            'route'       => 'admin.anuncios.index',
            'icon'        => 'fas fa-bullhorn',
            'can'         => 'admin.anuncios.index',
        ],
        [
            'text'        => 'Notificaciones',
            'icon'        => 'fas fa-bell',
            'can'         => 'admin.notificaciones.show',
            'submenu' => [
                [
                    // 'shift'    => 'ml-3' ,
                    'text' => 'No leidas',
                    'url'  => 'admin/notificacion/0',
                    // 'icon' => 'fas fa-eye-slash',
                    'can'  => 'admin.index',
                ],
                [
                    // 'shift'    => 'ml-3' ,
                    'text' => 'Leidas',
                    'url'  => 'admin/notificacion/1',
                    // 'icon' => 'fas fa-eye',
                    'can'  => 'admin.index',
                ],
            ],

        ],
        [
            'text' => 'Correspondencia',
            'route'  => 'admin.seguimiento.index',
            'icon' => 'fas fa-shipping-fast',
            'can'  => 'admin.seguimiento.index',
        ],
        // [
        //     'text' => 'Zonas Comunes',
        //     'route'  => 'admin.zonas.zonacomun',
        //     'icon' => 'fas fa-swimmer',
        //     'can'  => 'admin.zonas.zonacomun',
        //     'label'       => 'desarrollo',
        //     'label_color' => 'warning',
        // ],
        [
            'text'        => 'Dashboard',
            'route'         => 'admin.show',
            'icon'        => 'fas fa-tachometer-alt',
            'can'          => 'admin.dashboard.index',
        ],
        [
            'header' => 'CONTROL DE ACCESO',
            'can'    => 'admin.entregas.index',
        ],
        [
            'text'        => 'Residentes',
            'route'         => 'admin.residentes.list',
            'icon'        => 'fas fa-user-friends',
            'can'          => 'admin.entregas.index',
        ],
        [
            'text'        => 'Recepcion',
            'route'         => 'admin.entregas.index',
            'icon'        => 'fas fa-concierge-bell',
            'can'          => 'admin.entregas.index',
        ],
        [
            'text' => 'Visitantes',
            'route'  => 'admin.visitantes.index',
            'icon' => 'fas fa-user-clock',
            'can'  => 'admin.visitantes.index',
            'submenu' => [
                [
                    // 'shift'    => 'ml-3' ,
                    'text' => 'Ingresar Visitantes',
                    'route'  => 'admin.visitantes.index',
                    // 'icon' => 'fas fa-user-clock',
                    'can'  => 'admin.entregas.index',
                ],
                [
                    'text' => 'Mis Visitantes',
                    'route'  => 'admin.visitantes.index',
                    'can'  => 'admin.seguimiento.index',
                ],
                [
                    'text' => 'Historial Visitantes',
                    'route'  => 'admin.visitantes.getVisitantes',
                    'can'  => 'admin.visitantes.index',
                ],
            ],
        ],
        [
            'header' => 'SEGURIDAD',
            'can'    => 'admin.users.index',
        ],
        [
            'text'   => 'Personas',
            'route'  => 'admin.personas.index',
            'icon'   => 'fas fa-users fa-fw',
            'can'    => 'admin.personas.index',
        ],
        [
            'text'   => 'Usuarios',
            'route'  => 'admin.users.index',
            'icon'   => 'fas fa-users fa-fw',
            'can'    => 'admin.users.index',
        ],
        [
            'text'   => 'Roles',
            'route'  => 'admin.roles.index',
            'icon'   => 'fas fa-users-cog fa-fw',
            'can'    => 'admin.roles.index',
        ],

        [
            'header' => 'CONFIGURACION',
            'can'    => 'admin.unidads.index',
        ],
        [
            'text' => 'Paises',
            'route'  => 'admin.pais.index',
            'icon' => 'fas fa-globe-americas',
            'can'  => 'admin.pais.index',
        ],
        [
            'text' => 'Ciudades',
            'route'  => 'admin.ciudads.index',
            'icon' => 'fas fa-city',
            'can'  => 'admin.ciudads.index',
        ],
        [
            'text' => 'Barrios',
            'route'  => 'admin.barrios.index',
            'icon' => 'fas fa-image',
            'can'  => 'admin.barrios.index',
        ],
        [
            'text'   => 'Organos',
            'route'  => 'admin.organos.index',
            'icon'   => 'fas fa-sitemap fa-fw',
            'can'    => 'admin.organos.index',
        ],
        [
            'text'   => 'Colaboradores',
            'route'  => 'admin.empleados.index',
            'icon'   => 'fas fa-user-tie fa-fw',
            'can'    => 'admin.empleados.index',
        ],
        [
            'text' => 'Condominios',
            'route'  => 'admin.condominios.index',
            'icon' => 'fas fa-archway',
            'can'  => 'admin.condominios.index',
        ],
        [
            'text' => 'Parqueaderos',
            'route'  => 'admin.parqueaderos.index',
            'icon' => 'fas fa-car',
            'can'  => 'admin.parqueaderos.index',
        ],
        [
            'text' => 'Zonas Comunes',
            'route'  => 'admin.zonas.index',
            'icon' => 'fas fa-swimmer',
            'can'  => 'admin.zonas.index',
            'label'       => 'PRO',
            'label_color' => 'warning',
        ],
        [
            'text' => 'Bloques',
            'route'  => 'admin.bloques.index',
            'icon' => 'fas fa-th-large',
            'can'  => 'admin.bloques.index',
        ],
        [
            'text' => 'Tipo de Unidades',
            'route'  => 'admin.clase_unidads.index',
            'icon' => 'fas fa-map',
            'can'  => 'admin.clase_unidads.index',
        ],
        [
            'text' => 'Unidades',
            'route'  => 'admin.unidads.index',
            'icon' => 'fas fa-home',
            'can'  => 'admin.unidads.index',
        ],
        [
            'text' => 'Residentes',
            'route'  => 'admin.residentes.index',
            'icon' => 'fas fa-user',
            'can'  => 'admin.residentes.index',
        ],
        [
            'text' => 'Vehiculos',
            'route'  => 'admin.vehiculos.index',
            'icon' => 'fas fa-car',
            'can'  => 'admin.vehiculos.index',
        ],
        [
            'text' => 'Mascotas',
            'route'  => 'admin.mascotas.index',
            'icon' => 'fas fa-paw',
            'can'  => 'admin.mascotas.index',
        ],
        [
            'text'    => 'multilevel',
            'icon'    => 'fas fa-fw fa-share',
            'can'  => 'prueba',
            'submenu' => [
                [
                    'shift'    => 'ml-3' ,
                    'text' => 'algo',
                    'url'  => '#',
                ],
                [
                    'text' => 'level_one',
                    'url'  => '#',
                ],
            ],
        ],
        ['header' => 'labels',
         'can'  => 'prueba',],
        [
            'text'       => 'important',
            'icon_color' => 'red',
            'url'        => '#',
            'can'  => 'prueba',
        ],
        [
            'text'       => 'warning',
            'icon_color' => 'yellow',
            'url'        => '#',
            'can'  => 'prueba',
        ],
        [
            'text'       => 'information',
            'icon_color' => 'cyan',
            'url'        => '#',
            'can'  => 'prueba',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-colvis-1.7.1/b-html5-1.7.1/datatables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js',
                ],[
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap.min.js',
                ],
                // [
                //     'type' => 'css',
                //     'asset' => false,
                //     'location' => '//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css',
                // ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap5.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'Toast' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css',
                ],
            ],
        ],
        'Toastr' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css',
                ],
            ],
        ],
        'Inputmask' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js',
                ],
            ],
        ],
        'Timepicker' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'Step' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css',
                ],
            ],
        ],
        'Calendar' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//adminlte.io/themes/v3/plugins/fullcalendar/main.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//adminlte.io/themes/v3/plugins/fullcalendar/main.css',
                ],

            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => true,
];
