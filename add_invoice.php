<?php
require_once("config.php");
require_once("upload.php");
global $config;

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";
    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);
    $stmt = $pdo->prepare("INSERT INTO invoices (userID, invoiceNumber, nettoValue, vatValue, bruttoValue, filename, date, status) values (?,?,?,?,?,?,?,?)");
    $userID = isset($_POST['option']) ? $_POST['option'] : '';
    echo $userID . "\n";
    $invoiceNumber = isset($_POST['invoiceNumber']) ? $_POST['invoiceNumber'] : '';
    echo  $invoiceNumber. "\n";
    $nettoValue = isset($_POST['nettoValue']) ? $_POST['nettoValue'] : '';
    echo $nettoValue. "\n";
    $vatValue = isset($_POST['vatValue']) ? $_POST['vatValue'] : '';
    echo $vatValue. "\n";
    $bruttoValue = isset($_POST['bruttoValue']) ? $_POST['bruttoValue'] : '';
    echo $bruttoValue. "\n";
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    echo $date. "\n";
    uploadFile($_FILES['file']);
    $done = $stmt->execute([$userID, $invoiceNumber,$nettoValue,$vatValue,$bruttoValue,$_FILES['file']['name'],$date,"nie zapłacone"]);
    if($done)
    {
        $_SESSION['done'] = True;
    }
    else{
        $_SESSION['done'] = False;
    }
}

header('Location: add_invoice_form.php');