<?php
require_once('connection.php');
$sql = "SELECT * FROM `products`;";
$statement = $database->prepare($sql);
$statement->execute();
if ($statement->rowCount() == 0) {
    $warning = 'No products found';
}
?>

<div class="container table-responsive">
    <table class="table table-striped table-bordered align-middle mb-0 bg-white">
        <thead class="bg-dark text-light">
            <tr>
                <th>Name</th>
                <th>price</th>
                <th>image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($warning)) {
                echo '<td colspan=4>' . $warning . '</td>';
            } else {
                foreach ($statement as $p) {
            ?>
                    <tr>
                        <td>
                            <p class="fw-normal mb-1"><?= $p['name']; ?></p>
                        </td>
                        <td>
                            <p class="fw-normal mb-1">$<?= $p['price']; ?></p>
                        </td>
                        <td>
                            <img src="../uploaded_files/<?= $p['image']; ?>" alt="" style="width: 70px; height: 70px" />
                        </td>
                        <form method="post" action="../component/delete.php">
                            <td>
                                <button data-id="<?= $p['id']; ?>" data-name="<?= $p['name']; ?>" data-number="<?= $p['price']; ?>" data-image="<?= $p['image']; ?>" data-mdb-toggle="modal" data-mdb-target="#exampleModal2" type="button" class="btn btn-warning btn-sm btn-rounded my-2">
                                    Edit
                                </button>
                                <!-- <a href="edit.php?edit=<?= $p['id']; ?>" class="btn btn-warning btn-sm btn-rounded my-2">
                                    Edit
                                </a> -->
                                <button value="<?= $p['id']; ?>" name="delete" type="submit" class="btn btn-danger btn-sm btn-rounded my-2">
                                    Delete
                                </button>
                            </td>
                        </form>

                    </tr>
            <?php
                }
            }

            ?>

        </tbody>
    </table>
</div>
<!-- Modal of edit -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">edit product</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <!-- name input -->
                    <div class="form-outline mb-4">
                        <input name="name" type="text" id="name" class="form-control" />
                        <label class="form-label" for="name">Name</label>
                    </div>
                    <?= $errors['nameErr'] ?? ''; ?>
                    <!-- Price input -->
                    <div class="form-outline mb-4">
                        <input name="price" type="number" id="number" class="form-control" min="1" max="<?= PHP_INT_MAX ?>" />
                        <label class="form-label" for="number">Price</label>
                    </div>

                    <!-- photo -->
                    <p>choose a photo to product</p>
                    <div class="form-outline mb-4">
                        <input name="image" type="file" id="image" class="form-control" accept="image/*" />
                    </div>
                    <?= $errors['imgErr'] ?? ''; ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">edit</button>
                </div>
            </form>
        </div>
    </div>
</div>