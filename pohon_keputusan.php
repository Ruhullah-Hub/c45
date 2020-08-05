<?php
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
include_once "database.php";
include_once "fungsi.php";
//object database class
$db_object = new database();
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Pohon Keputusan</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?module=home">Beranda</a></li>
          <li class="breadcrumb-item active">Pohon Keputusan</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
            <!-- end: PAGE HEADER -->
            <!-- start: PAGE CONTENT -->
            <?php
            if (isset($_GET['act'])) {
                $action = $_GET['act'];
                //$id = $_GET['id'];
                if ($action == 'delete') {
                    $db_object->db_query("TRUNCATE t_keputusan");
                    //header('location:?module=pohon_keputusan');
                }
            }

            $query = $db_object->db_query("select * from t_keputusan order by(id)");
            $jumlah = $db_object->db_num_rows($query);
//jika pohon keputusan kosong
            if ($jumlah == 0) {
                echo "<center><h3> Pohon keputusan belum terbentuk...</h3></center>";
            } else {
                //hanya kaprodi yang bisa menghapus pohon keputusan dan menguji akurasi
                
                    ?>
                    <p>
                        <a href="?module=pohon_keputusan&act=delete" class="btn btn-danger" onClick="return confirm('Anda yakin akan hapus pohon keputusan?')">
                            Hapus Pohon Keputusan
                        </a>
                        <!--<a href="?menu=pohon_tree" >Lihat Pohon Keputusan</a> |-->
                        <a href="?module=uji_rule" class="btn btn-default">Uji Rule</a>
                    </p>
                    <?php
                
                echo "Jumlah rule : " . $jumlah . "<br>";
                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="sample-table-1">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Aturan</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $warna1 = '#ffc';
                            $warna2 = '#eea';
                            $warna = $warna1;
                            $no = 1;
                            while ($row = $db_object->db_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td align='center'><?php echo $row['id']; ?></td>
                                    <td><?php
                                        echo "IF ";
                                        if ($row['parent'] != '') {
                                            echo $row['parent'] . " AND ";
                                        }
                                        echo $row['akar'] . " THEN Label = " . $row['keputusan'];
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }


            /*
              //select id dari pohon keputusan
              $que_sql = $db_object->db_query("SELECT id FROM t_keputusan");
              $id = array();
              $l = 0;
              while ($bar_row = $db_object->db_fetch_array($que_sql)) {
              $id[$l] = $bar_row[0];
              $l++;
              }

              $query = $db_object->db_query("SELECT * FROM t_keputusan ORDER BY(id)");
              $temp_rule = array();
              $temp_rule[0] = '';
              $ll = 0; //variabel untuk iterasi id pohon keputusan
              while ($bar = $db_object->db_fetch_array($query)) {
              //menampung rule
              if ($bar[1] != '') {
              $rule = $bar[1] . " AND " . $bar[2];
              } else {
              $rule = $bar[2];
              }

              $rule = str_replace("OR", "/", $rule);
              //explode rule
              $exRule = explode(" AND ", $rule);
              $jml_ExRule = count($exRule);
              $jml_temp = count($temp_rule);

              $i = 0;
              while ($i < $jml_ExRule) {
              if ($temp_rule[$i] == $exRule[$i]) {
              $temp_rule[$i] = $exRule[$i];
              $exRule[$i] = "---- ";
              } else {
              $temp_rule[$i] = $exRule[$i];
              }

              if ($i == ($jml_ExRule - 1)) {
              $t = $i;
              while ($t < $jml_temp) {
              $temp_rule[$t] = "";
              $t++;
              }
              }

              //jika terakhir tambah cetak keputusan
              if ($i == ($jml_ExRule - 1)) {
              $strip = '';
              for ($x = 1; $x <= $i; $x++) {
              $strip = $strip . "---- ";
              }
              $sql_que = $db_object->db_query("SELECT keputusan FROM t_keputusan WHERE id=$id[$ll]");
              $row_bar = $db_object->db_fetch_array($sql_que);
              if ($exRule[$i - 1] == "---- ") {
              echo "<font color='#000'><b>" . $exRule[$i] . "</b></font> <i>Maka donor darah = </i><strong>" . $row_bar[0] . " (" . $id[$ll] . ")</strong>";
              } else if ($exRule[$i - 1] != "---- ") {
              echo "<br>" . $strip . "<font color='#000'><b>" . $exRule[$i] . "</b></font> <i>Maka donor darah = </i><strong>" . $row_bar[0] . "  (" . $id[$ll] . ")</strong>";
              }
              }
              //jika pertama
              else if ($i == 0) {
              if ($ll == 1) {
              echo "<font color='#000'><b>" . $exRule[$i] . "</b></font> <b></b>";
              } else {
              echo $exRule[$i] . " ";
              }
              }
              //jika ditengah
              else {
              if ($exRule[$i] == "---- ") {
              echo $exRule[$i] . " ";
              } else {
              if ($exRule[$i - 1] == "---- ") {
              echo "<font color='#000'><b>" . $exRule[$i] . "</b></font> <b></b>";
              } else {
              $strip = '';
              for ($x = 1; $x <= $i; $x++) {
              $strip = $strip . "---- ";
              }
              echo "<br>" . $strip . "<font color='#000'><b>" . $exRule[$i] . "</b></font> <b></b>";
              }
              }
              }
              $i++;
              }
              echo "<br>";
              $ll++;
              }

             * 
             */
            ?>
                    </div>
                </div>
            </div>
        </div>
  </div>
</section>

