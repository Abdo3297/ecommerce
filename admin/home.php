<?php
session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin')) {
    header('Location:http://localhost/tst/login.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="../assets/css/mdb.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
</head>

<body>

    <?php include('../component/nav.php') ?>
    <?php include('../component/welcome.php') ?>
    <?php include('../component/addproduct.php') ?>
    <?php include('../component/table.php') ?>

    <script src="../assets/js/mdb.min.js"></script>
</body>

</html>