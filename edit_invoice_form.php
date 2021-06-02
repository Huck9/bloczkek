<?php

require_once("config.php");
global $config;
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    $stmt = $pdo->prepare('SELECT * FROM invoices WHERE invoiceID = ?');
    $stmt->execute([$_GET['id']]);
    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <!doctype html>
    <html class="no-js" lang="">

    <?php include('head.php'); ?>
    <script>
        $(document).ready(function() {
            $('#vatValue, #nettoValue').change(function() {
                let totalValue = 0
                totalValue += parseFloat(parseFloat($('#nettoValue').val()) + parseFloat($('#vatValue').val()));
                totalValue = totalValue.toFixed(2)
                $('#bruttoValue').val(totalValue);
            });
        });
    </script>
<body>


<div class="content">

    <?php include('header.php'); ?>

    <div class="infoUser">
        <?php echo $infoUser ?>
    </div>
    <a href="read_invoices.php">
        <button class="btn btn-outline-secondary">Wróć</button>
    </a>

    <form method="POST" action="edit_invoice.php?id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
        <div class="inputs">
            <div class="form-group"><label>Numer Faktury:</label> <input type="text" name="invoiceNumber"
                                                                         value="<?= $invoice['invoiceNumber'] ?>"
                                                                         class="form-control" required></div>
            <div class="form-group"><label>Wartość netto:</label> <input type="number" id="nettoValue" step="0.01" name="nettoValue"
                                                                         value="<?= $invoice['nettoValue'] ?>"
                                                                         class="form-control" required></div>
            <div class="form-group"><label>Wartość VAT: </label><input type="number" id="vatValue" step="0.01" name="vatValue"
                                                                       value="<?= $invoice['vatValue'] ?>"
                                                                       class="form-control" required></div>
            <div class="form-group"><label>Watrosc brutto: </label><input type="number" id="bruttoValue" step="0.01"
                                                                          name="bruttoValue"
                                                                          value="<?= $invoice['bruttoValue'] ?>"
                                                                          class="form-control" required readonly></div>
            <div class="form-group"><label>Data faktury: </label><input type="date" name="date"
                                                                        value="<?= $invoice['date'] ?>"
                                                                        class="form-control" required></div>
            <div class="form-group"><label>Zmiana pliku:</label> <input type="file" id="file" class="form-control-file"
                                                                        name="file" size="50"></div>
            <div class="form-group"><input type="submit" name="submit" class="btn btn-outline-primary">
        </div>
    </form>

</div>

    <?php
} else {
    echo "No session started.";
}

