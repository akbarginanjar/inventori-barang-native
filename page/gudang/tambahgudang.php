<?php



$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");
$no = mysqli_query($koneksi, "select kode_barang from gudang order by kode_barang desc");
$kdbarang = mysqli_fetch_array($no);
$kode = $kdbarang['kode_barang'];


$urut = substr($kode, 8, 3);
$tambah = (int) $urut + 1;
$bulan = date("m");
$tahun = date("y");

if (strlen($tambah) == 1) {
	$format = "BAR-" . $bulan . $tahun . "00" . $tambah;
} else if (strlen($tambah) == 2) {
	$format = "BAR-" . $bulan . $tahun . "0" . $tambah;
} else {
	$format = "BAR-" . $bulan . $tahun . $tambah;
}



$jumlah = 0;

?>





<div class="container-fluid">

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Tambah Stok</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">


				<div class="body">

					<form method="POST" enctype="multipart/form-data">

						<label for="">Kode Barang</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="kode_barang" class="form-control" id="kode_barang" value="<?php echo $format; ?>" readonly />
							</div>
						</div>



						<label for="">Nama Barang</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="nama_barang" class="form-control" required />
							</div>
						</div>

						<!-- <label for="">Jenis Barang</label> -->
						<div class="form-group">
							<div class="form-line">
								<select name="jenis_barang" class="form-control" hidden />
								<option value="">-- Pilih Jenis Barang --</option>
								<?php

								$sql = $koneksi->query("select * from jenis_barang order by id");
								while ($data = $sql->fetch_assoc()) {
									echo "<option value='$data[id].$data[jenis_barang]'>$data[jenis_barang]</option>";
								}
								?>
								</select>


							</div>
						</div>


						<label for="">Jumlah</label>
						<div class="form-group">
							<div class="form-line">
								<input type="text" name="jumlah" class="form-control" id="jumlah" value="<?php echo $jumlah; ?>" readonly />


							</div>
						</div>







						<label for="">Satuan Barang</label>
						<div class="form-group">
							<div class="form-line">
								<select name="satuan" class="form-control" required />
								<option value="">-- Pilih Satuan Barang --</option>
								<?php

								$sql = $koneksi->query("select * from satuan order by id");
								while ($data = $sql->fetch_assoc()) {
									echo "<option value='$data[id].$data[satuan]'>$data[satuan]</option>";
								}
								?>
								</select>


							</div>
						</div>

						<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">

					</form>



					<?php

					if (isset($_POST['simpan'])) {

						$kode_barang = $_POST['kode_barang'];
						$nama_barang = $_POST['nama_barang'];


						$jenis_barang = $_POST['jenis_barang'];
						$pecah_jenis = explode(".", $jenis_barang);

						$id = $pecah_jenis[0];
						$jenis_barang = $pecah_jenis[1];

						$jumlah = $_POST['jumlah'];
						$harga_rata = 0;
						$total_nilai_stok = 0;



						$satuan = $_POST['satuan'];
						$pecah_satuan = explode(".", $satuan);

						$id = $pecah_satuan[0];
						$satuan = $pecah_satuan[1];







						$sql = $koneksi->query("insert into gudang (kode_barang, nama_barang,  jumlah, satuan, harga_rata, total_nilai_stok ) values('$kode_barang','$nama_barang','$jumlah','$satuan', '$harga_rata', '$total_nilai_stok')");

						if ($sql) {
					?>

							<script type="text/javascript">
								Swal.fire({
									toast: true,
									position: "top-end",
									icon: "success",
									title: "Data berhasil disimpan!",
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
					}


					?>