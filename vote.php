<?php
require_once("config.php");
global $config;

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

$stm = $pdo->query("SELECT ID FROM users WHERE name = {$_SESSION['name']}");
if ($stm != null) {
    $userID = $stm->fetchAll();
} else {
    $userID = null;
}

if ($userID != null) {
    $stm = $pdo->query("SELECT answer FROM user_votes WHERE userID = {$userID}");
}

$stm = $pdo->query("SELECT * FROM votings");
$votings = $stm->fetchAll();

$dom = new DomDocument();
$dom->loadHTMLFile("voting_panel_for_user.php");


if (isset($_POST['buttons'])) {
    $sql = "INSERT INTO users (userID, votingID, aswer) VALUES (?,?,?)";
    $stmt = $pdo->prepare($sql);

    if ($_POST['buttons'] == "Za") {
        $button = $dom->getElementById("yes");
        $votingID = substr($button->parentNode->parentNode->getAttribute("id"), 4);
        echo $votingID;
        $stmt->execute([$userID, $votings[$votingID]['ID'], "Za"]);
    } elseif ($_POST['buttons'] == "Wstrzymuję się") {
        $button = $dom->getElementById("without_answer");
        echo $button->tagName;
        $votingID = $button->parentNode->parentNode->getAttribute("id");
        echo $votingID;
        $stmt->execute([$userID, $votings[$votingID]['ID'], "Wstrzymuję się"]);
    } elseif ($_POST['buttons'] == "Przeciw") {
        $button = $dom->getElementById("no");
        $votingID = substr($button->parentNode->parentNode->getAttribute("id"), 4);
        echo $votingID;
        $stmt->execute([$userID, $votings[$votingID]['ID'], "Przeciw"]);
    }
}