<?php
session_start();
if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') {
    header('Location:http://localhost/ecommerce/pages/admin/dash.php');
    die;
} else {
    header('Location:http://localhost/ecommerce/pages/login.php');
    die;
}