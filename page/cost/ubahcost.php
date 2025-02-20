

<?php
 $id = $_GET['id'];
 $sql2 = $koneksi->query("select * from cost where id = '$id'");
 $tampil = $sql2->fetch_assoc();
 


 
 
 
 ?>
 
  <div class="container-fluid">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Ubah Cost</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
							
							
							<div class="body">

							<form method="POST" enctype="multipart/form-data">
							
							<label for="">Nama</label>
                            <div class="form-group">
                               <div class="form-line">
                                <input type="text" name="nama" value="<?php echo $tampil['nama']; ?>" class="form-control" />
	 
							</div>
                            </div>
							<label for="">Biaya</label>
                            <div class="form-group">
                               <div class="form-line">
                                <input type="text" name="biaya" value="<?php echo $tampil['biaya']; ?>" class="form-control" />
	 
							</div>
                            </div>
							
						
							
							<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
							
							</form>
							
							
							
							<?php
							
							if (isset($_POST['simpan'])) {
								$nama= $_POST['nama'];
								$biaya= $_POST['biaya'];
								
								
								
								
								$sql = $koneksi->query("update cost set nama='$nama', biaya='$biaya' where id='$id'"); 
								
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
												window.location.href = "?page=cost";
											}, 1000);
										</script>
										
										<?php
								}
							
							}
							
							
							?>
										
										
										
								
								
								
								
								
