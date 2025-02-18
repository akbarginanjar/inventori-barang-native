  <script>
  	function sum() {
  		var stok = document.getElementById('stok').value;
  		var jumlahkeluar = document.getElementById('jumlahkeluar').value;
  		var result = parseInt(stok) - parseInt(jumlahkeluar);
  		if (!isNaN(result)) {
  			document.getElementById('total').value = result;
  		}
  		var harga = document.getElementById('harga_satuan').value;
  		var total = harga * jumlahkeluar;
  		document.getElementById('total_harga').value = total;
  	}
  </script>

  <?php


	$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");
	$no = mysqli_query($koneksi, "select id_transaksi from barang_keluar order by id_transaksi desc");
	$idtran = mysqli_fetch_array($no);
	$kode = $idtran['id_transaksi'];


	$urut = substr($kode, 8, 3);
	$tambah = (int) $urut + 1;
	$bulan = date("m");
	$tahun = date("y");

	if (strlen($tambah) == 1) {
		$format = "TRK-" . $bulan . $tahun . "00" . $tambah;
	} else if (strlen($tambah) == 2) {
		$format = "TRK-" . $bulan . $tahun . "0" . $tambah;
	} else {
		$format = "TRK-" . $bulan . $tahun . $tambah;
	}



	$tanggal_keluar = date("Y-m-d");

	function firstBarang($kode_barang)
	{
		$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");
		// Query dengan prepared statement
		$sql = "SELECT * FROM gudang WHERE kode_barang = ? LIMIT 1";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param("s", $kode_barang); // "s" untuk string
		$stmt->execute();
		$result = $stmt->get_result();

		// Ambil satu data pertama
		$row = $result->fetch_assoc();

		// Tutup koneksi
		$stmt->close();
		$koneksi->close();

		return $row; // Return null jika tidak ada data
	}

	?>

  <div class="container-fluid">

  	<!-- DataTales Example -->
  	<div class="card shadow mb-4">
  		<div class="card-header py-3">
  			<h6 class="m-0 font-weight-bold text-primary">Tambah Barang Keluar</h6>
  		</div>
  		<div class="card-body">
  			<div class="table-responsive">


  				<div class="body">

  					<form method="POST" enctype="multipart/form-data">

  						<label for="">Id Transaksi</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="text" name="id_transaksi" class="form-control" id="id_transaksi" value="<?php echo $format; ?>" readonly />
  							</div>
  						</div>



  						<label for="">Tanggal Keluar</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="date" name="tanggal_keluar" class="form-control" id="tanggal_kelauar" value="<?php echo $tanggal_keluar; ?>" />
  							</div>
  						</div>


  						<label for="">Barang</label>
  						<div class="form-group">
  							<div class="form-line">
  								<select name="barang" id="cmb_barang" class="form-control" />
  								<option value="">-- Pilih Barang --</option>
  								<?php

									$sql = $koneksi->query("select * from gudang order by kode_barang");
									while ($data = $sql->fetch_assoc()) {
										echo "<option value='$data[kode_barang].$data[nama_barang]'>$data[kode_barang] | $data[nama_barang]</option>";
									}
									?>

  								</select>


  							</div>
  						</div>
  						<div class="tampung"></div>

  						<label for="">Jumlah</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="text" name="jumlahkeluar" id="jumlahkeluar" onkeyup="sum()" class="form-control" />
  							</div>
  						</div>

  						<label for="total">Total Stok</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input readonly="readonly" name="total" id="total" type="number" class="form-control">
  							</div>
  						</div>

  						<div class="tampung1"></div>

  						<label for="">Harga Satuan</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="text" name="harga_satuan" id="harga_satuan" onkeyup="sum()" class="form-control" />
  							</div>
  						</div>

  						<label for="jumlah">Total Harga</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input readonly="readonly" name="total_harga" id="total_harga" type="number" class="form-control">


  							</div>
  						</div>

  						<label for="">Nama Konsumen</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="text" name="nama_konsumen" class="form-control" />
  							</div>
  						</div>
  						<label for="">No HP</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="number" name="no_hp" class="form-control" />
  							</div>
  						</div>
  						<label for="">Jatuh Tempo</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="date" name="jatuh_tempo" class="form-control" id="jatuh_tempo" />
  							</div>
  						</div>

  						<label for="">Marketing</label>
  						<div class="form-group">
  							<div class="form-line">
  								<select name="id_marketing" class="form-control" />
  								<option value="0">Tanpa Marketing</option>
  								<?php

									$sql = $koneksi->query("select * from users where level='marketing'");
									while ($data = $sql->fetch_assoc()) {
										echo "<option value='$data[id]'>$data[nama] </option>";
									}
									?>

  								</select>


  							</div>
  						</div>



  						<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">

  					</form>
  					<script>
  						// Ambil elemen input date
  						let inputDate = document.getElementById("jatuh_tempo");

  						// Ambil tanggal hari ini dalam format YYYY-MM-DD
  						let today = new Date().toISOString().split("T")[0];

  						// Set atribut min agar tidak bisa memilih tanggal sebelum hari ini
  						inputDate.setAttribute("min", today);
  					</script>



  					<?php

						if (isset($_POST['simpan'])) {
							$id_transaksi = $_POST['id_transaksi'];
							$tanggal = $_POST['tanggal_keluar'];

							$barang = $_POST['barang'];
							$pecah_barang = explode(".", $barang);
							$kode_barang = $pecah_barang[0];
							$nama_barang = $pecah_barang[1];
							$jumlah = $_POST['jumlahkeluar'];

							$satuan = $_POST['satuan'];
							$nama_konsumen = $_POST['nama_konsumen'];
							$no_hp = $_POST['no_hp'];


							$total = $_POST['total'];
							$harga_satuan = $_POST['harga_satuan'];
							$total_harga = $_POST['total_harga'];


							$id_marketing = $_POST['id_marketing'];
							$jatuh_tempo = $_POST['jatuh_tempo'];

							$sisa2 = $total;
							if ($sisa2 < 0) {
						?>

  							<script type="text/javascript">
  								alert("Stok Barang Habis, Transaksi Tidak Dapat Dilakukan");
  								window.location.href = "?page=barangkeluar&aksi=tambahbarangkeluar";
  							</script>

  						<?php
							} else {
								$newjumlah = $_POST['total'];
								$gudang = firstBarang($kode_barang);
								if ($id_marketing != '0') {
									$laba_kotor = round(($jumlah * $harga_satuan) - ($jumlah * $gudang['harga_rata']));
									$fee_marketing = ($laba_kotor * 30) / 100;
									$sql = $koneksi->query("insert into barang_keluar (id_transaksi, tanggal, kode_barang, nama_barang, jumlah, satuan, nama_konsumen, no_hp, harga_satuan, total_harga, jatuh_tempo, id_marketing, fee_marketing) values('$id_transaksi','$tanggal','$kode_barang','$nama_barang','$jumlah','$satuan','$nama_konsumen', '$no_hp', '$harga_satuan', '$total_harga', '$jatuh_tempo', '$id_marketing', '$fee_marketing')");
								} else {
									$sql = $koneksi->query("insert into barang_keluar (id_transaksi, tanggal, kode_barang, nama_barang, jumlah, satuan, nama_konsumen, no_hp, harga_satuan, total_harga, jatuh_tempo) values('$id_transaksi','$tanggal','$kode_barang','$nama_barang','$jumlah','$satuan','$nama_konsumen', '$no_hp', '$harga_satuan', '$total_harga', '$jatuh_tempo')");
								}



								$id_barang_keluar = $koneksi->insert_id;

								$sql2 = $koneksi->query("INSERT INTO notifikasi (id_barang_keluar, jatuh_tempo) VALUES ('$id_barang_keluar', '$jatuh_tempo')");

								$total_nilai_stok = round($gudang['harga_rata'] * $newjumlah);
								$sql3 = $koneksi->query(" UPDATE gudang SET jumlah = '$newjumlah', total_nilai_stok = '$total_nilai_stok' WHERE kode_barang = '$kode_barang'");


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
  									window.location.href = "?page=barangkeluar";
  								}, 1000);
  							</script>
  					<?php
							}
						}


						?>