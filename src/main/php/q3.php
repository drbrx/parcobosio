<?php
require_once("../../common/php/DBConnector.php");

$connMySQL = new ConnectionMySQL();
$pdo = $connMySQL->getConnection();
$plantStmt = $pdo->prepare("SELECT count(id) AS bornCount FROM tanimale WHERE tanimale.idSpecieAnimale = " . $_REQUEST["specie"] . " AND tanimale.annoNascitaStimato = " . $_REQUEST["anno"]);
$plantStmt->execute();
echo $plantStmt->fetchAll()[0]['bornCount'];
