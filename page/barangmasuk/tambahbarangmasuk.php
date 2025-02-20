  <script>
  	function sum() {
  		var stok = document.getElementById('stok').value;
  		var jumlahmasuk = document.getElementById('jumlahmasuk').value;
  		var result = parseInt(stok) + parseInt(jumlahmasuk);
  		if (!isNaN(result)) {
  			document.getElementById('jumlah').value = result;
  		}
  		var harga = document.getElementById('harga_satuan').value;
  		var total = harga * jumlahmasuk;
  		document.getElementById('total_harga').value = total;

  	}
  </script>

  <?php

	$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");
	$no = mysqli_query($koneksi, "select id_transaksi from barang_masuk order by id_transaksi desc");
	$idtran = mysqli_fetch_array($no);
	$kode = $idtran['id_transaksi'];



	$urut = substr($kode, 8, 3);
	$tambah = (int) $urut + 1;
	$bulan = date("m");
	$tahun = date("y");

	if (strlen($tambah) == 1) {
		$format = "TRM-" . $bulan . $tahun . "00" . $tambah;
	} else if (strlen($tambah) == 2) {
		$format = "TRM-" . $bulan . $tahun . "0" . $tambah;
	} else {
		$format = "TRM-" . $bulan . $tahun . $tambah;
	}



	$tanggal_masuk = date("Y-m-d");

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
  			<h6 class="m-0 font-weight-bold text-primary">Tambah Barang Masuk</h6>
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



  						<label for="">Tanggal Masuk</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="date" name="tanggal_masuk" class="form-control" id="tanggal_masuk" value="<?php echo $tanggal_masuk; ?>" />
  							</div>
  						</div>


  						<!-- <label for="">Barang</label>
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
  						</div> -->

  						<!-- <div class="tampung"></div> -->

  						<!-- <label for="">Jumlah</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="text" name="jumlahmasuk" id="jumlahmasuk" onkeyup="sum()" class="form-control" />


  							</div>
  						</div> -->

  						<!-- <label for="jumlah">Total Stok</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input readonly="readonly" name="jumlah" id="jumlah" type="number" class="form-control">
  							</div>
  						</div> -->

  						<!-- <div class="tampung1"></div> -->

  						<!-- <label for="">Harga Satuan</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input type="number" name="harga_satuan" id="harga_satuan" onkeyup="sum()" class="form-control" value="0" />
  							</div>
  						</div> -->

  						<!-- <label for="jumlah">Total Harga</label>
  						<div class="form-group">
  							<div class="form-line">
  								<input readonly="readonly" name="total_harga" id="total_harga" type="number" class="form-control">


  							</div>
  						</div> -->

						<label for="">Supplier</label>
  						<div class="form-group">
  							<div class="form-line">
  								<select name="pengirim" class="form-control" />
  								<option value="">-- Pilih Supplier --</option>
  								<?php

									$sql = $koneksi->query("select * from tb_supplier order by nama_supplier");
									while ($data = $sql->fetch_assoc()) {
										echo "<option value='$data[nama_supplier]'>$data[nama_supplier]</option>";
									}
									?>

  								</select>
  							</div>
  						</div>

						<div class="card mb-3">
							<div class="card-body">
								<div style="display: flex; justify-content: space-between; align-items: center">
									<h5 style="color: black;">Data Barang</h5>
									<a onclick="tambahBarang()" class="btn btn-info text-white mb-2" style="cursor: pointer;">Tambah Barang</a>
								</div>
								<table id="barangTable" class="table table-bordered table-hover" style="color: black;">
								  <thead>
									  <tr>
										  <th>No</th>
										  <th>Barang</th>
										  <th>Stok</th>
										  <th>Jumlah</th>
										  <th>Total Stok</th>
										  <th>Harga</th>
										  <th>Total Harga</th>
										  <th></th>
									  </tr>
								  </thead>
								  <tbody>
								  </tbody>
							  </table>
							</div>
						</div>

  						<input type="submit" name="simpan" value="Simpan" class="btn btn-primary">

  					</form>

					  <script>
						let count = 0;

						function tambahBarang() {
							count++;
							const table = document.getElementById('barangTable').getElementsByTagName('tbody')[0];
							const row = table.insertRow();
							
							const cellNo = row.insertCell(0);
							const cellBarang = row.insertCell(1);
							const cellStok = row.insertCell(2);
							const cellJumlah = row.insertCell(3);
							const cellTotalStok = row.insertCell(4);
							const cellHarga = row.insertCell(5);
							const cellTotalHarga = row.insertCell(6);
							const cellAksi = row.insertCell(7);

							cellNo.innerText = count;
							cellBarang.innerHTML = `<select name="barang" id="cmb_barang" class="form-control" />
  								<option value="">-- Pilih Barang --</option>
  								<?php

									$sql = $koneksi->query("select * from gudang order by kode_barang");
									while ($data = $sql->fetch_assoc()) {
										echo "<option value='$data[kode_barang].$data[nama_barang]'>$data[kode_barang] | $data[nama_barang]</option>";
									}
									?>

  								</select>`;
							cellStok.innerHTML = `<input readonly="readonly" id="stok" type="number" class="form-control" value="0">`;
							cellJumlah.innerHTML = `<div class="input-group mb-3">
								<input type="text" class="form-control" aria-describedby="basic-addon2">
								<span class="input-group-text" id="basic-addon2">Kg</span>
								</div>`;
							cellTotalStok.innerHTML = `<input readonly="readonly" type="number" class="form-control" value="0">`;
							cellHarga.innerHTML = `<input type="number" class="form-control" value="">`;
							cellTotalHarga.innerHTML = `<input type="number" class="form-control" value="">`;
							cellAksi.innerHTML = `<button onclick="hapusBarang(this)" class="btn btn-danger btn-sm">Hapus</button>`;
						}

						function hapusBarang(button) {
							const row = button.parentNode.parentNode;
							row.parentNode.removeChild(row);
							updateNomor();
						}

						function updateNomor() {
							const table = document.getElementById('barangTable').getElementsByTagName('tbody')[0];
							const rows = table.getElementsByTagName('tr');
							count = 0;
							for (let i = 0; i < rows.length; i++) {
								rows[i].cells[0].innerText = i + 1;
								count++;
							}
						}
					</script>


  					<?php

						if (isset($_POST['simpan'])) {
							$id_transaksi = $_POST['id_transaksi'];
							$tanggal = $_POST['tanggal_masuk'];

							$barang = $_POST['barang'];
							$pecah_barang = explode(".", $barang);
							$kode_barang = $pecah_barang[0];
							$nama_barang = $pecah_barang[1];



							$jumlah = $_POST['jumlahmasuk'];


							$pengirim = $_POST['pengirim'];
							$pecah_nama = explode($nama_supplier, ""); //tole
							$nama_supplier = $pecah_nama[0];

							$satuan = $_POST['satuan'];
							$harga_satuan = $_POST['harga_satuan'];
							$total_harga = $_POST['total_harga'];
							$sql = $koneksi->query("insert into barang_masuk  (id_transaksi, tanggal, kode_barang, nama_barang, jumlah, satuan, pengirim, harga_satuan, total_harga) values('$id_transaksi','$tanggal','$kode_barang','$nama_barang','$jumlah','$satuan','$pengirim', '$harga_satuan', '$total_harga')");

							// Update Gudang
							$newjumlah = $_POST['jumlah'];
							$gudang = firstBarang($kode_barang);
							if ($gudang['jumlah'] == 0) {
								$harga_rata = $total_harga / $jumlah;
								$total_nilai_stok = $harga_rata * $jumlah;
							} else {
								$harga_rata = round(($gudang['total_nilai_stok'] + $total_harga) / ($gudang['jumlah'] + $jumlah));
								$total_nilai_stok = round($harga_rata * ($gudang['jumlah'] + $jumlah));
							}
							$sql2 = $koneksi->query(" UPDATE gudang SET jumlah = '$newjumlah', harga_rata = '$harga_rata', total_nilai_stok = '$total_nilai_stok' WHERE kode_barang = '$kode_barang'");
							if ($sql && $sql2) {
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
  									window.location.href = "?page=barangmasuk";
  								}, 1000);
  							</script>
  					<?php
							}
						}


						?>