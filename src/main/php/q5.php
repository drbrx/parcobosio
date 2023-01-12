<?php

require_once("../../common/php/DBConnector.php");

$connMySQL = new ConnectionMySQL();
$pdo = $connMySQL->getConnection();
$tableStmt = $pdo->prepare("SELECT id FROM tparco WHERE idRegione = ".$_REQUEST["regione"]);
$tableStmt->execute();
$tableStmtResult = $tableStmt->fetchAll();

$result = array();
foreach ($tableStmtResult as $park) {
    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $foreignTableStmt = $pdo->prepare("SELECT COUNT(DISTINCT tpianta.idSpeciePianta) AS piniCount, tparco.nomeParco AS parco FROM tpianta INNER JOIN tspeciepianta ON tspeciepianta.id = tpianta.idSpeciePianta INNER JOIN tgenere ON tgenere.id = tspeciepianta.idGenere INNER JOIN tparco ON tparco.id = tpianta.idParco WHERE tpianta.idParco = 2 AND tparco.id = " . $park["id"] . " AND tgenere.nomeGenere LIKE 'Pino'");

    $foreignTableStmt->execute();
    $result[] = $foreignTableStmt->fetchAll()[0];
}

echo json_encode($result);
