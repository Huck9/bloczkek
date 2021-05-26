<?php
session_start();

$people = "";
$msgs = "";
if (isset($_SESSION) && isset($_SESSION['name']) and isset($_SESSION['role'])) {

    require_once("config.php");
    global $config;

    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

    $stm = $pdo->prepare('SELECT * FROM users WHERE login = ?');
    $stm->execute([$_SESSION['name']]);
    $userID = $stm->fetch(PDO::FETCH_ASSOC);
    $userID = $userID['userID'];

    if ($_SESSION['role'] == 'user'){
        $ppl = $pdo->prepare('SELECT * FROM users WHERE accountType = "ADMIN" or accountType = "worker" and not login = :name');
    } else {
        $ppl = $pdo->prepare('SELECT * FROM users WHERE not login = :name');
    }
    $ppl->execute(array('name'=>$_SESSION['name']));
    $people_names = $ppl->fetchAll(PDO::FETCH_ASSOC);
    $people = "";
    if (isset($_POST['person'])){
        $_SESSION['other_person'] = $_POST['person'];
    } else {
        $_SESSION['other_person'] = $people_names[0]["userID"];
    }
    $person_ID = $_SESSION['other_person'];
    foreach ($people_names as $ppln){
        $name="";
        $name = $ppln["name"] . " " . $ppln["surname"];
        $people_id = $ppln["userID"];
        if ($person_ID == $people_id){
            $people = $people . "<option value='$people_id' selected='selected'>$name</option>";
        } else {
            $people = $people . "<option value='$people_id'>$name</option>";
        }
    }

    if (isset($_SESSION['postdata']) && $_SERVER["REQUEST_METHOD"] == "POST"){
        if ($_SESSION['postdata'] == $_POST) $flag = false;
        else $flag = true;
    } else $flag = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['person']) && $flag){
        if (isset($_POST['msg_text']) && isset($_POST['send']) && $person_ID != -1 && strlen($_POST['msg_text']) > 0){
            $snd = $pdo->prepare('INSERT INTO chat_logs (from_user, to_user, date, time, content) VALUES (:userID,:person_ID,:date,:time,:content)');
            $date = date("Y-m-d");
            $time = date('H:i:s');
            $snd->execute(array('userID'=>$userID,'person_ID'=>$person_ID,'date'=>$date,'time'=>$time,'content'=>$_POST['msg_text']));
        }
    }

    $req = $pdo->prepare('SELECT * FROM chat_logs where (from_user = :user_id and to_user = :other_user_id) or (from_user = :other_user_id2 and to_user = :user_id2) order by date');
    $req->execute(array('user_id'=>$userID, 'other_user_id'=>$person_ID, 'other_user_id2'=>$person_ID, 'user_id2'=>$userID));
    $messages = $req->fetchAll(PDO::FETCH_ASSOC);
    $msgs = "";
    if (sizeof($messages) > 0){
        $msg_date = $messages[0]['date'];
        $msgs = $msgs . "<div class='chat_date'>$msg_date</div>";
    }
    foreach ($messages as $msg){
        $txt = $msg['content'];
        if ($msg_date != $msg['date']) {
            $msg_date = $msg['date'];
            $msgs = $msgs . "<div class='chat_date'>$msg_date</div>";
        }
        if ($msg['from_user'] == $userID){
            $msgs = $msgs . "<div class='my_message'>$txt</div>";
        } else{
            $msgs = $msgs . "<div class='others_message'>$txt</div>";
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

<body>
<div>

    <div class="content">

        <?php include('header.php'); ?>

        <form id="select_person" name="select_person" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>
                <select name="person" onchange="form.submit();">
                    <?php echo $people;?>
                </select>
            </label>

        <div id="chat_field">
            <?php echo $msgs;?>
        </div>

            <label>
                <input type="text" size="255" id="msg_text_field" name="msg_text">
            </label>
            <input type="submit" name='send' value="Wyślij">
        </form>

    </div>

</div>

</body>

</html>
