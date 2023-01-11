<?php

require_once("../../common/php/DBConnector.php");

$connMySQL = new ConnectionMySQL();
$pdo = $connMySQL->getConnection();
$foreignTableStmt = $pdo->prepare("SELECT tanimale.codice AS id, tparco.nomeParco AS parco FROM tanimale INNER JOIN tparco ON tparco.id = tanimale.idParco WHERE tanimale.idSpecieAnimale = " . $_REQUEST['specie']);
$foreignTableStmt->execute();
$foreignTable = $foreignTableStmt->fetchAll();

echo json_encode($foreignTable);
