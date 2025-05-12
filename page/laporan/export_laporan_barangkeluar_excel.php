<?php
if (isset($_POST['submit'])) { ?>

	<?php

	$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");

	header("Content-type: application/vnd-ms-excel");

	$bln = $_POST['bln'];
	$thn = $_POST['thn'];

	?>

	<?php
	if ($bln == 'all') {
		header("Content-Disposition: attachment; filename=Laporan_Barang_Keluar (01-01-" . $thn . " - 31-12-" . $thn . ").xls");
	?>

		<body>
			<center>
				<h2>Laporan Barang Keluar Bulan 1 January <?= $thn ?> - 31 December <?= $thn ?></h2>
			</center>
			<table border="1">
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Keluar</th>
					<th>Nama Barang</th>
					<th>Nama Konsumen</th>
					<th>Total Harga</th>

				</tr>


				<?php

				$no = 1;
				$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_keluar where tanggal BETWEEN '$thn-01-01' AND '$thn-12-31'");

				$row = $query->fetch_assoc();
				$total = $row['total'];

				$sql = $koneksi->query("
				SELECT bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang,
						GROUP_CONCAT(bki.nama_barang ORDER BY bki.id SEPARATOR ', ') AS nama_barang
				FROM barang_keluar bk
				LEFT JOIN barang_keluar_items bki ON bk.id = bki.id_barang_keluar
				WHERE bk.tanggal BETWEEN '$thn-01-01' AND '$thn-12-31'
				GROUP BY bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang
				");
				while ($data = $sql->fetch_assoc()) {

				?>

					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['nama_konsumen'] ?></td>
						<td><?php echo $data['total_harga_barang'] ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="5" style="text-align: center;">Total</td>
					<td><?php echo $total ?></td>
				</tr>
			</table>
		</body>

	<?php } else {
		header("Content-Disposition: attachment; filename=Laporan_Barang_Keluar (Bulan " . $bln . " Tahun " . $thn . ").xls");
	?>

		<body>
			<center>
				<h2>Laporan Barang Keluar Bulan <?php echo $bln; ?> Tahun <?php echo $thn; ?></h2>
			</center>
			<table border="1">
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Keluar</th>
					<th>Nama Barang</th>
					<th>Nama Konsumen</th>
					<th>Total Harga</th>

				</tr>


				<?php

				$no = 1;
				$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_keluar where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'");

				$row = $query->fetch_assoc();
				$total = $row['total'];

				$sql = $koneksi->query("
					SELECT bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang,
							GROUP_CONCAT(bki.nama_barang ORDER BY bki.id SEPARATOR ', ') AS nama_barang
					FROM barang_keluar bk
					LEFT JOIN barang_keluar_items bki ON bk.id = bki.id_barang_keluar
					where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'
					GROUP BY bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang
					");
				while ($data = $sql->fetch_assoc()) {

				?>

					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['nama_konsumen'] ?></td>
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

$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");


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
					<th>Tanggal Keluar</th>
					<th>Nama Barang</th>
					<th>Nama Konsumen</th>
					<th>Total Harga</th>

				</tr>
			</thead>
			<tbody>


				<?php
				$no = 1;
				$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_keluar where tanggal BETWEEN '$thn-01-01' AND '$thn-12-31'");

				$row = $query->fetch_assoc();
				$total = $row['total'];

				$sql = $koneksi->query("
				SELECT bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang,
						GROUP_CONCAT(bki.nama_barang ORDER BY bki.id SEPARATOR ', ') AS nama_barang
				FROM barang_keluar bk
				LEFT JOIN barang_keluar_items bki ON bk.id = bki.id_barang_keluar
				WHERE bk.tanggal BETWEEN '$thn-01-01' AND '$thn-12-31'
				GROUP BY bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang
				");
				while ($data = $sql->fetch_assoc()) {
				?>


					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['nama_konsumen'] ?></td>
						<td><?php echo number_format($data['total_harga_barang'], 0, '', '.') ?></td>

					</tr>
				<?php
				}
				?>

			</tbody>
		</table>
		<h4 class="text-right mt-3 text-primary">Total : Rp. <?php echo number_format($total, 0, '', '.') ?></h4>

	</div>


<?php
} else { ?>
	<div class="table-responsive">

		<table class="display table table-bordered" id="transaksi">

			<thead>
				<tr>
					<th>No</th>
					<th>Id Transaksi</th>
					<th>Tanggal Keluar</th>
					<th>Nama Barang</th>
					<th>Nama Konsumen</th>
					<th>Total Harga</th>

				</tr>
			</thead>
			<tbody>


				<?php
				$no = 1;
				$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_keluar where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'");

				$row = $query->fetch_assoc();
				$total = $row['total'];

				$sql = $koneksi->query("
				SELECT bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang,
						GROUP_CONCAT(bki.nama_barang ORDER BY bki.id SEPARATOR ', ') AS nama_barang
				FROM barang_keluar bk
				LEFT JOIN barang_keluar_items bki ON bk.id = bki.id_barang_keluar
				where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'
				GROUP BY bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang
				");
				while ($data = $sql->fetch_assoc()) {

				?>

					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $data['id_transaksi'] ?></td>
						<td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
						<td><?php echo $data['nama_barang'] ?></td>
						<td><?php echo $data['nama_konsumen'] ?></td>
						<td><?php echo number_format($data['total_harga_barang'], 0, '', '.') ?></td>

					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<h4 class="text-right mt-3 text-primary">Total : Rp. <?php echo number_format($total, 0, '', '.') ?></h4>

	</div>

<?php

}

?>