<div class="container mt-4">
    <h4 class="mb-3 text-primary">Notifikasi</h4>

    <!-- Notifikasi Sukses -->
    <?php
    $query = $koneksi->query("select notifikasi.id, notifikasi.jatuh_tempo, barang_keluar.nama_barang, barang_keluar.nama_konsumen from notifikasi inner join barang_keluar on notifikasi.id_barang_keluar = barang_keluar.id");

    while ($data = $query->fetch_assoc()) {
    ?>
        <div class="card mb-2" style="border-radius: 15px;">
            <div class="p-3">
                <div class="row">
                    <div class="col-sm-1">
                        <center>
                            <div class="icon-circle bg-gradient-primary">
                                <i class="fa-solid fa-bell text-white"></i>
                            </div>
                        </center>
                    </div>
                    <div class="col">
                        <div>
                            <h6 class="mb-0 text-primary"><b> <?= $data['nama_konsumen'] ?> </b></h6>
                            <div style="color: black;"><?= $data['nama_barang'] ?></div>
                            <div class="mb-0 mt-3 text-xs">Jatuh Tempo : <?= date("d M Y", strtotime($data['jatuh_tempo'])) ?></div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <a class="btn btn-outline-primary float-right px-3 btn-sm" href="?page=notifikasi&aksi=detail&id=<?= $data['id'] ?>">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>