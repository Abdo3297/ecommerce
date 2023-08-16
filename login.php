<?php
    $errors = [];
    require_once('./component/connection.php');

    
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
                header('Location:/user/home.php');
                die;
            }else{
                header('Location:/admin/home.php');
                die;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./assets/css/mdb.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="center">
        <form method="post">
            <!-- Email input -->
            <div class="form-outline mb-4">
                <input name="email" type="email" id="form2Example1" class="form-control" />
                <label class="form-label" for="form2Example1">Email address</label>
            </div>
            <?= $errors['emailErr']??''?>
            <!-- Password input -->
            <div class="form-outline mb-4">
                <input name="password" type="password" id="form2Example2" class="form-control" />
                <label class="form-label" for="form2Example2">Password</label>
            </div>
            <?= $errors['passErr']??''?>
            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                        <label class="form-check-label" for="form2Example31"> Remember me </label>
                    </div>
                </div>

                <div class="col">
                    <!-- Simple link -->
                    <a href="#!">Forgot password?</a>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>

    <script src="./assets/js/mdb.min.js"></script>
</body>

</html>