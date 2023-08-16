<?php
require_once('connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $delete = $database->prepare("delete from products where id = :id");
    $id = $_POST['delete'];
    $delete->bindParam("id",$id);
    if($delete->execute()) {
        header('location:http://localhost/ecommerce/admin/home.php');
    }
}