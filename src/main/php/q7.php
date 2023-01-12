 <?php

    require_once("../../common/php/DBConnector.php");
    $result = array();

    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $tableStmt = $pdo->prepare("SELECT id FROM tspecieanimale");
    $tableStmt->execute();
    $tableStmtResult = $tableStmt->fetchAll();

    foreach ($tableStmtResult as $specie) {
        $connMySQL = new ConnectionMySQL();
        $pdo = $connMySQL->getConnection();
        $foreignTableStmt = $pdo->prepare("SELECT codice, nomeSpecieAnimale AS specie, annoNascitaStimato AS y, meseNascitaStimato AS m, giornoNascitaStimato AS d FROM tanimale INNER JOIN tspecieanimale ON tspecieanimale.id = tanimale.idSpecieAnimale  WHERE idSpecieAnimale = " . $specie["id"] . " AND idParco = " . $_REQUEST["parco"] . " ORDER BY tanimale.annoNascitaStimato ASC, tanimale.meseNascitaStimato ASC, tanimale.giornoNascitaStimato ASC LIMIT 1");

        $foreignTableStmt->execute();
        $record = $foreignTableStmt->fetchAll();

        if (isset($record[0]) && (isset($record[0]["y"]) || isset($record[0]["m"]) || isset($record[0]["d"]))) {
            $result[] = $record[0];
        }
    }

    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $tableStmt = $pdo->prepare("SELECT id FROM tspeciepianta");
    $tableStmt->execute();
    $tableStmtResult = $tableStmt->fetchAll();

    foreach ($tableStmtResult as $specie) {
        $connMySQL = new ConnectionMySQL();
        $pdo = $connMySQL->getConnection();
        $foreignTableStmt = $pdo->prepare("SELECT codice, nomeSpeciePianta AS specie, annoNascitaStimato AS y, meseNascitaStimato AS m, giornoNascitaStimato AS d FROM tpianta INNER JOIN tspeciepianta ON tspeciepianta.id = tpianta.idSpeciePianta WHERE idSpeciePianta = " . $specie["id"] . " AND idParco = " . $_REQUEST["parco"] . " ORDER BY tpianta.annoNascitaStimato ASC, tpianta.meseNascitaStimato ASC, tpianta.giornoNascitaStimato ASC LIMIT 1");

        $foreignTableStmt->execute();
        $record = $foreignTableStmt->fetchAll();

        if (isset($record[0]) && (isset($record[0]["y"]) || isset($record[0]["m"]) || isset($record[0]["d"]))) {
            $result[] = $record[0];
        }
    }

    echo json_encode($result);
