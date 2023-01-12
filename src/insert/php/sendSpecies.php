<head>
    <link rel="stylesheet" href="../../common/css/sidebar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>PHPYA Insert</title>

</head>

<body>
    <?php //all non generic, do not re-use unless you like suffering
    require_once("../../common/php/DBConnector.php");
    //echo var_dump($_SESSION);
    //echo "<br>-*-*-*-*-<br>";
    //echo var_dump($_REQUEST);
    //echo "<br>-*-*-*-*-<br>";
    //echo http_build_query($_REQUEST);
    //echo "<br>-*-*-*-*-<br>";
    //echo $_REQUEST["insertData"];

    parse_str($_REQUEST["insertData"], $insArray);
    unset($insArray["submit"]);
    $table = $insArray["table"];
    $speciesTable = ($table == "tanimale" ? "tspecieanimale" : "tspeciepianta");
    $field = ($table == "tanimale" ? "nomeSpecieAnimale" : "nomeSpeciePianta");
    $categoria = ($table == "tanimale" ? "idOrdine" : "idGenere");
    unset($insArray["table"]);


    $query = "INSERT INTO $speciesTable ($field, $categoria" . ($table == "tpianta" ? ", periodoFioritura" : "") . ") VALUES ('" . $insArray[$_REQUEST["field"]] . "', " . $_REQUEST[$categoria] . ($table == "tpianta" ? ", '" . $_REQUEST["fioritura"] . "'" : "") . ")";
    echo $query;
    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $id = $pdo->lastInsertId();

    $insArray[$_REQUEST["field"]] = $id;


    $columns = implode(', ', array_keys($insArray));
    $values = implode(', ', array_map(function ($val) {
        return "'" . $val . "'";
    }, array_values($insArray)));

    $query = "INSERT INTO $table ($columns) VALUES ($values)";
    $query = str_replace("'on'", "1", $query);
    echo "<br>query: " . $query;

    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    header("location: ../insert.php?table=" . $table . "&added=1");

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>