<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();

$koneksi = new mysqli("127.0.0.1", "root", "", "inventori");

if (empty($_SESSION['admin'])) {

    header("location:/login.php");
  }
  ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
        <div class="container my-4" style="display: flex; justify-content: center;">
            <div class="col-sm-7">
            <a href="/index.php?page=barangkeluar" class="btn btn-outline-primary">Kembali</a>
            <br><br>
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1 class="invoice-title">INVOICE</h1>
                </div>
                <div class="col-md-6 text-end">
                    <h4>PT. MMS GROUP</h4>
                    <p>Inventaris Barang</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>KEPADA :</strong></p>
                    <div>Nama Konsumen: Ketut Susilo</div>
                    <div>No HP : 08934838472</div>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>TANGGAL KELUAR :</strong> 28 Maret 2022</p>
                    <p><strong>ID TRANSAKSI :</strong>TRK-0225001</p>
                </div>
            </div>
            <table class="table table-bordered mt-4">
                <thead class="table-light">
                    <tr>
                        <th>KODE BARANG</th>
                        <th>NAMA BARANG</th>
                        <th>SATUAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>BAR-0225001</td>
                        <td>Lidah</td>
                        <td>Kg</td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <!-- <p><strong>PEMBAYARAN :</strong></p>
                    <p>Nama : Salford & Co.</p>
                    <p>No Rek : +123-456-7890</p> -->
                </div>
                <div class="col-md-6 text-end">
                    <p>HARGA SATUAN : Rp. 15.000</p>
                    <p>JUMLAH KELUAR : 30</p>
                    <p class="total">TOTAL : RP 880,000</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
