<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name'])) {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";
    ?>
<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>

<body>

<div>

    <div class="content">

        <?php include('header.php'); ?>

        <a href="worker_panel.php"><button>Wróć</button></a>

        <form action="add_vote.php" method="POST">

            <div class="forms">

                <div class="form-group">
                    <p>Nazwa: <label for="title"></label><input type="text" name="title" class="form-control" id="title"
                                                                placeholder="..."></p>
                </div>

                <div class="form-group">
                    <p>Termin zakończenia: <label for="date"></label><input type="date" name="date" class="form-control"
                                                                            id="date" placeholder="..."></p>
                </div>

                <div class="form-group">
                    <p>Opis: <label for="description"></label><input type="text" name="description" class="form-control"
                                                                     id="description" placeholder="..."></p>
                </div>

                <div class="userButtons">
                    <div class="addArea">
                        <input type="submit" name="add" id="add" value="Dodaj" class="btn btn-outline-primary">
                    </div>
                </div>

                <div id="error"></div>
            </div>

    </div>

</div>

</body>

<?php
} else {
    echo "Brak dostępu";
}

require_once("config.php");
global $config;

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    if ($title == "" or $date == null or $description == ""){
        ?>
        <script type="text/javascript">
            document.getElementById("error").innerHTML = "<?php echo "Wypełnij wszystkie pola" ?>";
        </script>
        <?php
    }
    else{
        $sql = "INSERT INTO votings (title, date, description, yes, no, without_answer) VALUES (?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $date, $description, 0, 0, 0]);
        header("location: worker_panel.php");
    }
}
?>