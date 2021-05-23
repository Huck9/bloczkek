<?php
require_once("config.php");
require_once("upload.php");
global $config;
$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";

    $stmt = $pdo->prepare("UPDATE invoices set invoiceNumber = ?, nettoValue =?, vatValue =?, bruttoValue=?, filename=?, date=? WHERE invoiceID = ?");
    $invoiceNumber = isset($_POST['invoiceNumber']) ? $_POST['invoiceNumber'] : '';
    $nettoValue = isset($_POST['nettoValue']) ? $_POST['nettoValue'] : '';
    $vatValue = isset($_POST['vatValue']) ? $_POST['vatValue'] : '';
    $bruttoValue = isset($_POST['bruttoValue']) ? $_POST['bruttoValue'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    uploadFile($_FILES['file']);
    $stmt->execute([$invoiceNumber, $nettoValue, $vatValue, $bruttoValue, $_FILES['file']['name'], $date, $_GET['id']]);

}
header('Location: read_invoices.php');