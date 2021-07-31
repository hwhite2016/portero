@extends('adminlte::page')

@section('title', 'Paises')

@section('content_header')

@stop

@section('content')

@php
    // SDK de Epayco
    require base_path('vendor/autoload.php');
    // Agrega credenciales
    $epayco = new Epayco\Epayco(array(
        "apiKey" => config('services.epayco.apiKey'),
        "privateKey" => config('services.epayco.privateKey'),
        "lenguage" => "ES",
        "test" => true
    ));
@endphp

<section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-12">
          <div class="callout callout-info mt-2">
            <h4>Cuota de Administración</h4>
          </div>


          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-6">
                <h5>
                  <i class="fas fa-receipt"></i>
                  <small class="font-weight-bold text-uppercase">Conjunto residencial siena / NIT 901.185.123</small>
                </h5>
              </div>
              <div class="col-6">
                <h5>
                  <small class="float-right font-weight-bold text-uppercase">CUENTA DE COBRO No. 9048</small>
                </h5>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->

            <div class="row invoice-info mt-2">
                <div class="col-md-5 invoice-col">
                    <div class="row">
                        <div class="col-3 p-1 border">
                            <span class="font-weight-bold">Cliente</span>
                        </div>
                        <div class="col-9 p-1 border">
                            Victor Lopez
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 p-1 border">
                            <span class="font-weight-bold">NIT</span>
                        </div>
                        <div class="col-9 p-1 border">
                            7143433
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 p-1 border">
                            <span class="font-weight-bold">Unidad</span>
                        </div>
                        <div class="col-9 p-1 border">
                            Torre 6, Apartamento 348
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 p-1 border">
                            <span class="font-weight-bold">Telefono</span>
                        </div>
                        <div class="col-9 p-1 border">
                            321 432 3221
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-7 invoice-col">
                    <div class="row">
                        <div class="col-3 p-1 border">
                            <span class="font-weight-bold">Fecha Factura</span>
                        </div>
                        <div class="col-9 p-1 border">
                            01 de Junio de 2021
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 p-1 border">
                            <span class="font-weight-bold">Fecha de Vencimiento</span>
                        </div>
                        <div class="col-9 p-1 border">
                            30 de Junio de 2021
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 p-1 border">
                            <span class="font-weight-bold">Descuento 5% hasta</span>
                        </div>
                        <div class="col-9 p-1 border">
                            10 de Junio de 2021
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 p-1 border">
                            <span class="font-weight-bold">Por concepto de</span>
                        </div>
                        <div class="col-9 p-1 border">
                            Administración mes de Junio de 2021
                        </div>
                    </div>
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->


            <!-- Table row -->
            <div class="row mt-3">
              <div class="col-12 table-responsive">
                <table class="table table-sm table-striped">
                  <thead>
                  <tr>
                    <th>Item</th>
                    <th>Descripcion</th>
                    <th>Valor Cuota</th>
                    <th>Descuento 5%</th>
                    <th>Total</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1</td>
                    <td>Cuota Ordinaria de Administración</td>
                    <td>172.992</td>
                    <td>8.650</td>
                    <td>164.342</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                <p class="lead">Metodos de pago:</p>
                <img src="../vendor/adminlte/dist/img/credit/visa.png" alt="Visa">
                <img src="../vendor/adminlte/dist/img/credit/mastercard.png" alt="Mastercard">
                <img src="../vendor/adminlte/dist/img/credit/american-express.png" alt="American Express">
                <img src="../vendor/adminlte/dist/img/credit/dinners.png" alt="Paypal">

                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Puede elegir desde uno hasta varios canales.
                </p>
              </div>
              <!-- /.col -->
              <div class="col-6">
                <p class="lead">SALDOS ANTERIORES</p>

                <div class="table-responsive">
                  <table class="table table-sm">
                    <tr>
                      <th style="width:50%">Cuota Administración</th>
                      <td>-2.631</td>
                    </tr>
                    <tr>
                        <th>Intereses por Mora</th>
                        <td>0</td>
                    </tr>
                    <tr>
                      <th>Total Saldo Anterior</th>
                      <td>-2.631</td>
                    </tr>
                    <tr>
                      <th>Total Factura</th>
                      <td>161.711</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="{{url('admin/orders2')}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                  Payment
                </button> --}}

                <form class="float-right">
                    <script
                        src="https://checkout.epayco.co/checkout.js"
                        class="epayco-button"
                        data-epayco-key=c36a1b917258e3073bfbf773c11dd5a0
                        data-epayco-amount="161711"
                        data-epayco-name="Pago cuota de administración"
                        data-epayco-description="Pago cuota de administración"
                        data-epayco-currency="cop"
                        data-epayco-country="co"
                        data-epayco-test="true"
                        data-epayco-external="false"
                        data-epayco-button="../image/logo/boton_pago.png"
                        data-epayco-response="https://ejemplo.com/respuesta.html"
                        data-epayco-confirmation="https://ejemplo.com/confirmacion">
                    </script>
                </form>
                <div class="cho-container float-right"></div>

                <button type="button" class="pagar btn btn-primary float-right" style="margin-right: 5px;">
                  <i class="fas fa-download"></i> Generar PDF
                </button>

              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@stop

@section('footer')
    @include('admin.partial.footer')
@stop

@section('css')
    <!-- /<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')

@stop
