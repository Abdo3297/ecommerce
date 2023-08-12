<?php
$errors = array();
// connection
require_once('../config/connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    $repassword = strip_tags(trim($repassword));

    if (empty($username)) {
        $errors['userErr'] = "username is required";
    } else {
        // check if username length is < 8 char
        if (strlen($username) < 8) {
            $errors['userErr'] = "username must min have 8 characters";
        } else {
            $username = strip_tags(trim($username));
        }
    }

    if (empty($email)) {
        $errors['emailErr'] = "Email is required";
    } else {
        $email = strip_tags(trim($email));
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['emailErr'] = "Invalid email format";
        }
    }

    function validatePassword($password)
    {
        // Check for at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        // Check for at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        // Check for at least one special character
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            return false;
        }
        // All requirements met
        return true;
    }
    if (validatePassword($password)) {
        $password = strip_tags(trim($password));
    } else {
        $errors['passErr'] = "Password is not strong";
    }

    if (empty($errors)) {
        // check email not duplicate
        $check = $database->prepare("select * from users where email=:email");
        $check->bindParam("email", $email);
        $check->execute();
        if ($check->rowCount() > 0) {
            $errors['emailErr'] = "email is already exist";
        } else {
            // add user
            $addUser = $database->prepare("insert into users(username,email,password,role)values(:username,:email,:password,'user');");
            $addUser->bindParam("username", $username);
            $addUser->bindParam("email", $email);
            $addUser->bindParam("password", $password);
            if ($repassword == $password) {
                if ($addUser->execute()) {
                    header('location:login.php');
                    die;
                } else {
                    echo '<script>alert("error happend");</script>';
                }
            } else {
                $errors['RepassErr'] = "Password is not match";
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign up an account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST">
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                    <div class="mt-2">
                        <input value="<?php if (isset($username)) {
                                            echo $username;
                                        } ?>" id="username" name="username" type="text" autocomplete="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <?php echo $errors['userErr'] ?? ''; ?>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input value="<?php if (isset($email)) {
                                            echo $email;
                                        } ?>" id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <?php echo $errors['emailErr'] ?? ''; ?>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        
                    </div>
                    <div class="mt-2">
                        <input value="<?php if (isset($password)) {
                                            echo $password;
                                        } ?>" id="password" name="password" type="password" autocomplete="current-password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <label class="text-sm font-medium leading-6 text-gray-900">must contain min 1 small & 1 capital & 1 special</label>
                    <?php echo $errors['passErr'] ?? ''; ?>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                    </div>
                    <div class="mt-2">
                        <input value="<?php if (isset($repassword)) {
                                            echo $repassword;
                                        } ?>" id="password" name="repassword" type="password" autocomplete="current-password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <?php echo $errors['RepassErr'] ?? ''; ?>
                </div>

                <div>
                    <button name="register" type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign up</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                already a member?
                <a href="login.php" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">sign in</a>
            </p>
              
        </div>
    </div>
</body>

</html>