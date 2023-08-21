<?php
require_once('../component/connection.php');
session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'user')) {
    header('Location:http://localhost/ecommerce/login.php');
    die;
}
$user_id = $_SESSION['user']['id'];
if (isset($_POST['place_order'])) {

    $name = $_POST['name'];
    $name = filter_var($name, 513);

    $number = $_POST['number'];
    $number = filter_var($number, 513);

    $email = $_POST['email'];
    $email = filter_var($email, 513);

    $address = $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
    $address = filter_var($address, 513);

    $address_type = $_POST['address_type'];
    $address_type = filter_var($address_type, 513);

    $method = $_POST['method'];
    $method = filter_var($method, 513);

    $verify_cart = $database->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $verify_cart->execute([$user_id]);

    if (isset($_GET['get_id'])) {

        $get_product = $database->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);
        if ($get_product->rowCount() > 0) {
            while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                $insert_order = $database->prepare("INSERT INTO `orders`(user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?)");
                $insert_order->execute([$user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1]);
                header('location:http://localhost/ecommerce/user/orders.php');
            }
        } else {
            $warning_msg[] = 'Something went wrong!';
        }
    } elseif ($verify_cart->rowCount() > 0) {

        while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {

            $insert_order = $database->prepare("INSERT INTO `orders`(user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $number, $email, $address, $address_type, $method, $f_cart['product_id'], $f_cart['price'], $f_cart['qty']]);
        }

        if ($insert_order) {
            $delete_cart_id = $database->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart_id->execute([$user_id]);
            header('location:http://localhost/ecommerce/user/orders.php');
        }
    } else {
        $warning_msg[] = 'Your cart is empty!';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/mdb.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
</head>

<body>
    <?php include('../component/usernavbar.php'); ?>
    <h2 class="p-3 m-3 text-center">Billing Details</h2>
    <div class="container my-3">
        <form method="post">
            <div class="row mb-4">
                <div class="col">
                    <div class="form-group">
                        <p>your name <span>*</span></p>
                        <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <p>your number <span>*</span></p>
                        <input type="tel" name="number" required maxlength="10" placeholder="enter your number" class="form-control" min="0" max="9999999999">
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="form-group">
                        <p>your email <span>*</span></p>
                        <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <p>payment method <span>*</span></p>
                        <select name="method" class="form-control">
                            <option value="cash on delivery">cash on delivery</option>
                            <option value="credit or debit card">credit or debit card</option>
                            <option value="net banking">net banking</option>
                            <option value="UPI or wallets">UPI or RuPay</option>
                        </select>

                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="form-group">
                        <p>address type <span>*</span></p>
                        <select name="address_type" class="form-control">
                            <option value="home">home</option>
                            <option value="office">office</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <p>address line 01 <span>*</span></p>
                        <input type="text" name="flat" required maxlength="50" placeholder="e.g. flat & building number" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="form-group">
                        <p>address line 02 <span>*</span></p>
                        <input type="text" name="street" required maxlength="50" placeholder="e.g. street name & locality" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <p>city name <span>*</span></p>
                        <input type="text" name="city" required maxlength="50" placeholder="enter your city name" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="form-group">
                        <p>country name <span>*</span></p>
                        <input type="text" name="country" required maxlength="50" placeholder="enter your country name" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <p>pin code <span>*</span></p>
                        <input type="number" name="pin_code" required maxlength="6" placeholder="e.g. 123456" class="form-control" min="0" max="999999">
                    </div>
                </div>
            </div>
            <button name="place_order" type="submit" class="btn btn-primary btn-block mb-4">place order</button>
        </form>
        <div class="summary">
            <h2 class="p-3 m-3 text-center">cart items</h2>
            <?php
            $grand_total = 0;
            if (isset($_GET['get_id'])) {
                $select_get = $database->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_get->execute([$_GET['get_id']]);
                while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                    $sub_total = (1 * $fetch_get['price']);
                    $grand_total += $sub_total;
            ?>
                    <div class="card my-3 p-3">
                        <img style="width: 150px;height: 150px;" src="../uploaded_files/<?= $fetch_get['image']; ?>" class="card-img-top" alt="Fissure in Sandstone" />
                        <div class="card-body">
                            <h5 class="card-title"><?= $fetch_get['name']; ?></h5>
                            <p class="card-text">$<?= $fetch_get['price']; ?> x 1</p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                $select_cart = $database->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $select_cart->execute([$user_id]);
                if ($select_cart->rowCount() > 0) {
                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        $select_products = $database->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_products->execute([$fetch_cart['product_id']]);
                        $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                        $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);

                        $grand_total += $sub_total;
                    ?>
                        <div class="card my-3 p-3">
                            <img style="width: 150px;height: 150px;" src="../uploaded_files/<?= $fetch_product['image']; ?>" class="card-img-top" alt="Fissure in Sandstone" />
                            <div class="card-body">
                                <h5 class="card-title"><?= $fetch_product['name']; ?></h5>
                                <p class="card-text">$<?= $fetch_product['price']; ?> x <?= $fetch_cart['qty']; ?></p>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo '<p class="p-3 m-3 text-center">your cart is empty</p>';
                }
            }
            ?>
            <span>grand total :</span>
            <p><i class="fas fa-indian-rupee-sign"></i><?= $grand_total; ?></p>

        </div>
    </div>
    <?php include('../component/footer.php'); ?>
    <!-- Submit button -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../assets/js/mdb.min.js"></script>
    <?php include('../component/alert.php'); ?>
</body>

</html>