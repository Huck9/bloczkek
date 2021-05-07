<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) and $_SESSION['role'] == "ADMIN" or $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";
    ?>
    <!doctype html>
    <html class="no-js" lang="">

    <?php include('head.php'); ?>

    <body>

    <div>

        <div class="content">

            <?php include('header.php');

            if ($_SESSION['role'] == "ADMIN"):
            ?>
            <a href="admin_panel.php">
                <?php
                elseif ($_SESSION['role'] == "worker"):
                ?>
                <a href="worker_panel.php">
                    <?php
                    endif;
                    ?>
                    <button>Wróć</button>
                </a>

                <div class="forms">

                    <form action="register.php" method="POST">

                        <div class="form-group">
                            <p>Imię: <label for="name"></label><input type="text" name="name" class="form-control"
                                                                      id="name"
                                                                      placeholder="..."></p>

                        </div>

                        <div class="form-group">
                            <p>Nazwisko: <label for="surname"></label><input type="text" name="surname"
                                                                             class="form-control"
                                                                             id="surname" placeholder="...">
                            </p>

                        </div>

                        <div class="form-group">
                            <p>Login: <label for="login"></label><input type="text" name="login" class="form-control"
                                                                        id="login" placeholder="..."></p>

                        </div>

                        <div class="form-group">
                            <p>E-mail: <label for="e-mail"></label><input type="text" name="e-mail" class="form-control"
                                                                          id="e-mail" placeholder="..."></p>

                        </div>

                        <div class="form-group">
                            <p>Hasło: <label for="password"></label><input type="password" name="password"
                                                                           class="form-control" id="password"
                                                                           placeholder="...">
                            </p>

                        </div>

                        <div class="form-group">
                            <p>Powtórz hasło: <label for="second_password"></label><input type="password"
                                                                                          name="second_password"
                                                                                          class="form-control"
                                                                                          id="second_password"
                                                                                          placeholder="..."></p>
                        </div>

                        <?php
                        if ($_SESSION['role'] == "ADMIN"):
                            ?>
                            <input type="radio" id="user" name="account_type" value="user">
                            <label for="user">Użytkownik</label><br>
                            <input type="radio" id="worker" name="account_type" value="worker">
                            <label for="worker">Pracownik</label><br>
                        <?php
                        endif;
                        ?>

                        <div class="userButtons">
                            <div class="loginArea">
                                <input type="submit" name="register" id="register"
                                       value="Zarejestruj nowego użytkownika"
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
} else {
    echo "Brak dostępu";
}

require_once("config.php");
global $config;

function getRandomString($length = 10): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

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

    if (!isset($_POST['account_type']) and $_SESSION['role'] == "ADMIN") {
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

    $salt = getRandomString(10);
    $password = hash('sha256', $password . $salt);
    $sql = "INSERT INTO users (name, surname, login, password, salt, email, accountType) VALUES (?,?,?,?,?,?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($_SESSION['role'] == "worker") {
        $stmt->execute([$name, $surname, $login, $password, $salt, $email, "user"]);
    } elseif (($_SESSION['role'] == "ADMIN")) {
        $account = $_POST['account_type'];
        $stmt->execute([$name, $surname, $login, $password, $salt, $email, $account]);
    }
    header("location: admin_panel.php");
}

?>


