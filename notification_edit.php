<?php
require_once("config.php");
require_once("upload.php");
global $config;
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";

    $stmt = $pdo->prepare("UPDATE notification set title=?, text=? ,date=? WHERE id = ?");
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $text = isset($_POST['text']) ? $_POST['text'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';

    $stmt->execute([$title, $text, $date, $_GET['id']]);

}
header('Location: notification_show.php');
