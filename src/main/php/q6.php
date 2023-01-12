<?php

require_once("../../common/php/DBConnector.php");

$connMySQL = new ConnectionMySQL();
$pdo = $connMySQL->getConnection();
$foreignTableStmt = $pdo->prepare("SELECT tanimale.idSpecieAnimale AS specie, tanimale.cucciolo AS cucciolo FROM tanimale INNER JOIN tparco ON tparco.id = tanimale.idParco INNER JOIN tregione ON tparco.idRegione = tregione.id WHERE tregione.id = " . $_REQUEST["regione"]);

$foreignTableStmt->execute();
$record = $foreignTableStmt->fetchAll();
//echo var_dump($record) . "1x1x1x1x1x1";

$listaAnimali = array();

foreach ($record as $animale) {
    if (!isset($listaAnimali[$animale['specie']])) {
        $listaAnimali += [$animale['specie'] => [0 => 0, 1 => 0]];
    };
    $listaAnimali[$animale['specie']][$animale['cucciolo']] += 1;
    //echo var_dump($listaAnimali) . "2x2x2x2x2x2";
}

$total = 0;
foreach ($listaAnimali as $specie) {
    $total += $specie[1] / ($specie[0] + $specie[1]);
}
if (count($listaAnimali) > 0) {
    echo ($total / count($listaAnimali)) * 100 . "%";
} else {
    echo "Non sono stati trovati dati sugli animali nei parchi della regione selezionata";
}
