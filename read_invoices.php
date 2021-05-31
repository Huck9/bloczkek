<?php

require_once("config.php");
global $config;

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "user" or "worker") {
    $infoUser = "Aktualnie zalogowany: {$_SESSION['name']}, ID sesji: " . session_id() . ", rola: {$_SESSION['role']} ";

    $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

    $brutto = 0;
    $stmt = $pdo->query("SELECT * FROM invoices ");
    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cnt = 0;
    foreach ($invoices as $invoice):
        $cnt++;
        $brutto += $invoice['bruttoValue'];
    endforeach;

    $limit = 25;
    $currentPage = 0;
    $page = ceil($cnt / $limit);

    if (isset($_GET["page"])) {
        $currentPage = $_GET["page"];
    }
    $offset = $limit * $currentPage;
    $isSearch = false;

    if (isset($_GET['search']) && isset($_GET['option']) && !isset($_GET['all'])) {
        $isSearch = true;
        $search = $_GET['search'];
        $option = $_GET['option'];

        if ($option == 'invoiceNumber') {
            $stmt = $pdo->prepare("SELECT * FROM invoices WHERE invoiceNumber LIKE ? ORDER BY date LIMIT $offset, $limit");
        } elseif ($option == 'date') {
            $stmt = $pdo->prepare("SELECT * FROM invoices WHERE date=? ORDER BY date LIMIT $offset, $limit");
        }

        $stmt->execute([$search]);
        $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo->query("SELECT * FROM invoices ORDER BY date LIMIT $offset, $limit");
        $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    ?>

    <!doctype html>
    <html class="no-js" lang="">

    <?php include('head.php'); ?>

    <body>

    <div>

        <div class="content">

            <?php include('header.php'); ?>
            <div class="infoUser">
                <?php echo $infoUser ?>
            </div>
            <?php

            if ($_SESSION['role'] == "user"):
            ?>
            <a href="user_panel.php">
                <?php
                elseif ($_SESSION['role'] == "worker"):
                ?>


                <a href="worker_panel.php">
                    <?php
                    endif;
                    ?>


                    <button class="btn btn-outline-secondary">Wróć</button>
                </a>


                <form action="#">
                    <div class="form-group" style="margin-top: 30px">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Podaj numer faktury">
                    </div>
                    <div class="form-group">
                    <select name="option" id="search_select" class="form-control">
                        <option value="invoiceNumber">Numer faktury</option>
                        <option value="date">Data</option>
                    </select>
                    </div>
                    <button class="btn btn-outline-primary">Szukaj</button>
                    <button name="all" class="btn btn-outline-primary">Pokaż wszystko</button>
                </form>
                <p></p>
                <div id='invTable'>
                    <table class="table" id="table">
                        <thead>
                        <tr class="category">

                            <th scope="col">Numer faktury</th>
                            <th scope="col">Wartość netto</th>
                            <th scope="col">Wartość VAT</th>
                            <th scope="col">Wartość brutto</th>
                            <th scope="col">Data faktury</th>
                            <th scope="col">Status</th>
                            <th scope="col">Podgląd faktury</th>
                            <?php if ($_SESSION['role'] == "worker") : ?>
                                <th scope="col">Opcja</th>
                                <th scope="col">Działanie</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr class="type">
                                <td><?= $invoice['invoiceNumber'] ?></td>
                                <td><?= $invoice['nettoValue'] ?></td>
                                <td><?= $invoice['vatValue'] ?></td>
                                <td><?= $invoice['bruttoValue'] ?></td>
                                <td><?= $invoice['date'] ?></td>
                                <td><?= $invoice['status'] ?></td>
                                <td><a href="invoice_detail.php?id=<?= $invoice['invoiceID'] ?>"
                                       class="edit">podgląd</a></td>
                                <?php if ($_SESSION['role'] == "worker") : ?>
                                    <td class="actions">
                                        <a href="edit_invoice_form.php?id=<?= $invoice['invoiceID'] ?>" class="edit"><i
                                                    class='fas fa-edit' style='font-size:24px'></i></a>

                                        <a href="delete_invoice.php?id=<?= $invoice['invoiceID'] ?>" class="delete"><i
                                                    class='fas fa-trash-alt' style='font-size:24px'></i></a>
                                    </td>
                                    <td>
                                        <form action="read_invoices.php" method="POST">
                                            <input id="number" name="number" value="<?php echo $invoice['invoiceID'] ?>"
                                                   style="display: none">
                                            <?php if ($invoice['status'] == "nie zapłacone") : ?>
                                                <input type="submit" name="payment" id="payed"
                                                       value="Oznacz jako zapłacone">
                                            <?php elseif ($invoice['status'] == "zapłacone") : ?>
                                                <input type="submit" name="payment" id="not_payed"
                                                       value="Cofnij status zapłaconego">
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php
                if ($invoices != null) {
                    echo "Strona:";
                    for ($i = 1; $i <= $page; $i++) {
                        ?>
                        <a href="read_invoices.php?page=<?= $i - 1 ?>"><?= $i ?></a>
                        <?php
                    }
                    if (!$isSearch) {
                        ?>

                        <p>Ogółem do zapłaty: <?= $brutto ?></p>
                        <?php
                    }
                }
                ?>

        </div>

    </div>

    </body>

    </html>

    <?php
} else {
    echo "No session started.";
}

if (isset($_POST['payment'])) {
    $status = $_POST['payment'];
    $id = $_POST['number'];
    if ($status == "Oznacz jako zapłacone") {
        $stmt = $pdo->prepare("UPDATE invoices SET status = ? WHERE invoiceID = $id");
        $stmt->execute(["zapłacone"]);
    } elseif ($status == "Cofnij status zapłaconego") {
        $stmt = $pdo->prepare("UPDATE invoices SET status = ? WHERE invoiceID = $id");
        $stmt->execute(["nie zapłacone"]);
    }
    echo "<meta http-equiv='refresh' content='0'>";
}
