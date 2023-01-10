-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2023 at 08:18 PM
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

--
-- Dumping data for table `tanimale`
--

INSERT INTO `tanimale` (`id`, `idSpecieAnimale`, `idParco`, `sesso`, `statoSalute`, `giornoNascitaStimato`, `meseNascitaStimato`, `annoNascitaStimato`, `cucciolo`, `codice`) VALUES
(2, 1, 2, 'f', 0, 1, 1, 1000, 0, '2'),
(3, 2, 3, 'm', 0, 5, 5, 4567, 0, 'kjh'),
(4, 3, 1, 'f', 0, 1, 1, 0, 0, 'cod'),
(5, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(6, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(7, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(8, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(9, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(10, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(11, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(12, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(13, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(14, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(15, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(16, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(17, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(18, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(19, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(20, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(21, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(22, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(23, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(24, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(25, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(26, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(27, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(28, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(29, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(30, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(31, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(32, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(33, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(34, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(35, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(36, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(37, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(38, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(39, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(40, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(41, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(42, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(43, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(44, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(45, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(46, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(47, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(48, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(49, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(50, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(51, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(52, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(53, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(54, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(55, 2, 3, 'f', 1, 4, 8, 2020, 0, '10011001'),
(57, 1, 1, 'f', 0, 1, 1, 0, 0, 'ca'),
(58, 1, 1, 'm', 0, 1, 1, 0, 0, 'cc'),
(59, 2, 0, 'f', 0, 1, 1, 0, 0, 'ccc'),
(60, 2, 4, 'm', 0, 5, 5, 1000, 0, 'code');

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

--
-- Dumping data for table `tpianta`
--

INSERT INTO `tpianta` (`id`, `idSpeciePianta`, `idParco`, `statoSalute`, `giornoNascitaStimato`, `meseNascitaStimato`, `annoNascitaStimato`, `codice`) VALUES
(1, 0, -2, 0, 1, 1, 2000, 'codex12121'),
(2, 2, 1, 0, NULL, NULL, NULL, '2112'),
(3, 1, 2, 0, NULL, NULL, NULL, '2112'),
(4, 1, 2, 0, NULL, NULL, NULL, '2112'),
(5, 1, 2, 0, NULL, NULL, NULL, '2112'),
(6, 1, 2, 0, NULL, NULL, NULL, '2112'),
(7, 5, 2, 0, NULL, NULL, NULL, '2112'),
(8, 1, 2, 0, NULL, NULL, NULL, '2112'),
(9, 1, 2, 0, NULL, NULL, NULL, '2112'),
(10, 1, 2, 0, NULL, NULL, NULL, '2112'),
(11, 1, 2, 0, NULL, NULL, NULL, '2112'),
(12, 6, 2, 0, NULL, NULL, NULL, '2112'),
(13, 1, 2, 0, NULL, NULL, NULL, '2112'),
(14, 1, 2, 0, NULL, NULL, NULL, '2112'),
(15, 1, 2, 0, NULL, NULL, NULL, '2112'),
(16, 1, 2, 0, NULL, NULL, NULL, '2112'),
(17, 1, 2, 0, NULL, NULL, NULL, '2112'),
(18, 1, 2, 0, NULL, NULL, NULL, '2112'),
(19, 1, 2, 0, NULL, NULL, NULL, '2112'),
(20, 1, 2, 0, NULL, NULL, NULL, '2112'),
(21, 1, 2, 0, NULL, NULL, NULL, '2112'),
(22, 5, 2, 0, NULL, NULL, NULL, '2112'),
(23, 1, 2, 1, NULL, NULL, NULL, '2112'),
(24, 1, 2, 0, NULL, NULL, NULL, '2112'),
(25, 1, 2, 0, NULL, NULL, NULL, '2112'),
(26, 1, 1, 0, NULL, NULL, NULL, '2112'),
(27, 1, 2, 0, NULL, NULL, NULL, '2112'),
(28, 1, 2, 0, NULL, NULL, NULL, '2112'),
(29, 1, 2, 0, NULL, NULL, NULL, '2112'),
(30, 1, 2, 0, NULL, NULL, NULL, '2112'),
(31, 1, 2, 0, NULL, NULL, NULL, '2112'),
(32, 1, 2, 0, NULL, NULL, NULL, '2112'),
(33, 1, 2, 0, NULL, NULL, NULL, '2112'),
(34, 1, 2, 0, NULL, NULL, NULL, '2112'),
(35, 1, 2, 0, NULL, NULL, NULL, '2112'),
(36, 1, 2, 0, NULL, NULL, NULL, '2112'),
(37, 1, 2, 0, NULL, NULL, NULL, '2112'),
(38, 1, 2, 0, NULL, NULL, NULL, '2112'),
(39, 1, 2, 0, NULL, NULL, NULL, '2112'),
(40, 1, 2, 0, NULL, NULL, NULL, '2112'),
(41, 1, 2, 0, NULL, NULL, NULL, '2112'),
(42, 1, 2, 0, NULL, NULL, NULL, '2112'),
(43, 1, 2, 0, NULL, NULL, NULL, '2112'),
(44, 1, 2, 0, NULL, NULL, NULL, '2112'),
(45, 1, 2, 0, NULL, NULL, NULL, '2112'),
(46, 1, 2, 0, NULL, NULL, NULL, '2112'),
(47, 1, 2, 0, NULL, NULL, NULL, '2112'),
(48, 1, 2, 0, NULL, NULL, NULL, '2112'),
(49, 2, 4, 0, 11, 9, 4567, 'cod');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tregione`
--
ALTER TABLE `tregione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tspecieanimale`
--
ALTER TABLE `tspecieanimale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tspeciepianta`
--
ALTER TABLE `tspeciepianta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
