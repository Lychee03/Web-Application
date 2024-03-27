<?php 
    include 'components/connect.php';
    
    error_reporting(0);
    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    } else {
        $user_id = '';
        header('location:login.php');
    }
    
    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id=? ORDER BY FIELD(status, 'in progress', 'complete', 'canceled'), date DESC");
    $select_orders->execute([$user_id]);    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- box icon cdn link  -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/user_style.css">
    <title>The Moon Florist - My Order Page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    
    <div class="banner">
        <div class="detail">
            <h1>my order</h1>
            <p>Your Floral Dreams Come True: <br>
            Explore, Customize, and Order Today!</p>
            <span><a href="home.html">home</a><i class='bx bx-right-arrow-alt'></i>my order</span>
        </div>
    </div>
    <div class="orders">
        <div class="heading">
            <h1>my orders</h1>
            <img src="image/separator.png" alt="">         
        </div>
        <div class="box-container">
            <?php 
                if ($select_orders->rowCount() > 0) {
                    while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        $product_id = $fetch_orders['product_id'];
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                        $select_products->execute([$fetch_orders['product_id']]);
                        if ($select_products->rowCount() > 0) {
                            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="box" <?php if($fetch_orders['status']=='canceled'){echo 'style="border:2px solid red;"';} ?>>
                <a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>">
                    <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
                    <div class="content">
                        <p class="date"><i class='bx bxs-calendar-alt'></i><span><?= $fetch_orders['date']; ?></span></p>
                        
                        <div class="row">
                            <h3 class="name"><?= $fetch_products['name']; ?></h3>
                            <p class="price">Price : RM<?= $fetch_products['price']; ?></p>
                            <?php 
                                // Check payment status and update order status accordingly
                                if ($fetch_orders['payment_status'] == 'complete') {
                                    $order_status = 'complete';
                                } elseif ($fetch_orders['payment_status'] == 'canceled') {
                                    $order_status = 'canceled';
                                } else {
                                    $order_status = 'in progress';
                                }
                            ?>
                            <p class="status" style="color:<?php if($order_status == 'complete'){echo "green";}elseif($order_status == 'canceled'){echo "red";}else{echo "orange";} ?>"><?= $order_status; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php 
                            }
                        }
                    }
                } else {
                    echo '<p class="empty">No orders placed yet!</p>';
                }
            ?>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <!-- sweetalert cdn link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link  -->
    <script type="text/javascript" src="js/script.js"></script>

    <?php include 'components/alert.php'; ?>
</body>
</html>
