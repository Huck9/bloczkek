<?php

session_start();
require_once("config.php");
global $config;


if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "user" or "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

    $stm = $pdo->query("SELECT * FROM cameras");
    $cameras= $stm->fetchAll();

    $stm2 = $pdo->query("SELECT * FROM users");
    $users= $stm2->fetchAll();
    $buildingId = 0;
    foreach ($users as $u) {
        if(strval($u['login'])==$_SESSION['name'] ){
            $buildingId=$u['building_id'];
        }
    }

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

            <a href="user_panel.php">
                <button class="btn btn-outline-secondary">Wróć</button>
            </a>
                <div id='invTable'>
                    <table class="table" id="table">
                        <thead>
                        <tr class="category">
                            <th scope="col">Id kamery</th>
                            <th scope="col">Link</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($cameras as $camera) : ?>
                            <?php if($buildingId == $camera['building_id']): ?>
                                <tr class="type">
                                    <td><?=  $camera['id'] ?></td>
                                    <td><a href="<?php echo $camera['link'] ?>"><?php echo $camera['link'] ?></a></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>



        </div>

    </div>

    </body>

    </html>

    <?php
} else {
    echo "No session started.";
}