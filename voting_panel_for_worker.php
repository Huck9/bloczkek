<?php
session_start();

require_once("config.php");
global $config;

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

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
                <?php echo $infoUser?>
            </div>
            <a href="worker_panel.php">
                <button class="btn btn-outline-secondary">Wróć</button>
            </a>

            <?php
            $stm = $pdo->query("SELECT * FROM votings");
            $data = $stm->fetchAll();
            ?>

            <table class="table" id="table" style="margin-top:30px">
                <thead>
                <tr>
                    <th>Nazwa projektu</th>
                    <th>Koniec głosowania</th>
                    <th>Opis</th>
                    <th>Za</th>
                    <th>Wstrzymało się</th>
                    <th>Przeciw</th>
                    <th>Ilość głosów</th>
                    <th>Opcja</th>
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
                <tr style>
                    <?php
                    else:
                    ?>
                <tr>
                    <?php
                    endif;
                    ?>
                    <th scope="col"><?= $v['title'] ?></th>
                    <td scope="col"><?= $v['date'] ?></td>
                    <td scope="col"><?= $v['description'] ?></td>
                    <td scope="col"><?= $v['yes'] ?></td>
                    <td scope="col"><?= $v['without_answer'] ?></td>
                    <td scope="col"><?= $v['no'] ?></td>
                    <td scope="col"><?= strval($v['yes'] + $v['without_answer'] + $v['no']) . '/' . sizeof($users)?></td>
                    <?php if ($_SESSION['role'] == "worker") : ?>
                        <td class="actions">
                            <a href="voting_edit_form.php?id=<?= $v['votingID'] ?>" class="edit"><i
                                        class='fas fa-edit' style='font-size:24px'></i></a>

                            <a href="vote_delete.php?id=<?= $v['votingID'] ?>" class="delete"><i
                                        class='fas fa-trash-alt' style='font-size:24px'></i></a>
                        </td>
                    <?php endif; ?>
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