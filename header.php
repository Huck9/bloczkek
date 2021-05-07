<div class="header">
    <a href="index.php">
        <img src="assets/images/logoWide.png" alt="logo aplikacji">
    </a>
    <form method="post">
        <?php
        if (isset($_SESSION)):
        ?>
        <input type="submit" name="logOutButton" id="logOutButton" class="btn btn-outline-danger"
               value="Wyloguj">
        <?php
        endif;
        ?>
    </form>
</div>
<?php
if (isset($_POST['logOutButton'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
}
?>