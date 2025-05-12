<?php
$id = $_GET['id'];

// $query = $koneksi->query("select notifikasi.id, notifikasi.jatuh_tempo, barang_keluar.id_transaksi, barang_keluar.kode_barang, barang_keluar.nama_barang, barang_keluar.satuan, barang_keluar.tanggal, barang_keluar.jumlah, barang_keluar.harga_satuan, barang_keluar.total_harga, barang_keluar.nama_konsumen, barang_keluar.no_hp from notifikasi inner join barang_keluar on notifikasi.id_barang_keluar = barang_keluar.id where notifikasi.id=$id");
$query = $koneksi->query("
SELECT notifikasi.id, notifikasi.jatuh_tempo, 
       GROUP_CONCAT(barang_keluar_items.nama_barang SEPARATOR ', ') AS nama_barang, 
       barang_keluar.nama_konsumen, barang_keluar.no_hp, barang_keluar.id_transaksi, barang_keluar.tanggal, barang_keluar.total_harga_barang
FROM notifikasi
INNER JOIN barang_keluar ON notifikasi.id_barang_keluar = barang_keluar.id
INNER JOIN barang_keluar_items ON barang_keluar.id = barang_keluar_items.id_barang_keluar
WHERE notifikasi.id=$id
GROUP BY notifikasi.id 
");
$data = $query->fetch_assoc();
?>

<div class="container mt-4">

    <a href="?page=notifikasi" class="btn btn-sm btn-primary mb-3"><i class="fa fa-arrow-left mr-2"></i> Kembali</a>

    <!-- Notifikasi Sukses -->
    <div class="card " style="border-radius: 15px;">
        <div class="p-3">
            <h5 class="text-primary">Detail Notifikasi</h5>
            <hr>
            <div class="row">
                <div class="col-sm">
                    <div class="mb-3">
                        <div class="mb-0 text-xs">ID Transaksi</div>
                        <h6 class="mb-0" style="color: black;"> <?= $data['id_transaksi'] ?> </h6>
                    </div>
                    <div class="mb-3">
                        <div class="mb-0 text-xs">Tanggal Keluar</div>
                        <h6 class="mb-0" style="color: black;"> <?= date("d-m-Y", strtotime($data['tanggal'])) ?> </h6>
                    </div>
                    <div class="mb-3">
                        <div class="mb-0 text-xs">Jatuh Tempo</div>
                        <h6 class="mb-0" style="color: black;"> <?= date("d-m-Y", strtotime($data['jatuh_tempo'])) ?> </h6>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="mb-3">
                        <div class="mb-0 text-xs">Nama Konsumen</div>
                        <h6 class="mb-0" style="color: black;"> <?= $data['nama_konsumen'] ?> </h6>
                    </div>
                    <div class="mb-3">
                        <div class="mb-0 text-xs">No. HP</div>
                        <h6 class="mb-0" style="color: black;"> <?= $data['no_hp'] ?> </h6>
                    </div>
                </div>
            </div>
            <table class="table table-bordered mt-2">
                <thead style="background: whitesmoke;">
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "
                    SELECT bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.no_hp, bk.total_harga_barang,
                           bki.kode_barang, bki.nama_barang, bki.jumlah, bki.satuan,
                           bki.harga_satuan, total_harga
                    FROM barang_keluar bk
                    JOIN barang_keluar_items bki ON bk.id = bki.id_barang_keluar
                    WHERE bk.id_transaksi = '$data[id_transaksi]' ";

                    $result = $koneksi->query($query);
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $row['kode_barang'] ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td><?= $row['satuan'] ?></td>
                            <td><?= number_format($row['harga_satuan'], 0, '', '.') ?></td>
                            <td><?= number_format($row['total_harga'], 0, '', '.') ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <h5 class="float-right"> <b>TOTAL :</b> Rp.<?= number_format($data['total_harga_barang'], 0, '', '.') ?></h5>
        </div>
    </div>

</div>