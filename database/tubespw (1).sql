-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jan 2024 pada 05.23
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tubespw`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `nama_mobil` varchar(255) NOT NULL,
  `merek` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `tahun` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `produsen_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mobil`
--

INSERT INTO `mobil` (`id`, `nama_mobil`, `merek`, `model`, `tahun`, `gambar`, `produsen_id`) VALUES
(1, 'Civic', 'Honda', 'Turbo', 2024, 'uploads/img_659291438ffe3_maxresdefault.jpg', 2),
(2, 'Brio', 'Honda', 'Turbo', 2024, 'uploads/img_659291a4d74ef_R.jpg', 2),
(3, 'Fortuner', 'Toyota', '4x4', 2022, 'uploads/img_65929222716ad_018a7d334b284d74a5575f961703e633.jpg', 1),
(4, 'Lexus', 'Lexus', 'Gs F', 2025, 'uploads/img_659292c9573e0_OIP.jpg', 3);

-- Update data in 'mobil' table
UPDATE `mobil` SET `nama_mobil` = 'NewCivic', `tahun` = 2025 WHERE `id` = 1;

-- Delete data from 'mobil' table
DELETE FROM `mobil` WHERE `id` = 4;


-- --------------------------------------------------------


--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `no_telepon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id`, `user_id`, `mobil_id`, `alamat`, `tanggal_pembelian`, `no_telepon`) VALUES
(1, 10, 1, 'kalimantan', '2023-12-01', '081234753'),
(2, 10, 1, 'surabaya', '2023-12-04', '09876647'),
(13, 10, 1, 'sidoarjo', '2023-12-28', '0909090'),
(14, 10, 1, 'sidoarjo', '2023-12-28', '0909090'),
(15, 10, 1, 'sidoarjo', '2023-12-28', '0909090'),
(22, 11, 2, '', '2024-01-01', ''),
(23, 11, 2, '', '2024-01-01', '');

-- Update data in 'pembelian' table
UPDATE `pembelian` SET `alamat` = 'jakarta' WHERE `id` = 1;

-- Delete data from 'pembelian' table
DELETE FROM `pembelian` WHERE `id` = 15;


-- --------------------------------------------------------

--
-- Struktur dari tabel `produsen`
--

CREATE TABLE `produsen` (
  `id` int(11) NOT NULL,
  `nama_produsen` varchar(255) NOT NULL,
  `alamat_produsen` text DEFAULT NULL,
  `telepon_produsen` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `produsen`
--

INSERT INTO `produsen` (`id`, `nama_produsen`, `alamat_produsen`, `telepon_produsen`) VALUES
(1, 'Toyota Astra Indonesia ', 'Jl. Gaya Motor II No.15, RT.9/RW.9 14330 Daerah Khusus Ibukota Jakarta Jawa', '62 21 6511210'),
(2, 'Honda Indonesia', 'Jl. Gaya Motor I Sunter II, Jakarta 14330', '0 800 14 46632'),
(3, 'Toyota Motor Corporation', 'Jl. Proklamasi No. 35 Menteng, Jakarta Pusat 10320', ' 021 3901325');

-- Update data in 'produsen' table
UPDATE `produsen` SET `nama_produsen` = 'Toyota Astra Corp' WHERE `id` = 1;

-- Delete data from 'produsen' table
DELETE FROM `produsen` WHERE `id` = 3;


-- --------------------------------------------------------

--
-- Struktur dari tabel `rating_mobil`
--

CREATE TABLE `rating_mobil` (
  `id` int(11) NOT NULL,
  `mobil_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `ulasan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rating_mobil`
--

INSERT INTO `rating_mobil` (`id`, `mobil_id`, `user_id`, `rating`, `ulasan`) VALUES
(1, 1, 10, 3, 'jelek'),
(2, 1, 11, 1, 'tes'),
(3, 1, 11, 1, 'bismillah\r\n'),
(4, 2, 11, 1, 'jelek');

-- Update data in 'rating_mobil' table
UPDATE `rating_mobil` SET `rating` = 4, `ulasan` = 'Bagus' WHERE `id` = 1;

-- Delete data from 'rating_mobil' table
DELETE FROM `rating_mobil` WHERE `id` = 3;


-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', 'admin'),
(10, 'andre12', '$2y$10$qTqQOaJ2ENSNqUJgq8/CNuTCu5ZKg/FyJFrYGW2Ge4CoMhecXK0X6', 'user'),
(11, 'andre', '$2y$10$GyM46U9juDq.w4uvY9Zox.8k1PbyArkDJ36cRwlpgDHxe7Ao0OiH6', 'user');

-- Update data in 'users' table
UPDATE `users` SET `password` = '$2y$10$NewHashedPassword' WHERE `id` = 10;

-- Delete data from 'users' table
DELETE FROM `users` WHERE `id` = 11;


--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mobil_produsen` (`produsen_id`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mobil_id` (`mobil_id`);

--
-- Indeks untuk tabel `produsen`
--
ALTER TABLE `produsen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rating_mobil`
--
ALTER TABLE `rating_mobil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mobil_id` (`mobil_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `produsen`
--
ALTER TABLE `produsen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rating_mobil`
--
ALTER TABLE `rating_mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mobil`
--
ALTER TABLE `mobil`
  ADD CONSTRAINT `fk_mobil_produsen` FOREIGN KEY (`produsen_id`) REFERENCES `produsen` (`id`);

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pembelian_ibfk_3` FOREIGN KEY (`mobil_id`) REFERENCES `mobil` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rating_mobil`
--
ALTER TABLE `rating_mobil`
  ADD CONSTRAINT `rating_mobil_ibfk_1` FOREIGN KEY (`mobil_id`) REFERENCES `mobil` (`id`),
  ADD CONSTRAINT `rating_mobil_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
