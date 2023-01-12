<head>
    <!--<link rel="stylesheet" href="css/insert.css">-->
    <link rel="stylesheet" href="../common/css/sidebar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>PHPYA Insert</title>

</head>
<?php
require_once("../common/php/DBConnector.php");
//echo var_dump($_SESSION);
?>

<body>
    <div class="sidebar" style="width:10%; float: left">
        <div class="sidebarButton"><a href="../main/main.php">View</a></div>
        <div class="sidebarButtonCurrent"><a href="">Insert</a></div>
    </div>

    <div style="float: left; width: 90%; background-color: #272a2e; height: 100%;">
        <?php
        if (is_array($_SESSION['table_name'])) { //multiple table functionality
        ?>
            <div class="btn-group dropend">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Cambia classe di esemplare da catalogare
                </button>
                <ul class="dropdown-menu">
                    <?php
                    $tableIndex = 0;
                    foreach ($_SESSION['table_name'] as $tableOption) {
                        echo "<li><a class=\"dropdown-item\" href=\"./insert.php?table=" . $tableOption . "\">" . $tableOption . "</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <?php
            if (isset($_REQUEST["table"])) {
                $table = $_REQUEST["table"];
            }
        } else {
            $table = $_SESSION['table_name'];
        }
        if (isset($table)) {
            $connMySQL = new ConnectionMySQL();
            $pdo = $connMySQL->getConnection();
            $stmt = $pdo->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $table . "'");
            $stmt->execute();
            $stmtResponse = $stmt->fetchAll();


            ?>
            <div id="form" class="d-flex align-items-center justify-content-center" style="height: 100%">
                <form action="php/send.php">
                    <div id="tableWrapper" class="container-md">
                        <table class="table table-dark table-striped-columns">

                            <?php
                            foreach ($stmtResponse as $currentRecord) {
                                if ($currentRecord["TABLE_SCHEMA"] == $_SESSION['db_name'] && !isset($configInfo[$currentRecord["COLUMN_NAME"] . "HIDDEN"])) {
                                    //echo var_dump($currentRecord);
                                    if ($currentRecord["EXTRA"] != "auto_increment") {
                                        echo "<td class=\"fw-bold\">" . (isset($configInfo[$currentRecord["COLUMN_NAME"] . "ALIAS"]) ? $configInfo[$currentRecord["COLUMN_NAME"] . "ALIAS"] : $currentRecord["COLUMN_NAME"]) . "</td><td>";
                                        $maxLenght = isset($configInfo[$currentRecord["COLUMN_NAME"] . "Length"]) ? intval($configInfo[$currentRecord["COLUMN_NAME"] . "Length"]) : preg_replace("/[^0-9]/", "", $currentRecord["COLUMN_TYPE"]);
                                        //echo $currentRecord["COLUMN_NAME"] . "Length" . " - " . isset($configInfo[$currentRecord["COLUMN_NAME"] . "Lenght"]) . " - " . $maxLenght;
                                        $dataType = strtok($currentRecord["COLUMN_TYPE"], '(');
                                        //echo $currentRecord["IS_NULLABLE"];

                                        switch (isset($configInfo[$currentRecord["COLUMN_NAME"]]) ? $configInfo[$currentRecord["COLUMN_NAME"]] : $dataType) {
                                            case "int":
                                                echo "<input class=\"form-control\" type=\"text\" pattern=\"\d*\" maxlength=\"" . $maxLenght . "\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\" placeholder=\"numero di max " . $maxLenght . " cifre\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . "></input>";
                                                break;
                                            case "varchar":
                                                echo ($maxLenght > 20 ? "<textarea class=\"form-control\"" : "<input class=\"form-control\" type=\"text\"") .
                                                    " maxlength=\"" . $maxLenght . "\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\" value=\"\" placeholder=\"testo di max " . $maxLenght . " caratteri\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">" . ($maxLenght > 20 ? "</textarea>" : "</input>");
                                                break;
                                            case "date":
                                                echo "<input type=\"date\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . "></input>";
                                                break;
                                            case "customText":
                                                echo "<input class=\"form-control\" type=\"text\" maxlength=\"" . $configInfo[$currentRecord["COLUMN_NAME"] . 'Length'] . "\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\" placeholder=\"stringa di max " . $configInfo[$currentRecord["COLUMN_NAME"] . 'Length'] . " caratteri\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . "></input>";
                                                break;
                                            case "checkbox":
                                                echo "<input class=\"form-check-input\" type=\"checkbox\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\"></input>";
                                                break;
                                            case "select":
                                                $foreignTable = getForeignValues(strtolower(str_replace("id", '', $currentRecord["COLUMN_NAME"])), $configInfo);
                                                echo "<select class=\"form-select form-select-sm\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">";
                                                foreach ($foreignTable as $foreignRow) {
                                                    echo "<option value=\"" . $foreignRow['id'] . "\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">" . $foreignRow[$configInfo['t' . strtolower(str_replace("id", '', $currentRecord["COLUMN_NAME"])) . 'MAINFIELD']] .  "</option>";
                                                }
                                                echo "</select>";
                                                break;
                                            case "radio":
                                                $foreignTable = getForeignValues(strtolower(str_replace("id", '', $currentRecord["COLUMN_NAME"])), $configInfo);
                                                for ($i = 1; $i <= count($foreignTable); $i++) {
                                                    echo "<input class=\"form-check-input\" type=\"radio\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . $i . "\" value=\"" . $foreignTable[$i]['id'] . "\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">" . $foreignTable[$i][$configInfo['t' . strtolower(str_replace("id", '', $currentRecord["COLUMN_NAME"])) . 'MAINFIELD']] . "    </input>";
                                                }

                                                break;
                                            case "sex":
                                                echo "<input class=\"form-check-input m-1\" type=\"radio\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "M" . "\" value=\"m\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">M</input>";
                                                echo "<input class=\"form-check-input m-1\" type=\"radio\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "F" . "\" value=\"f\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">F</input>";


                                                break;
                                            case "day":
                                                echo "<select class=\"form-select form-select-sm\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">";
                                                echo "<option value=NULL " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">Inserire se noto</option>";
                                                for ($i = 1; $i <= 31; $i++) {
                                                    echo "<option value=\"" . $i . "\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">" . $i .  "</option>";
                                                }

                                                break;
                                            case "month":
                                                echo "<select class=\"form-select form-select-sm\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">";
                                                echo "<option value=NULL " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">Inserire se noto</option>";
                                                for ($i = 1; $i <= 12; $i++) {
                                                    echo "<option value=\"" . $i . "\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . ">" . DateTime::createFromFormat('!m', $i)->format('F') .  "</option>";
                                                }

                                                break;
                                            case "year":
                                                echo "<input class=\"form-control\" type=\"text\" pattern=\"\d*\" maxlength=\"4\" name=\"" . $currentRecord["COLUMN_NAME"] . "\" id=\"" . $currentRecord["COLUMN_NAME"] . "\" placeholder=\"Numero di max 4 cifre\" " . ($currentRecord["IS_NULLABLE"] != "NO" ? "" : "required") . "></input>";

                                                break;
                                        }
                                    }
                                    echo "</td></tr>";
                                }
                            }
                            ?>
                            <tr>
                                <td><input type="hidden" name="idParco" value="<?php echo $_SESSION["park_id"] ?>" /></td>
                                <input type="hidden" name="table" value="<?php echo $_REQUEST["table"] ?>" />
                                <td><input class="btn btn-primary" type="submit" name="submit" value="Invia" /></td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="d-flex align-items-center justify-content-center">
                <div id="selectMessage" class="alert alert-info" role="alert" style="width: fit-content">
                    <div id="deletionMessageTip">
                        Selezionare la classe di esemplare da catalogare.
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<?php
function getForeignValues($tableName, $configInfo)
{
    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $foreignTableStmt = $pdo->prepare("SELECT id, " . $configInfo['t' . $tableName . 'MAINFIELD'] . " FROM t" . $tableName);
    $foreignTableStmt->execute();
    $foreignTableStmtResponse = $foreignTableStmt->fetchAll();

    //echo var_dump($foreignTableStmtResponse);
    return $foreignTableStmtResponse;
}
