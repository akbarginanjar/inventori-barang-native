<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();

$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");

if (empty($_SESSION['admin'])) {

    header("location:/login.php");
}

$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';

$id_transaksi = $_GET['id_transaksi'];

$query = "
SELECT bk.id_transaksi, bk.tanggal, bk.nama_konsumen, bk.no_hp, bk.alamat, bk.total_harga_barang,
       bki.kode_barang, bki.nama_barang, bki.jumlah, bki.satuan,
       bki.harga_satuan, total_harga
FROM barang_keluar bk
JOIN barang_keluar_items bki ON bk.id = bki.id_barang_keluar
WHERE bk.id_transaksi = '$id_transaksi' ";

$result = $koneksi->query($query);

// Ambil informasi umum
$detail = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-header {
            font-weight: bold;
        }

        .invoice-title {
            font-size: 40px;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            font-size: 25px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature img {
            width: 150px;
        }

        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }

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
                left: -20px;
                top: 0;
                width: 100%;
            }

            /* Sembunyikan tombol print di mode cetak */
            .btn {
                display: none;
            }

            .row {
                display: flex;
                flex-wrap: nowrap;
                justify-content: space-between;
            }

            .col-md-6 {
                width: 48% !important;
                float: left;
            }

            .text-end {
                text-align: right !important;
            }
        }
    </style>
</head>

<body>
    <div class="" >
        <div class="">
            <?php 
                if ($current_page == 'barangkeluar') {
                    ?>
                    <a href="?page=barangkeluar" class="btn btn-outline-primary btn-sm mb-2">Kembali</a>
                    <?php
                } else {
                    ?>
                    <a href="?page=feemarketing" class="btn btn-outline-primary btn-sm mb-2">Kembali</a>
                    <?php
                }
            ?>
            
            <div class="card">
                <div class="card-body">
                    <div id="printArea">
                        <br><br>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <!-- <h1 class="invoice-title">INVOICE</h1> -->
                                <img src="img/logo-mms.png" style="width: 100px; border-radius: 15px;" class="mb-2" alt="">
                            </div>
                            <div class="col-md-6 text-end">
                                <h4>CHIPS SUPPLIER</h4>
                                <!-- <p>Inventaris Barang</p> -->
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div><b> Kepada : </b> <?= $detail['nama_konsumen'] ?></div>
                                <div><b> No HP : </b> <?= $detail['no_hp'] ?> </div>
                                <div><b> Alamat : </b> <?= $detail['alamat'] ?? '-' ?> </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <b> Tanggal Faktur : </b><?= date("d-m-Y", strtotime($detail['tanggal'])); ?> <br>
                                <b> Pembayaran : </b>25-02-2024 <br>
                                <b> No Faktur : </b><?= $detail['id_transaksi'] ?> <br>
                            </div>
                        </div>
                        <table class="table table-bordered mt-4">
                            <thead class="table-light">
                                <tr>
                                    <th>KODE BARANG</th>
                                    <th>NAMA BARANG</th>
                                    <th>JUMLAH</th>
                                    <th>SATUAN</th>
                                    <th>HARGA SATUAN</th>
                                    <th>TOTAL HARGA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result->data_seek(0); // Kembalikan pointer ke awal data
                                while ($row = $result->fetch_assoc()):
                                ?>
                                    <tr>
                                        <td><?= $row['kode_barang'] ?></td>
                                        <td><?= $row['nama_barang'] ?></td>
                                        <td><?= $row['jumlah'] ?></td>
                                        <td><?= $row['satuan'] ?></td>
                                        <td><?= number_format($row['harga_satuan'], 0, '', '.') ?></td>
                                        <td><?= number_format($row['total_harga'], 0, '', '.') ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <div>
                            <p class="total float-right">TOTAL : RP <?= number_format($detail['total_harga_barang'], 0, '', '.') ?></p>

                        </div>
                    </div>
                </div>
            </div>

            <button onclick="window.print()" class="btn btn-info col-3 mt-3">Print</button>
        </div>
        <br><br>
    </div>
</body>

</html>