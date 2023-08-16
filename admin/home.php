<?php
require_once('../component/connection.php');
session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin')) {
    header('Location:http://localhost/ecommerce/login.php');
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
    <?php include('../component/footer.php') ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../assets/js/mdb.min.js"></script>
    <?php include('../component/alert.php'); ?>
</body>

</html>