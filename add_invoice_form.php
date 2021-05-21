<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";
    ?>
    <!doctype html>
    <html class="no-js" lang="">

    <?php include('head.php'); ?>

<body>

<div id="content">

    <?php include('header.php'); ?>

    <a href="worker_panel.php"><button>Wróć</button></a>

    <form method="post" action="add_invoice.php" enctype="multipart/form-data">

        <div class="inputs">
            Numer Faktury: <input type="text" name="invoiceNumber" class="standardInput"><br>
            Wartość netto: <input type="number" step="0.01" name="nettoValue" class="standardInput"><br>
            Wartość VAT: <input type="number" step="0.01" name="vatValue" class="standardInput"><br>
            Watrosc brutto: <input type="number" step="0.01" name="bruttoValue" class="standardInput"><br>
            Data faktury: <input type="date" name="date" class="standardInput"><br>
            <input type="file" name="file" size="50"><br>
            <input type="submit" class="submitInput">

        </div>

    </form>

</div>

    <?php
} else {
    echo "No session started.";
}
