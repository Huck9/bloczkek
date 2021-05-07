<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) and $_SESSION['role'] == 'user') {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";

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

    <?php include("head.php"); ?>

    <body>

    <div>

        <div class="content">

            <?php include("header.php"); ?>

            <a href="user_panel.php">
                <button>Wróć</button>
            </a>

            <div id="votings">
                <?php
                $stm = $pdo->query("SELECT * FROM votings");
                $data = $stm->fetchAll();
                $num = 0;
                foreach ($data as $d) {
                    $stm = $pdo->prepare("SELECT * FROM user_votes WHERE userID = ? AND votingID = ?");
                    $stm->execute([$userID, $d['votingID']]);
                    $votes = $stm->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div id="vote<?php echo $num ?>">
                        <form action="" method="POST">
                            <input id="vote" name="voting" value="<?php echo $num ?>" style="display: none">
                            <div id="title">
                                <p>Nazwa projektu: </p>
                                <p><?= $d['title'] ?></p>
                            </div>
                            <div id="date">
                                <p>Koniec głosowania: </p>
                                <p><?= $d['date'] ?></p>
                            </div>
                            <div id="description">
                                <p>Opis: </p>
                                <p><?= $d['description'] ?></p>
                            </div>
                            <div id="buttons">
                                <?php
                                if ($votes == null):
                                    ?>
                                    <input type="submit" class="buttons" name="buttons" id="yes" value="Za">
                                    <input type="submit" class="buttons" name="buttons" id="without_answer"
                                           value="Wstrzymuję się">
                                    <input type="submit" class="buttons" name="buttons" id="no" value="Przeciw">
                                <?php
                                else:
                                    if ($votes['answer'] == "Za"):
                                        ?>
                                        <input type="submit" class="buttons" name="buttons" id="yes" value="Za"
                                               disabled="disabled" style="color: green">
                                    <?php
                                    else:
                                        ?>
                                        <input type="submit" class="buttons" name="buttons" id="yes" value="Za"
                                               disabled="disabled">
                                    <?php
                                    endif;
                                    if ($votes['answer'] == "Wstrzymuje sie"):
                                        ?>
                                        <input type="submit" class="buttons" name="buttons" id="no" value="Wstrzymuje sie"
                                               disabled="disabled" style="color: green">
                                    <?php
                                    else:
                                        ?>
                                        <input type="submit" class="buttons" name="buttons" id="no" value="Wstrzymuje sie"
                                               disabled="disabled">
                                    <?php
                                    endif;
                                    if ($votes['answer'] == "Przeciw"):
                                        ?>
                                        <input type="submit" class="buttons" name="change" id="change"
                                               value="Przeciw" disabled="disabled" style="color: green">
                                    <?php
                                    else:
                                        ?>
                                        <input type="submit" class="buttons" name="change" id="change"
                                               disabled="disabled" value="Przeciw">
                                    <?php
                                    endif;
                                    ?>
                                    <input type="submit" class="buttons" name="change" id="change"
                                           value="Zmień decyzję">
                                <?php endif;
                                ?>
                            </div>
                        </form>
                    </div>
                    <?php
                    $num++;
                }
                ?>
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

