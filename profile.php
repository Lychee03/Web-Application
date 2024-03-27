<?php

   include 'components/connect.php';

   if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      header('location:login.php');
   }

   $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
   $select_orders->execute([$user_id]);
   $total_orders = $select_orders->rowCount();

   $select_comments = $conn->prepare("SELECT * FROM `message` WHERE user_id = ?");
   $select_comments->execute([$user_id]);
   $total_comments = $select_comments->rowCount();




?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

   <?php include 'components/user_header.php'; ?>
   <div class="banner">
        <div class="detail">
            <h1>profile</h1>
            <p>Blossom with Us: <br>
            Manage Your Floral Preferences <br>
            and Orders with Ease!</p>
            <span><a href="home.html">home</a><i class='bx bx-right-arrow-alt'></i>profile</span>
        </div>
    </div>

    <section class="profile">
       <div class="heading">
          <h1>profile detail</h1>
          <img src="image/separator-img.png" alt="">
       </div>
       <div class="details">
          <div class="user">
             <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
             <h3><?= $fetch_profile['name']; ?></h3>
             <p>user</p>
             <a href="update.php" class="btn">update profile</a>
          </div>
          <div class="box-container">
             <div class="box">
                <div class="flex">
                   <i class="bx bxs-bookmarks"></i>
                   <h3><?= $total_orders; ?></h3>
                   <span>orders placed</span>
                </div>
                <a href="order.php" class="btn">view order</a>
             </div>
          </div>
       </div>
    </section>