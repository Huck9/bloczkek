<!doctype html>
<html class="no-js" lang="">


<?php include('head.php'); ?>

<body>

<div>


    <div class="content">

        <?php include('header.php'); ?>

        <form action="index.php" method="POST">


            <div class="forms">


                <div class="form-group">
                    <p>Login: <label for="login"></label><input type="text" name="login" class="form-control" id="login"
                                                                placeholder="..."></p>

                </div>

                <div class="form-group">
                    <p>Hasło: <label for="password"></label><input type="password" name="password" class="form-control"
                                                                   id="password" placeholder="..."></p>

                </div>

                <div class="userButtons">
                    <div class="loginArea">
                        <input type="submit" name="sign" id="sign_in" value="Zaloguj" class="btn btn-outline-primary"
                               title="Pamiętaj o wylogowaniu się po zakończeniu pracy!">
                    </div>
                    <div class="registerArea">
                        <a href="register.php" class="btn btn-outline-secondary">Nie masz konta? Zarejestruj się</a>
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

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

if (isset($_POST['sign'])) {

    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $stm = $pdo->query("SELECT * FROM users WHERE login='$login' AND password='$password' ");
    $user = $stm->fetch();

    if ($user > 0) {
        $role = $user['accountType'];
        session_start();
        $_SESSION['name'] = $login;
        $_SESSION['role'] = $role;
        # header("location: #######");
    } else {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Zły login lub hasło, spróbuj ponownie" ?>";
        </script>
        <?php
    }
}

?>


