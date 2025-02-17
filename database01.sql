-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 10:11 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_ambilS=@@CHARACTER_SET_ambilS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainit_saw`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama`) VALUES
(2, 'admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'admin masjid'),
(3, 'aulia', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'puput'),
(4, 'TPA Bustanul Ulum', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'TPA Bustanul Ulum'),
(5, 'kimnamjoon@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'RIDHWAN'),
(6, 'auliaputri@students.amikom.ac.id', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Aulia Putri');

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `kode_alternatif` varchar(5) NOT NULL,
  `nama_alternatif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`kode_alternatif`, `nama_alternatif`) VALUES
('A1', 'Sukinah'),
('A10', 'Poerwadi'),
('A2', 'Parsiman'),
('A3', 'Handri Kiswanto'),
('A4', 'Purwanto'),
('A5', 'Sri Mardiyati'),
('A6', 'Dumianah'),
('A7', 'Jumiyatun'),
('A8', 'Rahmat Hidayat'),
('A9', 'Sarimin');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `kode_kriteria` varchar(5) NOT NULL,
  `nama_kriteria` varchar(100) NOT NULL,
  `atribut_kriteria` enum('benefit','cost') NOT NULL,
  `bobot_kriteria` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`kode_kriteria`, `nama_kriteria`, `atribut_kriteria`, `bobot_kriteria`) VALUES
('C1', 'Penghasilan Kepala Keluarga', 'cost', '0.20'),
('C2', 'Penghasilan Istri', 'cost', '0.20'),
('C3', 'Jumlah Tanggungan Keluarga', 'benefit', '0.30'),
('C4', 'Status Kepemilikan Rumah', 'benefit', '0.10'),
('C5', 'Jumlah Anak yang Masih Sekolah', 'benefit', '0.20');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `kode_alternatif` varchar(5) NOT NULL,
  `kode_kriteria` varchar(5) NOT NULL,
  `id_subkriteria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `kode_alternatif`, `kode_kriteria`, `id_subkriteria`) VALUES
(1, 'A1', 'C1', 1),
(2, 'A1', 'C2', 7),
(3, 'A1', 'C3', 12),
(4, 'A1', 'C4', 17),
(5, 'A1', 'C5', 34),
(6, 'A2', 'C1', 4),
(7, 'A2', 'C2', 8),
(8, 'A2', 'C3', 13),
(9, 'A2', 'C4', 18),
(10, 'A2', 'C5', 21),
(11, 'A3', 'C1', 3),
(12, 'A3', 'C2', 9),
(13, 'A3', 'C3', 14),
(14, 'A3', 'C4', 18),
(15, 'A3', 'C5', 22),
(16, 'A4', 'C1', 3),
(17, 'A4', 'C2', 9),
(18, 'A4', 'C3', 14),
(19, 'A4', 'C4', 17),
(20, 'A4', 'C5', 22),
(21, 'A5', 'C1', 1),
(22, 'A5', 'C2', 9),
(23, 'A5', 'C3', 11),
(24, 'A5', 'C4', 17),
(25, 'A5', 'C5', 34),
(26, 'A10', 'C1', 2),
(27, 'A10', 'C2', 7),
(28, 'A10', 'C3', 14),
(29, 'A10', 'C4', 20),
(30, 'A10', 'C5', 22),
(31, 'A6', 'C1', 1),
(32, 'A6', 'C2', 8),
(33, 'A6', 'C3', 11),
(34, 'A6', 'C4', 17),
(35, 'A6', 'C5', 34),
(36, 'A7', 'C1', 1),
(37, 'A7', 'C2', 10),
(38, 'A7', 'C3', 13),
(39, 'A7', 'C4', 17),
(40, 'A7', 'C5', 22),
(41, 'A8', 'C1', 4),
(42, 'A8', 'C2', 6),
(43, 'A8', 'C3', 11),
(44, 'A8', 'C4', 17),
(45, 'A8', 'C5', 34),
(46, 'A9', 'C1', 2),
(47, 'A9', 'C2', 8),
(48, 'A9', 'C3', 11),
(49, 'A9', 'C4', 17),
(50, 'A9', 'C5', 34);

-- --------------------------------------------------------

--
-- Table structure for table `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id_subkriteria` int(11) NOT NULL,
  `kode_kriteria` varchar(5) NOT NULL,
  `nama_subkriteria` varchar(100) NOT NULL,
  `nilai_subkriteria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subkriteria`
--

INSERT INTO `subkriteria` (`id_subkriteria`, `kode_kriteria`, `nama_subkriteria`, `nilai_subkriteria`) VALUES
(1, 'C1', 'Janda', 20),
(2, 'C1', '<500.000', 40),
(3, 'C1', '500.000 - 1.000.000', 60),
(4, 'C1', '1.000.000 - 1.500.000', 80),
(5, 'C1', '1.500.000 - 2.000.000', 100),
(6, 'C2', 'Duda', 20),
(7, 'C2', '<500.000', 40),
(8, 'C2', '500.000 - 1.000.000', 60),
(9, 'C2', '1.000.000 - 1.500.000	', 80),
(10, 'C2', '1.500.000 - 2.000.000', 100),
(11, 'C3', 'Tidak Ada Sendiri', 20),
(12, 'C3', '1 Orang', 40),
(13, 'C3', '2-3 Orang', 60),
(14, 'C3', '4-6 Orang', 80),
(15, 'C3', '>7  Orang', 100),
(17, 'C4', 'Sendiri', 40),
(18, 'C4', 'Keluarga', 60),
(19, 'C4', 'Kontrak', 80),
(20, 'C4', 'Menumpang', 100),
(21, 'C5', '2 Anak', 60),
(22, 'C5', '3 Anak', 80),
(23, 'C5', '4 Anak', 100),
(34, 'C5', 'Tidak Ada', 20),
(35, 'C5', '1 Anak', 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`kode_alternatif`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`kode_kriteria`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id_subkriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id_subkriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_ambilS=@OLD_CHARACTER_SET_ambilS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
