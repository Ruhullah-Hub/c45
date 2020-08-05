
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
<!-- /.content-header -->
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
        	<?php
				if(isset($_GET['aksi']) == 'delete_all'){
					
					$delete = mysqli_query($koneksi, "DELETE FROM data_latih");
					if($delete){
						echo '<div class="alert alert-success" role="alert">
							  <strong>Sukses!</strong> Data berhasil Dihapus
							  </div>';
					}else{
						echo '<div class="alert alert-danger" role="alert">
							  <strong>Sukses!</strong> Data berhasil Dihapus
							  </div>';
					}
				}
				
			?>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"> <a href="?module=input_latih"><button class="btn btn-warning">Upload Data Latih</button></a>&nbsp;<a href="?module=latih&aksi=delete_all"><button class="btn btn-danger">Hapus Data Latih</button></a></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
				 <tr>
	                  <th>No.</th>
	                  <th>Nama Barang</th>
	                  <th>Merek</th>
	                  <th>Jumlah Penjualan</th>
	                  <th>Model Penjualan</th>
	                  <th>Kelas</th>   
	                  <th>Aksi</th>     
				</tr>
			</thead>
			<tbody>
				<?php
				$sql =  mysqli_query($koneksi, "SELECT * FROM data_latih");
					$no = 1;
					while($data = mysqli_fetch_assoc($sql)){
				?>
						
						<tr>
							<td><?php echo $no; ?></td>
                            <td><?php echo $data["nama_barang"] ?></td>
                            <td><?php echo strtoupper($data["merek"]) ?></td>
                            <td><?php echo $data["jumlah"] ?></td>
                            <td><?php echo strtoupper($data["penjualan"]) ?></td>
                            <td><?php echo strtoupper($data["kelas_asli"]) ?></td>
							<td>								
								<a href="?module=latih&aksi=delete&id=<?php echo $row['id']; ?>" title="Hapus Data Latih" onclick="return confirm('Anda yakin akan menghapus Data Uji')" class="btn btn-danger btn-sm"> <i class="nav-icon fas fa-trash"></i></a>
							</td>
						</tr>
						
						<?php
						$no++;
				}
				?>
				</tbody>
				<tfoot>
					 <tr>
		                  <th>No.</th>
		                  <th>Nama Barang</th>
		                  <th>Merek</th>
		                  <th>Jumlah Penjualan</th>
		                  <th>Model Penjualan</th>
		                  <th>Kelas</th>   
		                  <th>Aksi</th>     
					</tr>
				</tfoot>
				</table>
				</div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

	