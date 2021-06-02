<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    $infoUser =  "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";
    ?>
    <!doctype html>
    <html class="no-js" lang="">

    <?php include('head.php'); ?>

    <body>

    <div>
        <div class="content">

            <?php include('header.php'); ?>

    <div class="infoUser">
        <?php echo $infoUser ?>
    </div>

    <a href="worker_panel.php">
        <button class="btn btn-outline-secondary">Wróć</button>
    </a>

    <form method="post" action="add_invoice.php" enctype="multipart/form-data" style="margin-top:30px">

        <div class="inputs">

            <div class="form-group"><label>Numer Faktury:</label> <input type="text" required name="invoiceNumber" class="form-control"></div>
            <div class="form-group"><label>Wartość netto:</label> <input type="number" required step="0.01" name="nettoValue"
                                                                         class="form-control"></div>
            <div class="form-group"><label>Wartość VAT:</label> <input type="number" required step="0.01" name="vatValue" class="form-control">
            </div>
            <div class="form-group"><label>Watrosc brutto:</label> <input type="number" required step="0.01" name="bruttoValue"
                                                                          class="form-control"></div>
            <div class="form-group"><label>Data faktury:</label> <input type="date" required name="date" class="form-control"></div>
            <div class="form-group"><label>Dodaj plik</label>
            <input type="file"  class="form-control-file" name="file" size="50"><br>

            </div>
            <input type="submit" class="btn btn-secondary">

        </div>

    </form>

</div>
</div>
</body>

    <?php
} else {
    echo "No session started.";
}
