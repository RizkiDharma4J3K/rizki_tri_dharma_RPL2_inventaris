-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2025 at 04:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_gudang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int NOT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `id_kategori` int NOT NULL,
  `stock` int NOT NULL,
  `harga` int NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `min_stok` int DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `id_kategori`, `stock`, `harga`, `tanggal_masuk`, `min_stok`) VALUES
(8, 'Meja', 2, 34, 120000, '2025-11-11', 5),
(9, 'hp samsung a55', 3, 10, 12000, '2025-11-07', 5),
(10, 'Kulkas', 3, 12, 500000, '2025-11-11', 5),
(11, 'frying pan', 4, 12, 50000, '2025-11-12', 5),
(52, 'Laptop Lenovo Thinkpad', 3, 10, 6500000, '2025-01-01', 5),
(53, 'Laptop Acer Aspire 5', 3, 7, 7200000, '2025-01-01', 5),
(54, 'Monitor Samsung 24 Inch', 3, 6, 1850000, '2025-01-02', 5),
(55, 'Monitor LG 27 Inch', 3, 5, 2450000, '2025-01-02', 5),
(56, 'Printer Epson L3110', 3, 8, 2300000, '2025-01-03', 5),
(57, 'Proyektor Epson X200', 3, 4, 3500000, '2025-01-03', 5),
(58, 'Mouse Logitech M170', 3, 30, 120000, '2025-01-04', 5),
(59, 'Keyboard Logitech K120', 3, 25, 180000, '2025-01-04', 5),
(60, 'Headset JBL Tune 500', 3, 12, 325000, '2025-01-05', 5),
(61, 'Microphone USB BM800', 3, 9, 210000, '2025-01-05', 5),
(62, 'Webcam Logitech C270', 3, 7, 260000, '2025-01-06', 5),
(63, 'Smart TV Samsung 43 Inch', 3, 3, 4100000, '2025-01-06', 5),
(64, 'Harddisk External WD 1TB', 3, 9, 780000, '2025-01-07', 5),
(65, 'Harddisk Seagate 2TB', 3, 5, 1350000, '2025-01-07', 5),
(66, 'Flashdisk Sandisk 32GB', 3, 50, 65000, '2025-01-08', 5),
(67, 'Flashdisk Sandisk 64GB', 3, 35, 95000, '2025-01-08', 5),
(68, 'Router TP-Link Archer C20', 3, 10, 350000, '2025-01-09', 5),
(69, 'Speaker Bluetooth JBL GO 3', 3, 14, 375000, '2025-01-10', 5),
(70, 'UPS APC 650VA', 3, 5, 950000, '2025-01-10', 5),
(71, 'Kabel HDMI 2 Meter', 3, 40, 35000, '2025-01-10', 5),
(72, 'Meja Kerja Kayu Jati', 2, 6, 850000, '2025-01-01', 5),
(73, 'Meja Belajar Minimalis', 2, 10, 550000, '2025-01-01', 5),
(74, 'Meja Komputer Minimalis', 2, 11, 270000, '2025-01-02', 5),
(75, 'Kursi Kantor Hidrolik', 2, 12, 475000, '2025-01-02', 5),
(76, 'Kursi Plastik Napolly', 2, 30, 45000, '2025-01-03', 5),
(77, 'Sofa Minimalis 3 Dudukan', 2, 2, 2250000, '2025-01-04', 5),
(78, 'Lemari Pakaian 2 Pintu', 2, 4, 1350000, '2025-01-05', 5),
(79, 'Rak Buku 5 Susun', 2, 7, 350000, '2025-01-05', 5),
(80, 'Rak Sepatu 4 Tingkat', 2, 9, 160000, '2025-01-06', 5),
(81, 'Kursi Tamu Kayu Jati', 2, 5, 1250000, '2025-01-07', 5),
(82, 'Meja TV Minimalis', 2, 6, 495000, '2025-01-07', 5),
(83, 'Bangku Cafe Kayu', 2, 18, 90000, '2025-01-08', 5),
(84, 'Lemari Arsip Besi', 2, 3, 1800000, '2025-01-09', 5),
(85, 'Kasur Lipat Busa', 2, 8, 275000, '2025-01-09', 5),
(86, 'Kasur Springbed 160x200', 2, 2, 2300000, '2025-01-10', 5),
(87, 'Meja Tamu Minimalis', 2, 5, 450000, '2025-01-10', 5),
(88, 'Meja Rapat Panjang', 2, 1, 3150000, '2025-01-11', 5),
(89, 'Lemari Dapur Aluminium', 2, 3, 970000, '2025-01-11', 5),
(90, 'Rak Display Showcase', 2, 2, 2250000, '2025-01-11', 5),
(91, 'Kursi Lipat Serbaguna', 2, 20, 65000, '2025-01-11', 5);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(2, 'Furnitur'),
(3, 'Elektronik'),
(4, 'alat dapur');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
