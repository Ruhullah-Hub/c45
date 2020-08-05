<?php  
//error_reporting(0);
session_start();
include "koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>METODE c4.5 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="images/logo_11.png" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed" onload="window.print()">
<div class="wrapper">

   <!-- hasil akhir -->

          <div class="card">
            <div class="card-body">
            <div class="panel-heading"></div>
              <div class="datatable">
                 <table class="table">
              <tr>
                <td width="15%" align="center">
                  <img src="images/logo_11.JPG" width="150px">
                </td>
                <td width="70%" align="center">
                  <p><h3>HASIL PREDIKSI STOK BARANG ALAT MOBIL<br>KABUPATEN ROKAN HULU</h3></p>
                  <p>Jalan : - Kabupaten Rokan Hulu   Kode pos  28558</p>
                </td>
                <td width="15%" align="center">
                  <img src="images/logo_11.JPG" width="170px" height="170px">
                </td>
              </tr>
            </table>
            <hr>
            
                <table class="table table-hover table-bordered">
                  <thead>
                   <tr>
                    <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Merek</th>
                                        <th>Jumlah</th>
                                        <th>Penjualan</th>
                                        <th>Kelas Hasil</th>
                                        <th>Id rule</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $nomor = 0;
                      $hasil = mysqli_query($koneksi,"SELECT * FROM hasil_prediksi");
                      while ($dataku = mysqli_fetch_array($hasil)) {
                       
                      ?>
                      <tr>
                        <td><?php echo $nomor=$nomor+1; ?></td>
                        <td><?php echo $dataku['id']; ?></td>
                        <td><?php echo $dataku['nama_barang']; ?></td>
                        <th><?php echo $dataku['merek']; ?></th>
                        <td><?php echo $dataku['jumlah']; ?></td>
                        <th><?php echo $dataku['penjualan']; ?></th>
                        <td><?php echo $dataku['kelas_hasil']; ?></td>
                        <td><?php echo $dataku['id_rule']; ?></td>
                      </tr>
                      <?php 
                    }
                    ?>                
                    <!-- CMAX -->
                     
                  </tbody>
                </table>
                <table class="table table-hover">
                  <tr>
                    <td width="75%">&nbsp;</td>
                    <td width="25%">
                      <center>
                        Rokan Hulu, <?php echo date("d/m/Y") ?><br>
                        Mengetahui,
                        <br><br><br><br><br>
                        (Mr.X)
                      </center>
                    </td>
                  </tr>
                </table>
              </div>
          </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
      $(this).remove(); 
    });
  }, 1000);
</script>
<!-- <script type="text/javascript" src="style/jquery.js"></script> -->
  <script type="text/javascript"  src="style/rupiah.js"></script>
</body>
</html>
