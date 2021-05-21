<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";
    ?>
<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>

<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>

        <div>

            <a href = 'register.php'><button onclick="" class="btn btn-outline-primary">Dodaj mieszkańca</button></a>

            <a href = 'add_vote.php'><button onclick="" class="btn btn-outline-primary">Dodaj głosowanie</button></a>

            <a href = 'voting_panel_for_worker.php'><button onclick="" class="btn btn-outline-primary">Przeglądaj głosowania</button></a>

            <a href = 'add_invoice_form.php'><button onclick="" class="btn btn-outline-primary">Dodaj fakturę</button></a>

        </div>

    </div>

</div>

</body>

<?php
} else {
    echo "Brak dostępu";
}
