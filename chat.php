<?php
session_start();
if (isset($_POST['logOutButton'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
}
$people = "";
$msgs = "";
$back_btn = "";
if (isset($_SESSION) && isset($_SESSION['name']) and isset($_SESSION['role'])) {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";
    if ($_SESSION['role'] == 'user') {
        $back_btn = "<a href='user_panel.php'>
            <button class='btn btn-outline-secondary'>Wróć</button>
        </a>";
    } elseif ($_SESSION['role'] == 'worker') {
        $back_btn = "<a href='worker_panel.php'>
            <button class='btn btn-outline-secondary'>Wróć</button>
        </a>";
    } elseif ($_SESSION['role'] == 'ADMIN') {
        $back_btn = "<a href='admin_panel.php'>
            <button class='btn btn-outline-secondary'>Wróć</button>
        </a>";
    }
    require_once("config.php");
    global $config;
    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

    $stm = $pdo->prepare('SELECT * FROM users WHERE login = ?');
    $stm->execute([$_SESSION['name']]);
    $userID = $stm->fetch(PDO::FETCH_ASSOC);
    $userID = $userID['userID'];

    if ($_SESSION['role'] == 'user') {
        $ppl = $pdo->prepare('SELECT * FROM users WHERE accountType = "ADMIN" or accountType = "worker" and not login = :name');
    } else {
        $ppl = $pdo->prepare('SELECT * FROM users WHERE not login = :name');
    }
    $ppl->execute(array('name' => $_SESSION['name']));
    $people_names = $ppl->fetchAll(PDO::FETCH_ASSOC);
    $people = "";
    if (isset($_POST['person'])) {
        $_SESSION['other_person'] = $_POST['person'];
    } else {
        $_SESSION['other_person'] = $people_names[0]["userID"];
    }
    $person_ID = $_SESSION['other_person'];
    foreach ($people_names as $ppln) {
        $name = "";
        $name = $ppln["name"] . " " . $ppln["surname"];
        $people_id = $ppln["userID"];
        if ($person_ID == $people_id) {
            $people = $people . "<option value='$people_id' selected='selected'>$name</option>";
        } else {
            $people = $people . "<option value='$people_id'>$name</option>";
        }
    }

    if (isset($_SESSION['postdata']) && $_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_SESSION['postdata'] == $_POST) $flag = false;
        else $flag = true;
    } else $flag = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['person']) && $flag) {
        if (isset($_POST['msg_text']) && isset($_POST['send']) && $person_ID != -1 && strlen($_POST['msg_text']) > 0) {
            $snd = $pdo->prepare('INSERT INTO chat_logs (from_user, to_user, date, time, content) VALUES (:userID,:person_ID,:date,:time,:content)');
            $date = date("Y-m-d");
            $time = date('H:i:s');
            $snd->execute(array('userID' => $userID, 'person_ID' => $person_ID, 'date' => $date, 'time' => $time, 'content' => $_POST['msg_text']));
        }
    }

    $req = $pdo->prepare('SELECT * FROM chat_logs where (from_user = :user_id and to_user = :other_user_id) or (from_user = :other_user_id2 and to_user = :user_id2) order by date');
    $req->execute(array('user_id' => $userID, 'other_user_id' => $person_ID, 'other_user_id2' => $person_ID, 'user_id2' => $userID));
    $messages = $req->fetchAll(PDO::FETCH_ASSOC);
    $msgs = "";
    if (sizeof($messages) > 0) {
        $msg_date = $messages[0]['date'];
        $msgs = $msgs . "<div class='chat_date'>$msg_date</div>";
    } else {
        $msgs = $msgs . "<div id='chat_no_msg'>Brak wiadomości</div>";
    }
    foreach ($messages as $msg) {
        $txt = $msg['content'];
        if ($msg_date != $msg['date']) {
            $msg_date = $msg['date'];
            $msgs = $msgs . "<div class='chat_date'>$msg_date</div>";
        }
        if ($msg['from_user'] == $userID) {
            $msgs = $msgs . "<div class='chat_my_message'>$txt</div>";
        } else {
            $msgs = $msgs . "<div class='chat_others_message'>$txt</div>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['postdata'] = $_POST;
        unset($_POST);
    }
}
?>

<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<body>
<div>

    <div class="content">

        <?php include('header.php'); ?>
        <div class="infoUser">
            <?php echo $infoUser ?>
        </div>
        <?php echo $back_btn ?>
        <form id="chat_select_person" name="select_person" method="post"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <select name="person" class="selectpicker show-tick" data-width="fit" data-style="btn-primary"  data-live-search="true"onchange="form.submit();">
                <optgroup label="Odbiorca wiadomości">
                <?php echo $people; ?>
                </optgroup>
            </select>

            <div id="chat_field" style="margin-top: 20px">
                <?php echo $msgs; ?>
            </div>


            <div class="input-group mb-3" style="margin-top: 20px">
                <input type="text" class="form-control" name="msg_text" placeholder="Wprowadź treść wiadomości..." aria-label="Wprowadź treść wiadomości..." aria-describedby="basic-addon2" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit" name='send' value="Wyślij">Wyślij wiadomość</button>
                </div>
            </div>
        </form>

    </div>

</div>

</body>

</html>
