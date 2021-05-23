<?php
require_once("config.php");
global $config;
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    if (isset($_GET['id'])) {

        $pdo = new PDO($config['dsn'], $config['username'], $config['password']);
        $stmt = $pdo->prepare("DELETE FROM invoices WHERE invoiceID = ?");

        $stmt->execute([$_GET['id']]);
    }
}
header('Location: read_invoices.php');