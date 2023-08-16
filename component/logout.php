<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_unset();
    session_destroy();
    header('Location:http://localhost/ecommerce/login.php');
    die;
}