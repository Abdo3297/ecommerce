<?php
require_once('../component/connection.php');
session_start();
if (!(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'user')) {
    header('Location:http://localhost/ecommerce/login.php');
    die;
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
        <form>
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
            <div class="card my-3 p-3">
                <img style="width: 150px;height: 150px;" src="../uploaded_files/bag.webp" class="card-img-top" alt="Fissure in Sandstone" />
                <div class="card-body">
                    <h5 class="card-title">bag</h5>
                    <p class="card-text">$50 x 1</p>
                    <span>grand total :</span>
                    <p><i class="fas fa-indian-rupee-sign"></i>50000</p>
                </div>
            </div>
        </div>
    </div>
    <?php include('../component/footer.php'); ?>
    <!-- Submit button -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="../assets/js/mdb.min.js"></script>
    <?php include('../component/alert.php'); ?>
</body>

</html>