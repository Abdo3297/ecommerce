<?php
// array of errors
$errors = array();
######################################################
// connection
require_once('connection.php');

######################################################
// register
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
    ######################################################
    // logic
    if (empty($errors)) {
        // add product
        $addproduct = $database->prepare("insert into products(name,price,image)values(:name,:price,:image);");
        $addproduct->bindParam("name", $namePrd);
        $addproduct->bindParam("price", $pricePrd);
        $addproduct->bindParam("image", $_FILES["image"]["name"]);
        if ($addproduct->execute()) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $success_msg[] = "product added successfully :)";
        }
    }
}
?>


<!-- Button trigger modal -->
<div class="container">
    <button type="button" class="btn btn-primary py-3 my-3 w-100 text-capitalize" data-mdb-toggle="modal"
        data-mdb-target="#exampleModal">
        add product
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="exampleModalLabel">add product</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- name input -->
                    <div class="form-outline mb-4">
                        <input name="name" type="text" id="name" class="form-control" />
                        <label class="form-label" for="name">Name</label>
                    </div>
                    <?= $errors['nameErr'] ?? ''; ?>
                    <!-- Price input -->
                    <div class="form-outline mb-4">
                        <input name="price" type="number" id="number" class="form-control" min="1"
                            max="<?= PHP_INT_MAX ?>" />
                        <label class="form-label" for="number">Price</label>
                    </div>

                    <!-- photo -->
                    <p>choose a photo to product</p>
                    <div class="form-outline mb-4">
                        <input name="image" type="file" id="photo" class="form-control" accept="image/*" />
                    </div>
                    <?= $errors['imgErr'] ?? ''; ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>