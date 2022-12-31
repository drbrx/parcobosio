<html>

<head>
    <!--<link rel="stylesheet" href="css/main.css">-->
    <link rel="stylesheet" href="../common/css/sidebar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

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
