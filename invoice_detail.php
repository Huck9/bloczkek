<?php

require_once("config.php");
global $config;

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "user" or "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare('SELECT * FROM invoices WHERE invoiceID = ?');
        $stmt->execute([$_GET['id']]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);



        ?>


        <!doctype html>
        <html class="no-js" lang="">
        <?php include('head.php'); ?>
    <body>
    <div class="content">

        <?php include('header.php'); ?>
        <div class="infoUser">
            <?php echo $infoUser ?>
        </div>
        <div class="container">

            <div class="invDetails">

                <img src="uploads/<?= $invoice['filename'] ?>" height=400px width=400px>
                <button class="btn btn-outline-secondary" style="max-width: 200px; margin: 0 auto; margin-top:10px; "><a href="read_invoices.php"> Powrót do opłat</a></button>

            </div>

        </div>
    </div>
    </body>

        <?php
    }
} else {
    echo "No session started.";
}
