 <?php
 
 $id = $_GET['id'];
 $sql = $koneksi->query("delete from satuan where id = '$id'");

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
												window.location.href = "?page=satuanbarang";
											}, 1000);
										</script>
	
 <?php
 
 }
 
 ?>