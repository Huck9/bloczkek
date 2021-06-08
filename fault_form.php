<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>
<body>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<div>

    <div class="content">

        <?php include('header.php'); ?>

        <a href="user_panel.php">
            <button class="btn btn-outline-secondary">Wróć</button>
        </a>
        <form action="" method="POST">

            <div class="forms">

                <div class="form-group">
                    <p>Opis: <label for="password"></label><input type="text" name="description" class="form-control"
                                                                   id="description" placeholder="Opis usterki" required
                                                                   minlength="10"></p>
                </div>
                <div class="form-group">
                    <p>Data wystąpienia usterki: <input type="date" name="date" class="form-control"
                                               id="date" value=<?php
                        echo date('Y-m-d');
                        ?> required min=<?php
                        echo date('Y-m-d');
                        ?>></p>
                </div>


                <div class="userButtons">
                    <div class="loginArea">
                        <input type="submit" name="sign" id="sign_in" value="Zgłoś usterkę"
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
session_start();
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);
if (isset($_POST['description'])) {
    if (isset($_SESSION['name']) && ($_SESSION['role'] == "user")) {
        $stm = $pdo->prepare('SELECT * FROM users WHERE login = ?');
        $stm->execute([$_SESSION['name']]);
        $userID = $stm->fetch(PDO::FETCH_ASSOC);
        $userID = $userID['userID'];

        $description = $_POST['description'];
        $date = $_POST['date'];
        $sql = "INSERT INTO faults (userID,description, status, date) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userID,$description, 0, $date]);
        echo "<script type='text/javascript'>toastr.success('Dodano usterkę')</script>";


    }
}