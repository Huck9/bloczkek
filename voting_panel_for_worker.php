<?php
session_start();

require_once("config.php");
global $config;

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

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

            <a href="worker_panel.php">
                <button>Wróć</button>
            </a>

            <?php
            $stm = $pdo->query("SELECT * FROM votings");
            $data = $stm->fetchAll();
            ?>

            <table>
                <thead>
                <tr>
                    <th>Nazwa projektu</th>
                    <th>Koniec głosowania</th>
                    <th>Opis</th>
                    <th>Za</th>
                    <th>Wstrzymało się</th>
                    <th>Przeciw</th>
                    <th>Ilość głosów</th>
                </tr>
                </thead>
                <?php

                $stm = $pdo->query("SELECT * FROM votings");
                $votes = $stm->fetchAll(PDO::FETCH_ASSOC);

                $stm = $pdo->query("SELECT * FROM users WHERE accountType = 'user'");
                $users = $stm->fetchAll(PDO::FETCH_ASSOC);

                foreach ($votes as $v) {
                if (strtotime($v['date']) - time() < 0):
                ?>
                <tr style="background: gray">
                    <?php
                    else:
                    ?>
                <tr>
                    <?php
                    endif;
                    ?>
                    <td><?= $v['title'] ?></td>
                    <td><?= $v['date'] ?></td>
                    <td><?= $v['description'] ?></td>
                    <td><?= $v['yes'] ?></td>
                    <td><?= $v['without_answer'] ?></td>
                    <td><?= $v['no'] ?></td>
                    <td><?= strval($v['yes'] + $v['without_answer'] + $v['no']) . '/' . sizeof($users)?></td>
                    <?php
                    }
                    ?>

                </tr>
            </table>

        </div>

    </div>

    </body>

    <?php
} else {
    echo "Brak dostępu";
}