<!doctype html>
<html class="no-js" lang="">


<?php include('head.php'); ?>


<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>

        <div class="forms">

            <form action="register.php" method="POST">

                <div class="form-group">
                    <p>Imię: <label for="name"></label><input type="text" name="name" class="form-control" id="name" placeholder="..."></p>

                </div>

                <div class="form-group">
                    <p>Nazwisko: <label for="surname"></label><input type="text" name="surname" class="form-control" id="surname" placeholder="...">
                    </p>

                </div>

                <div class="form-group">
                    <p>Login: <label for="login"></label><input type="text" name="login" class="form-control" id="login" placeholder="..."></p>

                </div>

                <div class="form-group">
                    <p>E-mail: <label for="e-mail"></label><input type="text" name="e-mail" class="form-control" id="e-mail" placeholder="..."></p>

                </div>

                <div class="form-group">
                    <p>Hasło: <label for="password"></label><input type="password" name="password" class="form-control" id="password"
                                                                   placeholder="...">
                    </p>

                </div>

                <div class="form-group">
                    <p>Powtórz hasło: <label for="second_password"></label><input type="password" name="second_password" class="form-control"
                                                                                  id="second_password"
                                                                                  placeholder="..."></p>

                </div>

                <div class="userButtons">
                    <div class="loginArea">
                        <input type="submit" name="register" id="register" value="Zarejestruj"
                               class="btn btn-outline-primary">
                    </div>

                    <div class="registerArea">
                        <a href="index.php" class="btn btn-outline-secondary">Mam już konto</a>
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

