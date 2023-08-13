<?php
session_start();
if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'user') {
    header('Location:http://localhost/ecommerce/pages/user/user.php');
    die;
} else {
    header('Location:http://localhost/ecommerce/pages/login.php');
    die;
}