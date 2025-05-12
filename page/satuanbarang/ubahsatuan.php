

<?php
 $id = $_GET['id'];
 $sql2 = $koneksi->query("select * from satuan where id = '$id'");
 $tampil = $sql2->fetch_assoc();
 


 
 
 
 ?>
 
  <div class="container-fluid">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Ubah User</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
							
							
							<div class="body">

							<form method="POST" enctype="multipart/form-data">
							
							<label for="">Satuan Barang</label>
                            <div class="form-group">
                               <div class="form-line">
                                <input type="text" name="satuan" value="<?php echo $tampil['satuan']; ?>" class="form-control" />
	 
							</div>
                            </div>
							
						
							
							<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
							
							</form>
							
							
							
							<?php
							
							if (isset($_POST['simpan'])) {
								
								$satuan= $_POST['satuan'];
								
								
								
								
								$sql = $koneksi->query("update satuan set satuan='$satuan' where id='$id'"); 
								
								if ($sql) {
									?>
									
									<script type="text/javascript">
											Swal.fire({
												toast: true,
												position: "top-end",
												icon: "success",
												title: "Data berhasil diubah!",
												showConfirmButton: false,
												timer: 3000,
												timerProgressBar: true
											});
									
											// Tunggu 3 detik sebelum redirect
											setTimeout(() => {
												window.location.href = "?page=satuanbarang";
											}, 1000);
										</script>
										
										<?php
								}
							
							}
							
							
							?>
										
										
										
								
								
								
								
								
