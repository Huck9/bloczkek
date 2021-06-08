<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";
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

            <div style="margin-top: 30px">

                <a href='register.php'>
                    <button onclick="" class="btn btn-outline-primary">Dodaj mieszkańca</button>
                </a>

                <a href='add_vote.php'>
                    <button onclick="" class="btn btn-outline-primary">Dodaj głosowanie</button>
                </a>

                <a href='voting_panel_for_worker.php'>
                    <button onclick="" class="btn btn-outline-primary">Przeglądaj głosowania</button>
                </a>

                <a href = 'add_camera.php'>
                    <button onclick="" class="btn btn-outline-primary">Dodaj kamerę</button>
                </a>

                <a href = 'add_building.php'>
                    <button onclick="" class="btn btn-outline-primary">Dodaj budynek</button>
                </a>

                <a href='add_invoice_form.php'>
                    <button onclick="" class="btn btn-outline-primary">Dodaj fakturę</button>
                </a>

                <a href='read_invoices.php'>
                    <button onclick="" class="btn btn-outline-primary">Przeglądaj opłaty</button>
                </a>

                <a href='chat.php'>
                    <button onclick="" class="btn btn-outline-primary">Komunikator</button>
                </a>

                <a href='notification_form.php'>
                    <button onclick="" class="btn btn-outline-primary">Dodaj ogłoszenie</button>
                </a>

                <a href='notification_show.php'>
                    <button onclick="" class="btn btn-outline-primary">Przeglądaj ogłoszenia</button>
                </a>

                <a href='faults_show.php'>
                    <button onclick="" class="btn btn-outline-primary">Przeglądaj usterki</button>
                </a>

            </div>

        </div>

    </div>

    </body>

    <?php
} else {
    echo "Brak dostępu";
}
