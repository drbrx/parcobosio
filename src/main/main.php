<html>

<head>
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

        <a class="btn btn-info" href="../../index.php" role="button">Cambia parco...</a>

        <?php
        require_once("../common/php/DBConnector.php");
        if (isset($_REQUEST['park'])) {
            $_SESSION['park_id'] = $_REQUEST['park'];
        } else if (!isset($_SESSION['park'])) {
            $_SESSION['park_id'] = 0;
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

                            $found1 = false;
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
                                        if (!$found1) {
                                            echo "<b>Animali:</b><br>";
                                            $found1 = true;
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

                            $found2 = false;
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
                                        if (!$found2) {
                                            echo "<b>Piante:</b><br>";
                                            $found2 = true;
                                        }
                                        echo  $species['nomeSpeciePianta'] . ": " . $illPlants . "/" . $allPlants . " (" . round($illPlants / $allPlants * 100, 0) . "% degli esemplari NON sono in buona salute)<br>";
                                    }
                                }
                            }

                            if (!$found1 && !$found2) {
                                echo "Non sono state trovate specie in via d'estinzione";
                            }

                            ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Contare le nascite di una certa specie in un certo anno
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form id="q3form">
                                <select name="specie" id="" required>
                                    <option value="-1">Selezionare la specie</option>
                                    <?php
                                    $connMySQL = new ConnectionMySQL();
                                    $pdo = $connMySQL->getConnection();
                                    $foreignTableStmt = $pdo->prepare("SELECT id, nomeSpecieAnimale FROM tspecieanimale");
                                    $foreignTableStmt->execute();
                                    $foreignTable = $foreignTableStmt->fetchAll();

                                    foreach ($foreignTable as $species) {
                                        echo "<option value='" . $species['id'] . "'>" . $species['nomeSpecieAnimale'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="number" name="anno" placeholder="Selezionare l'anno" value="<?php echo date("Y"); ?>" required>
                                <input type="submit" value="Cerca">
                            </form>
                            <div id="q3response">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Contare e visualizzare le specie diarbusti in una regione
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Seleziona la regione in cui cercare:
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                $connMySQL = new ConnectionMySQL();
                                $pdo = $connMySQL->getConnection();
                                $foreignTableStmt = $pdo->prepare("SELECT id, nomeRegione FROM tregione");
                                $foreignTableStmt->execute();
                                $foreignTable = $foreignTableStmt->fetchAll();

                                foreach ($foreignTable as $region) {
                                    echo "<li><a class=\"dropdown-item\" onclick=\"q4(" . $region['id'] . ")\">" . $region['nomeRegione'] . "</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <div id="showQ4">

                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Contare le specie di pino in una regione
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Seleziona la regione in cui cercare:
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                $connMySQL = new ConnectionMySQL();
                                $pdo = $connMySQL->getConnection();
                                $foreignTableStmt = $pdo->prepare("SELECT id, nomeRegione FROM tregione");
                                $foreignTableStmt->execute();
                                $foreignTable = $foreignTableStmt->fetchAll();

                                foreach ($foreignTable as $region) {
                                    echo "<li><a class=\"dropdown-item\" onclick=\"q5(" . $region['id'] . ")\">" . $region['nomeRegione'] . "</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <div id="showQ5">

                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Trovare che parte degli animali dei parchi di una regione sono cuccioli </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Seleziona la regione in cui cercare: </button>
                            <ul class="dropdown-menu">
                                <?php
                                $connMySQL = new ConnectionMySQL();
                                $pdo = $connMySQL->getConnection();
                                $foreignTableStmt = $pdo->prepare("SELECT id, nomeRegione FROM tregione");
                                $foreignTableStmt->execute();
                                $foreignTable = $foreignTableStmt->fetchAll();

                                foreach ($foreignTable as $region) {
                                    echo "<li><a class=\"dropdown-item\" onclick=\"q6(" . $region['id'] . ")\">" . $region['nomeRegione'] . "</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <div id="showQ6">

                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        Visualizzare l'esemplare più anziano di ogni specie in un parco </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="btn-group dropdown">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Selezionare il parco </button>
                            <ul class="dropdown-menu">
                                <?php
                                $connMySQL = new ConnectionMySQL();
                                $pdo = $connMySQL->getConnection();
                                $foreignTableStmt = $pdo->prepare("SELECT id, nomeParco FROM tparco");
                                $foreignTableStmt->execute();
                                $foreignTable = $foreignTableStmt->fetchAll();

                                foreach ($foreignTable as $parco) {
                                    echo "<li><a class=\"dropdown-item\" onclick=\"q7(" . $parco['id'] . ")\">" . $parco['nomeParco'] . "</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
                        <div id="showQ7">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

<script>
    $(document).ready(function() {
        $('#q3form').on('submit', function(e) {
            e.preventDefault();
            var formDataSer = $(this).serialize();
            var formData = $.parseJSON('{"' + formDataSer.replace(/&/g, '","').replace(/=/g, '":"') + '"}');
            console.log(formDataSer);
            console.log(formData);
            if (formData.specie >= 0) {

                $.ajax({
                    type: 'GET',
                    url: './php/q3.php',
                    data: formDataSer,
                    success: function(response) {
                        $('#q3response').html("Sono state stimate <b>" + response + "</b> nascite nel " + formData.anno);
                    }
                });
            } else {
                alert("Scelgiere una specie valida e ritentare la ricerca");
            }

        });
    });

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
                    if (queryResponse.length > 0) {
                        $("#showQ1table").html("<th>codice</th><th>parco</th>");

                        for (let i = 0; i < queryResponse.length; i++) {
                            console.log(i);
                            $("#showQ1table").append("<tr><td>" + queryResponse[i].id + "</td><td>" + queryResponse[i].parco + "</td></tr>");
                        };
                    } else {
                        $("#showQ1table").html("Non sono stati trovati esemplari");
                    }

                }

            },

        })
    }

    function q4(idRegione) {
        $.ajax({
            type: 'GET',
            url: "./php/q4.php",
            data: {
                regione: idRegione
            },
            success: function(q4Response) {
                if (q4Response != "") {
                    console.log(q4Response);
                    q4Response = JSON.parse(q4Response);
                    console.log(q4Response);

                    $("#showQ4").html("<b>Totale</b><br>" + q4Response.length + "<table id=\"showQ4table\"></table>");
                    if (q4Response.length > 0) {
                        $("#showQ4table").html("<th>Specie</th>");
                        for (let j = 0; j < q4Response.length; j++) {
                            $("#showQ4table").append("<tr><td>" + q4Response[j].specie + "</td></tr>");
                        };
                    }

                }

            },

        })
    }

    function q5(idRegione) {
        $.ajax({
            type: 'GET',
            url: "./php/q5.php",
            data: {
                regione: idRegione
            },
            success: function(q5Response) {
                if (q5Response != "") {
                    console.log(q5Response);
                    q5Response = JSON.parse(q5Response);
                    console.log(q5Response);

                    $("#showQ5").html("<table id=\"showQ5table\"></table>");
                    if (q5Response.length > 0) {
                        $("#showQ5table").html("<th>Parco</th><th>Speci di pino</th>");
                        for (let k = 0; k < q5Response.length; k++) {
                            if (q5Response[k].piniCount > 0) {
                                $("#showQ5table").append("<tr><td>" + q5Response[k].parco + "</td><td>" + q5Response[k].piniCount + "</td></tr>");
                            }
                        };
                    } else {
                        $("#showQ5").html("Non sono stati trovati pini nella regione selezionata");
                    }

                } else {
                    $("#showQ5").html("Non sono stati trovati pini nella regione selezionata");
                }

            },

        })
    }

    function q6(idRegione) {
        $.ajax({
            type: 'GET',
            url: "./php/q6.php",
            data: {
                regione: idRegione
            },
            success: function(q6Response) {
                if (q6Response.includes("%")) {
                    console.log(q6Response);

                    $("#showQ6").html("Nella regione selezionata il <b>" + q6Response + "</b> degli esemplari di animali sono cuccioli");

                } else {
                    $("#showQ6").html(q6Response);
                }

            },
        })
    }

    function q7(idParco) {
        $.ajax({
            type: 'GET',
            url: "./php/q7.php",
            data: {
                parco: idParco
            },
            success: function(q7Response) {
                if (q7Response != "") {
                    console.log(q7Response);
                    q7Response = JSON.parse(q7Response);
                    console.log(q7Response);

                    $("#showQ7").html("<table id=\"showQ7table\"></table>");
                    if (q7Response.length > 0) {
                        $("#showQ7table").html("<th>Specie</th><th>Codice esemplare</th><th>Anno</th><th>Mese</th><th>Giorno</th>");
                        for (let h = 0; h < q7Response.length; h++) {
                            $("#showQ7table").append("<tr><td>" + q7Response[h].specie + "</td><td>" + q7Response[h].codice + "</td><td>" + q7Response[h].y + "</td><td>" + q7Response[h].m + "</td><td>" + q7Response[h].d + "</td></tr>");
                        };
                    } else {
                        $("#showQ7table").html("Non sono stati trovati esemplari nel parco selezionato");
                    }

                }

            },

        })
    }
</script>

<?php

function showTable($configInfo, $table)
{
    echo "<div class=\"d-flex align-items-center flex-column justify-content-start\" style=\"height: 70%;\">
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

    $returnArray = array();
    foreach ($foreignTableStmtResponse as $row) {
        $returnArray += [$row['id'] => $row[$configInfo['t' . $tableName . 'MAINFIELD']]];
    }
    return $returnArray;
}

?>