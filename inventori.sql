-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 13 Feb 2025 pada 06.28
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventori`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` int(11) NOT NULL,
  `id_transaksi` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah` double NOT NULL,
  `tujuan` varchar(100) NOT NULL,
  `satuan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `id_transaksi`, `tanggal`, `kode_barang`, `nama_barang`, `jumlah`, `tujuan`, `satuan`) VALUES
(2, 'TRK-1122001', '2022-11-28', 'BAR-1122001', 'Rustam HQ 31', 12, 'Sumedang alamanda', 'Kg'),
(3, 'TRK-1122002', '2022-11-28', 'BAR-1122001', 'Rustam HQ 31', 5, 'saas', 'Kg'),
(4, 'TRK-1122003', '2022-11-28', 'BAR-1122001', 'Rustam HQ 31', 2, 'edi', 'Kg');

--
-- Trigger `barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `barang_keluar` AFTER INSERT ON `barang_keluar` FOR EACH ROW BEGIN
	UPDATE gudang SET jumlah = jumlah-new.jumlah
    WHERE kode_barang=new.kode_barang;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL,
  `id_transaksi` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `pengirim` varchar(100) NOT NULL,
  `jumlah` double NOT NULL,
  `satuan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `id_transaksi`, `tanggal`, `kode_barang`, `nama_barang`, `pengirim`, `jumlah`, `satuan`) VALUES
(8, 'TRM-1122002', '2022-11-28', 'BAR-1122001', 'Rustam HQ 31', 'PT. Seribu Masa Bersama', 1, 'Kg');

--
-- Trigger `barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `barang_masuk` AFTER INSERT ON `barang_masuk` FOR EACH ROW BEGIN
	UPDATE gudang SET jumlah = jumlah+new.jumlah
    WHERE kode_barang=new.kode_barang;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gudang`
--

CREATE TABLE `gudang` (
  `id` int(11) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jenis_barang` varchar(100) NOT NULL,
  `jumlah` double NOT NULL,
  `satuan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `gudang`
--

INSERT INTO `gudang` (`id`, `kode_barang`, `nama_barang`, `jenis_barang`, `jumlah`, `satuan`) VALUES
(4, 'BAR-1122002', 'IAF', 'FQ 18 (Bullpack)', 1, 'Kg'),
(5, 'BAR-1122003', 'Rustam', 'FQ 11', 2, 'Kg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id` int(11) NOT NULL,
  `jenis_barang` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `jenis_barang`
--

INSERT INTO `jenis_barang` (`id`, `jenis_barang`) VALUES
(7, 'FQ 18 (Bullpack)'),
(9, 'Flanka'),
(10, 'Iga Tulang'),
(11, 'Iga Daging'),
(20, 'Wagyu Sirloin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `satuan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id`, `satuan`) VALUES
(12, 'Kg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id` int(100) NOT NULL,
  `kode_supplier` varchar(100) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_supplier`
--

INSERT INTO `tb_supplier` (`id`, `kode_supplier`, `nama_supplier`, `alamat`, `telepon`) VALUES
(11, 'SUP-1122002', 'CV ADS KARTINI', 'Jl mangga raya. dsn Sukamanah timur, RT.3/RW.3, desa, Cikampek Bar., Kec. Cikampek, Karawang, Jawa B', '081382402505'),
(12, 'SUP-1122003', 'PT. Seribu Masa Bersama', 'Jl. Puri BKR Raya No.42, Cigereleng, Kec. Regol, Kota Bandung, Jawa Barat 40253', '081320706729'),
(13, 'SUP-1122004', 'NIAGA JAYA', 'Ciroyom bermartabat blok 1C no 134-137 (NIAGA JAYA, Ciroyom, Kec. Andir, Kota Bandung, Jawa Barat 40', '081321354444');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(25) NOT NULL DEFAULT 'member',
  `foto` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nik`, `nama`, `alamat`, `telepon`, `username`, `password`, `level`, `foto`) VALUES
(26, '1001', 'Admin', '', '08999444000', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'teacher4.png'),
(27, '10001', 'Gudang', '', '0986660000', 'gudang', '202446dd1d6028084426867365b0c7a1', 'gudang', 'mahugi.jpg'),
(28, '123', 'Marketing', '', '083821198187', 'marketing', 'c769c2bd15500dd906102d9be97fdceb', 'marketing', 'DSC_0696.JPG'),
(30, '102938', 'Keuangan', '-', '08374627838', 'keuangan', 'a4151d4b2856ec63368a7c784b1f0a6e', 'keuangan', 'foto.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
