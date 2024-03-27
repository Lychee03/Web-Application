<?php 
    include '../components/connect.php';
    
    // Check if the seller is logged in
    if(isset($_COOKIE['seller_id'])){
        $seller_id = $_COOKIE['seller_id'];
    } else {
        $seller_id = '';
        header('location:login.php');
    } 

    // Update order status if payment status is complete
    if (isset($_POST['update_order'])) {
        $order_id = $_POST['order_id'];
        $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

        $update_status = $_POST['update_status'];
        $update_status = filter_var($update_status, FILTER_SANITIZE_STRING);

        // Update order status in the database
        $update_status_query = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
        $update_status_query->execute([$update_status, $order_id]);

        // Check if payment status is complete and update order status accordingly
        if ($update_status == 'complete') {
            $update_payment_status_query = $conn->prepare("UPDATE `orders` SET payment_status = 'complete' WHERE id = ?");
            $update_payment_status_query->execute([$order_id]);
        }

        $success_msg[] = 'Order status updated';
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
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <title>Admin - order placed page</title>
</head>
<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>
        <section class="order-container">
            <div class="heading">
                <h1>Total confirmed orders</h1>
                <img src="../image/break.png" width="100">
            </div>
            
            <div class="box-container">
                <?php 
                    $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id=? AND status='in progress'");
                    $select_order->execute([$seller_id]);
                    
                    if ($select_order->rowCount() > 0) {
                        while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="box">
                    <div class="status" style="color: <?php if($fetch_order['status'] == 'In Progress'){echo "limegreen";}else{echo "coral";} ?>"><?= $fetch_order['status']; ?></div>
                    <div class="detail">
                        <p>User Name: <span><?= $fetch_order['name']; ?></span></p>
                        <p>User ID: <span><?= $fetch_order['user_id']; ?></span></p>
                        <p>Placed On: <span><?= $fetch_order['date']; ?></span></p>
                        <p>Number: <span><?= $fetch_order['number']; ?></span></p>
                        <p>Email: <span><?= $fetch_order['email']; ?></span></p>
                        <p>Total Price: <span><?= $fetch_order['price']; ?></span></p>
                        <p>Payment Method: <span><?= $fetch_order['method']; ?></span></p>
                        <p>Address: <span><?= $fetch_order['address']; ?></span></p>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                        <select name="update_status" class="box" style="width:90%;">
                            <option disabled selected><?php echo $fetch_order['status']; ?></option>
                            <option value="in progress">In Progress</option>
                            <option value="complete">Complete</option>
                        </select>
                        <div class="flex-btn">
                            <input type="submit" name="update_order" value="Update Status" class="btn">
                            <input type="submit" name="delete_order" value="Delete Order" class="btn" onclick="return confirm('Delete this order?');">
                        </div>
                    </form>
                </div>
                <?php 
                        }
                    } else {
                        echo '<div class="empty"><p>No confirmed orders yet!</p></div>';
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
