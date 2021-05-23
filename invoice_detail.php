<?php

require_once("config.php");
global $config;

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "user" or "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";

    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare('SELECT * FROM invoices WHERE invoiceID = ?');
        $stmt->execute([$_GET['id']]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>

        <div class="container">

            <div class="details">

                <img src="uploads/<?= $invoice['filename'] ?>" height=400px width=400px>
                <button><a href="read_invoices.php"> Powrót do opłat</a></button>

            </div>

        </div>

        <?php
    }
} else {
    echo "No session started.";
}
