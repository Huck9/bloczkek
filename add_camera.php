<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>

<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>

        <div class="forms">

            <form action="add_camera.php" method="POST">

                <div class="form-group">
                    <p>Nazwa budynku: <label for="buildingName"></label><input type="text" name="buildingName" class="form-control" id="buildingName" placeholder="..."></p>

                </div>

                <div class="form-group">
                    <p>Link do kamery: <label for="link"></label><input type="text" name="link" class="form-control" id="link" placeholder="...">
                    </p>

                </div>

                <div class="userButtons">
                    <div class="loginArea">
                        <input type="submit" name="addCamera" id="addCamera" value="Dodaj kamerę"
                               class="btn btn-outline-primary">
                    </div>
                </div>

            </form>

            <p id="error"></p>
        </div>
    </div>

</div>

</body>

</html>

<?php

require_once("config.php");
global $config;

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

if (isset($_POST['addCamera'])) {

    $buildingName = $_POST['buildingName'];
    $link = $_POST['link'];

    if ($buildingName == "" or $link == "") {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Wypełnij wszystkie pola" ?>";
        </script>
        <?php
        exit();
    }


    $stm2 = $pdo->query("SELECT * FROM buildings");
    $buildings= $stm2->fetchAll();

    $buildingExist = false;
    $buildingId=0;
    foreach ($buildings as $b) {
        if ($buildingName == strval($b['name'])) {
            $buildingExist = true;
            $buildingId=$b['id'];
        }
    }
    if($buildingExist == false){
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Nie ma takiego budynku" ?>";
        </script>
        <?php
        exit();
    }

    $sql = "INSERT INTO cameras (link, building_id) VALUES (?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$link,$buildingId]);
    header("location: index.php");
}

?>


