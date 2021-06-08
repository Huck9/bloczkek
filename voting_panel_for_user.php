<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) and $_SESSION['role'] == 'user') {
    $infoUser =  "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    require_once("config.php");
    global $config;

    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

    $stm = $pdo->prepare('SELECT * FROM users WHERE login = ?');
    $stm->execute([$_SESSION['name']]);
    $userID = $stm->fetch(PDO::FETCH_ASSOC);
    $userID = $userID['userID'];

    $stm = $pdo->query("SELECT * FROM votings");
    $votings = $stm->fetchAll();

    ?>
    <!doctype html>
    <html class="no-js" lang="">

    <?php include('head.php'); ?>

    <body>

    <div>

        <div class="content">

            <?php include('header.php'); ?>
            <div class="infoUser">
                <?php echo $infoUser?>
            </div>
            <a href="user_panel.php">
                <button class="btn btn-outline-secondary">Wróć</button>
            </a>

            <div id="votings" style="margin-top:30px">
                <?php
                $stm = $pdo->query("SELECT * FROM votings");
                $data = $stm->fetchAll();
                $num = 0;
                foreach ($data as $d) {
                    if (strtotime($d['date']) - time() > -2592000)
                    {
                    $stm = $pdo->prepare("SELECT * FROM user_votes WHERE userID = ? AND votingID = ?");
                    $stm->execute([$userID, $d['votingID']]);
                    $votes = $stm->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div id="vote<?php echo $num ?>">
                        <form action="" method="POST">
                            <input id="vote" name="voting" value="<?php echo $num ?>" style="display: none">
                            <div class="card" style="margin-top:30px">

                                <h5 class="card-header">Temat głosowania: <?= $d['title'] ?></h5>

                                <div class="card-body">



                                    <h5 class="card-title">Opis: <?= $d['description'] ?></h5>
                                    <p class="card-text">Koniec głosowania: <?= $d['date'] ?></p>


                            <div id="buttons">
                                <?php
                                if ($votes == null and strtotime($d['date']) - time() > 0):
                                    ?>
                                    <input type="submit" class="btn btn-success" name="buttons" id="yes" value="Za">
                                    <input type="submit" class="btn btn-secondary" name="buttons" id="without_answer"
                                           value="Wstrzymuję się">
                                    <input type="submit" class="btn btn-danger" name="buttons" id="no" value="Przeciw">
                                <?php
                                elseif (strtotime($d['date']) - time() < 0):
                                    ?>
                                <p style="color: red;">Głosowanie dobiegło końca</p>
                                    <div class="card-text" style="display:flex; flex-direction: row">
                                    <p style="color: green; font-weight: bold;"> Za: <?= $d['yes']?> </p>
                                    <p style="color: gray; font-weight: bold; margin-left: 10px""> Wstrzymało się: <?= $d['without_answer']?> </p>
                                    <p style="color: red; font-weight: bold; margin-left: 10px""> Przeciw: <?= $d['no']?> </p>
                                    </div>
                                <?php
                                else:
                                    if ($votes['answer'] == "Za"):
                                        ?>
                                        <input type="submit" class="btn btn-success" name="buttons" id="yes" value="Za"
                                               disabled="disabled" style="color: white; border: 3px solid green">
                                    <?php
                                    else:
                                        ?>
                                        <input type="submit" class="btn bg-transparent" name="buttons" id="yes" value="Za"
                                               disabled="disabled" style="">
                                    <?php
                                    endif;
                                    if ($votes['answer'] == "Wstrzymuje sie"):
                                        ?>
                                        <input type="submit" class="btn btn-secondary" name="buttons" id="no" value="Wstrzymuje sie"
                                               disabled="disabled" style="color: white; border: 3px solid black">
                                    <?php
                                    else:
                                        ?>
                                        <input type="submit" class="btn bg-transparent" name="buttons" id="no" value="Wstrzymuje sie"
                                               disabled="disabled">
                                    <?php
                                    endif;
                                    if ($votes['answer'] == "Przeciw"):
                                        ?>
                                        <input type="submit" class="btn btn-danger" name="change" id="change"
                                               value="Przeciw" disabled="disabled" style="color: white; border: 3px solid red">
                                    <?php
                                    else:
                                        ?>
                                        <input type="submit" class="btn bg-transparent" name="change" id="change"
                                               disabled="disabled" value="Przeciw">
                                    <?php
                                    endif;
                                    ?>
                                    <input type="submit" style="margin-left: 20px" class="btn btn-outline-info" name="change" id="change"
                                           value="Zmień decyzję">
                                <?php endif;
                                }
                                ?>
                            </div>
                        </form>
                    </div>
            </div>
                    <?php
                    $num++;
                }
                ?>
            </div>
    </div>
        </div>

    </div>

    </body>

    </html>
    <?php

    if (isset($_POST['buttons'])) {
        $votingID = $_POST['voting'];
        $sql = "INSERT INTO user_votes (userID, votingID, answer) VALUES (?,?,?)";
        $stmt = $pdo->prepare($sql);

        $votingID = (int)$votingID;

        if ($_POST['buttons'] == "Za") {
            $stmt->execute([$userID, $votings[$votingID]['votingID'], "Za"]);
            $sql = "UPDATE votings SET yes = yes + 1 WHERE votingID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$votings[$votingID]['votingID']]);

        } elseif ($_POST['buttons'] == "Wstrzymuję się") {
            $stmt->execute([$userID, $votings[$votingID]['votingID'], "Wstrzymuje sie"]);
            $sql = "UPDATE votings SET without_answer = without_answer + 1 WHERE votingID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$votings[$votingID]['votingID']]);

        } elseif ($_POST['buttons'] == "Przeciw") {
            $stmt->execute([$userID, $votings[$votingID]['votingID'], "Przeciw"]);
            $sql = "UPDATE votings SET no = no + 1 WHERE votingID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$votings[$votingID]['votingID']]);
        }


        echo "<meta http-equiv='refresh' content='0'>";
    }

    if (isset($_POST['change'])) {
        $votingID = $_POST['voting'];

        $sql = "SELECT * FROM user_votes WHERE userID = ? AND votingID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userID, $votings[$votingID]['votingID']]);
        $f = $stmt->fetch(PDO::FETCH_ASSOC);

        $answer = $f['answer'];

        if ($f['answer'] == "Za") {
            $sql = "UPDATE votings SET yes = yes - 1 WHERE votingID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$votings[$votingID]['votingID']]);

        } elseif ($f['answer'] == "Wstrzymuje sie") {
            $sql = "UPDATE votings SET without_answer = without_answer - 1 WHERE votingID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$votings[$votingID]['votingID']]);

        } elseif ($f['answer'] == "Przeciw") {
            $sql = "UPDATE votings SET no = no - 1 WHERE votingID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$votings[$votingID]['votingID']]);
        }

        $sql = "DELETE FROM user_votes WHERE userID = ? AND votingID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userID, $votings[$votingID]['votingID']]);

        echo "<meta http-equiv='refresh' content='0'>";
    }

} else {
    echo "Brak dostępu";
}

