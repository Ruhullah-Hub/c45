<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Latih</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?module=home">Beranda</a></li>
          <li class="breadcrumb-item active">Data Latih</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
      <div class="container-fluid">
      <div class="row">
        <div class="col-12">
			
			<?php
			

			if(isset($_POST['add'])){
					
					// upload file xls
				$target = basename($_FILES['faile']['name']);
				move_uploaded_file($_FILES['faile']['tmp_name'], $target);

				// beri permisi agar file xls dapat di baca
				chmod($_FILES['faile']['name'], 0777);

				// mengambil isi file xls
				$data = new Spreadsheet_Excel_Reader($_FILES['faile']['name'], false);
				// $data = new Spreadsheet_Excel_Reader();
				// $data->setOutputEncoding('utf-8');
				// $data->read($_FILES['filetraining']['name'], false);
				// menghitung jumlah baris data yang ada
				$jumlah_baris = $data->rowcount($sheet_index = 0);

				// jumlah default data yang berhasil di import
				// $berhasil = 0;
				for ($i = 2; $i <= $jumlah_baris; $i++) {

				    // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
				    $nama_barang    = $data->val($i, 1);
				    $merek          = $data->val($i, 2);
				    $jumlah         = $data->val($i, 3);
				    $penjualan      = $data->val($i, 4);
				    $kelas          = $data->val($i, 5);
				    
				    if ($nama_barang != "" && $merek != "" && $jumlah != "" && $penjualan != "" && $kelas != "") {
				        // input data ke database (table data_pegawai)
				        $upload=mysqli_query($koneksi, "INSERT into data_latih (nama_barang, merek, jumlah, penjualan, kelas_asli)values('$nama_barang', '$merek', '$jumlah', '$penjualan', '$kelas')");
				    }
				}

				if($upload){
					echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Data Latih Berhasil Di Update.</div>';
				}else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Ups, Data Latih Gagal Di Upadate ! </div>';
				}	
				
				// hapus kembali file .xls yang di upload tadi
				//unlink($_FILES['failelatih']['name']);

			}
			
			?>
			<div class="card card-warning">
              	<div class="card-header">
                    <h3 class="card-title">Form Upload </h3>

                    
                      </div>
						
						<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label class="col-sm-3 control-label">File Data Latih</label>
								<div class="col-sm-12">
									<input type="file" name="faile" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">&nbsp;</label>
								<div class="col-sm-12">
									<input type="submit" name="add" class="btn btn-sm btn-warning" value="Simpan">
									<a href="?module=training" class="btn btn-sm btn-danger">Batal</a>
								</div>
							</div>

						</form>
						
					</div>	
			</div>
		</div>
	</div>
</section>