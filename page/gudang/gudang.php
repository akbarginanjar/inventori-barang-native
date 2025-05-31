<?php
if ($_SESSION['admin']) {
  $user = $_SESSION['admin'];
  
}
$sql = $koneksi->query("select * from users where id='$user'");
$dataUser = $sql->fetch_assoc();

$query = $koneksi->query("SELECT SUM(total_nilai_stok) AS total_stok FROM gudang");

$row = $query->fetch_assoc();
$total_stok = $row['total_stok'];
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content: space-between;">
      <h6 class="m-0 font-weight-bold text-primary">Stok Barang</h6>
      <?php
      if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
      ?>
        <a href="?page=gudang&aksi=tambahgudang" class="btn btn-primary">Tambah Data Barang</a>
      <?php } ?>
    </div>
    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <!-- <th>Jenis Barang</th> -->

              <th>Jumlah Barang</th>
              <th>Satuan</th>
              <th>Harga Rata-Rata</th>
              <th>Total Nilai Stok</th>
              <?php
              if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
              ?>
                <th>Pengaturan</th>
              <?php } ?>

            </tr>
          </thead>


          <tbody>
            <?php

            $no = 1;
            $sql = $koneksi->query("select * from gudang ORDER BY id DESC");
            while ($data = $sql->fetch_assoc()) {

            ?>

              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['kode_barang'] ?></td>
                <td><?php echo $data['nama_barang'] ?></td>
                <!-- <td><?php echo $data['jenis_barang'] ?></td> -->

                <td><?php echo $data['jumlah'] ?></td>
                <td><?php echo $data['satuan'] ?></td>
                <td><?php echo number_format($data['harga_rata'], 0, '', '.') ?></td>
                <td><?php echo number_format($data['total_nilai_stok'], 0, '', '.') ?></td>


                <?php
                if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
                ?>
                  <td class="d-flex">

                    <a href="?page=gudang&aksi=ubahgudang&kode_barang=<?php echo $data['kode_barang'] ?>" class="btn btn-success mr-1">Ubah</a>
                    <a href="javascript:void(0);"
                      onclick="confirmDelete('<?php echo $data['kode_barang']; ?>')" class="btn btn-danger">Hapus</a>
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>

          </tbody>
        </table>

        </tbody>
        </table>
        <h4 class="text-right mt-3 text-primary">Total : Rp. <?= number_format($total_stok, 0, '', '.') ?></h4>
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
        window.location.href = "?page=gudang&aksi=hapusgudang&kode_barang=" + id;
      }
    });
  }
</script>