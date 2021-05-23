<?php

require_once("config.php");
global $config;
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";

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

    <a href="read_invoices.php">
        <button>Wróć</button>
    </a>

    <form method="POST" action="edit_invoice.php?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
        <div class="inputs">
            Numer Faktury: <input type="text" name="invoiceNumber" value="<?= $invoice['invoiceNumber'] ?>"
                                  class="standardInput"><br>
            Wartość netto: <input type="number" step="0.01" name="nettoValue"
                                  value="<?= $invoice['nettoValue'] ?>" class="standardInput"><br>
            Wartość VAT: <input type="number" step="0.01" name="vatValue" value="<?= $invoice['vatValue'] ?>"
                                class="standardInput"><br>
            Watrosc brutto: <input type="number" step="0.01" name="bruttoValue"
                                   value="<?= $invoice['bruttoValue'] ?>" class="standardInput"><br>
            Data faktury: <input type="date" name="date" value="<?= $invoice['date'] ?>"
                                 class="standardInput"><br>
            Zmiana pliku: <input type="file" id="file" name="file" size="50"><br>
            <input type="submit" name="submit" class="submitInput">
        </div>
    </form>

</div>

    <?php
} else {
    echo "No session started.";
}

