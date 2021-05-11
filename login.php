<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>

<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>

        <form action="login.php" method="POST">

            <div class="forms">

                <div class="form-group">
                    <p>Login: <label for="login"></label><input type="text" name="login" class="form-control"
                                                                id="login"
                                                                placeholder="..."></p>
                </div>

                <div class="form-group">
                    <p>Hasło: <label for="password"></label><input type="password" name="password"
                                                                   class="form-control"
                                                                   id="password" placeholder="..."></p>
                </div>

                <div class="userButtons">
                    <div class="loginArea">
                        <input type="submit" name="sign" id="sign_in" value="Zaloguj"
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

if (isset($_POST['sign'])) {

    $login = $_POST['login'];
    $password = $_POST['password'];


    $stm = $pdo->query("SELECT * FROM users WHERE login='$login'");
    $user = $stm->fetch();


    if ($user > 0) {


        $salt = $user['salt'];
        $checkPass = hash('sha256', $password . $salt);


        if ($checkPass == $user['password']) {
            $role = $user['accountType'];
            session_start();
            $_SESSION['name'] = $login;
            $_SESSION['role'] = $role;
            if ($role == 'user') {
                header("location: user_panel.php");
            } elseif ($role == 'worker') {
                header("location: worker_panel.php");
            } elseif ($role == 'ADMIN') {
                header("location: admin_panel.php");
            }
        } else {
            ?>
            <script type="text/javascript">
                document.getElementById("error").innerHTML = "<?php echo "Zły login lub hasło, spróbuj ponownie" ?>";
            </script>
            <?php
        }

    } else {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Zły login lub hasło, spróbuj ponownie" ?>";
        </script>
        <?php
    }
}

?>


