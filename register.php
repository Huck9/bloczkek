<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>BloczKEK</title>

</head>

<body>

<div>

    <div>

        <form action="register.php" method="POST">

            <div>
                <h1> BloczKEK </h1>
            </div>

            <div class="input_div">
                <p>Imię: <input type="text" name="name" class="css-input" id="name" placeholder="..."></p>

            </div>

            <div class="input_div">
                <p>Nazwisko: <input type="text" name="surname" class="css-input" id="surname" placeholder="..."></p>

            </div>

            <div class="input_div">
                <p>Login: <input type="text" name="login" class="css-input" id="login" placeholder="..."></p>

            </div>

            <div class="input_div">
                <p>E-mail: <input type="text" name="e-mail" class="css-input" id="e-mail" placeholder="..."></p>

            </div>

            <div class="input_div">
                <p>Hasło: <input type="password" name="password" class="css-input" id="password" placeholder="...">
                </p>

            </div>

            <div class="input_div">
                <p>Powtórz hasło: <input type="password" name="second_password" class="css-input" id="second_password"
                                         placeholder="..."></p>

            </div>

            <div>
                <div>
                    <a href="index.php">Masz konto? Zaloguj się</a>
                </div>
                <div>
                    <input type="submit" name="register" id="register" value="Zarejestruj">
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

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $login = $_POST['login'];
    $email = $_POST['e-mail'];
    $password = $_POST['password'];
    $secondPassword = $_POST['second_password'];

    if ($name == "" or $surname == "" or $login == "" or $email == "" or $password == "" or $secondPassword == "") {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Wypełnij wszystkie pola" ?>";
        </script>
        <?php
        exit();
    }

    $stm = $pdo->query("SELECT * FROM users");
    $users = $stm->fetchAll();

    foreach ($users as $u) {
        if ($login == strval($u['login'])) {
            ?>
            <script type="text/javascript">
                document.getElementById("error").innerHTML = "<?php echo "Istnieje już użytkownik o takim loginie" ?>";
            </script>
            <?php
            exit();
        }
    }

    if (strlen($password) < 8) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Hasło musi mieć co najmniej 8 znaków" ?>";
        </script>
        <?php
        exit();
    }

    if (!strpos($email, '@')) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Podałeś nieprawidłowy adres e-mail" ?>";
        </script>
        <?php
        exit();
    }

    if ($password != $secondPassword) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Podane hasła nie są identyczne" ?>";
        </script>
        <?php
        exit();
    }

    $password = md5($password);
    $sql = "INSERT INTO users (name, surname, login, password, email, accountType) VALUES (?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $surname, $login, $password, $email, "user"]);
    header("location: index.php");
}

?>

