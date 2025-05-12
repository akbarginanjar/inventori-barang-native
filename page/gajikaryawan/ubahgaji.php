<?php
$id = $_GET['id'];
$sql = $koneksi->query("select * from users where id = '$id'");
$tampil = $sql->fetch_assoc();

?>

<div class="container-fluid">

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Ubah Gaji Karyawan</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">


				<div class="body">

					<form method="POST" enctype="multipart/form-data">

						<label for="">Nama Karyawan</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="nama" value="<?= $tampil['nama'] ?>" class="form-control">
							</div>
						</div>
						<label for="">Gaji /bulan</label>
						<div class="form-group">
							<div class="form-line">
								<input type="number" name="gaji" value="<?= $tampil['gaji'] ?>" class="form-control" />
							</div>
						</div>
						<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">

					</form>



					<?php

					if (isset($_POST['simpan'])) {

						$gaji = $_POST['gaji'];


						$sql = $koneksi->query("update users set gaji='$gaji' where id='$id'");

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
									window.location.href = "?page=gajikaryawan";
								}, 1000);
							</script>

					<?php
						}
					}


					?>