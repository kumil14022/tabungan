-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Apr 2023 pada 21.24
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabungan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_tabungan`
--

CREATE TABLE `riwayat_tabungan` (
  `id_riwayat_tabungan` int(11) NOT NULL,
  `id_tabungan` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `jenis_transaksi` enum('SETORAN','TARIKAN') NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_tabungan`
--

INSERT INTO `riwayat_tabungan` (`id_riwayat_tabungan`, `id_tabungan`, `tanggal_transaksi`, `jenis_transaksi`, `nominal`) VALUES
(2, 1, '2023-04-05 16:39:44', 'SETORAN', 15000),
(4, 2, '2023-04-05 16:50:04', 'SETORAN', 50000),
(5, 1, '2023-04-14 02:13:43', 'TARIKAN', 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `kelas_siswa` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_siswa`, `kelas_siswa`) VALUES
(2, 'Andri Firman Saputra', '6C'),
(4, 'ikmal', '6A');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabungan`
--

CREATE TABLE `tabungan` (
  `id_tabungan` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `tanggal_dibuka` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabungan`
--

INSERT INTO `tabungan` (`id_tabungan`, `id_siswa`, `saldo`, `tanggal_dibuka`) VALUES
(1, 2, 10000, '2023-04-05 16:32:51'),
(2, 4, 50000, '2023-04-05 16:49:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'ikmal123', '$2y$10$OIfWk9/wZZSKm/V13Lvgh.iFIlQhEBSDsBavIQZO8QUbUVmZPqrvC', 'Ikmal'),
(2, 'admin', '$2y$10$lq/xIahhpKBF7azUWWUXQuv8bTh4qiknned.THWWYwVmSNm9NRyIq', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `riwayat_tabungan`
--
ALTER TABLE `riwayat_tabungan`
  ADD PRIMARY KEY (`id_riwayat_tabungan`),
  ADD KEY `id_tabungan` (`id_tabungan`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indeks untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  ADD PRIMARY KEY (`id_tabungan`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `riwayat_tabungan`
--
ALTER TABLE `riwayat_tabungan`
  MODIFY `id_riwayat_tabungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tabungan`
--
ALTER TABLE `tabungan`
  MODIFY `id_tabungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
