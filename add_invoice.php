<?php
require_once("config.php");
require_once("upload.php");
global $config;

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";
    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);
    $stmt = $pdo->prepare("INSERT INTO invoices (invoiceNumber, nettoValue, vatValue, bruttoValue, filename, date) values (?,?,?,?,?,?)");
    $invoiceNumber = isset($_POST['invoiceNumber']) ? $_POST['invoiceNumber'] : '';
    $nettoValue = isset($_POST['nettoValue']) ? $_POST['nettoValue'] : '';
    $vatValue = isset($_POST['vatValue']) ? $_POST['vatValue'] : '';
    $bruttoValue = isset($_POST['bruttoValue']) ? $_POST['bruttoValue'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    uploadFile($_FILES['file']);
    $stmt->execute([$invoiceNumber,$nettoValue,$vatValue,$bruttoValue,$_FILES['file']['name'],$date]);
}

header('Location: worker_panel.php');