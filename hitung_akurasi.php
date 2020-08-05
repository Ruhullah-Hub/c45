<?php

include_once "database.php";
include_once "fungsi.php";
include_once "proses_mining.php";
?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Haitung Akurasi</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?module=home">Beranda</a></li>
          <li class="breadcrumb-item active">Hitung Akurasi</li>
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
            $query = $db_object->db_query("SELECT * FROM data_uji");
            $id_rule = array();
            $it = 0;
            while ($bar = $db_object->db_fetch_array($query)) {
                //ambil data uji
                $n_merek = $bar['merek'];
                $n_jumlah = $bar['jumlah'];
                $n_penjualan = $bar['penjualan'];
                $n_kelas_asli = $bar['kelas_asli'];

                $hasil = klasifikasi($db_object, $n_merek, $n_jumlah, $n_penjualan);

                $keputusan = $hasil['keputusan'];
                $id_rule_keputusan = $hasil['id_rule'];
                $it++;
                $db_object->db_query("UPDATE data_uji SET kelas_hasil='$keputusan', id_rule='$id_rule_keputusan' WHERE id=$bar[0]");
            }//end loop data uji
//menampilkan data uji dengan hasil prediksi
            $sql = $db_object->db_query("SELECT * FROM data_uji");
            ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="sample-table-1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Merek</th>
                            <th>Jumlah</th>
                            <th>Penjualan</th>
                            <th>Kelas Asli</th>
                            <th>Hasil Prediksi</th>
                            <th>Id Rule</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        while ($row = $db_object->db_fetch_array($sql)) {
                            if ($row['kelas_asli'] == $row['kelas_hasil']) {
                                $ketepatan = "benar";
                            } else {
                                $ketepatan = "salah";
                            }
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $row['nama_barang'] . "</td>";
                            echo "<td>" . $row['merek'] . "</td>";
                            echo "<td>" . $row['jumlah'] . "</td>";
                            echo "<td>" . $row['penjualan'] . "</td>";
                            echo "<td>" . $row['kelas_asli'] . "</td>";
                            echo "<td>" . $row['kelas_hasil'] . "</td>";
                            echo "<td>" . $row['id_rule'] . "</td>";
                            echo "<td>" . ($ketepatan == 'benar' ? "<b>" . $ketepatan . "</b>" : $ketepatan) . "</td>";
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
//perhitungan akurasi
            $que = $db_object->db_query("SELECT * FROM data_uji");
            $jumlah_uji = $db_object->db_num_rows($que);
            $TP=0; $FN=0; $TN=0; $FP=0; $kosong=0;
            //$TA = $FB = $FC = $FD = $FE = $TF = $FG = $FH = $FI = $FJ = $TK = $FL = $FM = $FN = $FO = $TP = 0;
            $kosong =$tepat = $tidak_tepat =  0;
            while ($row = $db_object->db_fetch_array($que)) {
                $asli = $row['kelas_asli'];
                $prediksi = $row['kelas_hasil'];
                if($asli==$prediksi){
                    if($asli=='laris'){
                        $TP++;
                    }
                    else{
                        $TN++;
                    }
                    $tepat++;
                }
                else{
                    if($asli=='laris'){
                        $FN++;
                    }
                    else{
                        $FP++;
                    }
                    $tidak_tepat++;
                }
            }
//            $tepat = ($TA + $TF + $TK + $TP);
//            $tidak_tepat = ($FB + $FC + $FD + $FE + $FG + $FH + $FI + $FJ + $FL + $FM + $FN + $FO + $kosong);
            $akurasi = ($tepat / $jumlah_uji) * 100;
            $laju_error = ($tidak_tepat / $jumlah_uji) * 100;
                        $sensitivitas=round(($TP/($TP+$FN))*100, 2);
                        $spesifisitas=round(($TN/($FP+$TN))*100, 2);

            $akurasi = round($akurasi, 2);
            $laju_error = round($laju_error, 2);
            echo "<br><br>";
            ?>
            <table class="table table-striped table-bordered table-hover" id="sample-table-1">
                <tr>
                    <td colspan="2"><CENTER><h2>HASIL UJI AKURASI</h2></CENTER></td>
                </tr>
                <tr>
                    <td width="50%">JUMLAH PREDIKSI</td>
                    <td width="50%"><?php echo $jumlah_uji ?></td>
                </tr>
                <tr>
                    <td width="50%">JUMLAH TEPAT</td>
                    <td width="50%"><?php echo $tepat ?></td>
                </tr>
                <tr>
                    <td width="50%">JUMLAH TIDAK TEPAT</td>
                    <td width="50%"><?php echo $tidak_tepat ?></td>
                </tr>
                <?php 
                    if($kosong!=0)
                    {
                        ?>
                        <tr>
                            <td>JUMLAH DATA YANG DIPREDIKSI KOSONG $kosong</td>
                        </tr>
                    </table>
                        <?php 
                    }else{
                        ?>
                        <tr>
                            <td width="50%">AKURASI</td>
                            <td width="50%"><?php echo $akurasi ?>%</td>
                        </tr>
                        <tr>
                            <td width="50%">LAJU ERROR</td>
                            <td width="50%"><?php echo $laju_error ?>%</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">TP = <?php  echo $TP ?>, TN = <?php  echo $TN ?>, FN = <?php  echo $FN ?></td>
                        </tr>
                        <tr>
                            <td>SENSITIVITAS</td>
                            <td><?php echo $sensitivitas ?>%</td>
                        </tr>
                        <tr>
                            <td>SPESIFITAS</td>
                            <td><?php echo $spesifisitas ?>%</td>
                        </tr>
                    </table>
                        <?php 
                    }
                 ?>
                
            <?php 
            /*echo "<center><h4>";
            echo "Jumlah prediksi: $jumlah_uji<br>";
            echo "Jumlah tepat: $tepat<br>";
            echo "Jumlah tidak tepat: $tidak_tepat<br>";
            if ($kosong != 0) {
                echo "Jumlah data yang prediksinya kosong: $kosong<br></h4>";
            }
            echo "<h2>AKURASI = $akurasi %<br>";
            echo "LAJU ERROR = $laju_error %<br><h2>";
            
            echo "<h3>";
            echo "TP=$TP  TN=$TN  FP=$FP  FN=$FN<br>";
            echo "Sensitivitas = $sensitivitas %<br>";
            echo "Spesifisitas = $spesifisitas %<br>";
                echo "</h3>";*/
            ?>
        </div>
                </div>
            </div>
        </div>
  </div>
</section>