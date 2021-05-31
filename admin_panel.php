<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "ADMIN") {
    $infoUser =  "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";    ?>
<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>

<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>
        <div class="infoUser">
            <?php echo $infoUser?>
        </div>
        <div  style="margin-top: 30px">

            <a href = 'register.php'><button onclick="" class="btn btn-outline-primary">Dodaj użytkownika</button></a>

        </div>

        <div  style="margin-top: 30px">

            <a href = 'chat.php'><button onclick="" class="btn btn-outline-primary">Komunikator</button></a>

        </div>

    </div>

</div>

</body>



<?php
} else {
    echo "Brak dostępu";
}

