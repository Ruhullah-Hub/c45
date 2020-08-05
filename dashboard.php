<?php  
error_reporting(0);
session_start();
include "koneksi.php";
include "koneksi2.php";
include "libs/excel_reader2.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>METODE C4.5</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="shortcut icon" href="images/logo_11.png" />
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-yellow navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="?module=home" class="nav-link">Beranda</a>
      </li>
    </ul>

   
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <table bgcolor="white">
      <tr>
        <td>
          <a href="?module=home" class="brand-link">
            <center><img src="images/logo_11.jpg" alt="AdminLTE Logo" width="75%"><br>
            <font color="black"><small></small></font>
            </center>
          </a>
        </td>
      </tr>
    </table>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/users.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="?module=edit_user&id=<?php echo $_SESSION['id']; ?>" class="d-block"><?php echo $_SESSION["nama"] ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="?module=latih" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Data Latih</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?module=uji" class="nav-link">
              <i class="nav-icon fas fa-paste"></i>
              <p>Data Uji</p>
            </a>
          </li>
           <li class="nav-item">
            <a href="?module=data_mining" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Data Mining</p>
            </a>
          </li>
         <li class="nav-item">
            <a href="?module=pohon_keputusan" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Pohon Keputusan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?module=prediksi" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Prediksi</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?module=hasil" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Hasil</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?module=data_user" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Keluar</p>
            </a>
          </li>
        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <?php  
        $module=$_GET["module"];
        
            switch ($module) {
              default:
                # code...
                ?>
                <div class="content-header">
                  <div class="container-fluid">
                    <div class="row mb-2">
                      <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                      </div><!-- /.col -->
                      <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                          <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                      </div><!-- /.col -->
                    </div><!-- /.row -->
                  </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->


                <!-- Main content -->
                <section class="content">
                  <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                      <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Data Latih</span>
                            <?php 
                            $sql=mysqli_query($koneksi, "SELECT COUNT(id) AS jumlah FROM data_latih");
                            $data=mysqli_fetch_array($sql);
                            ?>
                            <span class="info-box-number">
                              <?php echo $data["jumlah"] ?>
                            </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-paste"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Data Uji</span>
                            <?php 
                            $sql=mysqli_query($koneksi, "SELECT COUNT(id) AS jumlah FROM data_uji");
                            $data=mysqli_fetch_array($sql);
                            ?>
                            <span class="info-box-number"><?php echo $data["jumlah"] ?></span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->

                      <!-- fix for small devices only -->
                      <div class="clearfix hidden-md-up"></div>

                      <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-warehouse"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Hasil Prediksi</span>
                            <?php 
                            $sql=mysqli_query($koneksi, "SELECT COUNT(id) AS jumlah FROM hasil_prediksi");
                            $data=mysqli_fetch_array($sql);
                            ?>
                            <span class="info-box-number"><?php echo $data["jumlah"] ?></span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                           <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-star"></i></span>

                          <div class="info-box-content">
                          <span class="info-box-text">User</span>
                            <?php 
                            $sql=mysqli_query($koneksi, "SELECT COUNT(id_user) AS jumlah FROM users");
                            $data=mysqli_fetch_array($sql);
                            ?>
                            <span class="info-box-number"><?php echo $data["jumlah"] ?></span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- TABLE: LATEST ORDERS -->
                    <div class="row"> 
                      <div class="col-sm-6">
                        <div class="card ">
                          <div class="card-header border-transparent">
                            <h3 class="card-title">DATA LATIH</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.card-header -->
                          <?php  
                          $sql=mysqli_query($koneksi, "SELECT * FROM data_latih ORDER BY id ASC LIMIT 5");
                          $no=1;
                          ?>
                          <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Nama Barang</th>
                                  <th>Merek</th>
                                  <th>Jumlah Penjualan</th>
                                  <th>Model Penjualan</th>
                                  <th>Kelas</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php  
                                  while($data=mysqli_fetch_array($sql))
                                  {
                                    ?>
                                    <tr>
                                      <td><?php echo $no; ?></td>
                                      <td><?php echo $data["nama_barang"] ?></td>
                                      <td><?php echo strtoupper($data["merek"]) ?></td>
                                      <td><?php echo $data["jumlah"] ?></td>
                                      <td><?php echo strtoupper($data["penjualan"]) ?></td>
                                      <td><?php echo strtoupper($data["kelas_asli"]) ?></td>
                                    </tr>
                                    <?php 
                                    $no++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                            <!-- /.table-responsive -->
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer clearfix">
                            <a href="?module=input_latih" class="btn btn-sm btn-info float-left">Tambah Data</a>
                            <a href="?module=latih" class="btn btn-sm btn-secondary float-right">Lihat Data</a>
                          </div>
                          <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                      </div>
                    
                      <div class="col-sm-6">
                        <div class="card ">
                          <div class="card-header border-transparent">
                            <h3 class="card-title">DATA UJI</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.card-header -->
                          <?php  
                          $sql=mysqli_query($koneksi, "SELECT * FROM data_uji ORDER BY id ASC LIMIT 5");
                          $no=1;
                          ?>
                           <div class="card-body p-0">
                            <div class="table-responsive">
                              <table class="table m-0">
                                <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Nama Barang</th>
                                  <th>Merek</th>
                                  <th>Jumlah Penjualan</th>
                                  <th>Model Penjualan</th>
                                  <th>Kelas</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php  
                                  while($data=mysqli_fetch_array($sql))
                                  {
                                    ?>
                                    <tr>
                                      <td><?php echo $no; ?></td>
                                      <td><?php echo $data["nama_barang"] ?></td>
                                      <td><?php echo strtoupper($data["merek"]) ?></td>
                                      <td><?php echo $data["jumlah"] ?></td>
                                      <td><?php echo strtoupper($data["penjualan"]) ?></td>
                                      <td><?php echo strtoupper($data["kelas_asli"]) ?></td>
                                    </tr>
                                    <?php 
                                    $no++;
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                            <!-- /.table-responsive -->
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer clearfix">
                            <a href="?module=input_latih" class="btn btn-sm btn-info float-left">Tambah Data</a>
                            <a href="?module=latih" class="btn btn-sm btn-secondary float-right">Lihat Data</a>
                          </div>
                          <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                      </div>
                      </div>
                      <!-- /.col -->
                      
                       <!-- Small boxes (Stat box) -->
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="card ">
                              <div class="card-header">
                                <h3 class="card-title">HASIL PREDIKSI</h3>
                                <div class="card-tools">
                                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                  </button>
                                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                  </button>
                                </div>
                              </div>
                              <?php  
                              $sql=mysqli_query($koneksi, "SELECT * FROM hasil_prediksi ORDER BY id ASC LIMIT 5");
                              $no=1;
                              ?>
                              <div class="card-body p-0">
                                <div class="table-responsive">
                                  <table class="table m-0">
                                    <thead>
                                    <tr>
                                      <th>No.</th>
                                      <th>Nama Barang</th>
                                      <th>Merek</th>
                                      <th>Jumlah Penjualan</th>
                                      <th>Model Penjualan</th>
                                      <th>Kelas</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php  
                                      while($data=mysqli_fetch_array($sql))
                                      {
                                        ?>
                                        <tr>
                                          <td><?php echo $no; ?></td>
                                          <td><?php echo $data["nama_barang"] ?></td>
                                          <td><?php echo strtoupper($data["merek"]) ?></td>
                                          <td><?php echo $data["jumlah"] ?></td>
                                          <td><?php echo strtoupper($data["penjualan"]) ?></td>
                                          <td><?php echo strtoupper($data["kelas_hasil"]) ?></td>
                                        </tr>
                                        <?php 
                                        $no++;
                                      }
                                      ?>
                                    </tbody>
                                  </table>
                            </div>
                            <!-- /.table-responsive -->
                          </div>
                              <!-- /.card-body -->
                              <div class="card-footer clearfix">
                                <a href="?module=prediksi" class="btn btn-sm btn-info float-left">Proses Prediksi</a>
                                <a href="?module=hasil" class="btn btn-sm btn-secondary float-right">Lihat Data</a>
                              </div>
                            </div>
                            <!-- /.card -->
                         
                        </div>
                      </div>
                        <!-- /.row -->
                         
                    </div>
                    <!-- /.content-->
                <?php 
                break;
                
                case "latih" :
                        include "modul/latih/latih.php";
                break;
                case "input_latih" :
                        include "modul/latih/input.php";
                break;
                 case "edit_latih" :
                        include "modul/latih/edit.php";
                break;
                case "uji" :
                        include "modul/uji/uji.php";
                break;
                case "input_uji" :
                        include "modul/uji/input.php";
                break;
                 case "edit_uji" :
                        include "modul/uji/edit.php";
                break;
                case "data_user" :
                        include "modul/user/data_user.php";
                break;
                case "input_user" :
                        include "modul/user/input_user.php";
                break;
                case "edit_user" :
                        include "modul/user/edit_user.php";
                break;
                case "data_mining" :
                        include "data_mining.php";
                break;
                case "pohon_keputusan" :
                        include "pohon_keputusan.php";
                break;
                case "prediksi" :
                        include "prediksi.php";
                break;
                case "hasil" :
                        include "hasil.php";
                break;
                case "uji_rule" :
                        include "uji_rule.php";
                break;
            }
        ?>
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <!-- isi utama disini -->
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.2-pre
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
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
