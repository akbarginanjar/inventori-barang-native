 <?php
 
 $kode_supplier = $_GET['id'];
 $sql = $koneksi->query("delete from tb_supplier where kode_supplier = '$kode_supplier'");

 if ($sql) {
 
 ?>
 
 
 <script type="text/javascript">
											Swal.fire({
												toast: true,
												position: "top-end",
												icon: "success",
												title: "Data berhasil dihapus!",
												showConfirmButton: false,
												timer: 3000,
												timerProgressBar: true
											});
									
											// Tunggu 3 detik sebelum redirect
											setTimeout(() => {
												window.location.href = "?page=supplier";
											}, 1000);
										</script>
	
 <?php
 
 }
 
 ?>