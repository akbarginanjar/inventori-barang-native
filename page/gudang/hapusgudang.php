 <?php
 
 $kode_barang = $_GET['kode_barang'];
 $sql = $koneksi->query("delete from gudang where kode_barang = '$kode_barang'");

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
												window.location.href = "?page=gudang";
											}, 1000);
										</script>
	
 <?php
 
 }
 
 ?>