<?php

require_once("config.php");
global $config;

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "user" or "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

    $stmt = $pdo->query("SELECT * FROM faults order by faultID asc");
    $faults = $stmt->fetchAll(PDO::FETCH_ASSOC);



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
            <?php

            if ($_SESSION['role'] == "user"):
            ?>
            <a href="user_panel.php">
                <?php
                elseif ($_SESSION['role'] == "worker"):
                ?>


                <a href="worker_panel.php">
                    <?php
                    endif;
                    ?>


                    <button class="btn btn-outline-secondary">Wróć</button>
                </a>



                <div id='invTable'>
                    <table class="table" id="table">
                        <thead>
                        <tr class="category">


                            <th scope="col">Id usterki</th>
                            <th scope="col">Opis usterki</th>
                            <th scope="col">Data opublikowania</th>
                            <th scope="col">Status</th>

                            <?php if ($_SESSION['role'] == "worker") : ?>
                                <th scope="col">Opcja</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($faults as $fault) : ?>
                            <?php
                            if($fault['status'] == 0)
                                $status = 'Zgłoszono';
                            elseif ($fault['status'] == 1)
                                $status = 'Przyjęto do realizacji';
                            elseif ($fault['status'] == 2)
                                $status = 'W trakcie naprawy';
                            elseif ($fault['status'] == 3)
                                $status = 'Naprawiono';
                            elseif ($fault['status'] == 9)
                                $status = 'Odrzucono'; ?>
                            <tr class="type">
                                <td><?=  $fault['faultID'] ?></td>
                                <td><?= $fault['description'] ?></td>
                                <td  style="display: flex; flex-direction: row;"><?=  $fault['date'] ?></td>
                                <td ><?=  $status ?></td>

                                <?php if ($_SESSION['role'] == "worker") : ?>
                                    <td class="actions">
                                        <a href="faults_edit_form.php?id=<?= $fault['faultID'] ?>" class="edit"><i
                                                class='fas fa-edit' style='font-size:24px'></i></a>

                                        <a href="fault_delete.php?id=<?= $fault['faultID'] ?>" class="delete"><i
                                                class='fas fa-trash-alt' style='font-size:24px'></i></a>
                                    </td>
                                <?php endif; ?>
                            </tr>
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


