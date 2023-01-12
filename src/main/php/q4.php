<?php

require_once("../../common/php/DBConnector.php");

$connMySQL = new ConnectionMySQL();
$pdo = $connMySQL->getConnection();
$foreignTableStmt = $pdo->prepare("SELECT DISTINCT tspeciepianta.nomeSpeciePianta AS specie FROM tpianta INNER JOIN tspeciepianta ON tspeciepianta.id = tpianta.idSpeciePianta INNER JOIN tgenere ON tgenere.id = tspeciepianta.idGenere INNER JOIN tparco ON tparco.id = tpianta.idParco WHERE tgenere.idCategoria = 2 AND tparco.idRegione = " . $_REQUEST['regione']);

$foreignTableStmt->execute();
$foreignTable = $foreignTableStmt->fetchAll();

echo json_encode($foreignTable);
