<?php

require_once("config.php");
global $config;
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    $stmt = $pdo->prepare('SELECT * FROM votings WHERE votingId = ?');
    $stmt->execute([$_GET['id']]);
    $voting = $stmt->fetch(PDO::FETCH_ASSOC);
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

    <form method="POST" action="voting_edit.php?id=<?= $_GET['id'] ?>">
        <div class="inputs">
            <div class="form-group"><label>Nazwa projektu:</label> <input type="text" name="title"
                                                                            value="<?= $voting['title'] ?>"
                                                                            class="form-control" required></div>
            <div class="form-group"><label>Koniec głosowania:</label> <input type="date" id="date"  name="date"
                                                                            value="<?= $voting['date'] ?>"
                                                                            class="form-control" required></div>
            <div class="form-group"><label>Opis: </label><input type="text" id="description" name="description"
                                                                           value="<?= $voting['description'] ?>"
                                                                           class="form-control" required></div>
            <div class="form-group"><input type="submit" name="submit" class="btn btn-outline-primary">
            </div>
    </form>

</div>

    <?php
} else {
    echo "No session started.";
}

