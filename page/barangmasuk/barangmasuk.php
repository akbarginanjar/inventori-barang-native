<?php
$query = $koneksi->query("SELECT SUM(total_harga) AS total FROM barang_masuk");

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
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Pengirim</th>
              <th>Jumlah Masuk</th>
              <th>Satuan Barang</th>
              <th>Harga Satuan</th>
              <th>Total Harga</th>
              <?php
              if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
              ?>
              <th>Pengaturan</th>
<?php }?>
            </tr>
          </thead>


          <tbody>
            <?php

            $no = 1;
            $sql = $koneksi->query("select * from barang_masuk");
            while ($data = $sql->fetch_assoc()) {

            ?>

              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['id_transaksi'] ?></td>
                <td><?php echo $data['tanggal'] ?></td>
                <td><?php echo $data['kode_barang'] ?></td>
                <td><?php echo $data['nama_barang'] ?></td>

                <td><?php echo $data['pengirim'] ?></td>


                <td><?php echo $data['jumlah'] ?></td>
                <td><?php echo $data['satuan'] ?></td>
                <td><?php echo number_format($data['harga_satuan'], 0, '', '.') ?></td>
                <td><?php echo number_format($data['total_harga'], 0, '', '.') ?></td>

                <?php
              if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
              ?>
                <td>

                  <a href="javascript:void(0);"
                    onclick="confirmDelete('<?php echo $data['id_transaksi']; ?>')" class="btn btn-danger">Hapus</a>
                </td>
                <?php } ?>
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