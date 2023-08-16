<?php
$errors = array();
require_once('../component/connection.php');

session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin')) {
    header('Location:http://localhost/ecommerce/login.php');
    die;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get data
    $namePrd = $_POST['name'];
    $pricePrd = $_POST['price'];
    ######################################################

    // validate name product
    if (empty($namePrd)) {
        $errors['nameErr'] = "product name is required";
    } else {
        $namePrd = strip_tags(trim($namePrd));
    }
    ######################################################
    // validate image
    $target_dir = "../uploaded_files/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check file size
    if ($_FILES["image"]["size"] > 900000) {
        $errors['imgErr'] = "Sorry, your file is too large.";
    }
    // Allow certain file formats
    if ($imageFileType != "webp") {
        $errors['imgErr'] = "Sorry, only webp files are allowed.";
    }
    if(empty($errors)) {
        $updateproduct = $database->prepare("update products set name=:name,price=:price,image=:image where id=:id");
        $updateproduct->bindParam("id", $_POST['update']);
        $updateproduct->bindParam("name", $namePrd);
        $updateproduct->bindParam("price", $pricePrd);
        $updateproduct->bindParam("image", $_FILES["image"]["name"]);
        if ($updateproduct->execute()) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $success_msg[] = "product edited successfully :)";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/mdb.min.css">
</head>

<body>
    <div class="center">
        <?php
        if (isset($_GET['edit'])) {
            $getdata = $database->prepare("select * from products where id=:id");
            $id = $_GET['edit'];
            $getdata->bindParam("id", $id);
            $getdata->execute();
            foreach ($getdata as $val) {
        ?>
                <form method="post" enctype="multipart/form-data">
                    <!-- name input -->
                    <div class="form-outline mb-4">
                        <input value="<?= $val['name']?>" name="name" type="text" class="form-control" />
                        <label class="form-label" for="name">Name</label>
                    </div>
                    <?= $errors['nameErr'] ?? ''; ?>
                    <!-- Price input -->
                    <div class="form-outline mb-4">
                        <input value="<?= $val['price']?>" name="price" type="number" class="form-control" min="1" max="<?= PHP_INT_MAX ?>" />
                        <label class="form-label" for="number">Price</label>
                    </div>
                    <!-- photo -->
                    <p>choose a photo to product</p>
                    <div class="form-outline mb-4">
                        <input value="<?= $val['image']?>" name="image" type="file" class="form-control" accept="image/*" />
                    </div>
                    <?= $errors['imgErr'] ?? ''; ?>
                    <!-- Submit button -->
                    <button value="<?= $val['id']?>" name="update" type="submit" class="btn btn-primary btn-block mb-4">Edit</button>
                    <a href="http://localhost/ecommerce/admin/home.php" class="btn btn-danger btn-block">Cancel</a>
                </form>
        <?php
            }
        }
        ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../assets/js/mdb.min.js"></script>
    <?php include('../component/alert.php'); ?>
</body>

</html>