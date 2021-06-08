<?php
require_once("config.php");
global $config;

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);
    $stm = $pdo->query('SELECT * FROM users WHERE accountType = "user"');
    $users = $stm->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!doctype html>
    <html class="no-js" lang="">

    <?php include('head.php'); ?>
    <script>
        $(document).ready(function () {
            $('#vatValue, #nettoValue').change(function () {
                let totalValue = 0
                totalValue += parseFloat(parseFloat($('#nettoValue').val()) + parseFloat($('#vatValue').val()));
                totalValue = totalValue.toFixed(2)
                $('#bruttoValue').val(totalValue);
            });
        });
    </script>
    <body>

    <div>
        <div class="content">

            <?php include('header.php'); ?>

            <div class="infoUser">
                <?php echo $infoUser ?>
            </div>

            <a href="worker_panel.php">
                <button class="btn btn-outline-secondary">Wróć</button>
            </a>

            <form method="post" action="add_invoice.php" enctype="multipart/form-data" style="margin-top:30px">

                <div class="inputs">

                    <div class="form-group"><label>Numer Faktury:</label> <input type="text" required
                                                                                 name="invoiceNumber"
                                                                                 class="form-control"></div>
                    <p>Wybierz mieszkańca: </p>
                    <select name="option" id="search_select" class="form-control" >
                        <?php
                        foreach ($users as $user) {
                            ?>
                            <option name="choice" value="<?= $user['userID'] ?>"><?= $user['userID'] ?>, <?= $user['name'] ?> <?= $user['surname']?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <div class="form-group"><label for="nettoValue">Wartość netto:</label> <input type="number"
                                                                                                  id="nettoValue"
                                                                                                  required step="0.01"
                                                                                                  name="nettoValue"
                                                                                                  class="form-control">
                    </div>
                    <div class="form-group"><label for="vatValue">Wartość VAT:</label> <input type="number" required
                                                                                              step="0.01" id="vatValue"
                                                                                              name="vatValue"
                                                                                              class="form-control">
                    </div>
                    <div class="form-group"><label for="bruttoValue">Watrosc brutto:</label> <input type="number"
                                                                                                    id="bruttoValue"
                                                                                                    required readonly
                                                                                                    step="0.01"
                                                                                                    name="bruttoValue"
                                                                                                    class="form-control">
                    </div>
                    <div class="form-group"><label>Data faktury:</label> <input type="date" required name="date"
                                                                                class="form-control"></div>
                    <div class="form-group"><label>Dodaj plik</label>
                        <input type="file" class="form-control-file" name="file" size="50" required><br>

                    </div>
                    <input type="submit" class="btn btn-secondary">

                </div>

            </form>

        </div>

        <?php
        if (isset($_SESSION['done']) && $_SESSION['done'] == True)
        {
            echo "Faktura dodana poprawnie";
            $_SESSION['done'] = null;
        }
        elseif (isset($_SESSION['done']) && $_SESSION['done'] == False)
        {
            echo "Błąd w dodawaniu faktury";
            $_SESSION['done'] = null;
        }
        ?>

    </div>
    </body>

    <?php
} else {
    echo "No session started.";
}
