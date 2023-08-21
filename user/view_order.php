<?php
require_once('../component/connection.php');
session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'user')) {
    header('Location:http://localhost/ecommerce/login.php');
    die;
}
if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:orders.php');
}

if (isset($_POST['cancel'])) {

    $update_orders = $database->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
    $update_orders->execute(['canceled', $get_id]);
    header('location:orders.php');
}
$user_id = $_SESSION['user']['id'];
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
    <h2 class="p-3 m-3 text-center">Order Details</h2>
    <div class="container my-3">
        <?php
        $grand_total = 0;
        $select_orders = $database->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
        $select_orders->execute([$get_id]);
        if ($select_orders->rowCount() > 0) {
            while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                $select_product = $database->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
                $select_product->execute([$fetch_order['product_id']]);
                if ($select_product->rowCount() > 0) {
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                        $sub_total = ($fetch_order['price'] * $fetch_order['qty']);
                        $grand_total += $sub_total;
        ?>
                        <div class="row">
                            <div class="col">
                                <p><i class="fas fa-calendar"></i><?= $fetch_order['date']; ?></p>
                                <img src="../uploaded_files/<?= $fetch_product['image']; ?>" class="image" alt="">
                                <p><i class="fas fa-indian-rupee-sign"></i> <?= $fetch_order['price']; ?> x <?= $fetch_order['qty']; ?></p>
                                <h3><?= $fetch_product['name']; ?></h3>
                                <p>grand total : <span><i class="fas fa-indian-rupee-sign"></i> <?= $grand_total; ?></span></p>
                            </div>
                            <div class="col">
                                <p>billing address</p>
                                <p><i class="fas fa-user"></i><?= $fetch_order['name']; ?></p>
                                <p><i class="fas fa-phone"></i><?= $fetch_order['number']; ?></p>
                                <p><i class="fas fa-envelope"></i><?= $fetch_order['email']; ?></p>
                                <p><i class="fas fa-map-marker-alt"></i><?= $fetch_order['address']; ?></p>
                                <p>status</p>
                                <p style="color:<?php if ($fetch_order['status'] == 'delivered') {
                                                    echo 'green';
                                                } elseif ($fetch_order['status'] == 'canceled') {
                                                    echo 'red';
                                                } else {
                                                    echo 'orange';
                                                }; ?>"><?= $fetch_order['status']; ?></p>
                                <?php if ($fetch_order['status'] == 'canceled') { ?>
                                    <a href="checkout.php?get_id=<?= $fetch_product['id']; ?>">order again</a>
                                <?php } else { ?>
                                    <form method="POST">
                                        <input type="submit" value="cancel order" name="cancel" class="btn btn-danger btn-block" onclick="return confirm('cancel this order?');">
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
        <?php
                    }
                } else {
                    echo '<p class="empty">product not found!</p>';
                }
            }
        } else {
            echo '<p class="empty">no orders found!</p>';
        }
        ?>
    </div>
    <?php include('../component/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../assets/js/mdb.min.js"></script>
    <?php include('../component/alert.php'); ?>
</body>

</html>