<?php
require_once("../../common/php/DBConnector.php");
if (isset($_REQUEST)) {
    echo var_dump($_SESSION);
    echo "<br>-*-*-*-*-<br>";
    echo var_dump($_REQUEST);
    echo "<br>-*-*-*-*-<br>";
    echo http_build_query($_REQUEST);

    $table = $_REQUEST['table'];

    $connMySQLRows = new ConnectionMySQL();
    $pdoRows = $connMySQLRows->getConnection();
    $stmtRows = $pdoRows->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='" . $table . "'");
    $stmtRows->execute();
    $stmtResponseRows = $stmtRows->fetchAll();

    $values = "";
    $fieldList = "";
    foreach ($stmtResponseRows as $currentRecordRows) {
        if ($currentRecordRows["TABLE_SCHEMA"] == $_SESSION['db_name']) {
            if (($currentRecordRows["COLUMN_NAME"] == "idSpecieAnimale" || $currentRecordRows["COLUMN_NAME"] == "idSpeciePianta") && !is_int($_REQUEST[$currentRecordRows["COLUMN_NAME"]])) {/*proj specific, NON GENERIC, do not reuse*/
                header("location: ./specifyData.php?" . http_build_query($_REQUEST));
            }
            if ($currentRecordRows["EXTRA"] != "auto_increment") {
                if ($fieldList != "") {
                    $fieldList .= ", ";
                    $values .= ", ";
                }
                $fieldList .= $currentRecordRows["COLUMN_NAME"];
                if (isset($configInfo[$currentRecordRows["COLUMN_NAME"]]) && ($configInfo[$currentRecordRows["COLUMN_NAME"]] == "radio" || $configInfo[$currentRecordRows["COLUMN_NAME"]] == "select")) {
                    $values .= "'" . $_REQUEST[$currentRecordRows["COLUMN_NAME"]] . "'";
                } else if (isset($configInfo[$currentRecordRows["COLUMN_NAME"]]) && $configInfo[$currentRecordRows["COLUMN_NAME"]] == "checkbox") {
                    $values .= "'" . ($_REQUEST[$currentRecordRows["COLUMN_NAME"]] == "on" ? 1 : 0) . "'";
                } else {
                    $values .= "'" . $_REQUEST[$currentRecordRows["COLUMN_NAME"]] . "'";
                }
            }
        }
    }

    echo "<br>fields: " . $fieldList;
    echo "<br>values: " . $values;
    $query = "INSERT INTO " . $table . " (" . $fieldList . ") VALUES (" . $values . ")";
    echo "<br>query: " . $query;

    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $stmt = $pdo->prepare($query);
    $stmt->execute();
} else {
    echo "no data";
};

header("location: ../insert.php?table=" . $_REQUEST["table"] . "&added=1");
