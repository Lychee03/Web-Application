<?php 
    include '../components/connect.php';
    if(isset($_COOKIE['seller_id'])){
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header('location:login.php');
    } 
    
    // Delete order details
    if (isset($_POST['delete_order'])) {
        $delete_id = $_POST['order_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id=?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id=?");
            $delete_order->execute([$delete_id]);
            $success_msg[] = 'Order deleted!';
        } else {
            $warning_msg[] = 'Order already deleted';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- box icon cdn link  -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <title>Admin - order placed page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="order-container">
            <div class="heading">
                <h1>Total order placed</h1>
                <img src="../image/break.png" width="100">
            </div>
            
            <div class="box-container">
                <?php 
                    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id=?");
                    $select_order->execute([$seller_id]);
                    if ($select_order->rowCount() > 0) {
                        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="box">
                    <div class="status" style="color: <?php if($fetch_order['status'] == 'canceled'){echo "coral";}else{echo "limegreen";} ?>"><?= $fetch_order['status']; ?></div>
                    <div class="detail">
                        <p>User name: <span><?= $fetch_order['name']; ?></span></p>
                        <p>User ID: <span><?= $fetch_order['user_id']; ?></span></p>
                        <p>Placed on: <span><?= $fetch_order['date']; ?></span></p>
                        <p>Number: <span><?= $fetch_order['number']; ?></span></p>
                        <p>Email: <span><?= $fetch_order['email']; ?></span></p>
                        <p>Total price: <span><?= $fetch_order['price']; ?></span></p>
                        <p>Payment method: <span><?= $fetch_order['method']; ?></span></p>
                        <p>Address: <span><?= $fetch_order['address']; ?></span></p>
                    </div>
                </div>
                <?php 
                        }
                    } else {
                        echo '
                            <div class="empty">
                                <p>No order take place yet!</p>
                            </div>
                        ';
                    }
                ?>
            </div>
        </section>
    </div>
    
    <!-- sweetalert cdn link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link  -->
    <script type="text/javascript" src="script.js"></script>

    <?php include '../components/alert.php'; ?>
</body>
</html>
