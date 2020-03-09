# Host: localhost  (Version 5.5.5-10.4.8-MariaDB)
# Date: 2020-03-09 10:15:28
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "admin"
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

#
# Data for table "admin"
#

INSERT INTO `admin` VALUES (1,'Admin','admin','21232f297a57a5a743894a0e4a801fc3');

#
# Structure for table "barang"
#

DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `idBarang` int(11) NOT NULL AUTO_INCREMENT,
  `kodeBarang` varchar(255) NOT NULL,
  `namaBarang` varchar(255) NOT NULL,
  PRIMARY KEY (`idBarang`),
  UNIQUE KEY `kodeBarang` (`kodeBarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "barang"
#


#
# Structure for table "detailtransaksi"
#

DROP TABLE IF EXISTS `detailtransaksi`;
CREATE TABLE `detailtransaksi` (
  `idDetailTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `noInvoice` varchar(255) NOT NULL DEFAULT '0',
  `kodeBarang` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idDetailTransaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "detailtransaksi"
#


#
# Structure for table "transaksi"
#

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `idTransaksi` int(11) NOT NULL AUTO_INCREMENT,
  `noInvoice` varchar(255) NOT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`idTransaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "transaksi"
#

