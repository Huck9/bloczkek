<?php

require_once("config.php");
global $config;

session_start();
if (isset($_SESSION) && isset($_SESSION['name']) && $_SESSION['role'] == "user" or "worker") {
    echo "Current user: {$_SESSION['name']}, session id: " . session_id() . ", role: {$_SESSION['role']} ";

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

            <?php include('header.php');

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
                    <button>Wróć</button>
                </a>

            <form action="#">
                <input type="text" id="search" name="search" placeholder="Podaj numer faktury">
                <select name="option" id="search_select">
                    <option value="invoiceNumber">Numer faktury</option>
                    <option value="date">Data</option>
                </select>
                <button>Szukaj</button>
                <button name="all">Pokaż wszystko</button>
            </form>
            <p></p>
            <table id="table">
                <thead>
                <tr class="category">

                    <th>Numer faktury</th>
                    <th>Wartość netto</th>
                    <th>Wartość VAT</th>
                    <th>Wartość brutto</th>
                    <th>Data faktury</th>
                    <th>Status</th>
                    <th>Podgląd faktury</th>
                    <?php if ($_SESSION['role'] == "worker") : ?>
                        <th>Opcja</th>
                        <th>Działanie</th>
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
                        <td><a href="invoice_detail.php?id=<?= $invoice['invoiceID'] ?>" class="edit">podgląd</a></td>
                        <?php if ($_SESSION['role'] == "worker") : ?>
                            <td class="actions">
                                <a href="edit_invoice_form.php?id=<?= $invoice['invoiceID'] ?>" class="edit"><i
                                            class='fas fa-edit' style='font-size:24px'></i></a>

                                <a href="delete_invoice.php?id=<?= $invoice['invoiceID'] ?>" class="delete"><i
                                            class='fas fa-trash-alt' style='font-size:24px'></i></a>
                            </td>
                            <td>
                                <form action="read_invoices.php" method="POST">
                                    <input id="number" name="number" value="<?php echo $invoice['invoiceID'] ?>" style="display: none">
                                    <?php if ($invoice['status'] == "nie zapłacone") : ?>
                                        <input type="submit" name="payment" id="payed" value="Oznacz jako zapłacone">
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
