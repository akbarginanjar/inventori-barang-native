<?php
$query = $koneksi->query("SELECT SUM(total_nilai_stok) AS total_stok FROM gudang");

$row = $query->fetch_assoc();
$total_stok = $row['total_stok'];
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display: flex; justify-content: space-between;">
      <h6 class="m-0 font-weight-bold text-primary">Stok Gudang</h6>
      <a href="page/laporan/export_laporan_gudang_excel.php" class="btn btn-primary" style="margin-top:8 px"><i class="fa fa-print"></i>ExportToExcel</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Jumlah Barang</th>
              <th>Satuan</th>
              <th>Harga Rata-Rata</th>
              <th>Total Nilai Stok</th>

            </tr>
          </thead>


          <tbody>
            <?php

            $no = 1;
            $sql = $koneksi->query("select * from gudang");
            while ($data = $sql->fetch_assoc()) {

            ?>

              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['kode_barang'] ?></td>
                <td><?php echo $data['nama_barang'] ?></td>
                <td><?php echo $data['jumlah'] ?></td>
                <td><?php echo $data['satuan'] ?></td>
                <td><?php echo number_format($data['harga_rata'], 0, '', '.') ?></td>
                <td><?php echo number_format($data['total_nilai_stok'], 0, '', '.') ?></td>



              </tr>
            <?php } ?>

          </tbody>
        </table>
        <h4 class="text-right mt-3 text-primary">Total : Rp. <?php echo number_format($total_stok, 0, '', '.') ?></h4>

        </tbody>
        </table>
      </div>
    </div>
  </div>

</div>