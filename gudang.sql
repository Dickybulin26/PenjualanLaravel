-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 10:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`` FUNCTION `hargaJual` (`harga_modal` INT UNSIGNED, `keuntungan` INT UNSIGNED) RETURNS INT(11) DETERMINISTIC BEGIN
DECLARE besarKeuntungan INT UNSIGNED;
SET besarKeuntungan = harga_modal * (keuntungan/100);
return (harga_modal * besarKeuntungan);
END$$

CREATE DEFINER=`` FUNCTION `hargaTotal` (`harga_barang` INT UNSIGNED, `jumlah_beli` INT UNSIGNED) RETURNS INT(11) DETERMINISTIC Begin
return (jumlah_beli * harga_barang);
End$$

CREATE DEFINER=`` FUNCTION `hargaTotalKeuntungan` (`hargaModal` INT UNSIGNED, `total` INT UNSIGNED, `keuntungan` DECIMAL(10,2)) RETURNS INT(11) DETERMINISTIC BEGIN
DECLARE hargaModalTotal INT UNSIGNED;
DECLARE besarKeuntungan INT UNSIGNED;
SET hargaModalTotal = hargaModal * total;
SET besarKeuntungan = hargaModalTotal * (keuntungan/100);
RETURN (hargaModalTotal * besarKeuntungan);
END$$

CREATE DEFINER=`` FUNCTION `insert_barang` (`nama_barang` VARCHAR(100), `kode_barang` VARCHAR(200), `harga_barang` INT UNSIGNED) RETURNS INT(11) DETERMINISTIC BEGIN
INSERT INTO barang (nama_barang, kode_barang, harga_barang) VALUES (nama_barang, kode_barang, harga_barang);
RETURN 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kode_barang` varchar(200) NOT NULL,
  `harga_barang` int(20) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `kode_barang`, `harga_barang`, `keterangan`) VALUES
(1, 'hp victus gaming 15', 'dfkj222000123', 15000000, 'Ini laptop gaming HP'),
(2, 'hp xiomi redmi 6 pro', 'H3S0Y4M', 2500000, 'hp badut'),
(5, 'bakso tanpa tepung', 'BIBD001', 24000, 'baksonya mas roy enak tenan rek'),
(7, 'KOMODO KEBALIK', '2418JHJKKLL', 30600, NULL),
(8, 'KIPAS ANGIN KOSMOS', '2312KJK', 2500000, NULL),
(10, 'ayam beneran', 'jkhjh4545', 25000, NULL);

--
-- Triggers `barang`
--
DELIMITER $$
CREATE TRIGGER `BarangStokInsert` AFTER INSERT ON `barang` FOR EACH ROW BEGIN
	INSERT INTO stok (id_barang,jumlah_barang) VALUES (new.id_barang, 0);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambahBarang` AFTER INSERT ON `barang` FOR EACH ROW begin
insert into logs (pesan, tanggal) VALUES (CONCAT('Sebuah item baru sudah Ditambahkan pada table barang dengan nama',new.nama_barang,'dengan id_barang = ', new.id_barang, 'dengan harga satuan sebesar ',new.harga_barang), current_timestamp());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `id_beli` int(10) NOT NULL,
  `id_barang` int(10) NOT NULL,
  `jumlah_beli` int(10) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `harga_barang` int(10) NOT NULL,
  `total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beli`
--

INSERT INTO `beli` (`id_beli`, `id_barang`, `jumlah_beli`, `tanggal`, `harga_barang`, `total`) VALUES
(1, 1, 10, '0000-00-00 00:00:00', 15000000, 150000000),
(4, 1, 2, '2024-02-05 04:07:27', 15000000, 30000000),
(5, 5, 100, '2024-02-26 17:00:00', 24000, 2400000);

--
-- Triggers `beli`
--
DELIMITER $$
CREATE TRIGGER `BeliStok` AFTER INSERT ON `beli` FOR EACH ROW BEGIN
	UPDATE stok SET jumlah_barang = jumlah_barang + new.jumlah_beli WHERE id_barang = new.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRbeliLogs` AFTER INSERT ON `beli` FOR EACH ROW begin
insert into logs (pesan,tanggal) VALUES(concat('Aktifitas Pembelian untuk barang ',(select br.nama_barang from barang br where br.id_barang = new.id_barang)," dengan jumlah pembelian sebanyak ",new.jumlah_beli,' dengan harga satuan sebesar ',new.harga_barang,' dan total biaya sebesar ',new.total,' sudah dilakukan pada tanggal   ',current_timestamp()),current_timestamp());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `jual`
--

CREATE TABLE `jual` (
  `id_jual` int(10) NOT NULL,
  `id_barang` int(10) NOT NULL,
  `jumlah_jual` int(10) DEFAULT NULL,
  `harga_barang` int(100) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jual`
--

INSERT INTO `jual` (`id_jual`, `id_barang`, `jumlah_jual`, `harga_barang`, `tanggal`, `total`) VALUES
(1, 1, 3, 3000, '0000-00-00 00:00:00', 9000),
(2, 2, 5, 3000, '0000-00-00 00:00:00', 15000),
(3, 2, 5, 2500000, '2024-02-05 04:16:22', 16250000);

--
-- Triggers `jual`
--
DELIMITER $$
CREATE TRIGGER `JualStok` AFTER INSERT ON `jual` FOR EACH ROW BEGIN
	UPDATE stok SET jumlah_barang = jumlah_barang - new.jumlah_jual WHERE id_barang = new.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRJualLogs` AFTER INSERT ON `jual` FOR EACH ROW begin
insert into logs (pesan, tanggal) values (concat('Aktifitas penjualan untuk barang',(select br.nama_barang from barang as br WHERE br.id_barang = new.id_barang)," dengan jumlah penjualan sebanyak ", new.jumlah_jual,' dengan harga satuan sebesar ',new.harga_barang,' dan total biaya sebesar ',new.total,' sudah dilakukan pada tanggal ', current_timestamp()),current_timestamp());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id_logs` int(10) NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id_logs`, `pesan`, `tanggal`) VALUES
(1, 'Sebuah item baru sudah Ditambahkan pada table barang dengan namahp xiomi redmi 6 prodengan id_barang = 2dengan harga satuan sebesar 2500000', '2024-01-22'),
(2, 'Sebuah item baru sudah Ditambahkan pada table barang dengan namasate padangdengan id_barang = 3dengan harga satuan sebesar 5000', '2024-01-22'),
(3, 'Aktifitas Pembelian untuk baranghp victus gaming 15 dengan jumlah pembelian sebanyak 10dengan harga satuan sebesar 15000000 dan total biaya sebesar 150000000 sudah dilakukan pada tanggal2024-01-22 14:35:52', '2024-01-22'),
(4, 'Aktifitas penjualan untuk baranghp victus gaming 15 dengan jumlah penjualan sebanyak 3 dengan harga satuan sebesar 3000 dan total biaya sebesar 9000 sudah dilakukan pada tanggal 2024-01-22 15:06:59', '2024-01-22'),
(5, 'Aktifitas penjualan untuk baranghp xiomi redmi 6 pro dengan jumlah penjualan sebanyak 5 dengan harga satuan sebesar 3000 dan total biaya sebesar 15000 sudah dilakukan pada tanggal 2024-01-23 07:37:11', '2024-01-23'),
(6, 'Aktifitas Pembelian untuk barang hp victus gaming 15 dengan jumlah pembelian sebanyak 2 dengan harga satuan sebesar 15000000 dan total biaya sebesar 0 sudah dilakukan pada tanggal   2024-02-05 10:26:03', '2024-02-05'),
(7, 'Aktifitas Pembelian untuk barang hp victus gaming 15 dengan jumlah pembelian sebanyak 2 dengan harga satuan sebesar 15000000 dan total biaya sebesar 30000000 sudah dilakukan pada tanggal   2024-02-05 11:01:55', '2024-02-05'),
(8, 'Aktifitas Pembelian untuk barang hp victus gaming 15 dengan jumlah pembelian sebanyak 2 dengan harga satuan sebesar 15000000 dan total biaya sebesar 30000000 sudah dilakukan pada tanggal   2024-02-05 11:07:27', '2024-02-05'),
(9, 'Aktifitas penjualan untuk baranghp xiomi redmi 6 pro dengan jumlah penjualan sebanyak 5 dengan harga satuan sebesar 2500000 dan total biaya sebesar 16250000 sudah dilakukan pada tanggal 2024-02-05 11:16:22', '2024-02-05'),
(11, 'Sebuah item baru sudah Ditambahkan pada table barang dengan namabakso tanpa tepungdengan id_barang = 5dengan harga satuan sebesar 24000', '2024-02-05'),
(12, 'Sebuah item baru sudah Ditambahkan pada table barang dengan namaayam kebalikdengan id_barang = 6dengan harga satuan sebesar 25000', '2024-02-19'),
(13, 'Sebuah item baru sudah Ditambahkan pada table barang dengan namaKOMODO KEBALIKdengan id_barang = 7dengan harga satuan sebesar 30600', '2024-02-20'),
(14, 'Sebuah item baru sudah Ditambahkan pada table barang dengan namaKIPAS ANGIN KOSMOSdengan id_barang = 8dengan harga satuan sebesar 2500000', '2024-02-20'),
(15, 'Sebuah item baru sudah Ditambahkan pada table barang dengan namaak 47 seconddengan id_barang = 9dengan harga satuan sebesar 990000', '2024-02-27'),
(16, 'Sebuah item baru sudah Ditambahkan pada table barang dengan namaayam kebalikdengan id_barang = 10dengan harga satuan sebesar 25000', '2024-02-27'),
(17, 'Aktifitas Pembelian untuk barang bakso tanpa tepung dengan jumlah pembelian sebanyak 100 dengan harga satuan sebesar 24000 dan total biaya sebesar 2400000 sudah dilakukan pada tanggal   2024-02-27 15:19:25', '2024-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id_stok` int(10) NOT NULL,
  `jumlah_barang` int(10) NOT NULL,
  `id_barang` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`id_stok`, `jumlah_barang`, `id_barang`) VALUES
(3, 13, 1),
(4, -10, 2),
(7, 100, 5),
(9, 0, 7),
(10, 0, 8),
(12, 0, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`id_beli`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `jual`
--
ALTER TABLE `jual`
  ADD PRIMARY KEY (`id_jual`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_logs`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD UNIQUE KEY `id_barang` (`id_barang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `beli`
--
ALTER TABLE `beli`
  MODIFY `id_beli` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jual`
--
ALTER TABLE `jual`
  MODIFY `id_jual` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id_logs` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beli`
--
ALTER TABLE `beli`
  ADD CONSTRAINT `beli_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jual`
--
ALTER TABLE `jual`
  ADD CONSTRAINT `jual_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
