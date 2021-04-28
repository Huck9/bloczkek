<?php
include('head.php');
require_once("config.php");
global $config;

session_start();

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

$stmt = $pdo->prepare('SELECT email FROM users WHERE login = ?');
$stmt->execute([$_SESSION['name']]);
$update_users = $stmt->fetch(PDO::FETCH_ASSOC);

?>
    <body>

    <div>

        <div class="forms">

            <form action="edit_user.php" method="POST">
                <div class="form-group">
                    <p>E-mail: <label></label><input type="text" name="e-mail" id="e-mail" class="form-control" value="<?=$update_users['email']?>"></p>
                </div>

                <div class="form-group">
                    <p>Nowe hasło: <label></label><input type="password" name="password" id="password" class="form-control" placeholder="..."></p>
                </div>

                <div class="form-group">
                    <p>Powtórz nowe hasło: <label></label><input type="password" name="second_password" id="second_password" class="form-control" placeholder="..."></p>
                </div>

                <div>
                    <input type="submit" name="edit" id="edit" class="btn btn-outline-primary" value="Edytuj">
                </div>
            </form>
            <p id="error"></p>
        </div>

    </body>

<?php

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

if (isset($_POST['edit'])) {
    $email = $_POST['e-mail'];
    $password = $_POST['password'];
    $secondPassword = $_POST['second_password'];

    if (!strpos($email, '@')) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Podałeś nieprawidłowy adres e-mail" ?>";
        </script>
        <?php
        exit();
    }

    if (strlen($password) < 8) {
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Hasło musi mieć co najmniej 8 znaków" ?>";
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
    $password=hash('sha256',$password.$salt);
    $sql = "UPDATE users SET email = ?, password= ?, salt= ? WHERE login = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute( [$email, $password, $salt, $_SESSION['name']]);
    header("location: edit_user.php");
}

?>