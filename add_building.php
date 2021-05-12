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

                <div class="userButtons">
                    <div class="loginArea">
                        <input type="submit" name="addBuilding" id="addBuilding" value="Dodaj budynek"
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

    if ($buildingName == "") {
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
            ?>
            <script type="text/javascript">
                document.getElementById("error").innerHTML = "<?php echo "Taki budynek już istnieje." ?>";
            </script>
            <?php
            exit();
        }
    }


    $sql = "INSERT INTO buidlings (name) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$buildingName]);
    header("location: index.php");
}

?>


