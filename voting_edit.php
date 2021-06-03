<?php
require_once("config.php");
require_once("upload.php");
global $config;
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";

    $stmt = $pdo->prepare("UPDATE votings set title=?, date=? ,description=? WHERE votingID = ?");
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $text = isset($_POST['description']) ? $_POST['description'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';

    $stmt->execute([$title, $date, $text, $_GET['id']]);

}
header('Location: voting_panel_for_worker.php');
