<?php
require_once('../../config/connection.php');
session_start();

if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin')) {
    header('Location:http://localhost/ecommerce/pages/login.php');
    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updateUserData = $database->prepare("UPDATE users SET username = :username,email = :email,password =:password WHERE id = :id");
    $updateUserData->bindParam('username', $_POST['username']);
    $updateUserData->bindParam('email', $_POST['email']);
    $updateUserData->bindParam('password', $_POST['password']);
    $updateUserData->bindParam('id', $_POST['update']);

    if ($updateUserData->execute()) {
        $user = $database->prepare("SELECT * FROM users WHERE id = :id ");
        $user->bindParam('id', $_POST['update']);
        $user->execute();
        $_SESSION['user'] = $user->fetch(PDO::FETCH_ASSOC);
        header("refresh:2;");
    } else {
        echo '<script>alert("Fail");</script>';
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form#profile {
            max-width: 480px;
            width: 100%;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include('../../components/nav.php'); ?>

    <div class="container">
        <form id="profile" method="post">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Profile</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">This information will be displayed publicly so be careful what you share.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                            <div class="mt-2">
                                <input value="<?= $_SESSION['user']['username'] ?>" id="username" name="username" type="text" autocomplete="text" class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="Email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2">
                                <input value="<?= $_SESSION['user']['email'] ?>" id="Email" name="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="Password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="mt-2">
                                <input value="<?= $_SESSION['user']['password'] ?>" id="Password" name="password" type="password" autocomplete="password" class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="http://localhost/ecommerce/pages/admin/dash.php" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <button value="<?= $_SESSION['user']['id']; ?>" type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" name="update">Save</button>
            </div>
        </form>
    </div>


    <script src="./assets/js/script.js"></script>
</body>

</html>