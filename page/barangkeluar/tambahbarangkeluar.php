  <?php


	$koneksi = new mysqli("127.0.0.1", "root", "", "pengadaan_barang");
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
		$koneksi = new mysqli("127.0.0.1", "root", "", "pengadaan_barang");
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
								<input type="number" name="jumlahkeluar[]" class="form-control jumlah" min="1" required>
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
  							const totalStok = parseInt(stok) - parseInt(jumlah);
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
							$nama_konsumen = $_POST['nama_konsumen'];
							$no_hp = $_POST['no_hp'];
							$id_marketing = $_POST['id_marketing'];
							$jatuh_tempo = $_POST['jatuh_tempo'];
							$total_harga_barang = array_sum($_POST['total_harga']);

							$totalStok = $_POST['total_stok'];

							if (array_filter($totalStok, fn($stok) => $stok < 0)) {
						?>

  							<script type="text/javascript">
  								alert("Stok Barang Habis, Transaksi Tidak Dapat Dilakukan");
  								window.location.href = "?page=barangkeluar&aksi=tambahbarangkeluar";
  							</script>

  							<?php
							} else {


								$barang = $_POST['barang'];
								$jumlah = $_POST['jumlahkeluar'];
								$harga_satuan = $_POST['harga_satuan'];
								$total_laba_kotor = 0;

								// Hitung total laba kotor
								foreach ($jumlah as $index => $jml) {
									$pecah_barang = explode("|", $barang[$index]);
									$kode_barang = $pecah_barang[0];
									$gudang = firstBarang($kode_barang);
									$laba_kotor = ($jml * $harga_satuan[$index]) - ($jml * $gudang['harga_rata']);
									$total_laba_kotor += $laba_kotor;
								}

								if ($id_marketing != '0') {
									$fee_marketing = ($total_laba_kotor * 30) / 100;
									$sql = $koneksi->query("insert into barang_keluar (id_transaksi, tanggal, nama_konsumen, no_hp, total_harga_barang, jatuh_tempo, id_marketing, fee_marketing) values('$id_transaksi','$tanggal','$nama_konsumen', '$no_hp', '$total_harga_barang', '$jatuh_tempo', '$id_marketing', '$fee_marketing')");
								} else {
									$sql = $koneksi->query("insert into barang_keluar (id_transaksi, tanggal, nama_konsumen, no_hp, total_harga_barang, jatuh_tempo) values('$id_transaksi','$tanggal','$nama_konsumen', '$no_hp', '$total_harga_barang', '$jatuh_tempo')");
								}

								if ($sql) {
									$id_barang_keluar = $koneksi->insert_id; // Ambil ID yang baru saja dimasukkan

									$barang = $_POST['barang']; // Array barang
									$jumlah = $_POST['jumlahkeluar'];
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


											// Simpan ke tabel barang_keluar_items dengan id_barang_keluar
											$sql2 = $koneksi->query("INSERT INTO barang_keluar_items 
											(id_barang_keluar, kode_barang, nama_barang, jumlah, satuan, harga_satuan, total_harga) 
											VALUES ('$id_barang_keluar', '$kode_barang', '$nama_barang', '$jumlahData', '$satuan[$i]', '$hargaSatuanData', '$totalHargaData')");

											$sql3 = $koneksi->query("INSERT INTO notifikasi (id_barang_keluar, jatuh_tempo) VALUES ('$id_barang_keluar', '$jatuh_tempo')");

											$gudang = firstBarang($kode_barang);
											$newjumlah = $_POST['total_stok'];
											$total_nilai_stok = round($gudang['harga_rata'] * $newjumlah[$i]);
											$sql4 = $koneksi->query("UPDATE gudang SET jumlah = '$newjumlah[$i]', total_nilai_stok = '$total_nilai_stok' WHERE kode_barang = '$kode_barang'");
										}
									}

									if ($sql2 && $sql3 && $sql4) {
								?>
  									<script type="text/javascript">
  										let id = '<?= $id_transaksi ?>'

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
  											window.location.href = "?page=barangkeluar&aksi=invoice&id_transaksi=" + id;
  										}, 1000);
  									</script>
  							<?php
									}
								}
								?>
  					<?php
							}
						}


						?>