<?php
    try {
        $database = new PDO("mysql:host=localhost;dbname=ecommerce", "root", "");
    } catch (PDOException $e) {
        die($e->getMessage());
    }