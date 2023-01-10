-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 10, 2023 alle 10:49
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.1.12

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
-- Struttura della tabella `tanimale`
--

CREATE TABLE `tanimale` (
  `id` int(11) NOT NULL,
  `statoSalute` tinyint(1) NOT NULL,
  `idSpecieAnimale` int(11) NOT NULL,
  `sesso` varchar(1) NOT NULL,
  `giornoNascitaStimato` int(11) DEFAULT NULL,
  `meseNascitaStimato` int(11) DEFAULT NULL,
  `annoNascitaStimato` int(11) DEFAULT NULL,
  `idParco` int(11) NOT NULL,
  `codice` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tanimale`
--

INSERT INTO `tanimale` (`id`, `statoSalute`, `idSpecieAnimale`, `sesso`, `giornoNascitaStimato`, `meseNascitaStimato`, `annoNascitaStimato`, `idParco`, `codice`) VALUES
(1, 0, 2, 'f', 7, 8, 20, 3, 'codAn1'),
(2, 0, 1, 'm', 8, 0, 21, 0, 'aaa1'),
(3, 0, 2, 'f', 0, 0, 0, 0, 'ababab'),
(4, 0, 2, 'f', 0, 0, 0, 0, 'ababab');

-- --------------------------------------------------------

--
-- Struttura della tabella `tcategoria`
--

CREATE TABLE `tcategoria` (
  `id` int(11) NOT NULL,
  `nomeCategoria` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tcategoria`
--

INSERT INTO `tcategoria` (`id`, `nomeCategoria`) VALUES
(1, 'cat1'),
(2, 'cat2');

-- --------------------------------------------------------

--
-- Struttura della tabella `tordine`
--

CREATE TABLE `tordine` (
  `id` int(11) NOT NULL,
  `nomeOrdine` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tordine`
--

INSERT INTO `tordine` (`id`, `nomeOrdine`) VALUES
(1, 'ord1'),
(2, 'ord2');

-- --------------------------------------------------------

--
-- Struttura della tabella `tparco`
--

CREATE TABLE `tparco` (
  `id` int(11) NOT NULL,
  `nomeParco` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tparco`
--

INSERT INTO `tparco` (`id`, `nomeParco`) VALUES
(1, 'Parco Rosso'),
(2, 'Parco Verde'),
(3, 'Parco Giallo');

-- --------------------------------------------------------

--
-- Struttura della tabella `tpianta`
--

CREATE TABLE `tpianta` (
  `id` int(11) NOT NULL,
  `statoSalute` tinyint(1) NOT NULL,
  `idSpeciePianta` int(11) NOT NULL,
  `giornoNascitaStimato` int(11) DEFAULT NULL,
  `meseNascitaStimato` int(11) DEFAULT NULL,
  `annoNascitaStimato` int(11) DEFAULT NULL,
  `idParco` int(11) NOT NULL,
  `codice` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tpianta`
--

INSERT INTO `tpianta` (`id`, `statoSalute`, `idSpeciePianta`, `giornoNascitaStimato`, `meseNascitaStimato`, `annoNascitaStimato`, `idParco`, `codice`) VALUES
(1, 0, 1, 0, 0, 0, 0, 'codice'),
(2, 0, 2, 4, 0, 0, 3, 'cad');

-- --------------------------------------------------------

--
-- Struttura della tabella `tregione`
--

CREATE TABLE `tregione` (
  `id` int(11) NOT NULL,
  `nomeRegione` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tregione`
--

INSERT INTO `tregione` (`id`, `nomeRegione`) VALUES
(1, 'reg1'),
(2, 'reg2');

-- --------------------------------------------------------

--
-- Struttura della tabella `tspecieanimale`
--

CREATE TABLE `tspecieanimale` (
  `id` int(11) NOT NULL,
  `nomeSpecieAnimale` varchar(64) NOT NULL,
  `idOrdine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tspecieanimale`
--

INSERT INTO `tspecieanimale` (`id`, `nomeSpecieAnimale`, `idOrdine`) VALUES
(1, 'specA1', 2),
(2, 'specA2', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `tspeciepianta`
--

CREATE TABLE `tspeciepianta` (
  `id` int(11) NOT NULL,
  `nomeSpeciePianta` varchar(64) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `periodoFioritura` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tspeciepianta`
--

INSERT INTO `tspeciepianta` (`id`, `nomeSpeciePianta`, `idCategoria`, `periodoFioritura`) VALUES
(1, 'specP1', 2, 'estate'),
(2, 'specP2', 1, 'inverno');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `tanimale`
--
ALTER TABLE `tanimale`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tcategoria`
--
ALTER TABLE `tcategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tordine`
--
ALTER TABLE `tordine`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tparco`
--
ALTER TABLE `tparco`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tpianta`
--
ALTER TABLE `tpianta`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tregione`
--
ALTER TABLE `tregione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tspecieanimale`
--
ALTER TABLE `tspecieanimale`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tspeciepianta`
--
ALTER TABLE `tspeciepianta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `tanimale`
--
ALTER TABLE `tanimale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `tcategoria`
--
ALTER TABLE `tcategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `tordine`
--
ALTER TABLE `tordine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `tparco`
--
ALTER TABLE `tparco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `tpianta`
--
ALTER TABLE `tpianta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `tregione`
--
ALTER TABLE `tregione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `tspecieanimale`
--
ALTER TABLE `tspecieanimale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `tspeciepianta`
--
ALTER TABLE `tspeciepianta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
