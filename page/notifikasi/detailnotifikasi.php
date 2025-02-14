<?php
$id = $_GET['id'];
$query = $koneksi->query("select notifikasi.id, notifikasi.jatuh_tempo, barang_keluar.id_transaksi, barang_keluar.kode_barang, barang_keluar.nama_barang, barang_keluar.satuan, barang_keluar.tanggal, barang_keluar.jumlah, barang_keluar.harga_satuan, barang_keluar.total_harga, barang_keluar.nama_konsumen, barang_keluar.no_hp from notifikasi inner join barang_keluar on notifikasi.id_barang_keluar = barang_keluar.id where notifikasi.id=$id");
$data = $query->fetch_assoc();
?>

<div class="container mt-4">

    <a href="?page=notifikasi" class="btn btn-sm btn-primary mb-3"><i class="fa fa-arrow-left mr-2"></i> Kembali</a>

    <!-- Notifikasi Sukses -->
    <div class="card mb-3 col-9" style="border-radius: 15px;">
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
                        <div class="mb-0 text-xs">Kode Barang</div>
                        <h6 class="mb-0" style="color: black;"> <?= $data['kode_barang'] ?> </h6>
                    </div>
                    <div class="mb-3">
                        <div class="mb-0 text-xs">Nama Barang</div>
                        <h6 class="mb-0" style="color: black;"> <?= $data['nama_barang'] ?> </h6>
                    </div>
                    <div class="mb-3">
                        <div class="mb-0 text-xs">Satuan</div>
                        <h6 class="mb-0" style="color: black;"> <?= $data['satuan'] ?> </h6>
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
                        <div class="mb-0 text-xs">Jumlah</div>
                        <h6 class="mb-0" style="color: black;"> <?= $data['jumlah'] ?> </h6>
                    </div>
                    <div class="mb-3">
                        <div class="mb-0 text-xs">Harga Satuan</div>
                        <h6 class="mb-0" style="color: black;"> <?= number_format($data['harga_satuan'], 0, '', '.') ?> </h6>
                    </div>
                    <div class="mb-3">
                        <div class="mb-0 text-xs">Total Harga</div>
                        <h6 class="mb-0" style="color: black;"> <?= number_format($data['total_harga'], 0, '', '.') ?> </h6>
                    </div>
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
        </div>
    </div>

</div>