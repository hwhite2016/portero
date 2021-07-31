<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">


    <div class="row">
        <div class="col-6">
          <h5>
            <i class="fas fa-building"></i>
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

      <div class="row invoice-info">
          <div class="col-md-5 invoice-col">
              <div class="row">
                  <div class="col-3 p-1 border">
                      <span class="font-weight-bold">Cliente</span>
                  </div>
                  <div class="col-9 p-1 border">
                      Torre 6, Apartamento 348
                  </div>
              </div>
              <div class="row">
                  <div class="col-3 p-1 border">
                      <span class="font-weight-bold">NIT</span>
                  </div>
                  <div class="col-9 p-1 border">
                      Apartamento 348
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
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
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
            <table class="table">
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


  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
