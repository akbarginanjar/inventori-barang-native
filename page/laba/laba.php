<?php
$bln = $_GET['bln'];
$thn = $_GET['thn'];
if (!$bln && !$thn) {
  $bln = date('n');
  $thn = date('Y');
}

// Total Pembelian
$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total_beli FROM barang_masuk where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'");
$row = $query->fetch_assoc();
$total_beli = $row['total_beli'];

// Total Penjualan
$query = $koneksi->query("SELECT SUM(total_harga_barang) AS total_jual FROM barang_keluar where MONTH(tanggal) = '$bln' and YEAR(tanggal) = '$thn'");
$row = $query->fetch_assoc();
$total_jual = $row['total_jual'];

// Total Stok Gudang
$query = $koneksi->query("SELECT SUM(total_nilai_stok) AS total_stok FROM gudang");
$row = $query->fetch_assoc();
$total_stok = $row['total_stok'];
$hpp = $total_beli - $total_stok;

// Laba Kotor
$laba_kotor = $total_jual - $hpp;

// Total Gaji
$query = $koneksi->query("SELECT SUM(gaji) AS total_gaji FROM users");
$row = $query->fetch_assoc();
$total_gaji = $row['total_gaji'];

// Total fee marketing
$query = $koneksi->query("SELECT SUM(fee_marketing) AS total_fee 
                          FROM barang_keluar 
                          WHERE id_marketing IS NOT NULL 
                          AND MONTH(tanggal) = '$bln'
                          AND YEAR(tanggal) = '$thn'");
$row = $query->fetch_assoc();
$total_fee = $row['total_fee'];

// Total Cost
$query = $koneksi->query("SELECT SUM(biaya) AS total_cost FROM cost");
$row = $query->fetch_assoc();
$total_cost = $row['total_cost'] + $total_gaji + $total_fee;

// Laba Bersih
$laba_bersih = $laba_kotor - $total_cost;
?>

<style>
  @media print {
    body * {
      visibility: hidden;
      /* Sembunyikan semua elemen */
    }

    #printArea,
    #printArea * {
      visibility: visible;
      /* Tampilkan hanya #printArea */
    }

    #printArea {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }

    /* Sembunyikan tombol print di mode cetak */
    .form-area {
      display: none;
    }
  }
</style>
<div id="printArea" class="container mt-2">
  <h2 class="text-primary">Laba</h2>
  <div class="card">
    <div class="card-body">
      <form class="form-area" action="" method="get">
        <input type="hidden" name="page" value="laba">
        <div class="row form-group">
          <div class="col-md-3">
            <!-- <select class="form-control" name="bln">
              <?php
              $bulanSekarang = date('n'); // Ambil bulan sekarang (1-12)
              $bulan = [
                1 => "January",
                2 => "February",
                3 => "March",
                4 => "April",
                5 => "May",
                6 => "June",
                7 => "July",
                8 => "August",
                9 => "September",
                10 => "October",
                11 => "November",
                12 => "December"
              ];

              foreach ($bulan as $angka => $nama) {
                $selected = ($angka == $bln) ? 'selected' : '';
                echo "<option value='$angka' $selected>$nama</option>";
              }
              ?>
            </select>
          </div>
          <div class="col-md-2">
            <?php
            $now = date('Y');
            echo "<select name='thn' class='form-control'>";
            for ($a = 2022; $a <= $now; $a++) {
              $selected = ($a == $thn) ? 'selected' : '';
              echo "<option value='$a' $selected>$a</option>";
            }
            echo "</select>";
            ?>
          </div>
          <input type="submit" class="btn btn-primary"> -->
          <button class="btn btn-danger mb-2" onclick="window.print()">Print</button>
        </div>
      </form>
      <br>
      <table class="table table-bordered" style="color: black;">
        <tbody>
          <tr>
            <th colspan="2" class="text-center">Penjualan</th>
          </tr>
          <tr>
            <th>Total Penjualan</th>
            <td>Rp. <?= number_format($total_jual, 0, '', '.') ?></td>
          </tr>
          <tr>
            <th colspan="2" class="text-center">HPP</th>
          </tr>
          <tr>
            <th>Total Pembelian</th>
            <td>Rp. <?= number_format($total_beli, 0, '', '.') ?></td>
          </tr>
          <tr>
            <th>Total Nilai Stok Gudang</th>
            <td>Rp. <?= number_format($total_stok, 0, '', '.') ?> </td>
          </tr>
          <tr>
            <th>HPP</th>
            <td>Rp. <?= number_format($hpp, 0, '', '.') ?> </td>
          </tr>
          <tr>
            <th colspan="2" class="text-center">Laba Kotor</th>
          </tr>
          <?php
          $colorlabakotor = $laba_kotor > 0 ? "table-success" : "table-danger";
          ?>
          <tr class="<?= $colorlabakotor ?>">
            <th>Laba Kotor</th>
            <td>Rp. <?= number_format($laba_kotor, 0, '', '.') ?></td>
          </tr>
          <tr>
            <th colspan="2" class="text-center">Cost</th>
          </tr>
          <?php
          $sql = $koneksi->query("select * from cost");
          while ($data = $sql->fetch_assoc()) {
          ?>
            <tr>
              <th><?= $data['nama'] ?></th>
              <td>Rp. <?= number_format($data['biaya'], 0, '', '.') ?></td>
            </tr>
          <?php } ?>
          <tr>
            <th>Gaji Karyawan</th>
            <td>Rp. <?= number_format($total_gaji, 0, '', '.') ?></td>
          </tr>
          <tr>
            <th>Fee Marketing</th>
            <td>Rp. <?= number_format($total_fee, 0, '', '.') ?></td>
          </tr>
          <tr>
            <th>Total Cost</th>
            <td>Rp. <?= number_format($total_cost, 0, '', '.') ?></td>
          </tr>
          <tr>
            <th colspan="2" class="text-center">Laba Bersih</th>
          </tr>
          <?php
          $colorlababersih = $laba_bersih > 0 ? "table-success" : "table-danger";
          ?>
          <tr class="<?= $colorlababersih ?>">
            <th>Laba Bersih</th>
            <td>Rp. <?= number_format($laba_bersih, 0, '', '.') ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>