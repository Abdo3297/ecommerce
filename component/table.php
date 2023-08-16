<?php
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
                                <a href="http://localhost/ecommerce/admin/edit.php?edit=<?= $p['id']; ?>" class="btn btn-warning btn-sm btn-rounded my-2">
                                    Edit
                                </a>
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