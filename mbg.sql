-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2021 at 02:01 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbg`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`) VALUES
(1, 'Wayan Deswana', 'wayan', '6f3792a964f0e3a5f06a35dfe609716c');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `kd_detail_transaksi` int(11) NOT NULL,
  `kd_transaksi` int(11) DEFAULT NULL,
  `kd_paket` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`kd_detail_transaksi`, `kd_transaksi`, `kd_paket`, `jumlah`, `total`) VALUES
(22, 36, 4, 1, NULL),
(23, 36, 2, 2, NULL),
(24, 36, 1, 1, NULL),
(25, 37, 2, 2, '90000'),
(26, 37, 1, 1, '40000'),
(27, 38, 4, 1, '50000'),
(28, 38, 2, 1, '45000'),
(29, 39, 4, 2, '100000'),
(30, 39, 2, 1, '45000'),
(31, 39, 3, 1, '47000'),
(32, 40, 6, 1, '59000'),
(33, 40, 4, 1, '50000'),
(34, 40, 9, 1, '40000'),
(35, 41, 4, 1, '50000'),
(36, 42, 4, 2, '100000'),
(37, 43, 4, 2, '100000'),
(38, 43, 3, 1, '47000'),
(39, 44, 4, 2, '100000'),
(40, 44, 3, 1, '47000'),
(43, 45, 3, 1, '47000'),
(44, 45, 2, 2, '90000'),
(45, 46, 3, 1, '47000'),
(46, 46, 2, 1, '45000'),
(48, 47, 2, 1, '45000'),
(50, 48, 1, 1, '40000'),
(51, 48, 9, 1, '40000'),
(52, 49, 3, 1, '47000'),
(53, 49, 2, 1, '45000'),
(60, 50, 3, 1, '47000'),
(61, 50, 2, 1, '45000'),
(62, 50, 4, 4, '200000'),
(63, 51, 3, 1, '47000'),
(64, 51, 2, 1, '45000'),
(65, 52, 3, 1, '47000'),
(66, 52, 2, 1, '45000'),
(67, 53, 3, 1, '47000'),
(68, 53, 2, 1, '45000'),
(69, 53, 6, 1, '59000'),
(73, 55, 3, 1, '47000'),
(74, 55, 13, 1, '19000'),
(75, 55, 12, 1, '17000'),
(76, 55, 4, 1, '50000'),
(77, 56, 4, 5, '250000'),
(78, 56, 2, 5, '225000'),
(79, 57, 4, 1, '50000'),
(80, 58, 4, 2, '100000'),
(82, 59, 4, 3, '150000'),
(83, 59, 3, 1, '47000'),
(84, 59, 2, 1, '45000'),
(85, 60, 4, 4, '200000'),
(86, 60, 3, 1, '47000'),
(87, 60, 2, 1, '45000'),
(88, 60, 1, 1, '40000');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_paket`
--

CREATE TABLE `kategori_paket` (
  `kd_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori_paket`
--

INSERT INTO `kategori_paket` (`kd_kategori`, `nama_kategori`) VALUES
(1, 'Menu Buffet Ayam Kampung'),
(2, 'Menu Buffet Ayam Negeri'),
(3, 'Menu Buffet Coffee Break');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `kd_paket` int(11) NOT NULL,
  `nama_paket` varchar(50) NOT NULL,
  `kd_kategori` int(11) NOT NULL,
  `harga_paket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`kd_paket`, `nama_paket`, `kd_kategori`, `harga_paket`) VALUES
(1, 'Paket 1 AK', 1, 40000),
(2, 'Paket 2 AK', 1, 45000),
(3, 'Paket 3 AK', 1, 47000),
(4, 'Paket 4 AK', 1, 50000),
(5, 'Paket 5 AK', 1, 55000),
(6, 'Paket 6 AK', 1, 59000),
(7, 'Paket 1 AN', 2, 30000),
(8, 'Paket 2 AN', 2, 35000),
(9, 'Paket 3 AN', 2, 40000),
(10, 'Paket 4 AN', 2, 45000),
(11, 'Paket 1 CB', 3, 15000),
(12, 'Paket 2 CB', 3, 17000),
(13, 'Paket 3 CB', 3, 19000),
(14, 'Paket 4 CB', 3, 21000),
(15, 'Paket 5 CB', 3, 23000);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `email`, `alamat`, `username`, `password`) VALUES
(1, 'wayan', 'dezwanepark@gmail.com', 'Yogyakarta', 'wayan', '6f3792a964f0e3a5f06a35dfe609716c'),
(2, 'Vhelia Yodyana', 'vyodyana@gmail.com', 'Yogyakarta', 'vhelia', 'a231bded6be0ae76f589af46519f5420'),
(3, 'Bagus Nuzul', 'bagus@gmail.com', 'Pacitan', 'bagus', '17b38fc02fd7e92f3edeb6318e3066d8'),
(4, 'Albert', 'v@gmail.com', '', 'bert', '3de0746a7d2762a87add40dac2bc95a0'),
(5, 'Deswana', 'deswana@gmail.com', '', 'deswana', '3beba109b9bfc6078a2f04012c8091ae');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `kode_pesanan` int(11) NOT NULL,
  `nama_paket` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telepon` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(5) NOT NULL,
  `tempat` varchar(50) NOT NULL,
  `timeslot` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`kode_pesanan`, `nama_paket`, `email`, `telepon`, `tanggal`, `jumlah`, `tempat`, `timeslot`) VALUES
(5, 'Wayan', 'dezwanepark@gmail.com', '089506371018', '2021-04-23', '5', 'Lesehan', '09:00AM - 11:00AM'),
(6, 'Deswana', 'des@gmail.com', '089506371018', '2021-04-24', '5', 'Meja', '09:00AM - 11:00AM'),
(7, 'qwe', 'bagus@gmail.com', '089506371018', '2021-04-26', '6', 'Meja', '11:00AM - 13:00PM'),
(8, 'asd', 'bagus@gmail.com', '089506371018', '2021-04-26', '5', 'Lesehan', '17:00PM - 19:00PM');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `kd_promo` int(11) NOT NULL,
  `judul_promo` varchar(100) NOT NULL,
  `gambar_promo` varchar(250) NOT NULL,
  `harga_promo` double NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`kd_promo`, `judul_promo`, `gambar_promo`, `harga_promo`, `deskripsi`) VALUES
(1, 'Paket Akad Nikah', 'promo3.jpg', 3000000, 'Pengen nikah tapi bingung masalah dekorasi dan catering? di Mbok Berek Garden \r\n                    ada paket spesial nih buat kalian yang kebelet nikah tapi gamau ribet. \r\n\r\nAda berbagai macam pilihan makanan dan harga yang spesial tentunya. Yuk buruan di order, \r\n                      kalau mau tanya-tanya dulu juga boleh.'),
(2, 'Hamper', 'promo1.jpg', 330000, 'Sebentar lagi bulan desember nih. Ada Natal dan Tahun baru menanti dimasa pandemi ini. Belum bisa keluar kota mengunjungi sanak saudara? \r\nKirim hampers aja. kami siap melayani.'),
(3, 'Hamper Rantang', 'promo2.jpg', 180000, 'Kita punya hampers yang beda dari yang lainnya niih. Dalamnya ada macam-macem jajanan lawas ala jogja,yang pasti ada ayam kremesnya ya. Walau Masih masa pandemi, dan belum bisa keluar kota mengunjungi sanak saudaradiluar kota, jangan kawatir, kirim hampers aja kami siap melayani. ');

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

CREATE TABLE `slot` (
  `slot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tempat`
--

CREATE TABLE `tempat` (
  `kd_tempat` int(11) NOT NULL,
  `kategori_tempat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tempat`
--

INSERT INTO `tempat` (`kd_tempat`, `kategori_tempat`) VALUES
(1, 'Lesehan'),
(2, 'Meja');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `kd_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `timeslot` varchar(250) NOT NULL,
  `total` double NOT NULL,
  `bayar` enum('sudah','belum') NOT NULL,
  `status` enum('online','offline') NOT NULL,
  `no_pembayaran` varchar(15) DEFAULT NULL,
  `jml_pengunjung` int(50) NOT NULL,
  `pdf` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`kd_transaksi`, `id_pelanggan`, `tanggal`, `timeslot`, `total`, `bayar`, `status`, `no_pembayaran`, `jml_pengunjung`, `pdf`) VALUES
(36, 1, '2021-11-28', '11:00AM - 12:00PM', 180000, 'sudah', 'online', '236250473', 0, ''),
(37, 1, '2021-11-28', '12:00PM - 10:00AM', 130000, 'sudah', 'online', '893170466', 0, ''),
(38, 1, '2021-11-30', '16:00PM - 17:00PM', 95000, 'sudah', 'online', '1936478825', 0, ''),
(39, 1, '2021-11-30', '12:00PM - 14:00PM', 192000, 'sudah', 'online', '1641419079', 0, ''),
(40, 1, '2021-11-30', '14:00PM - 10:00AM', 149000, 'sudah', 'online', '137786978', 0, ''),
(41, 1, '2021-12-01', '12:00PM - 21:00PM', 50000, 'sudah', 'online', '459690284', 0, ''),
(42, 1, '2021-12-01', '16:00PM - 20:00PM', 100000, 'sudah', 'online', '1562150208', 0, ''),
(43, 1, '2021-12-02', '10:00AM - 20:00PM', 147000, 'sudah', 'online', '2135464354', 0, ''),
(44, 1, '2021-12-01', '20:00PM - 16:00PM', 147000, 'sudah', 'online', '1379131394', 0, ''),
(45, 1, '2021-12-03', '10:00AM - 11:00AM', 137000, 'sudah', 'online', '1317859504', 0, ''),
(46, 1, '2021-12-04', '18:00PM - 16:00PM', 92000, 'sudah', 'online', '1559757396', 0, ''),
(47, 1, '2021-12-03', '14:00PM - 16:00PM', 95000, 'sudah', 'online', '771015870', 0, ''),
(48, 4, '2021-12-03', '14:00PM - 18:00PM', 130000, 'sudah', 'online', '1474938535', 0, ''),
(49, 1, '2021-12-05', '10:00AM - 12:00PM', 92000, 'sudah', 'online', '1739764641', 0, ''),
(50, 1, '2021-12-09', '19:00PM - 20:00PM', 292000, 'sudah', 'online', '563336257', 0, ''),
(51, 1, '2021-12-09', '11:00AM - 17:00PM', 92000, 'sudah', 'online', '566086516', 0, ''),
(52, 1, '2021-12-09', '20:00PM - 16:00PM', 92000, 'sudah', 'online', '1615997030', 1, ''),
(53, 1, '2021-12-09', '20:00PM - 21:00PM', 151000, 'sudah', 'online', '1450587984', 4, ''),
(55, 3, '2021-12-09', '11:00AM - 13:00PM', 133000, 'sudah', 'online', '987423514', 3, ''),
(56, 1, '2021-12-09', '11:00AM - 19:00PM', 475000, 'sudah', 'online', '385938511', 4, ''),
(57, 5, '2021-12-16', '10:00AM - 12:00PM', 50000, 'sudah', 'online', '263405368', 1, ''),
(58, 5, '2021-12-09', '11:00AM - 19:00PM', 100000, '', 'online', '1850196580', 2, ''),
(59, 5, '2021-12-09', '11:00AM - 15:00PM', 242000, '', 'online', '1965504791', 2, ''),
(60, 5, '2021-12-09', '19:00PM - 20:00PM', 332000, 'sudah', 'online', '1501392737', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`kd_detail_transaksi`),
  ADD KEY `kode_transaksi` (`kd_transaksi`),
  ADD KEY `kode_detail_paket` (`kd_paket`);

--
-- Indexes for table `kategori_paket`
--
ALTER TABLE `kategori_paket`
  ADD PRIMARY KEY (`kd_kategori`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`kd_paket`),
  ADD KEY `kd_kategori` (`kd_kategori`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`kode_pesanan`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`kd_promo`);

--
-- Indexes for table `tempat`
--
ALTER TABLE `tempat`
  ADD PRIMARY KEY (`kd_tempat`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`kd_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `kd_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `kategori_paket`
--
ALTER TABLE `kategori_paket`
  MODIFY `kd_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `kd_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `kode_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `kd_promo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tempat`
--
ALTER TABLE `tempat`
  MODIFY `kd_tempat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `kd_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`kd_paket`) REFERENCES `paket` (`kd_paket`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`kd_transaksi`) REFERENCES `transaksi` (`kd_transaksi`);

--
-- Constraints for table `paket`
--
ALTER TABLE `paket`
  ADD CONSTRAINT `paket_ibfk_1` FOREIGN KEY (`kd_kategori`) REFERENCES `kategori_paket` (`kd_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
