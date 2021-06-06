<?php

require_once("config.php");
global $config;
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    $stmt = $pdo->prepare('SELECT * FROM notification WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $notification = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <!doctype html>
    <html class="no-js" lang="">

    <?php include('head.php'); ?>

<body>


<div class="content">

    <?php include('header.php'); ?>

    <div class="infoUser">
        <?php echo $infoUser ?>
    </div>
    <a href="read_invoices.php">
        <button class="btn btn-outline-secondary">Wróć</button>
    </a>

    <form method="POST" action="notification_edit.php?id=<?= $_GET['id'] ?>">
        <div class="inputs">
            <div class="form-group"><label>Tytył ogłoszenia:</label> <input type="text" name="title"
                                                                         value="<?= $notification['title'] ?>"
                                                                         class="form-control" required minlength="5"></div>
            <div class="form-group"><label>Treść ogłoszenia:</label> <input type="text" id="text" name="text"
                                                                         value="<?= $notification['text'] ?>"
                                                                         class="form-control" required
                                                                            minlength="10"></div>
            <div class="form-group"><label>Data publikacji: </label><input type="date" id="date" step="0.01" name="date"
                                                                       value="<?= $notification['date'] ?>"
                                                                       class="form-control" required min=<?php
                echo date('Y-m-d');
                ?> ></div>
            <div class="form-group"><input type="submit" name="submit" class="btn btn-outline-primary">
            </div>
    </form>

</div>

    <?php
} else {
    echo "No session started.";
}

