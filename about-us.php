<?php

   include 'components/connect.php';

   if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
      
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/user_style.css">
    <title>The Moon Florist - About Page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>about us</h1>
            <p>Welcome to The Moon Florist, where passion <br>
               blooms into every arrangement. Discover the art <br>
               of floral enchantment with us!</p>
            <span><a href="home.html">home</a><i class='bx bx-right-arrow-alt'></i>about us</span>
        </div>
    </div>
    <!-- -----------------about-us----------------- -->
    <div class="standers">
        <div class="detail">
            <div class="heading">
                <h1>Our Standards</h1>
                <img src="image/spt.png" alt="">
            </div>
            <p> We hand-select the freshest blooms daily to ensure vibrant, long-lasting arrangements.</p>
            <i class='bx bxs-heart'></i>
            <p> Our skilled florists meticulously craft each bouquet, infusing creativity and passion into every design.</p>
            <i class='bx bxs-heart'></i>
            <p>We prioritize your preferences and special requests, creating custom arrangements tailored to your vision.</p>
            <i class='bx bxs-heart'></i>
            <p>Committed to eco-friendly floristry, we source responsibly and minimize waste throughout our process.</p>
            <i class='bx bxs-heart'></i>
            <p>Your happiness is our priority, and we strive to exceed your expectations with every order.</p>
            <i class='bx bxs-heart'></i>
        </div>
    </div>
    <!-- -----------------standers----------------- -->
    <?php include 'components/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>