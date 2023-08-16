<?php
// array of errors
$errors = array();
######################################################
// connection
require_once('./component/connection.php');

######################################################
// register
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // get data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['cpassword'];
    ######################################################
    // filter
    $repassword = strip_tags($repassword);
    // validate username
    if (empty($username)) {
        $errors['userErr'] = "username is required";
    } else {
        if (strlen($username) < 8) {
            $errors['userErr'] = "username must min have 8 characters";
        } else {
            $username = strip_tags(trim($username));
        }
    }
    ######################################################
    // validate email
    if (empty($email)) {
        $errors['emailErr'] = "Email is required";
    } else {
        $email = strip_tags(trim($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['emailErr'] = "Invalid email format";
        }
    }
    ######################################################
    // validate password
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
        $password = strip_tags($password);
    } else {
        $errors['passErr'] = "Password is not strong";
    }
    ######################################################
    // validate image
    $target_dir = "uploaded_files/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check file size
    if ($_FILES["image"]["size"] > 900000) {
        $errors['imgErr'] = "Sorry, your file is too large.";
    }
    // Allow certain file formats
    if ($imageFileType != "png" && $imageFileType != "jpg") {
        $errors['imgErr'] = "Sorry, only PNG files are allowed.";
    }
    ######################################################
    // logic
    if (empty($errors)) {
        // check email not exist
        $check = $database->prepare("select * from users where email=:email");
        $check->bindParam("email", $email);
        $check->execute();
        if ($check->rowCount() > 0) {
            $errors['emailErr'] = "email is already exist";
        } else {
            // add user
            $addUser = $database->prepare("insert into users(username,email,password,role,image)values(:username,:email,:password,'user',:image);");
            $addUser->bindParam("username", $username);
            $addUser->bindParam("email", $email);
            $addUser->bindParam("password", $password);
            $addUser->bindParam("image", $_FILES["image"]["name"]);
            if ($repassword == $password) {
                if ($addUser->execute()) {
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file); 
                    header('location:login.php');
                    die;
                }
            } else {
                $errors['RepassErr'] = "Password is not match";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="./assets/css/mdb.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    
</head>

<body>
    <div class="center">
        <form method="post" enctype="multipart/form-data">
            <!-- User input -->
            <div class="form-outline mb-4">
                <input autocomplete="on" name="username" type="text" id="Username" class="form-control" />
                <label class="form-label" for="Username">Username</label>
            </div>
            <?php echo $errors['userErr'] ?? ''; ?>
            <!-- Email input -->
            <div class="form-outline mb-4">
                <input autocomplete="on" name="email" type="email" id="Email" class="form-control" />
                <label class="form-label" for="Email">Email address</label>
            </div>
            <?php echo $errors['emailErr'] ?? ''; ?>
            <!-- Password input -->
            <div class="form-outline mb-4">
                <input autocomplete="on" name="password" type="password" id="Password" class="form-control" />
                <label class="form-label" for="Password">Password</label>
            </div>
            <?php echo $errors['passErr'] ?? ''; ?>
            <!-- Confirm Password input -->
            <div class="form-outline mb-4">
                <input autocomplete="on" name="cpassword" type="password" id="Confirm" class="form-control" />
                <label class="form-label" for="Confirm">Confirm Password</label>
            </div>
            <?php echo $errors['RepassErr'] ?? ''; ?>
            <!-- photo -->
            <p>choose a photo to your account</p>
            <div class="form-outline mb-4">
                <input type="file" name="image" id="photo" class="form-control" accept="image/*" />
            </div>
            <?php echo $errors['imgErr'] ?? ''; ?>


            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">Sign up</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Already a member? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
    <script src="./assets/js/mdb.min.js"></script>
    <!-- <?php include('./component/alert.php');?> -->
</body>

</html>