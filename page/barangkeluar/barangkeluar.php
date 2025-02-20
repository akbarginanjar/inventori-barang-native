<?php
if ($_SESSION['admin']) {
  $user = $_SESSION['admin'];
}
$sql = $koneksi->query("select * from users where id='$user'");
$dataUser = $sql->fetch_assoc();

$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($dataUser['level'] != 'marketing') {
  $query = $koneksi->query("SELECT SUM(total_harga) AS total FROM barang_keluar");
} else {
  $query = $koneksi->query("SELECT SUM(fee_marketing) AS total FROM barang_keluar WHERE id_marketing='$dataUser[id]'");
}
$row = $query->fetch_assoc();
$total = $row['total'];
?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content: space-between;">
      <h6 class="m-0 font-weight-bold text-primary">

        <?php
        if ($dataUser['level'] == 'marketing' || $current_page == 'feemarketing') {
          echo 'Fee Marketing';
        } else {
          echo 'Barang Keluar';
        }
        ?></h6>
      <?php
              if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
              ?>
              <?php 
              if($current_page != 'feemarketing') {
                ?>
        <a href="?page=barangkeluar&aksi=tambahbarangkeluar" class="btn btn-primary">Tambah Barang Keluar</a>
      <?php } ?>
      <?php } ?>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Id Transaksi</th>
              <th>Tanggal Keluar</th>
              <th>Nama Barang</th>
              <th>Nama Konsumen</th>
              <?php
              if ($dataUser['level'] == 'marketing' || $current_page == 'feemarketing') {
              ?>
                <th>Fee Marketing</th>
              <?php } ?>
              <?php
              if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
              ?>
              <?php 
              if($current_page != 'feemarketing') {
                ?>
                <th></th>
                <?php } ?>
                <?php } else { ?>
                  <th></th>
                  <?php } ?>
                  
            </tr>
          </thead>


          <tbody>
            <?php

            $no = 1;
            if ($dataUser['level'] != 'marketing') {
              $sql = $koneksi->query("select * from barang_keluar");
            } else {
              $sql = $koneksi->query("select * from barang_keluar where id_marketing='$dataUser[id]'");
            }
            while ($data = $sql->fetch_assoc()) {

            ?>

              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['id_transaksi'] ?></td>
                <td><?php echo $data['tanggal'] ?></td>
                <td><?php echo $data['nama_barang'] ?>, Daging, Kepala</td>
                <td><?php echo $data['nama_konsumen'] ?></td>
                <?php
                if ($dataUser['level'] == 'marketing' || $current_page == 'feemarketing') {
                ?>
                  <td><?php echo number_format($data['fee_marketing'], 0, '', '.') ?></td>
                <?php } ?>
                <?php
              if ($dataUser['level'] != 'marketing' && $dataUser['level'] != 'keuangan') {
              ?>
              <?php 
              if($current_page != 'feemarketing') {
                ?>
                  <td>
                  <a class="btn btn-warning" style="color:black;" data-toggle="modal" data-target="#detailBarang">
                  Detail Barang
                </a>
                <a class="btn btn-success" style="color:black;" href="">
                  Invoice
                </a>
                    <a href="javascript:void(0);"
                      onclick="confirmDelete('<?php echo $data['id_transaksi']; ?>')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                      
                  </td>
                <?php } ?>
                  
                <?php } else { ?>
                  <td>
                  <a class="btn btn-warning" style="color:black;" data-toggle="modal" data-target="#detailBarang">
                  Detail Barang
                </a>
                  <a class="btn btn-success" style="color:black;" href="">
                  Invoice
                </a>
                  </td>
                  <?php } ?>
              </tr>
            <?php } ?>

          </tbody>
        </table>

        </tbody>
        </table>
        <h4 class="text-right mt-3 text-primary">Total : Rp. <?php echo number_format($total, 0, '', '.') ?></h4>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="detailBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Barang</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm">
              <div class="mb-3">
                <div class="mb-0 text-xs">ID Transaksi</div>
                <h6 class="mb-0" style="color: black;"> INV03249302</h6>
              </div>
            </div>
            <div class="col-sm">
              <div class="mb-3">
                <div class="mb-0 text-xs">Tanggal Keluar</div>
                <h6 class="mb-0" style="color: black;"> 23-02-2023</h6>
              </div>
            </div>
            <div class="col-sm">
              <div class="mb-3">
                <div class="mb-0 text-xs">Nama Konsumen</div>
                <h6 class="mb-0" style="color: black;">Akbar Ginanjar</h6>
              </div>
            </div>
            <div class="col-sm">
              <div class="mb-3">
                <div class="mb-0 text-xs">No HP</div>
                <h6 class="mb-0" style="color: black;">08934834788</h6>
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
              <tr>
                <td>BRG-23912329</td>
                <td>Lidah</td>
                <td>20</td>
                <td>Kg</td>
                <td>200.000</td>
                <td>400.000</td>
              </tr>
              <tr>
                <td>BRG-23912329</td>
                <td>Lidah</td>
                <td>20</td>
                <td>Kg</td>
                <td>200.000</td>
                <td>400.000</td>
              </tr>
              <tr>
                <td>BRG-23912329</td>
                <td>Lidah</td>
                <td>20</td>
                <td>Kg</td>
                <td>200.000</td>
                <td>400.000</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
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
        window.location.href = "?page=barangkeluar&aksi=hapusbarangkeluar&id_transaksi=" + id;
      }
    });
  }
</script>