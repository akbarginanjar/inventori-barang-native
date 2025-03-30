 <?php

	$koneksi = new mysqli("127.0.0.1", "root", "", "pengadaan_barang");



	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Stok_Gudang(" . date('d-m-Y') . ").xls");

	?>

 <h2>Laporan Stok Gudang</h2>

 <table border="1">
 	<tr>
 		<th>No</th>
 		<th>Kode Barang</th>
 		<th>Nama Barang</th>
 		<th>Jenis Barang</th>

 		<th>Jumlah Barang</th>
 		<th>Satuan</th>
 		<th>Harga Rata-Rata</th>
 		<th>Total Nilai Stok</th>


 	</tr>

 	<?php

		$no = 1;
		$sql = $koneksi->query("select * from gudang");
		while ($data = $sql->fetch_assoc()) {

		?>

 		<tr>
 			<td><?php echo $no++; ?></td>
 			<td><?php echo $data['kode_barang'] ?></td>
 			<td><?php echo $data['nama_barang'] ?></td>
 			<td><?php echo $data['jenis_barang'] ?></td>

 			<td><?php echo $data['jumlah'] ?></td>
 			<td><?php echo $data['satuan'] ?></td>
 			<td><?php echo number_format($data['harga_rata'], 0, '', '.') ?></td>
 			<td><?php echo number_format($data['total_nilai_stok'], 0, '', '.') ?></td>





 		</tr>
 	<?php } ?>

 </table>