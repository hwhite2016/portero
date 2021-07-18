<!DOCTYPE html>
<html lang="es">
<head>
<title>Portero</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" type="image/png" href="favicons/favicon.ico" />
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v17/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v18/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v17/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v17/vendor/animate/animate.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v17/vendor/css-hamburgers/hamburgers.min.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v17/vendor/animsition/css/animsition.min.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v17/vendor/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/cf/ContactFrom_v17/vendor/daterangepicker/daterangepicker.css">

<link rel="stylesheet" type="text/css" href="css/util.css">
<link rel="stylesheet" type="text/css" href="css/main_contact.css">

<meta name="robots" content="noindex, follow">

</head>
<body>
    <div class="container-contact100">

        <div class="wrap-contact100">

            <form id="myForm" action="{{route('contactanos.store')}}" method="POST" class="contact100-form validate-form">
                @csrf
                <a href="{{url('/')}}" class="mb-4"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
                <span class="contact100-form-title mt-4">
                    Contáctanos
                    <div class="txt2">
                        Déjanos tus datos y te contactaremos para hacer una demostración y brindarte más información.
                    </div>
                </span>

                @error('name')
                    <small class="text-danger">
                        {{$message}}
                    </small>
                @enderror
                <div class="wrap-input100 validate-input" data-validate="El nombre completo es requerido">
                    <label class="label-input100" for="name">Nombre Completo</label>
                    <input id="name" class="input100" type="text" name="name" value="{{old('name')}}" placeholder="Ingresa tu nombre...">
                    <span class="focus-input100"></span>
                </div>

                @error('email')
                    <small class="text-danger">
                        {{$message}}
                    </small>
                @enderror
                <div class="wrap-input100 validate-input" data-validate="Un correo valido es requerido: ex@abc.xyz">
                    <label class="label-input100" for="email">Correo Electrónico</label>
                    <input id="email" class="input100" type="email" name="email" value="{{old('email')}}" placeholder="Ingrese su correo...">
                    <span class="focus-input100"></span>
                </div>

                @error('celular')
                    <small class="text-danger">
                        {{$message}}
                    </small>
                @enderror
                <div class="wrap-input100 validate-input" data-validate="Ingrese su numero de celular">
                    <label class="label-input100" for="celular">Numero de Celular</label>
                    <input id="celular" class="input100" type="number" name="celular" value="{{old('celular')}}" placeholder="Ingrese su numero de celular">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100">
                    <div class="label-input100">Rol en la Copropiedad</div>
                    <div>
                        <select class="js-select2" name="rol" id="rol">
                            <option>Rol en la Copropiedad</option>
                            <option {{ old('rol') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            <option {{ old('rol') == 'Asistente Administrativo' ? 'selected' : '' }}>Asistente Administrativo</option>
                            <option {{ old('rol') == 'Consejero' ? 'selected' : '' }}>Consejero</option>
                            <option {{ old('rol') == 'Residente' ? 'selected' : '' }}>Residente</option>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Ingrese un numero valido">
                    <label class="label-input100" for="unidades">¿Cuantas unidades tiene tu copropiedad?</label>
                    <input id="unidades" class="input100" type="number" name="unidades" value="{{old('unidades')}}" placeholder="Ingrese numero de unidades...">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100">
                    <label class="label-input100" for="mensaje">Como podemos ayudarte</label>
                    <textarea id="mensaje" class="input100" name="mensaje" placeholder="Escribe tu mensaje aquí...">{{old('mensaje')}}</textarea>
                    <span class="focus-input100"></span>
                </div>
                <div class="container-contact100-form-btn">
                    <button id="btn-enviar" type="submit" class="contact100-form-btn">Enviar</button>
                </div>
            </form>

            <div class="contact100-more flex-col-c-m">
                <img src="{{ asset('image/logo/logo-contactanos.png') }}" alt="" class="dark-version-logo mb-4">

                <div class="txt5 mt-4">Informacion de contacto </div>
                <div class="txt4 mt-4"><i class="fa fa-envelope-o mr-2" aria-hidden="true"></i> support@portero.com.co </div>
                <div class="txt4 mt-4"><i class="fa fa-phone mr-2" aria-hidden="true"></i> +57 (300) 742 4455 </div>

            </div>

        </div>
    </div>
    <script src="https://colorlib.com/etc/cf/ContactFrom_v18/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="https://colorlib.com/etc/cf/ContactFrom_v18/vendor/bootstrap/js/popper.js"></script>
    <script src="https://colorlib.com/etc/cf/ContactFrom_v18/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://colorlib.com/etc/cf/ContactFrom_v18/vendor/select2/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>


    @if(session('info'))
        <script type="text/javascript">
            const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer)
                toast.addEventListener("mouseleave", Swal.resumeTimer)
            }
            })

            Toast.fire({
            icon: "success",
            title: "{{session('info')}}"
            })
        </script>
   @endif

    <script>
            $(document).ready(function(){
                $('#myForm').on('submit', function(){
                    //e.preventDefault();
                    $('#btn-enviar').html("<i class='fa fa-refresh fa-spin fa-2x fa-fw'></i> Enviando..");
                });
            });

            $(".js-select2").each(function(){
                $(this).select2({
                    minimumResultsForSearch: 20,
                    dropdownParent: $(this).next('.dropDownSelect2')
                });
            })
            $(".js-select2").each(function(){
                $(this).on('select2:open', function (e){
                    $(this).parent().next().addClass('eff-focus-selection');
                });
            });
            $(".js-select2").each(function(){
                $(this).on('select2:close', function (e){
                    $(this).parent().next().removeClass('eff-focus-selection');
                });
            });

        </script>

    <script src="https://colorlib.com/etc/cf/ContactFrom_v18/js/main.js"></script>


    </body>
    </html>
