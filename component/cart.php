<?php
// update quantity
if (isset($_POST['update_cart'])) {

    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, 513);
    $qty = $_POST['qty'];
    $qty = filter_var($qty, 513);

    $update_qty = $database->prepare("UPDATE cart SET qty = :qty WHERE id = :id");
    $update_qty->bindParam("qty", $qty);
    $update_qty->bindParam("id", $cart_id);
    $update_qty->execute();

    $success_msg[] = 'Cart quantity updated!';
}

// delete item from cart
if(isset($_POST['delete_item'])){
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, 513);
    $delete_cart_id = $database->prepare("DELETE FROM cart WHERE id = :id");
    $delete_cart_id->bindParam("id", $cart_id);
    $delete_cart_id->execute();
    $success_msg[] = 'Cart item deleted!';
}
// delete all items in cart
if (isset($_POST['empty_cart'])) {

    $delete_cart_id = $database->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $delete_cart_id->bindParam("user_id", $_SESSION['user']['id']);
    $delete_cart_id->execute();
    $success_msg[] = 'Cart emptied!';
}


?>
<?php
$grand_total = 0;
$selectCart = $database->prepare("select * from cart where user_id = :user_id");
$selectCart->bindParam("user_id", $_SESSION['user']['id']);
$selectCart->execute();
if ($selectCart->rowCount() > 0) {
    foreach ($selectCart as $sc) {
        $selectProducts = $database->prepare("SELECT * FROM products WHERE id = :id");
        $selectProducts->bindParam("id", $sc['product_id']);
        $selectProducts->execute();
        if ($selectProducts->rowCount() > 0) {
            $selectProducts = $selectProducts->fetch(PDO::FETCH_ASSOC);
?>
            <div class="container">
                <form method="post">
                    <input type="hidden" name="cart_id" value=<?= $sc['id']; ?> />
                    <div class="card my-3 p-3">
                        <img style="width: 150px;height: 150px;" src="../uploaded_files/<?= $selectProducts['image']; ?>" class="card-img-top" alt="Fissure in Sandstone" />
                        <div class="card-body">
                            <h5 class="card-title"><?= $selectProducts['name']; ?></h5>
                            <div class="d-flex justify-content-between">
                                <p class="card-text">$<?= $sc['price']; ?></p>
                                <div>
                                    <input name="qty" type="number" min="1" value="<?= $sc['qty']; ?>" max="10" maxlength="2" class="w-50">
                                    <button type="submit" name="update_cart" class="fas fa-edit btn btn-outline-info mt-1"></button>
                                </div>
                            </div>
                            <p class="sub-total">sub total : <span><i class="fas fa-indian-rupee-sign"></i><?= $sub_total = ($sc['qty'] * $sc['price']); ?></span></p>
                            <input type="submit" value="delete" name="delete_item" class="btn btn-danger btn-block" onclick="return confirm('delete this item?');">
                        </div>
                    </div>
                </form>
            </div>
<?php
            $grand_total += $sub_total;
        } else {
            echo '<h2 class="p-3 m-3 text-center">product was not found!</h2>';
        }
    }
} else {
    echo '<h2 class="p-3 m-3 text-center">your cart is empty!</h2>';
}
?>
<?php if ($grand_total != 0) { ?>
    <div class="container alert alert-warning" role="alert">
        <p>grand total : <span><i class="fas fa-indian-rupee-sign"></i> <?= $grand_total; ?></span></p>
            <form method="POST">
                    <input type="submit" value="empty cart" name="empty_cart" class="btn btn-danger btn-block my-2" onclick="return confirm('empty your cart?');">
            </form>
            <a href="http://localhost/ecommerce/user/checkout.php" class="btn btn-info btn-block">proceed to checkout</a>
    </div>
<?php } ?>