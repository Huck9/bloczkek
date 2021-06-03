<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "user") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";
    ?>
    <!doctype html>
    <?php include('head.php'); ?>
    <html class="no-js" lang="">


    <body>

    <div>

        <div class="content">

            <?php include('header.php'); ?>
            <div class="infoUser">
                <?php echo $infoUser ?>
            </div>

            <a href='voting_panel_for_user.php'>
                <button onclick="" class="btn btn-outline-primary">Głosowania</button>
            </a>

            <a href='edit_user.php'>
                <button onclick="" class="btn btn-outline-primary">Zmień hasło</button>
            </a>

            <a href='read_invoices.php'>
                <button onclick="" class="btn btn-outline-primary">Przeglądaj opłaty</button>
            </a>

            <a href='chat.php'>
                <button onclick="" class="btn btn-outline-primary">Komunikator</button>
            </a>

        </div>
        <?php
        require_once("config.php");
        global $config;

        $pdo = new PDO($config['dsn'], $config['username'], $config['password']);


        $stmt = $pdo->query("SELECT * FROM `notification` where date < CURDATE() ");
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($notifications > 0) {
            foreach ($notifications as $notification) {
                echo $notification['title'];
                echo " ";
                echo $notification['text'];
                echo " ";
                echo $notification['date'];
                echo " ";
                echo "<br>";
            }
        }
        ?>

    </div>

    </body>

    </html>

    <?php
} else {
    echo "Brak dostępu";
}
