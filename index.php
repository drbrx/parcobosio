<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>PHPYA Login</title>

</head>

<body style="background-color: rgb(75, 75, 75); color:aliceblue">
    <?php

    require_once("./src/common/php/DBConnector.php");

    $connMySQL = new ConnectionMySQL();
    $pdo = $connMySQL->getConnection();
    $foreignTableStmt = $pdo->prepare("SELECT id, " . $configInfo['tparco' . 'MAINFIELD'] . " FROM tparco");
    $foreignTableStmt->execute();
    $foreignTable = $foreignTableStmt->fetchAll();

    ?>
    <div class="d-flex align-items-center justify-content-center" style="margin-top: 50px;">
        <div id="selectMessage" class="alert alert-info" role="alert" style="width: fit-content">
            <div class=" btn-group dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Seleziona il parco in cui stai operando:
                </button>
                <ul class="dropdown-menu">
                    <?php
                    $tableIndex = 0;
                    foreach ($foreignTable as $park) {
                        echo "<li><a class=\"dropdown-item\" href=\"./src/main/main.php?park=" . $park['id'] . "\">" . $park[$configInfo['tparco' . 'MAINFIELD']] . "</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>