<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>
<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>

        <form action="" method="POST">

            <div class="forms">

                <div class="form-group">
                    <p>Tytuł: <label for="login"></label><input type="text" name="title" class="form-control" id="title"
                                                                placeholder="Tytuł ogłoszenia"></p>
                </div>

                <div class="form-group">
                    <p>Treść: <label for="password"></label><input type="text" name="text" class="form-control"
                                                                   id="text" placeholder="Treść ogłoszenia"></p>
                </div>
                <div class="form-group">
                    <p>Data ogłoszenia: <input type="date" name="date" class="form-control"
                                               id="date"></p>
                </div>


                <div class="userButtons">
                    <div class="loginArea">
                        <input type="submit" name="sign" id="sign_in" value="Dodaj ogłoszenie"
                               class="btn btn-outline-primary"
                               title="Pamiętaj o wylogowaniu się po zakończeniu pracy!">
                    </div>
                </div>

                <div id="error"></div>
            </div>

        </form>

    </div>

</div>
<script type="text/javascript" src="scripts.js"></script>
</body>


</html>
<?php

require_once("config.php");
global $config;
session_start();
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);
if (isset($_POST['title'])) {
    if (isset($_SESSION['name']) && ($_SESSION['role'] == "ADMIN" || $_SESSION['role'] == "worker")) {
        $title = $_POST['title'];
        $text = $_POST['text'];
        $date = $_POST['date'];
        $sql = "INSERT INTO notification (title, text, date) VALUES (?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $text, $date]);
        echo "<div> Dodano! </div>";
    }
}