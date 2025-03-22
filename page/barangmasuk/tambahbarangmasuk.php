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
  											<th>Harga Satuan</th>
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
  							cellBarang.innerHTML = `<select name="barang[]" class="form-control barang" required>
								<option value="">-- Pilih Barang --</option>
								<?php
								$sql = $koneksi->query("SELECT * FROM gudang ORDER BY kode_barang");
								while ($data = $sql->fetch_assoc()) {
									echo "<option value='{$data['kode_barang']}|{$data['nama_barang']}|{$data['jumlah']}|{$data['satuan']}'>
											{$data['nama_barang']} |  {$data['kode_barang']} 
										</option>";
								}
								?>
							</select>`;

  							cellStok.innerHTML = `<input name="stok[]" readonly type="number" class="form-control stok" value="0">`;

  							cellJumlah.innerHTML = `<div class="input-group mb-3">
								<input type="number" name="jumlahmasuk[]" class="form-control jumlah" min="1" required>
								<span class="input-group-text satuanLabel"></span>
								<input type="hidden" class="satuan" name="satuan[]"></input>
							</div>`;

  							cellTotalStok.innerHTML = `<input name="total_stok[]" readonly type="number" class="form-control total_stok" value="0">`;

  							cellHarga.innerHTML = `<input type="number" name="harga_satuan[]" class="form-control harga" min="1" required>`;

  							cellTotalHarga.innerHTML = `<input name="total_harga[]" readonly type="number" class="form-control total_harga" value="0">`;

  							cellAksi.innerHTML = `<button type="button" onclick="hapusBarang(this)" class="btn btn-danger btn-sm">Hapus</button>`;

  							// Event listener untuk update stok saat barang dipilih
  							row.querySelector(".barang").addEventListener("change", updateStok);

  							// Event listener untuk menghitung total harga otomatis
  							row.querySelector(".jumlah").addEventListener("input", hitungTotalHarga);
  							row.querySelector(".harga").addEventListener("input", hitungTotalHarga);
  						}

  						// Fungsi update stok berdasarkan barang yang dipilih
  						function updateStok() {
  							const row = this.closest("tr");
  							const selectedValue = this.value; // Ambil value dari dropdown
  							const stokInput = row.querySelector(".stok");
  							const satuanInput = row.querySelector(".satuan");
  							const satuanSpan = row.querySelector(".satuanLabel");

  							if (selectedValue) {
  								const stok = selectedValue.split("|")[2]; // Ambil stok dari value
  								const satuan = selectedValue.split("|")[3]; // Ambil satuan dari value
  								console.log
  								stokInput.value = stok;
  								satuanInput.value = satuan;
  								satuanSpan.innerHTML = satuan;
  							} else {
  								stokInput.value = 0;
  							}
  						}

  						// Fungsi menghitung total harga otomatis
  						function hitungTotalHarga() {
  							const row = this.closest("tr");
  							const jumlah = row.querySelector(".jumlah").value || 0;
  							const stok = row.querySelector(".stok").value || 0;
  							const totalStok = parseInt(stok) + parseInt(jumlah);
  							row.querySelector(".total_stok").value = totalStok;
  							const harga = row.querySelector(".harga").value || 0;
  							const totalHarga = jumlah * harga;
  							row.querySelector(".total_harga").value = totalHarga;
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
							include "koneksi.php"; // Pastikan koneksi ke database

							$id_transaksi = $_POST['id_transaksi'];
							$tanggal = $_POST['tanggal_masuk'];
							$pengirim = $_POST['pengirim'];
							$total_harga_barang = array_sum($_POST['total_harga']);

							// Simpan data utama ke barang_masuk
							$sql = $koneksi->query("INSERT INTO barang_masuk (id_transaksi, tanggal, pengirim, total_harga_barang) 
                            VALUES ('$id_transaksi', '$tanggal', '$pengirim', '$total_harga_barang')");

							if ($sql) {
								$id_barang_masuk = $koneksi->insert_id; // Ambil ID yang baru saja dimasukkan

								$barang = $_POST['barang']; // Array barang
								$jumlah = $_POST['jumlahmasuk'];
								$satuan = $_POST['satuan'];
								$harga_satuan = $_POST['harga_satuan'];
								$total_harga = $_POST['total_harga'];

								$totalData = count($barang); // Hitung jumlah barang yang dikirim

								for ($i = 0; $i < $totalData; $i++) {

									if (!empty($barang[$i]) && !empty($jumlah[$i]) && !empty($harga_satuan[$i])) {

										$pecah_barang = explode("|", $barang[$i]); // Pisahkan kode_barang dan nama_barang
										$kode_barang = $pecah_barang[0];
										$nama_barang = $pecah_barang[1];

										$jumlahData = intval($jumlah[$i]);
										$hargaSatuanData = intval($harga_satuan[$i]);
										$totalHargaData = intval($total_harga[$i]);


										// Simpan ke tabel barang_masuk_items dengan id_barang_masuk
										$sql2 = $koneksi->query("INSERT INTO barang_masuk_items 
										(id_barang_masuk, kode_barang, nama_barang, jumlah, satuan, harga_satuan, total_harga) 
										VALUES ('$id_barang_masuk', '$kode_barang', '$nama_barang', '$jumlahData', '$satuan[$i]', '$hargaSatuanData', '$totalHargaData')");

										// Cek data gudang dan update stok
										$gudang = firstBarang($kode_barang);
										if ($gudang['jumlah'] == 0) {
											$harga_rata = $totalHargaData / $jumlahData;
											$total_nilai_stok = $harga_rata * $jumlahData;
										} else {
											$harga_rata = round(($gudang['total_nilai_stok'] + $totalHargaData) / ($gudang['jumlah'] + $jumlahData));
											$total_nilai_stok = round($harga_rata * ($gudang['jumlah'] + $jumlahData));
										}

										$sql3 = $koneksi->query("UPDATE gudang 
										SET jumlah = jumlah + '$jumlahData', harga_rata = '$harga_rata', total_nilai_stok = '$total_nilai_stok' 
										WHERE kode_barang = '$kode_barang'");
									}
								}

								if ($sql2 && $sql3) {
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

  									setTimeout(() => {
  										window.location.href = "?page=barangmasuk";
  									}, 1000);
  								</script>
  					<?php
								}
							}
						}
						?>