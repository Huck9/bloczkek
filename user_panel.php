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

            <a href='voting_panel_for_user.php'>
                <button onclick="" class="btn btn-outline-primary">Głosowania</button>
            </a>

        </div>

    </div>

    </body>

    </html>

    <?php
} else {
    echo "Brak dostępu";
}
