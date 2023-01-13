<head>
    <link rel="stylesheet" href="../../common/css/sidebar.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>PHPYA Insert</title>

</head>
<script>
    function showForm() {}
</script>

<body>
    <?php //all non generic, do not re-use unless you like suffering
    require_once("../../common/php/DBConnector.php");
    //echo var_dump($_SESSION);
    //echo "<br>-*-*-*-*-<br>";
    //echo var_dump($_REQUEST);
    //echo "<br>-*-*-*-*-<br>";
    //echo http_build_query($_REQUEST);
    //echo "<br>-*-*-*-*-<br>";
    //echo $_REQUEST["table"] == "tanimale";
    $field = ($_REQUEST["table"] == "tanimale" ? "idSpecieAnimale" : "idSpeciePianta");
    //echo $field;
    $table = ($_REQUEST["table"] == "tanimale" ? "tspecieanimale" : "tspeciepianta");
    //echo $table;
    $specie = ($_REQUEST["table"] == "tanimale" ? $_REQUEST["idSpecieAnimale"] : $_REQUEST["idSpeciePianta"]);

    $connMySQLRows = new ConnectionMySQL();
    $pdoRows = $connMySQLRows->getConnection();
    $stmtRows = $pdoRows->prepare("SELECT id, " . str_replace("id", "nome", $field) . " AS nome FROM " . $table);
    $stmtRows->execute();
    $result = $stmtRows->fetchAll();
    $speciesList = array_column($result, "nome");
    //echo var_dump($speciesList);


    $MAXDIFF = (strlen($specie) / 3) + 1; //one error per 3 chars +1
    //echo $MAXDIFF;
    $minDiff = $MAXDIFF;
    $best = "";
    foreach ($speciesList as $string) {
        $distance = levenshtein(strtolower($specie), strtolower($string));
        if ($distance < $minDiff) {
            $minDiff = $distance;
            $best = $string;
        }
    }
    //echo $minDiff;
    if ($minDiff < $MAXDIFF) {
        echo "<div id=\"buttons\">È già presente nel sistema la specie '$best'. Si vuole comunque creare la specie '$specie'?
        <button onclick=\"showForm()\">Sì</button>
        <button onclick=\"window.location.href = ' ../insert.php'\">No</button></div>";
        $hide = true;
    } else {
        $hide = false;
    }
    showForm($specie, $configInfo, $field, $hide);


    function showForm($specie, $configInfo, $field, $hide)
    {

    ?>
        <form <?php if ($hide) {
                    echo "style=\"visibility: hidden\"";
                } ?> id="inputForm" action="sendSpecies.php" method="get">

            <b>Nome della specie: </b> <?php echo $specie; ?> <br>

            <label for=<?php $categoria = ($_REQUEST["table"] == "tanimale" ? "idOrdine" : "idGenere");
                        echo $categoria; ?>>Selezionare il gruppo di appartenenza dell specie:</label>
            <?php
            $foreignTable = getForeignValues(strtolower(str_replace("id", '', $categoria)), $configInfo);
            echo "<select class=\"form-select form-select-sm\" name=\"" . $categoria . "\" id=\"" . $categoria . "\" " . "required" . ">";
            foreach ($foreignTable as $foreignRow) {
                echo "<option value=\"" . $foreignRow['id'] . "\" required>" . $foreignRow[$configInfo['t' . strtolower(str_replace("id", '', $categoria)) . 'MAINFIELD']] .  "</option>";
            }
            echo "</select>";
            ?>
            <br>

            <?php if ($_REQUEST["table"] == "tpianta") { ?>
                <label for="fioritura">Inserire il periodo di fioritura:</label>
                <input type="text" name="fioritura" id="fioritura">
                <br><br>
            <?php }; ?>

            <input type="hidden" name="insertData" value="<?php echo http_build_query($_REQUEST); ?>">
            <input type="hidden" name="field" value="<?php echo $field; ?>">
            <input type="submit" value="Salva">
        </form>

    <?php } ?>

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
?>

<script>
    function showForm() {
        $("#inputForm").css("visibility", "visible");
        $("#buttons").css("visibility", "hidden");
    }
</script>