-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2026 pada 17.56
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_ps`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `no_identitas` varchar(50) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `status_pelanggan` varchar(20) DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `no_identitas`, `nama_pelanggan`, `no_hp`, `alamat`, `status_pelanggan`) VALUES
(2, '1029129810921', 'wira', '21821092', 'tabanan', 'Aktif'),
(3, '238209382039', 'agung', '32323', 'tabanan', 'Aktif'),
(4, '23820938203928', 'dika', '292029', 'tampal', 'Aktif'),
(5, '102912981092123', 'dadaj', '21821092', 'jumah', 'Aktif'),
(6, '102912981092123', 'jemberasas', '21821092', 'rumah', 'Aktif'),
(7, '00000000000000', 'Wiruy', '082134454546', 'Bendungan Temon', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_reservasi` int(11) NOT NULL,
  `total_payar` int(11) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `Denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`id_pembayaran`, `id_reservasi`, `total_payar`, `tgl_pembayaran`, `metode_pembayaran`, `Denda`) VALUES
(1, 3, 600000, '2026-06-12', 'Tunai', 0),
(2, 4, 300000, '2026-06-13', 'Tunai', 0),
(3, 7, 600000, '2026-06-15', 'Tunai', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_petugas`
--

CREATE TABLE `tb_petugas` (
  `id_petugas` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_petugas` varchar(100) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `role` enum('owner','pegawai') NOT NULL DEFAULT 'pegawai',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_petugas`
--

INSERT INTO `tb_petugas` (`id_petugas`, `username`, `password`, `nama_petugas`, `no_hp`, `role`, `created_at`) VALUES
(1, 'owner', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Owner Rental PS', '081234567890', 'owner', '2026-06-14 16:09:25'),
(2, 'pegawai1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pegawai Satu', '081111111111', 'pegawai', '2026-06-14 16:09:25'),
(3, 'pegawai2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Pegawai Dua', '082222222222', 'pegawai', '2026-06-14 16:09:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_reservasi`
--

CREATE TABLE `tb_reservasi` (
  `id_reservasi` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_paket` int(11) DEFAULT NULL,
  `tgl_reservasi` date NOT NULL,
  `lama_sewa` int(11) NOT NULL,
  `status_reservasi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_reservasi`
--

INSERT INTO `tb_reservasi` (`id_reservasi`, `id_pelanggan`, `id_paket`, `tgl_reservasi`, `lama_sewa`, `status_reservasi`) VALUES
(3, 3, 2, '2026-06-12', 4, 'Selesai'),
(4, 4, 2, '2026-06-13', 2, 'Selesai'),
(7, 7, 2, '2026-06-15', 4, 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_unit_playstation`
--

CREATE TABLE `tb_unit_playstation` (
  `id_paket` int(11) NOT NULL,
  `nama_unit` varchar(50) NOT NULL,
  `tipe_playstation` varchar(30) NOT NULL,
  `status_unit` varchar(20) NOT NULL,
  `harga_sewa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_unit_playstation`
--

INSERT INTO `tb_unit_playstation` (`id_paket`, `nama_unit`, `tipe_playstation`, `status_unit`, `harga_sewa`) VALUES
(1, 'PS5-01', 'PlayStation 5', 'Tersedia', 150000),
(2, 'PS5-02', 'PlayStation 5', 'Tersedia', 150000),
(3, 'PS4-01', 'PlayStation 4', 'Tersedia', 80000),
(4, 'PS4-02', 'PlayStation 4', 'Tersedia', 80000),
(5, 'PS3-01', 'PlayStation 3', 'Tersedia', 60000),
(6, 'PS3-02', 'PlayStation 3', 'Tersedia', 60000),
(7, 'PS2-01', 'PlayStation 2', 'Tersedia', 40000),
(8, 'PS2-02', 'PlayStation 2', 'Tersedia', 40000),
(11, 'XBOX-01', 'Xbox 360', 'Tersedia', 50000),
(12, 'XBOX-02', 'Xbox 360', 'Tersedia', 50000),
(13, 'NS-01', 'Nintendo Switch', 'Tersedia', 70000),
(14, 'NS-02', 'Nintendo Switch', 'Tersedia', 70000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_reservasi` (`id_reservasi`);

--
-- Indeks untuk tabel `tb_petugas`
--
ALTER TABLE `tb_petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `tb_reservasi`
--
ALTER TABLE `tb_reservasi`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_paket` (`id_paket`);

--
-- Indeks untuk tabel `tb_unit_playstation`
--
ALTER TABLE `tb_unit_playstation`
  ADD PRIMARY KEY (`id_paket`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_petugas`
--
ALTER TABLE `tb_petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_reservasi`
--
ALTER TABLE `tb_reservasi`
  MODIFY `id_reservasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_unit_playstation`
--
ALTER TABLE `tb_unit_playstation`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD CONSTRAINT `tb_pembayaran_ibfk_1` FOREIGN KEY (`id_reservasi`) REFERENCES `tb_reservasi` (`id_reservasi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_reservasi`
--
ALTER TABLE `tb_reservasi`
  ADD CONSTRAINT `tb_reservasi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `tb_pelanggan` (`id_pelanggan`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_reservasi_ibfk_2` FOREIGN KEY (`id_paket`) REFERENCES `tb_unit_playstation` (`id_paket`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
