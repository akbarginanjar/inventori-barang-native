<?php
// Total Pembelian
$query = $koneksi->query("SELECT SUM(total_harga) AS total_beli FROM barang_masuk");
$row = $query->fetch_assoc();
$total_beli = $row['total_beli'];

// Total Penjualan
$query = $koneksi->query("SELECT SUM(total_harga) AS total_jual FROM barang_keluar");
$row = $query->fetch_assoc();
$total_jual = $row['total_jual'];

// Total Stok Gudang
$query = $koneksi->query("SELECT SUM(total_nilai_stok) AS total_stok FROM gudang");
$row = $query->fetch_assoc();
$total_stok = $row['total_stok'];

$laba = $total_jual - ($total_beli - $total_stok);
?>

<div class="container mt-5">
    <h2 class="text-center">Laba</h2>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Total Penjualan</th>
                <td>Rp. <?= number_format($total_jual, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>Total Pembelian</th>
                <td>Rp. <?= number_format($total_beli, 0, '', '.') ?></td>
            </tr>
            <tr>
                <th>Total Nilai Stok Gudang</th>
                <td>Rp. <?= number_format($total_stok, 0, '', '.') ?> </td>
            </tr>
            <tr class="table-success">
                <th>Laba</th>
                <td>Rp. <?= number_format($laba, 0, '', '.') ?></td>
            </tr>
        </tbody>
    </table>
</div>
</body>