<!doctype html>
<html class="no-js" lang="">

<?php include('head.php'); ?>
<?php
session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "user") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";
    ?>
    <!doctype html>
    <?php include('head.php'); ?>
    <html class="no-js" lang="">


    <body>

    <div>

        <div class="content">

            <?php include('header.php'); ?>
            <div class="infoUser">
                <?php echo $infoUser ?>
            </div>

            <a href='voting_panel_for_user.php'>
                <button onclick="" class="btn btn-outline-primary">Głosowania</button>
            </a>

            <a href='edit_user.php'>
                <button onclick="" class="btn btn-outline-primary">Zmień hasło</button>
            </a>

            <a href='read_invoices.php'>
                <button onclick="" class="btn btn-outline-primary">Przeglądaj opłaty</button>
            </a>

            <a href='chat.php'>
                <button onclick="" class="btn btn-outline-primary">Komunikator</button>
            </a>

            <a href='camera_table.php'>
                <button onclick="" class="btn btn-outline-primary">Kamery</button>
            </a>

            <a href='fault_form.php'>
                <button onclick="" class="btn btn-outline-primary">Zgłoś usterkę</button>
            </a>

            <a href='faults_show.php'>
                <button onclick="" class="btn btn-outline-primary">Przeglądaj usterki</button>
            </a>

            <?php
            require_once("config.php");
            global $config;

            $pdo = new PDO($config['dsn'], $config['username'], $config['password']);


            $stmt = $pdo->query("SELECT * FROM `notification` where date <= CURDATE() order by date desc");
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($notifications > 0) {
                foreach ($notifications as $notification) {
                    $nTitle = $notification['title'];
                    $nText = $notification['text'];
                    $nDate = $notification['date'];
                    $nID = $notification['id'];

                    echo "<div class='newsContainer'>";
        echo "<div class='news'>";
            echo "<h2> Ogłoszenie #$nID</h2>";
            echo "<div class='card mb-3'>";
                echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>$nTitle</h5>";
                    echo "<p class='card-text'>$nText</p>";
                    echo "<p class='card-text'><small class='text-muted'>$nDate</small></p>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
        echo "</div>";

                }

            }

            ?>

        </div>


        </div>


    </body>

    </html>

    <?php
} else {
    echo "Brak dostępu";
}
