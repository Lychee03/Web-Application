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
    <title>The Moon Florist - Home Page</title>
</head>
<body>
    <?php include 'components/user_header.php'; ?>
    <!-- slider section -->
    <div class="slider-container" id="home">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <h1>Blossoms of Joy Await Step Into <br> Our Enchanting Floral World!</h1>
                    <a href="shop.php" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/home.png">
                </div>
            </div>
            <div class="slideBox">
                <div class="textBox">
                    <h1>Where Every Petal Tells a Story <br> Welcome to Our Floral Haven!</h1>
                    <a href="shop.php" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/home2.png">
                </div>
            </div>
            
        </div>
        <ul class="controls">
            <li onclick="nextSlide();" class="next"><i class='bx bx-right-arrow-alt'></i></li>
            <li onclick="prevsSlide();" class="prev"><i class='bx bx-left-arrow-alt'></i></li>
        </ul>
    </div>
    <?php include 'components/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>