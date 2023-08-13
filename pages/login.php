<?php
    $errors = [];
    require_once('../config/connection.php');

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // username and password sent from form
        $email = $_POST['email'];
        $pass = $_POST['password'];
        // filter
        $email = strip_tags($email);
        $email = filter_var($email, 517);
        $pass = strip_tags($pass);
        // validate
        if (empty($email)) {
            $errors['emailErr'] = "email is required";
        }
        if(empty($pass)){
            $errors['passErr'] = "password is required";
        }
        // check correct data
        $login = $database->prepare("SELECT * FROM users WHERE email = ? and password = ?");
        $login->execute([$email, $pass]);
        if($login->rowCount()==1){
            $response = $login->fetch(PDO::FETCH_ASSOC); 
            session_start();
            $_SESSION["user"]= $response;
            if($response["role"] == 'user'){
                header('Location:user.php');
                die;
            }else{
                header('Location:admin.php');
                die;
            }
        }else{
            $errors['passErr'] = "password is required";
        }
    }
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    <?= $errors['emailErr']??''?>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    
                    <?= $errors['passErr']??''?>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Not a member?
                <a href="register.php" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">create new account</a>
            </p>
              
        </div>
    </div>
</body>

</html> 