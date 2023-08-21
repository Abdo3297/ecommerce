<?php
require_once('../component/connection.php');
session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'user')) {
    header('Location:http://localhost/ecommerce/login.php');
    die;
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
    <h2 class="p-3 m-3 text-center">My Orders</h2>
    <div class="container my-3">
        <?php
        $select_orders = $database->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY date DESC");
        $select_orders->execute([$user_id]);
        if ($select_orders->rowCount() > 0) {
            while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                $select_product = $database->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_product->execute([$fetch_order['product_id']]);
                if ($select_product->rowCount() > 0) {
                    while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
        ?>
                        <div class="card my-3 p-3" <?php if ($fetch_order['status'] == 'canceled') {
                                                        echo 'style="border:.2rem solid red";';
                                                    }; ?>>
                            <a href="view_order.php?get_id=<?= $fetch_order['id']; ?>">
                                <p><i class="fa fa-calendar"></i><span><?= $fetch_order['date']; ?></span></p>
                                <img class="card-img-top" alt="Fissure in Sandstone" style="width: 150px;height: 150px;" src="../uploaded_files/<?= $fetch_product['image']; ?>">
                                <div class="card-body">
                                    <h3><?= $fetch_product['name']; ?></h3>
                                    <p><i class="fas fa-indian-rupee-sign"></i> <?= $fetch_order['price']; ?> x <?= $fetch_order['qty']; ?></p>
                                    <p style="color:<?php if ($fetch_order['status'] == 'delivered') {
                                                        echo 'green';
                                                    } elseif ($fetch_order['status'] == 'canceled') {
                                                        echo 'red';
                                                    } else {
                                                        echo 'orange';
                                                    }; ?>"><?= $fetch_order['status']; ?></p>
                                </div>
                            </a>
                        </div>
        <?php
                    }
                }
            }
        } else {
            echo '<p class="my-3 py-3 text-center text-capitalize">no orders found!</p>';
        }
        ?>
    </div>
    <?php include('../component/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../assets/js/mdb.min.js"></script>
    <?php include('../component/alert.php'); ?>
</body>

</html>