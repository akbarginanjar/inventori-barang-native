<?php
$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total FROM barang_keluar");
$row = $query->fetch_assoc();
$total = $row['total'];
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Barang Keluar</h6>
    </div>
    <div class="card-body">


      <table>
        <tr>
          <td>
            LAPORAN PERBULAN DAN PERTAHUN
          </td>
        </tr>
        <tr>
          <td width="50%">
            <form action="page/laporan/export_laporan_barangkeluar_excel.php" method="post">
              <div class="row form-group">

                <div class="col-md-5">
                  <select class="form-control " name="bln">

                    <option value="all" selected="">ALL (Juni - Mei) </option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <?php
                  $now = date('Y');
                  echo "<select name='thn' class='form-control'>";
                  for ($a = 2022; $a <= $now; $a++) {
                    echo "<option value='$a'>$a</option>";
                  }
                  echo "</select>";
                  ?>
                </div>

                <input type="submit" class="" name="submit" value="Export to Excel">
              </div>
            </form>


            <form id="Myform2">
              <div class="row form-group">

                <div class="col-md-5">
                  <select class="form-control " name="bln">

                    <option value="all" selected="">ALL (Juni - Mei) </option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <?php
                  $now = date('Y');
                  echo "<select name='thn' class='form-control'>";
                  for ($a = 2022; $a <= $now; $a++) {
                    echo "<option value='$a'>$a</option>";
                  }
                  echo "</select>";
                  ?>
                </div>


                <input type="submit" class="" name="submit2" value="Tampilkan">
              </div>
            </form>
          </td>


      </table>

      <div class="tampung2">


        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Id Transaksi</th>
                <th>Tanggal Keluar</th>
                <th>Nama Barang</th>
                <th>Nama Konsumen</th>
                <th>Total Harga</th>

              </tr>
            </thead>


            <tbody>
              <?php

              $no = 1;
              $sql = $koneksi->query("
              SELECT bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang,
                    GROUP_CONCAT(bki.nama_barang ORDER BY bki.id SEPARATOR ', ') AS nama_barang
              FROM barang_keluar bk
              LEFT JOIN barang_keluar_items bki ON bk.id = bki.id_barang_keluar
              GROUP BY bk.id, bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.total_harga_barang
              ");
              while ($data = $sql->fetch_assoc()) {

              ?>

                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $data['id_transaksi'] ?></td>
                  <td><?php echo date("d-m-Y", strtotime($data["tanggal"])) ?></td>
                  <td><?php echo $data['nama_barang'] ?></td>
                  <td><?php echo $data['nama_konsumen'] ?></td>
                  <td><?php echo number_format($data['total_harga_barang'], 0, '', '.') ?></td>
                </tr>
              <?php } ?>

            </tbody>
          </table>
          <h4 class="text-right mt-3 text-primary">Total : Rp. <?php echo number_format($total, 0, '', '.') ?></h4>

          </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>