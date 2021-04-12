<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>BloczKEK</title>

</head>

<body>

<div>

    <div>

        <form action="index.php" method="POST">

            <div>
                <h1> BloczKEK </h1>
            </div>

            <div class="input_div">
                <p>Login: <input type="text" name="login" class="css-input" id="login" placeholder="..."></p>

            </div>

            <div class="input_div">
                <p>Hasło: <input type="password" name="password" class="css-input" id="password" placeholder="..."></p>

            </div>

            <div>
                <div>
                    <a href="register.php">Nie masz konta? Zarejestruj się</a>
                </div>
                <div>
                    <input type="submit" name="sign" id="sign_in" value="Zaloguj">
                    <p id="error"></p>
                </div>
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
            document.getElementById("error").innerHTML = "<?php echo "Zły login lub hasło" ?>";
        </script>
        <?php
    }
}

?>


