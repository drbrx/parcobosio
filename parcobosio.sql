-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2023 at 01:41 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parcobosio`
--

-- --------------------------------------------------------

--
-- Table structure for table `tanimale`
--

CREATE TABLE `tanimale` (
  `id` int(11) NOT NULL,
  `idSpecieAnimale` int(11) NOT NULL,
  `idParco` int(11) NOT NULL,
  `sesso` varchar(1) NOT NULL,
  `statoSalute` tinyint(1) NOT NULL,
  `giornoNascitaStimato` int(11) DEFAULT NULL,
  `meseNascitaStimato` int(11) DEFAULT NULL,
  `annoNascitaStimato` int(11) DEFAULT NULL,
  `cucciolo` tinyint(1) NOT NULL,
  `codice` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tcategoria`
--

CREATE TABLE `tcategoria` (
  `id` int(11) NOT NULL,
  `nomeCategoria` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tcategoria`
--

INSERT INTO `tcategoria` (`id`, `nomeCategoria`) VALUES
(1, 'Albero'),
(2, 'Arbusto'),
(3, 'Pianta Erbacea');

-- --------------------------------------------------------

--
-- Table structure for table `tgenere`
--

CREATE TABLE `tgenere` (
  `id` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `nomeGenere` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tgenere`
--

INSERT INTO `tgenere` (`id`, `idCategoria`, `nomeGenere`) VALUES
(1, 2, 'Aloe'),
(2, 1, 'Pino');

-- --------------------------------------------------------

--
-- Table structure for table `tordine`
--

CREATE TABLE `tordine` (
  `id` int(11) NOT NULL,
  `nomeOrdine` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tordine`
--

INSERT INTO `tordine` (`id`, `nomeOrdine`) VALUES
(1, 'Mammiferi'),
(2, 'Pesci'),
(3, 'Uccelli'),
(4, 'Rettili'),
(5, 'Anfibi'),
(11, 'Poriferi'),
(12, 'Artropodi'),
(13, 'Celenterati'),
(14, 'Molluschi'),
(15, 'Vermi'),
(16, 'Echinodermi');

-- --------------------------------------------------------

--
-- Table structure for table `tparco`
--

CREATE TABLE `tparco` (
  `id` int(11) NOT NULL,
  `idRegione` int(11) NOT NULL,
  `nomeParco` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tparco`
--

INSERT INTO `tparco` (`id`, `idRegione`, `nomeParco`) VALUES
(1, 3, 'Parco Verde'),
(2, 8, 'Parco Giallo'),
(3, 20, 'Parco Rosso'),
(4, 13, 'Barco Blu'),
(5, 16, 'Parco Viola');

-- --------------------------------------------------------

--
-- Table structure for table `tpianta`
--

CREATE TABLE `tpianta` (
  `id` int(11) NOT NULL,
  `idSpeciePianta` int(11) NOT NULL,
  `idParco` int(11) NOT NULL,
  `statoSalute` tinyint(1) NOT NULL,
  `giornoNascitaStimato` int(11) DEFAULT NULL,
  `meseNascitaStimato` int(11) DEFAULT NULL,
  `annoNascitaStimato` int(11) DEFAULT NULL,
  `codice` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tregione`
--

CREATE TABLE `tregione` (
  `id` int(11) NOT NULL,
  `nomeRegione` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tregione`
--

INSERT INTO `tregione` (`id`, `nomeRegione`) VALUES
(1, 'Abruzzo'),
(2, 'Basilicata'),
(3, 'Calabria'),
(4, 'Campania'),
(5, 'Emilia-Romagna'),
(6, 'Friuli Venezia Giulia'),
(7, 'Lazio'),
(8, 'Liguria'),
(9, 'Lombardia'),
(10, 'Marche'),
(11, 'Molise'),
(12, 'Piemonte'),
(13, 'Puglia'),
(14, 'Sardegna'),
(15, 'Sicilia'),
(16, 'Toscana'),
(17, 'Trentino-Alto Adige'),
(18, 'Umbria'),
(19, 'Valle d\'Aosta'),
(20, 'Veneto');

-- --------------------------------------------------------

--
-- Table structure for table `tspecieanimale`
--

CREATE TABLE `tspecieanimale` (
  `id` int(11) NOT NULL,
  `nomeSpecieAnimale` varchar(64) NOT NULL,
  `idOrdine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tspecieanimale`
--

INSERT INTO `tspecieanimale` (`id`, `nomeSpecieAnimale`, `idOrdine`) VALUES
(1, 'Orso', 1),
(2, 'Vipera', 4),
(3, 'Falco', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tspeciepianta`
--

CREATE TABLE `tspeciepianta` (
  `id` int(11) NOT NULL,
  `nomeSpeciePianta` varchar(64) NOT NULL,
  `periodoFioritura` text NOT NULL,
  `idGenere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tspeciepianta`
--

INSERT INTO `tspeciepianta` (`id`, `nomeSpeciePianta`, `periodoFioritura`, `idGenere`) VALUES
(1, 'Aloe Vera', 'Estate', 1),
(2, 'Aloe Ferox', 'Estate', 1),
(3, 'Aloe Saponaria', 'Tarda Estate', 1),
(4, 'Pino Nero', 'Autunno', 2),
(5, 'Pino Silvestre', 'Inverno', 2),
(6, 'Pino Montano', 'Primavera', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tanimale`
--
ALTER TABLE `tanimale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tcategoria`
--
ALTER TABLE `tcategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tgenere`
--
ALTER TABLE `tgenere`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tordine`
--
ALTER TABLE `tordine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tparco`
--
ALTER TABLE `tparco`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tpianta`
--
ALTER TABLE `tpianta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tregione`
--
ALTER TABLE `tregione`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tspecieanimale`
--
ALTER TABLE `tspecieanimale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tspeciepianta`
--
ALTER TABLE `tspeciepianta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tanimale`
--
ALTER TABLE `tanimale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tcategoria`
--
ALTER TABLE `tcategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tgenere`
--
ALTER TABLE `tgenere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tordine`
--
ALTER TABLE `tordine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tparco`
--
ALTER TABLE `tparco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tpianta`
--
ALTER TABLE `tpianta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tregione`
--
ALTER TABLE `tregione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tspecieanimale`
--
ALTER TABLE `tspecieanimale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tspeciepianta`
--
ALTER TABLE `tspeciepianta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
