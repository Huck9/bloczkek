<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name'])) {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";
?>
<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>

<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>

        <a href="worker_panel.php"><button>Wróć</button></a>

    </div>

</div>

</body>

<?php
} else {
    echo "Brak dostępu";
}