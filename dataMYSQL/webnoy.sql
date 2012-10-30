-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 30, 2012 at 11:56 PM
-- Server version: 5.1.61
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webnoy`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE IF NOT EXISTS `tb_barang` (
  `kd_brg` varchar(100) NOT NULL,
  `nama_brg` varchar(250) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `hrg_beli` double NOT NULL,
  `hrg_jual_grosir` double NOT NULL,
  `hrg_jual_retail` double NOT NULL,
  `stok` double NOT NULL,
  `kd_hrgbeli` varchar(250) NOT NULL,
  PRIMARY KEY (`kd_brg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_gdin`
--

CREATE TABLE IF NOT EXISTS `tb_gdin` (
  `kd_brg` varchar(100) NOT NULL,
  `nama_brg` varchar(250) NOT NULL,
  `tgl` date NOT NULL,
  `ket` varchar(250) NOT NULL,
  `gudang` varchar(250) NOT NULL,
  `no_do` varchar(100) NOT NULL,
  `jumlah` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kostumer`
--

CREATE TABLE IF NOT EXISTS `tb_kostumer` (
  `kd_kos` varchar(200) NOT NULL,
  `nama_kos` varchar(200) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `tlp` varchar(200) NOT NULL,
  PRIMARY KEY (`kd_kos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_suplier`
--

CREATE TABLE IF NOT EXISTS `tb_suplier` (
  `kd_sup` varchar(200) NOT NULL,
  `nama_sup` varchar(200) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `tlp` varchar(200) NOT NULL,
  PRIMARY KEY (`kd_sup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_trxbeli`
--

CREATE TABLE IF NOT EXISTS `tb_trxbeli` (
  `nota` varchar(200) NOT NULL,
  `kd_sup` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_trxbeli1`
--

CREATE TABLE IF NOT EXISTS `tb_trxbeli1` (
  `nota` varchar(200) NOT NULL,
  `kd_brg` varchar(200) NOT NULL,
  `hrg_beli` double NOT NULL,
  `hrg_jual_grosir` double NOT NULL,
  `hrg_jual_retail` double NOT NULL,
  `stok` double NOT NULL,
  `kd_hrgbeli` varchar(250) NOT NULL,
  `totalbeli` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_trxbeli2`
--

CREATE TABLE IF NOT EXISTS `tb_trxbeli2` (
  `kd_user` int(11) NOT NULL,
  `kd_brg` varchar(200) NOT NULL,
  `nama_brg` varchar(250) NOT NULL,
  `hrg_beli` double NOT NULL,
  `stok` double NOT NULL,
  `kd_hrgbeli` varchar(250) NOT NULL,
  `totalbeli` double NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_trxjual`
--

CREATE TABLE IF NOT EXISTS `tb_trxjual` (
  `nota` varchar(200) NOT NULL,
  `kd_kos` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `tgljatuhtempo` date NOT NULL,
  PRIMARY KEY (`nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_trxjual1`
--

CREATE TABLE IF NOT EXISTS `tb_trxjual1` (
  `nota` varchar(200) NOT NULL,
  `kd_brg` varchar(200) NOT NULL,
  `hrg_beli` double NOT NULL,
  `hrg_jual` double NOT NULL,
  `selisih` double NOT NULL,
  `stok` double NOT NULL,
  `kd_hrgbeli` varchar(250) NOT NULL,
  `totaljual` double NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_trxjual2`
--

CREATE TABLE IF NOT EXISTS `tb_trxjual2` (
  `urutan` int(11) NOT NULL,
  `kd_user` int(11) NOT NULL,
  `kd_brg` varchar(200) NOT NULL,
  `nama_brg` varchar(250) NOT NULL,
  `hrg_beli` double NOT NULL,
  `hrg_jual` double NOT NULL,
  `selisih` double NOT NULL,
  `stok` double NOT NULL,
  `kd_hrgbeli` varchar(250) NOT NULL,
  `totaljual` double NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `hrg_diskon` double NOT NULL,
  `nambah` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `kd_user` int(11) NOT NULL AUTO_INCREMENT,
  `namanya` varchar(200) NOT NULL,
  `passwordnya` varchar(200) NOT NULL,
  `aktivekah` tinyint(1) NOT NULL,
  PRIMARY KEY (`kd_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
