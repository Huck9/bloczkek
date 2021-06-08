<?php
require_once("config.php");
global $config;
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    if (isset($_GET['id'])) {

        $pdo = new PDO($config['dsn'], $config['username'], $config['password']);
        $stmt = $pdo->prepare("DELETE FROM faults WHERE faultID = ?");

        $stmt->execute([$_GET['id']]);
    }
}
header('Location: faults_show.php');