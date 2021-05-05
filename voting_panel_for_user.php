<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>

<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>

        <a href="user_panel.php"><button>Wróć</button></a>

        <div id="votings">

        </div>

    </div>

</div>

</body>

</html>

<?php

require_once("config.php");
global $config;

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

$stm = $pdo->query("SELECT * FROM votings");
$data = $stm->fetchAll();

$dom = new DOMDocument();
$dom->loadHTMLFile("voting_panel_for_user.php");

foreach ($data as $d)
{
    $votings = $dom->getElementById("votings");
    $vote = $dom->createElement('div');
    $vote->setAttribute('name', 'vote');
    $votings->appendChild($vote);
    $title = $dom->createElement('div');
    $title->setAttribute('name', 'title');
    $title->nodeValue = 'Tytuł: ' . $d['title'];
    $vote->appendChild($title);
    $date = $dom->createElement('div');
    $date->setAttribute('name', 'date');
    $date->nodeValue = 'Koniec głosowania: ' . $d['date'];
    $vote->appendChild($date);
    $description = $dom->createElement('div', );
    $description->setAttribute('name', 'description');
    $description->nodeValue = 'Opis: ' . $d['description'];
    $vote->appendChild($description);
    $buttons = $dom->createElement('div');
    $buttons->setAttribute('name', 'buttons');
    $button_yes = $dom->createElement('button', 'Za');
    $button_without_answer = $dom->createElement('button', 'Wstrzymuję się');
    $button_no = $dom->createElement('button', 'Przeciw');
    $buttons->appendChild($button_yes);
    $buttons->appendChild($button_without_answer);
    $buttons->appendChild($button_no);
    $vote->appendChild($buttons);
}

echo $dom->saveHTML($votings);

?>
