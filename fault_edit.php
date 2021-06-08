<?php
require_once("config.php");
require_once("upload.php");
global $config;
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";

    $stmt = $pdo->prepare("UPDATE faults set status=? WHERE faultID = ?");
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $stmt->execute([$status, $_GET['id']]);

}
header('Location: faults_show.php');
