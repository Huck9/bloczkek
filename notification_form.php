<!doctype html>
<html class="no-js" lang="">

<?php
include('head.php');

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
$infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

?>
<body>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<div>

    <div class="content">

        <?php include('header.php'); ?>

        <div class="infoUser">
            <?php echo $infoUser ?>
        </div>

        <a href="worker_panel.php">
            <button class="btn btn-outline-secondary">Wróć</button>
        </a>

        <form action="" method="POST">

            <div class="forms">

                <div class="form-group">
                    <p>Tytuł: <label for="login"></label><input type="text" name="title" class="form-control" id="title"
                                                                placeholder="Tytuł ogłoszenia" required minlength="5">
                    </p>
                </div>

                <div class="form-group">
                    <p>Treść: <label for="password"></label><input type="text" name="text" class="form-control"
                                                                   id="text" placeholder="Treść ogłoszenia" required
                                                                   minlength="10"></p>
                </div>
                <div class="form-group">
                    <p>Data ogłoszenia: <input type="date" name="date" class="form-control"
                                               id="date" value=<?php
                        echo date('Y-m-d');
                        ?> required min=<?php
                        echo date('Y-m-d');
                        ?>></p>
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

</body>


</html>
<?php

require_once("config.php");
global $config;

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);
if (isset($_POST['title'])) {
    if (isset($_SESSION['name']) && ($_SESSION['role'] == "ADMIN" || $_SESSION['role'] == "worker")) {
        $title = $_POST['title'];
        $text = $_POST['text'];
        $date = $_POST['date'];
        $sql = "INSERT INTO notification (title, text, date) VALUES (?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $text, $date]);
        echo "<script type='text/javascript'>toastr.success('Dodano ogłoszenie')</script>";


    }
}

} else {
    echo "No session started.";
}