-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 21 Apr 2021 pada 17.14
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `barang_kode` varchar(100) NOT NULL,
  `barang_nama` varchar(100) NOT NULL,
  `brand_id` int(100) NOT NULL,
  `barang_model` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_brand`
--

CREATE TABLE `tb_brand` (
  `brand_id` int(100) NOT NULL,
  `brand_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_brand`
--

INSERT INTO `tb_brand` (`brand_id`, `brand_name`) VALUES
(1, 'Apple');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_barang`
--

CREATE TABLE `tb_detail_barang` (
  `detail_barang_id` int(100) NOT NULL,
  `barang_kode` varchar(100) NOT NULL,
  `detail_barang_prosessor` varchar(100) NOT NULL,
  `detail_barang_ram` int(4) NOT NULL,
  `detail_barang_storage` varchar(100) NOT NULL,
  `warna_kode` varchar(10) NOT NULL,
  `detail_barang_keterangan` int(100) NOT NULL,
  `lokasi_barang_id` int(100) NOT NULL,
  `detail_barang_stok` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `jabatan_id` int(100) NOT NULL,
  `jabatan_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_jabatan`
--

INSERT INTO `tb_jabatan` (`jabatan_id`, `jabatan_nama`) VALUES
(1, 'Admin'),
(2, 'Operator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lokasi_barang`
--

CREATE TABLE `tb_lokasi_barang` (
  `lokasi_barang_id` int(100) NOT NULL,
  `lokasi_barang_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_lokasi_barang`
--

INSERT INTO `tb_lokasi_barang` (`lokasi_barang_id`, `lokasi_barang_name`) VALUES
(1, 'Rak A1'),
(2, 'Rak A2'),
(6, 'Rak A3'),
(7, 'Rak A4');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_status_user`
--

CREATE TABLE `tb_status_user` (
  `status_user_id` int(100) NOT NULL,
  `status_user_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_status_user`
--

INSERT INTO `tb_status_user` (`status_user_id`, `status_user_nama`) VALUES
(1, 'Aktif'),
(2, 'Suspend');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi_barang`
--

CREATE TABLE `tb_transaksi_barang` (
  `transaksi_barang_id` int(100) NOT NULL,
  `transaksi_barang_no_faktur` varchar(100) NOT NULL,
  `transaksi_barang_tanggal` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `transaksi_barang_jenis` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi_barang_detail`
--

CREATE TABLE `tb_transaksi_barang_detail` (
  `transaksi_barang_detail_id` int(100) NOT NULL,
  `barang_kode` varchar(100) NOT NULL,
  `detail_barang_id` int(100) NOT NULL,
  `transaksi_barang_detail_jml` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(100) NOT NULL,
  `user_nama` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `status_user_id` int(2) NOT NULL,
  `jabatan_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_nama`, `user_email`, `user_password`, `status_user_id`, `jabatan_id`) VALUES
(1, 'Admin Gudang Saja', 'admin@gudang.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, 1),
(2, 'test', 'test@operator.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, 2),
(3, 'test', 'shiro@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_warna`
--

CREATE TABLE `tb_warna` (
  `warna_kode` varchar(10) NOT NULL,
  `warna_nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_warna`
--

INSERT INTO `tb_warna` (`warna_kode`, `warna_nama`) VALUES
('MRH01', 'Merah'),
('MRH02', 'Merah Ajah'),
('PTH01', 'Putih');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`barang_kode`);

--
-- Indeks untuk tabel `tb_brand`
--
ALTER TABLE `tb_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indeks untuk tabel `tb_detail_barang`
--
ALTER TABLE `tb_detail_barang`
  ADD PRIMARY KEY (`detail_barang_id`);

--
-- Indeks untuk tabel `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`jabatan_id`);

--
-- Indeks untuk tabel `tb_lokasi_barang`
--
ALTER TABLE `tb_lokasi_barang`
  ADD PRIMARY KEY (`lokasi_barang_id`);

--
-- Indeks untuk tabel `tb_status_user`
--
ALTER TABLE `tb_status_user`
  ADD PRIMARY KEY (`status_user_id`);

--
-- Indeks untuk tabel `tb_transaksi_barang`
--
ALTER TABLE `tb_transaksi_barang`
  ADD PRIMARY KEY (`transaksi_barang_id`);

--
-- Indeks untuk tabel `tb_transaksi_barang_detail`
--
ALTER TABLE `tb_transaksi_barang_detail`
  ADD PRIMARY KEY (`transaksi_barang_detail_id`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `tb_warna`
--
ALTER TABLE `tb_warna`
  ADD PRIMARY KEY (`warna_kode`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_brand`
--
ALTER TABLE `tb_brand`
  MODIFY `brand_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_barang`
--
ALTER TABLE `tb_detail_barang`
  MODIFY `detail_barang_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  MODIFY `jabatan_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_lokasi_barang`
--
ALTER TABLE `tb_lokasi_barang`
  MODIFY `lokasi_barang_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_status_user`
--
ALTER TABLE `tb_status_user`
  MODIFY `status_user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_transaksi_barang`
--
ALTER TABLE `tb_transaksi_barang`
  MODIFY `transaksi_barang_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_transaksi_barang_detail`
--
ALTER TABLE `tb_transaksi_barang_detail`
  MODIFY `transaksi_barang_detail_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
