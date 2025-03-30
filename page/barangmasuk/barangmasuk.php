<?php
$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_masuk");

$row = $query->fetch_assoc();
$total = $row['total'];

if ($_SESSION['admin']) {
  $user = $_SESSION['admin'];
}
$sql = $koneksi->query("select * from users where id='$user'");
$dataUser = $sql->fetch_assoc();
?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content: space-between;">
      <h6 class="m-0 font-weight-bold text-primary">Barang Masuk</h6>
      <?php
      if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
      ?>
        <a href="?page=barangmasuk&aksi=tambahbarangmasuk" class="btn btn-primary">Tambah Barang Masuk</a>
      <?php } ?>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Id Transaksi</th>
              <th>Tanggal Masuk</th>
              <th>Nama Barang</th>
              <th>Pengirim</th>
              <th>Total Harga barang</th>
              <?php
              if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
              ?>
                <th></th>
              <?php } else { ?>
                <th></th>
              <?php } ?>
            </tr>
          </thead>


          <tbody>
            <?php

            $no = 1;
            $sql = $koneksi->query("
              SELECT bm.id, bm.id_transaksi, bm.tanggal, bm.pengirim, bm.total_harga_barang,
                    GROUP_CONCAT(bmi.nama_barang ORDER BY bmi.id SEPARATOR ', ') AS nama_barang
              FROM barang_masuk bm
              LEFT JOIN barang_masuk_items bmi ON bm.id = bmi.id_barang_masuk
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
                <td>
                  <a class="btn btn-warning" style="color:black;" data-toggle="modal" data-target="#detailBarang<?= $data['id'] ?>">
                    Detail Barang
                  </a>
                  <div class="modal fade" id="detailBarang<?= $data['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Detail Barang</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <?php
                        $query = "
                        SELECT bm.id_transaksi, bm.tanggal, bm.pengirim,
                               bmi.kode_barang, bmi.nama_barang, bmi.jumlah, bmi.satuan,
                               bmi.harga_satuan, total_harga
                        FROM barang_masuk bm
                        JOIN barang_masuk_items bmi ON bm.id = bmi.id_barang_masuk
                        WHERE bm.id = '$data[id]' ";

                        $result = $koneksi->query($query);

                        // Ambil informasi umum
                        $detail = $result->fetch_assoc();
                        ?>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-sm">
                              <div class="mb-3">
                                <div class="mb-0 text-xs">ID Transaksi</div>
                                <h6 class="mb-0" style="color: black;"> <?= $detail['id_transaksi'] ?></h6>
                              </div>
                            </div>
                            <div class="col-sm">
                              <div class="mb-3">
                                <div class="mb-0 text-xs">Tanggal Masuk</div>
                                <h6 class="mb-0" style="color: black;"> <?= date("d-m-Y", strtotime($detail['tanggal'])); ?> </h6>
                              </div>
                            </div>
                            <div class="col-sm">
                              <div class="mb-3">
                                <div class="mb-0 text-xs">Pengirim</div>
                                <h6 class="mb-0" style="color: black;"><?= $detail['pengirim'] ?></h6>
                              </div>
                            </div>
                          </div>
                          <table class="table table-bordered" style="color: black;">
                            <thead style="background: whitesmoke;">
                              <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Masuk</th>
                                <th>Satuan Barang</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $result->data_seek(0); // Kembalikan pointer ke awal data
                              while ($row = $result->fetch_assoc()):
                              ?>
                                <tr>
                                  <td><?= $row['kode_barang']; ?></td>
                                  <td><?= $row['nama_barang']; ?></td>
                                  <td><?= $row['jumlah']; ?></td>
                                  <td><?= $row['satuan']; ?></td>
                                  <td><?= number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                                  <td><?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                </tr>
                              <?php endwhile; ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
                  ?>
                    <!-- <a href="javascript:void(0);"
                      onclick="confirmDelete('<?php echo $data['id_transaksi']; ?>')" class="btn btn-danger"><i class="fa fa-trash"></i></a> -->

                  <?php } ?>
                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>

        </tbody>
        </table>
        <h4 class="text-right mt-3 text-primary">Total : <?php echo number_format($total, 0, '', '.') ?></h4>
      </div>
    </div>
  </div>

</div>



<script>
  function confirmDelete(id) {
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Data yang dihapus tidak bisa dikembalikan!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "?page=barangmasuk&aksi=hapusbarangmasuk&id_transaksi=" + id;
      }
    });
  }
</script>