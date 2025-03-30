<?php
if (isset($_POST['submit'])) { ?>
	<?php

	$koneksi = new mysqli("127.0.0.1", "root", "", "pengadaan_barang");

	header("Content-type: application/vnd-ms-excel");

	$bln = $_POST['bln'];
	$thn = $_POST['thn'];

	?>

	<?php
	if ($bln == 'all') {

		header("Content-Disposition: attachment; filename=Laporan_Barang_Masuk (01-06-" . $thn . " - 31-05-" . $thn + 1 . ").xls");

	?>

		<body>
			<center>
				<h2>Laporan Barang Masuk Bulan 1 Juni <?= $thn ?> - 31 Mei <?= $thn + 1 ?></h2>
			</center>
			<table border="1">
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Masuk</th>
					<th>Nama Barang</th>
					<th>Pengirim</th>
					<th>Total Harga</th>
				</tr>


				<?php

				$no = 1;
				$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_masuk WHERE tanggal BETWEEN '$thn-06-01' AND '" . ($thn + 1) . "-05-31'");
				$row = $query->fetch_assoc();
				$total = $row['total'];

				$sql = $koneksi->query("
					SELECT bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang,
						GROUP_CONCAT(bmi.nama_barang ORDER BY bmi.id SEPARATOR ', ') AS nama_barang
					FROM barang_masuk bm
					LEFT JOIN barang_masuk_items bmi ON bm.id = bmi.id_barang_masuk
					WHERE bm.tanggal BETWEEN '$thn-06-01' AND '" . ($thn + 1) . "-05-31'
					GROUP BY bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang
				");
				while ($data = $sql->fetch_assoc()) {

				?>

					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['pengirim'] ?></td>
						<td><?php echo $data['total_harga_barang'] ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="5" style="text-align: center;">Total</td>
					<td><?php echo $total ?></td>
				</tr>
			</table>
		</body>
	<?php
	} else {
		header("Content-Disposition: attachment; filename=Laporan_Barang_Masuk (Bulan " . $bln . " Tahun " . $thn . ").xls");

	?>

		<body>
			<center>
				<h2>Laporan Barang Masuk Bulan <?php echo $bln; ?> Tahun <?php echo $thn; ?></h2>
			</center>
			<table border="1">
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Masuk</th>
					<th>Nama Barang</th>
					<th>Pengirim</th>
					<th>Total Harga</th>
				</tr>


				<?php

				$no = 1;
				$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_masuk where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'");

				$row = $query->fetch_assoc();
				$total = $row['total'];

				$sql = $koneksi->query("
					SELECT bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang,
							GROUP_CONCAT(bmi.nama_barang ORDER BY bmi.id SEPARATOR ', ') AS nama_barang
					FROM barang_masuk bm
					LEFT JOIN barang_masuk_items bmi ON bm.id = bmi.id_barang_masuk
					where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'
					GROUP BY bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang
				");
				while ($data = $sql->fetch_assoc()) {
				?>
					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['pengirim'] ?></td>
						<td><?php echo $data['total_harga_barang'] ?></td>

					</tr>
				<?php } ?>
				<tr>
					<td colspan="5" style="text-align: center;">Total</td>
					<td><?php echo $total ?></td>
				</tr>
			</table>
		</body>
	<?php } ?>

<?php
}
?>

<?php

$koneksi = new mysqli("127.0.0.1", "root", "", "pengadaan_barang");


$bln = $_POST['bln'];
$thn = $_POST['thn'];
?>

<?php
if ($bln == 'all') {
?>
	<div class="table-responsive">

		<table class="display table table-bordered" id="transaksi">

			<thead>
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Masuk</th>
					<th>Nama Barang</th>
					<th>Pengirim</th>
					<th>Total Harga</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_masuk WHERE tanggal BETWEEN '$thn-06-01' AND '" . ($thn + 1) . "-05-31'");
				$row = $query->fetch_assoc();
				$total = $row['total'];

				$sql = $koneksi->query("
					SELECT bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang,
						GROUP_CONCAT(bmi.nama_barang ORDER BY bmi.id SEPARATOR ', ') AS nama_barang
					FROM barang_masuk bm
					LEFT JOIN barang_masuk_items bmi ON bm.id = bmi.id_barang_masuk
					WHERE bm.tanggal BETWEEN '$thn-06-01' AND '" . ($thn + 1) . "-05-31'
					GROUP BY bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang
				");
				while ($data = $sql->fetch_assoc()) {

				?>

					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['pengirim'] ?></td>
						<td><?php echo number_format($data['total_harga_barang'], 0, '', '.') ?></td>

					</tr>
				<?php
				}
				?>

			</tbody>
		</table>
		<h4 class="text-right mt-3 text-primary">Total : <?php echo number_format($total, 0, '', '.') ?></h4>
	</div>


<?php
} else { ?>
	<div class="table-responsive">

		<table class="display table table-bordered" id="transaksi">

			<thead>
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Masuk</th>
					<th>Nama Barang</th>
					<th>Pengirim</th>
					<th>Total Harga</th>

				</tr>
			</thead>
			<tbody>


				<?php
				$no = 1;
				$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_masuk where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'");

				$row = $query->fetch_assoc();
				$total = $row['total'];

				$sql = $koneksi->query("
              SELECT bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang,
                    GROUP_CONCAT(bmi.nama_barang ORDER BY bmi.id SEPARATOR ', ') AS nama_barang
              FROM barang_masuk bm
              LEFT JOIN barang_masuk_items bmi ON bm.id = bmi.id_barang_masuk
			  where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'
              GROUP BY bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang
          ");
				while ($data = $sql->fetch_assoc()) {

				?>

					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['pengirim'] ?></td>
						<td><?php echo number_format($data['total_harga_barang'], 0, '', '.') ?></td>


					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<h4 class="text-right mt-3 text-primary">Total : <?php echo number_format($total, 0, '', '.') ?></h4>
	</div>

<?php

}

?>