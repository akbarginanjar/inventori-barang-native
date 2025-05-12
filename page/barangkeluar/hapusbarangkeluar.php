 <?php
 
 $id_transaksi = $_GET['id_transaksi'];
 $sql = $koneksi->query("delete from barang_keluar where id_transaksi = '$id_transaksi'");

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
												window.location.href = "?page=barangkeluar";
											}, 1000);
										</script>
	
 <?php
 
 }
 
 ?>