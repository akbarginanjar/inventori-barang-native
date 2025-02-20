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
    <h2 class="text-primary">Laba</h2>
    <div class="card">
        <div class="card-body">
        <form action="" method="post">
              <div class="row form-group">
                <div class="col-md-3">
                  <select class="form-control " name="bln">
                    <option value="1" selected="">January</option>
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
                <div class="col-md-2">
                  <?php
                  $now = date('Y');
                  echo "<select name='thn' class='form-control'>";
                  for ($a = 2018; $a <= $now; $a++) {
                    echo "<option value='$a'>$a</option>";
                  }
                  echo "</select>";
                  ?>
                </div>
                <input type="submit" class="btn btn-primary" name="submit" value="Tampilkan">
                <input type="submit" class="btn btn-danger ml-2" name="submit" value="Print PDF">
              </div>
            </form>
            <br>
            <table class="table table-bordered" style="color: black;">
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
    </div>
</div>
</body>