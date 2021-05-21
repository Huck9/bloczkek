<?php
require_once("config.php");
global $config;

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

            <form action="upload.php" method="post" enctype="multipart/form-data">

                <input type="file" name="file" size="50"/>

                <br/>

                <input type="submit" value="Upload"/>

            </form>

        </div>

    </div>

    </body>

    </html>
    <?php
} else {
    echo "No session started.";
}