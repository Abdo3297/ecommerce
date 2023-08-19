<?php

if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    $verify_cart = $database->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $verify_cart->bindParam("user_id", $_SESSION['user']['id']);
    $verify_cart->bindParam("product_id", $product_id);
    $verify_cart->execute();

    $max_cart_items = $database->prepare("SELECT * FROM cart WHERE user_id = :user_id");
    $max_cart_items->bindParam("user_id", $_SESSION['user']['id']);
    $max_cart_items->execute();

    if ($verify_cart->rowCount() > 0) {
        $warning_msg[] = 'Already added to cart!';
    } elseif ($max_cart_items->rowCount() == 10) {
        $warning_msg[] = 'Cart is full!';
    } else {

        $select_price = $database->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $select_price->bindParam("id", $product_id);
        $select_price->execute();
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_cart = $database->prepare("INSERT INTO cart(user_id, product_id, price, qty) VALUES(?,?,?,?)");
        $insert_cart->execute([$_SESSION['user']['id'], $product_id, $fetch_price['price'], $qty]);
        $success_msg[] = 'Added to cart!';
    }
}

// get all data
$statement = $database->prepare("SELECT * FROM products");
$statement->execute();
if ($statement->rowCount() == 0) {
    $warning = 'No products found';
}
?>
<div class="container">
    <?php
    if (isset($warning)) {
        echo '<p class="text-center text-capitalize text-danger">' . $warning . '</p>';
    } else {
        foreach ($statement as $p) {
    ?>
            <form method="post">
                <div class="card my-3 p-3">
                    <img style="width: 150px;height: 150px;" src="../uploaded_files/<?= $p['image'] ?>" class="card-img-top" alt="Fissure in Sandstone" />
                    <div class="card-body">
                        <h5 class="card-title"><?= $p['name'] ?></h5>
                        <div class="d-flex justify-content-between">
                            <p class="card-text">$<?= $p['price'] ?></p>
                            <input name="qty" type="number" min="1" value="1" max="10" maxlength="2" class="w-25 mb-2">
                        </div>
                        <input type="hidden" name="product_id" value="<?= $p['id']; ?>">
                        <button name="add_to_cart" type="submit" class="btn btn-info mb-1 w-100">Add to Cart</button>
                        <a href="" class="btn btn-danger d-block">Buy Now</a>
                    </div>
                </div>
            </form>
    <?php
        }
    }
    ?>

</div>