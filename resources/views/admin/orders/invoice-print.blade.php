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
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h4>
          <i class="fas fa-globe"></i> Conjunto Residencial Siena.
          <small class="float-right">Fecha: 01/07/2021</small>
        </h4>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        De
        <address>
          <strong>Administracion.</strong><br>
          Tv. 44 # 102 - 167, Miramar<br>
          Barranquilla, Atlantico<br>
          Telefono: (804) 123-5432<br>
          Email: siena@gmail.com
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Para
        <address>
          <strong>Eliana Solipa Zambrano</strong><br>
          Torre 6, Apto. 348<br>
          Conjunto Siena<br>
          Telefono: (316) 697-8010<br>
          Email: eliana@wikisoft.co
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Factura #007612</b><br>
        <br>
        <b>Nro. de Orden:</b> 4F3S8J<br>
        <b>Fecha de pago:</b> 2021/07/01<br>
        <b>Pronto pago:</b> 2021/07/10<br>
        <b>Cuenta:</b> Av Villas: 65234-968-34567
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
            <th>Qty</th>
            <th>Servicio</th>
            <th>Consecutivo #</th>
            <th>Description</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
            <td>Cuota Administracion</td>
            <td>455-981-221</td>
            <td>Cuota administracion mes de Julio</td>
            <td>$172.000</td>
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
        <img src="../vendor/adminlte/dist/img/credit/paypal2.png" alt="Paypal">

        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
            Puede elegir desde uno hasta varios canales.
        </p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Monto adeudado 2/22/2014</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>$172.000</td>
            </tr>
            <tr>
              <th>Descuento pronto pago (5%)</th>
              <td>- $7.000</td>
            </tr>
            <tr>
              <th>Otros descuentos:</th>
              <td>$0.00</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>$165.000</td>
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
