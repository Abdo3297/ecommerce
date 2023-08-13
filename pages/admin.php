<?php
session_start();
if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <h1>hello admin
            <?= $_SESSION['user']['username']; ?>
        </h1>
        <form method="get">

            <button type="submit" name="logout">log out</button>
        </form>
    </body>

    </html>
<?php
} else {
    header('Location:login.php');
    die;
}
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location:login.php');
}
?>