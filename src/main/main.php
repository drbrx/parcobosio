<html>

<head>
    <!--<link rel="stylesheet" href="css/main.css">-->
    <link rel="stylesheet" href="../common/css/sidebar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>PHPYourAdmin Control Panel</title>
</head>

<body>
    <div class="sidebar" style="width:10%; float: left">
        <div class="sidebarButtonCurrent"><a href="main.php">View</a></div>
        <div class="sidebarButton"><a href="../insert/insert.php">Insert</a></div>
    </div>

    <div style="float: left; width: 90%; background-color: #272a2e">
        <!--<div id="searchBarWrapper" class="d-flex align-items-center" style="height: 50%;">
            <div id="searchBar" class="container">
                <form action="main.php" class="input-group input-group-lg">
                    <input type="text" placeholder="Search globally across all fields and records" name="search" class="form-control">
                    <button type="submit" class="btn btn-outline-primary" type="button">Search</button>
                </form>
            </div>
        </div>-->

        <a class="btn btn-info" href="../../index.php" role="button">Cambia parco...</a>

        <?php
        require_once("../common/php/DBConnector.php");
        if (isset($_REQUEST['park'])) {
            $_SESSION['park_id'] = $_REQUEST['park'];
        } else if (!isset($_SESSION['park'])) {
            $_SESSION['park_id'] = 0;
        }

        if (is_array($_SESSION['table_name'])) { //multiple table functionality
            $tableIndex = 0;
            foreach ($_SESSION['table_name'] as $table) {
                //echo $table;
                if (isset($configInfo[$table . "PERMISSIONS"]) && $configInfo[$table . "PERMISSIONS"] != "none") {
                    $currentConfig = array();
                    foreach (array_keys($configInfo) as $configKey) {
                        $currentConfig += [$configKey => is_array($configInfo[$configKey]) ? $configInfo[$configKey][$tableIndex] : $configInfo[$configKey]];
                    }
                    showTable($currentConfig, $_SESSION["table_name"][$tableIndex]);
                }
                $tableIndex++;
            }
        } else {
            showTable($configInfo, $_SESSION["table_name"]);
        }

        ?>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Elenca tutti gli esemplari di animale di una certa specie e in che parco si trovano
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Seleziona la specie di fauna da cercare:
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                $connMySQL = new ConnectionMySQL();
                                $pdo = $connMySQL->getConnection();
                                $foreignTableStmt = $pdo->prepare("SELECT id, nomeSpecieAnimale FROM tspecieanimale");
                                $foreignTableStmt->execute();
                                $foreignTable = $foreignTableStmt->fetchAll();

                                foreach ($foreignTable as $species) {
                                    echo "<li><a class=\"dropdown-item\" onclick=\"q1(" . $species['id'] . ")\">" . $species['nomeSpecieAnimale'] . "</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <div id="showQ1">
                            <table id="showQ1table">

                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Elenco specie in via d'estizione (75% o più degli esemplari malati)
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php

                            $connMySQL = new ConnectionMySQL();
                            $pdo = $connMySQL->getConnection();
                            $animalStmt = $pdo->prepare("SELECT id, nomeSpecieAnimale FROM tspecieanimale");
                            $animalStmt->execute();
                            $animals = $animalStmt->fetchAll();

                            $found = false;
                            foreach ($animals as $species) {

                                $connMySQL = new ConnectionMySQL();
                                $pdo = $connMySQL->getConnection();
                                $allStmt = $pdo->prepare("select count(id) AS totCount FROM tanimale WHERE idSpecieAnimale = " . $species['id']);
                                $allStmt->execute();
                                $allAnimals = $allStmt->fetchAll()[0]['totCount'];

                                if ($allAnimals != 0) {
                                    $connMySQL = new ConnectionMySQL();
                                    $pdo = $connMySQL->getConnection();
                                    $illStmt = $pdo->prepare("SELECT count(id) AS totCount FROM tanimale WHERE idSpecieAnimale = " . $species['id'] . " AND statoSalute = 0");
                                    $illStmt->execute();
                                    $illAnimals = $illStmt->fetchAll()[0]['totCount'];

                                    if ($illAnimals / $allAnimals >= 0.75) {
                                        if (!$found) {
                                            echo "<b>Animali:</b><br>";
                                            $found = true;
                                        }
                                        echo  $species['nomeSpecieAnimale'] . ": " . $illAnimals . "/" . $allAnimals . " (" . round($illAnimals / $allAnimals * 100, 0) . "% degli esemplari NON sono in buona salute)<br>";
                                    }
                                }
                            }

                            $connMySQL = new ConnectionMySQL();
                            $pdo = $connMySQL->getConnection();
                            $plantStmt = $pdo->prepare("SELECT id, nomeSpeciePianta FROM tspeciepianta");
                            $plantStmt->execute();
                            $plants = $plantStmt->fetchAll();

                            $found = false;
                            foreach ($plants as $species) {

                                $connMySQL = new ConnectionMySQL();
                                $pdo = $connMySQL->getConnection();
                                $allStmt = $pdo->prepare("select count(id) AS totCount FROM tpianta WHERE idSpeciePianta = " . $species['id']);
                                $allStmt->execute();
                                $allPlants = $allStmt->fetchAll()[0]['totCount'];

                                if ($allPlants != 0) {
                                    $connMySQL = new ConnectionMySQL();
                                    $pdo = $connMySQL->getConnection();
                                    $illStmt = $pdo->prepare("SELECT count(id) AS totCount FROM tpianta WHERE idSpeciePianta = " . $species['id'] . " AND statoSalute = 0");
                                    $illStmt->execute();
                                    $illPlants = $illStmt->fetchAll()[0]['totCount'];

                                    if ($illPlants / $allPlants >= 0.75) {
                                        if (!$found) {
                                            echo "<b>Piante:</b><br>";
                                            $found = true;
                                        }
                                        echo  $species['nomeSpeciePianta'] . ": " . $illPlants . "/" . $allPlants . " (" . round($illPlants / $allPlants * 100, 0) . "% degli esemplari NON sono in buona salute)<br>";
                                    }
                                }
                            }

                            ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Elenco specie in via d'estizione (75% o più degli esemplari malati)
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            //
                        </div>
                    </div>
                </div>
            </div>

            /*
            input anno
            input specie
            SELECT count(id) AS bornCount FROM tanimale/pianta WHERE tanimale.idSpecieAnimale/Pianta = anno AND tanimale.annoNascitaStimato = anno
            */
            /*
            SELECT
            COUNT(
            DISTINCT tpianta.idSpeciePianta
            ) AS arbustiCount,
            tparco.nomeParco AS parco
            FROM
            tpianta
            INNER JOIN tspeciepianta ON tspeciepianta.id = tpianta.idSpeciePianta
            INNER JOIN tgenere ON tgenere.id = tspeciepianta.idGenere
            INNER JOIN tparco ON tparco.id = 1
            WHERE
            tpianta.idParco = 1 AND tgenere.idCategoria = 2;
            */
            /*
            SELECT
            COUNT(
            DISTINCT tpianta.idSpeciePianta
            ) AS piniCount,
            tparco.nomeParco AS parco
            FROM
            tpianta
            INNER JOIN tspeciepianta ON tspeciepianta.id = tpianta.idSpeciePianta
            INNER JOIN tgenere ON tgenere.id = tspeciepianta.idGenere
            INNER JOIN tparco ON tparco.id = 2
            WHERE
            tpianta.idParco = 2 AND tgenere.nomeGenere = 'Pino';
            */
            /*
            listaAnimali = array();
            SELECT
            tanimale.id AS esemplare,
            tanimale.idSpecieAnimale AS specie,
            tanimale.cucciolo AS cucciolo
            FROM
            tanimale
            INNER JOIN tspecieanimale ON tspecieanimale.id = tanimale.idSpecieAnimale
            INNER JOIN tparco ON tparco.id = tanimale.idParco
            INNER JOIN tregione ON tparco.idRegione = tregione.id
            WHERE
            tregione.id = ?;
            foreach(result){
            if(!isset(listaAnimali[result['specie']])){
            listaAnimali += ['result['specie']' => array(
            '1' => 0,
            '0' => 0
            )]}
            listaAnimali[result['specie']][result['cucciolo']] += 1;
            }
            $total = 0;
            foreach(listaAnimali){
            $total += listaAnimali[1] / (listaAnimali[0] + listaAnimali[1]);
            }
            echo $total/count(listaAnimali)
            */
            /*
            SELECT id, annoNascitaStimato, meseNascitaStimato, giornoNascitaStimato
            FROM tanimale
            ORDER BY tanimale.annoNascitaStimato ASC, tanimale.meseNascitaStimato ASC, tanimale.giornoNascitaStimato ASC
            LIMIT 1;
            SELECT id, annoNascitaStimato, meseNascitaStimato, giornoNascitaStimato
            FROM tpianta
            ORDER BY tanimale.annoNascitaStimato ASC, tanimale.meseNascitaStimato ASC, tanimale.giornoNascitaStimato ASC
            LIMIT 1;
            echo max(results)
            */
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

<script>
    function q1(idSpecie) {
        $.ajax({
            type: 'GET',
            url: "./php/q1.php",
            data: {
                specie: idSpecie
            },
            success: function(queryResponse) {
                if (queryResponse != "") {
                    queryResponse = JSON.parse(queryResponse);
                    console.log(queryResponse);
                    $("#showQ1table").html("<th>codice</th><th>parco</th>");

                    for (let i = 0; i < queryResponse.length; i++) {
                        console.log(i);
                        $("#showQ1table").append("<tr><td>" + queryResponse[i].id + "</td><td>" + queryResponse[i].parco + "</td></tr>");
                    };
                }

            },

        })
    }
</script>

<?php

function showTable($configInfo, $table)
{
    echo "<div class=\"d-flex align-items-center flex-column justify-content-start\" style=\"height: 50%;\">
            <div id=\"tableWrapper\" class=\"container-md\">";
    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $maxReads = $_SESSION['rowsPerPage'];
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
    //echo "SELECT * FROM $table " . (isset($_REQUEST['search']) ? "WHERE" . generateFilter($_REQUEST['search'], $table, $configInfo) : "") . "LIMIT $maxReads OFFSET " . ($page != 0 ? (($page * $maxReads) - 1) : 0);
    $stmt = $pdo->prepare("SELECT * FROM $table " . (isset($_REQUEST['search']) ? "WHERE" . generateFilter($_REQUEST['search'], $table, $configInfo) : "") . "LIMIT $maxReads OFFSET " . ($page != 0 ? ($page * $maxReads) : 0));
    $stmt->execute();
    $stmtResponse = $stmt->fetchAll();
    $stmt = $pdo->prepare("SELECT * FROM $table " . (isset($_REQUEST['search']) ? "WHERE" . generateFilter($_REQUEST['search'], $table, $configInfo) : ""));
    $stmt->execute();
    $maxPages = ceil(count($stmt->fetchAll()) / $maxReads);
    if ($maxPages > 0) {
        echo "  <table class=\"table table-dark table-hover\">
                        <thead>
                        <tr class=\"table-primary\"><th scope=\"col\">id</th>     
                        <th scope=\"col\">" . $configInfo[$table . 'MAINFIELD'] . "</th>
                        <th scope=\"col\"></th>
                    </tr> </thead>";
        foreach ($stmtResponse as $currentRecord) {
            if (isset($configInfo[$configInfo[$table . 'MAINFIELD'] . "EXTERNAL"]) && $configInfo[$configInfo[$table . 'MAINFIELD'] . "EXTERNAL"]) {
                $foreignTable = getForeignValues(strtolower(str_replace("id", '', $configInfo[$table . 'MAINFIELD'])), $configInfo);
            }
            echo    "<tr><td><p class=\"fw-bold\">" . $currentRecord['id'] . "</p></td>
                    <td>" . (isset($foreignTable) ? $foreignTable[$currentRecord[$configInfo[$table . 'MAINFIELD']]] : $currentRecord[$configInfo[$table . 'MAINFIELD']]) . "</td>
                    <td><a class=\"btn btn-primary\" href=\"../details/details.php?id=" . $currentRecord['id'] . "&table=" . $table . "\" role=\"button\">Details</a></td>
                    </tr>";
        }
        echo "</table>
                          </div>";
    } else {
        echo "<p style=\"color: white;\">Non sono stati trovati dati in " . $table . ". Prova con un filtro diverso se ne stai usando uno.</p>";
    }
    echo "
                <div id=\"pageWrapper\">
                    <a class=\"btn btn-dark\" role=\"button\" href=\"main.php?" . (isset($_REQUEST['search']) ? "search=" . $_REQUEST['search'] . "&" : "") . "page=" . ($page - 1) . "\" id=\"previousPage\" class=\"pageButton\" style=\"visibility:" . ($page <= 0 ? 'hidden;' : 'visible;') . "\">Previous</a>
                    <a class=\"btn btn-dark\" role=\"button\" href=\"main.php?" . (isset($_REQUEST['search']) ? "search=" . $_REQUEST['search'] . "&" : "") . "page=" . ($page + 1) . "\" id=\"nextPage\" class=\"pageButton\" style=\"visibility:" . ($page >= ($maxPages - 1) ? 'hidden;' : 'visible;') . "\">Next</a>
                </div>
                </div>
    ";
}

function generateFilter($searchTerm, $tableName, $configInfo)
{
    $filter = "";

    $connMySQL = new ConnectionMySQL();
    $columnPdo = $connMySQL->getConnection();
    $comumnStmt = $columnPdo->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $tableName . "'");
    $comumnStmt->execute();
    $columnStmtResponse = $comumnStmt->fetchAll();

    foreach ($columnStmtResponse as $currentColumn) {
        if ($currentColumn["TABLE_SCHEMA"] == $_SESSION['db_name']) {
            if ($filter != "") {
                $filter .= "OR ";
            }
            if (isset($configInfo[$currentColumn["COLUMN_NAME"] . 'EXTERNAL']) && $configInfo[$currentColumn["COLUMN_NAME"] . 'EXTERNAL']) {

                $connMySQL = new ConnectionMySQL();
                $foreignPdo = $connMySQL->getConnection();
                $foreignStmt = $foreignPdo->prepare("SELECT id FROM t" . strtolower(str_replace("id", '', $currentColumn["COLUMN_NAME"])) . " WHERE " . $configInfo['t' . strtolower(str_replace("id", '', $currentColumn["COLUMN_NAME"])) . 'MAINFIELD'] . " LIKE '%" . $searchTerm . "%'");
                $foreignStmt->execute();
                $foreignStmtResponse = $foreignStmt->fetchAll();
                if (isset($foreignStmtResponse[0]['id'])) {
                    $filter .= "`" . $currentColumn["COLUMN_NAME"] . "` LIKE '%" . $foreignStmtResponse[0]['id'] . "%' ";
                } else {
                    $filter .= "`" . $currentColumn["COLUMN_NAME"] . "` LIKE '%" . $searchTerm . "%' ";
                }
            } else {
                $filter .= "`" . $currentColumn["COLUMN_NAME"] . "` LIKE '%" . $searchTerm . "%' ";
            }
        }
    }

    return $filter;
}

function getForeignValues($tableName, $configInfo)
{
    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $foreignTableStmt = $pdo->prepare("SELECT id, " . $configInfo['t' . $tableName . 'MAINFIELD'] . " FROM t" . $tableName);
    $foreignTableStmt->execute();
    $foreignTableStmtResponse = $foreignTableStmt->fetchAll();

    //echo var_dump($foreignTableStmtResponse);
    $returnArray = array();
    foreach ($foreignTableStmtResponse as $row) {
        $returnArray += [$row['id'] => $row[$configInfo['t' . $tableName . 'MAINFIELD']]];
    }
    return $returnArray;
}

?>