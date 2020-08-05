<?php


include_once "database.php";
include_once "fungsi.php";
include_once "proses_mining.php";
//include_once "fungsi_proses.php";
?>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Mining</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?module=home">Beranda</a></li>
          <li class="breadcrumb-item active">Data Mining</li>
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
            <?php
            //object database class
            $db_object = new database();

            $pesan_error = $pesan_success = "";
            if (isset($_GET['pesan_error'])) {
                $pesan_error = $_GET['pesan_error'];
            }
            if (isset($_GET['pesan_success'])) {
                $pesan_success = $_GET['pesan_success'];
            }

            //if (!isset($_POST['submit'])) {
            ?>

            <form method="post" action="" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Nama Barang
                    </label>
                    <div class="col-sm-9">
                        
                        <select name="nama_barang" class="form-control">
                            <option value="">Pilih</option>
                        <?php  
                            $query=$db_object->db_query("SELECT DISTINCT nama_barang FROM data_latih order by(id)");
                             while ($row = $db_object->db_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $row['nama_barang'] ?>"><?php echo $row["nama_barang"] ?></option>
                                <?php 
                            }
                        ?>
                        </select>
                    
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Merek
                    </label>
                    <div class="col-sm-9">
                        <select name="merek" class="form-control">
                            <option value="">Pilih</option>
                        <?php  
                            $query=$db_object->db_query("SELECT DISTINCT merek FROM data_latih order by(id)");
                             while ($row = $db_object->db_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $row['merek'] ?>"><?php echo $row["merek"] ?></option>
                                <?php 
                            }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Jumlah
                    </label>
                    <div class="col-sm-9">
                        <input type="text" name="jumlah" id="form-field-1" class="form-control" 
                               value="<?php echo isset($_POST['jumlah'])?$_POST['jumlah']:"" ?>" required="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                        Penjualan
                    </label>
                    <div class="col-sm-9">
                        <select name="penjualan" class="form-control">
                            <option value="">Pilih</option>
                        <?php  
                            $query=$db_object->db_query("SELECT DISTINCT penjualan FROM data_latih order by(id)");
                             while ($row = $db_object->db_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $row['penjualan'] ?>"><?php echo $row["penjualan"] ?></option>
                                <?php 
                            }
                        ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-9 pull-right">
                        <input name="submit" type="submit" value="Submit" class="control-label btn btn-success">
                    </div>
                </div>
            </form>
            <?php
            //}
            if (isset($_POST['submit'])) {
                $success = true;
                $input_error = false;
                $pesan_gagal = $pesan_sukses = "";

                if (empty($_POST['nama_barang']) | empty($_POST['merek']) | empty($_POST['jumlah']) | empty($_POST['penjualan'])) {
                    $input_error = true;
                    display_error("lengkapi datanya");
                }
                
                
                if(!is_numeric($_POST['jumlah'])){
                    $input_error = true;
                    display_error("jumlah harus diisi angka");
                }

                if (!$input_error) {
                    $n_nama = $_POST['nama_barang'];
                    $n_merek = $_POST['merek'];
                    $n_jumlah = $_POST['jumlah'];
                    $n_penjualan = $_POST['penjualan'];
                   

                    $hasil = klasifikasi($db_object, $n_merek, $n_jumlah, $n_penjualan);

                    //simpan ke table hasil
                    $sql_in_hasil = "INSERT INTO hasil_prediksi
                                (nama_barang, merek, jumlah, penjualan,
                                kelas_hasil, id_rule)
                                VALUES
                                ('$n_nama', '" . $n_merek . "', '" . $n_jumlah . "', '" . $n_penjualan . "', "
                                . "'" . $hasil['keputusan'] . "', '" . $hasil['id_rule'] . "')";
                    $success = $db_object->db_query($sql_in_hasil);

                    //simpan ke data uji
//                        $sql_data_uji = "INSERT INTO data_uji "
//                                . "(nama, jenis_kelamin, usia, sekolah, jawaban_a, jawaban_b, jawaban_c, jawaban_d, kelas_asli) "
//                                . " VALUES "
//                                . "('" . $siswa['nama_siswa'] . "', '" . $siswa['jenis_kelamin'] . "', '" . $siswa['usia'] . "'"
//                                . ", '" . $siswa['sekolah'] . "', '" . $jawaban_a . "', '" . $jawaban_b . "'"
//                                . ", '" . $jawaban_c . "', '" . $jawaban_d . "', '" . $hasil['keputusan'] . "')";
//                        $db_object->db_query($sql_data_uji);

                    if ($success) {
                        if($hasil["keputusan"]=="laris")
                        {
                            $keterangan="Stok perlu ditambah";
                        }else{
                            $keterangan="Stok tidak perlu ditambah";
                        }

                        if($hasil["keputusan"]=="laris")
                        {
                            $keputusan="LARIS";
                        }else
                        {
                            $keputusan="TIDAK LARIS";
                        }
                        ?>
                        <table class="table table-striped table-bordered table-hover" id="sample-table-1">
                            <tr>
                                <td colspan="2"><CENTER><h2>HASIL PREDIKSI</h2></CENTER></td>
                            </tr>
                            <tr>
                                <td width="50%">NAMA BARANG</td>
                                <td width="50%"><?php echo strtoupper($_POST["nama_barang"]) ?></td>
                            </tr>
                            <tr>
                                <td width="50%">MODEL PENJUALAN</td>
                                <td width="50%"><?php echo strtoupper($_POST["penjualan"]) ?></td>
                            </tr>
                            <tr>
                                <td width="50%">HASIL KEPUTUSAN</td>
                                <td width="50%"><?php echo strtoupper($keputusan) ?></td>
                            </tr>
                            <tr>
                                <td width="50%">REKOMENDASI</td>
                                <td width="50%"><?php echo strtoupper($keterangan) ?></td>
                            </tr>
                        </table>
                       <?php 
                    } else {
                        display_error("failed");
                    }
                }
            }
            ?>
        </div>
    </div>
</div>
</div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</section>




