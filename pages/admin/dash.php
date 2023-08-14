<?php
session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin')) {
    header('Location:http://localhost/ecommerce/pages/login.php');
    die;
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
    <div class="min-h-full">
        <?php include('../../components/nav.php'); ?>

        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-center text-3xl font-bold tracking-tight text-gray-900">Dashboard , Hello <span class="text-red-600"><?= $_SESSION['user']['username'] ?></span></h1>
            </div>
        </header>

        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <!-- Your content -->
            </div>
        </main>
    </div>
    <script src="./assets/js/script.js"></script>
</body>

</html>