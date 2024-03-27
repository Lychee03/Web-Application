<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = ($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $verify_user->execute([$email, $pass]);
   $row = $verify_user->fetch(PDO::FETCH_ASSOC);
   
   if($verify_user->rowCount() > 0){
      setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
      header('location:home.php');
   }else{
      $warning_msg[] = 'incorrect email or password!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>The Moon Florist - Login Page</title>

   <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
   <div class="banner">
        <div class="detail">
            <h1>login</h1>
            <p>Welcome back to our blooming community! <br>
            Please enter your login details to access <br>
            your floral paradise.</p>
            <span><a href="home.html">home</a><i class='bx bx-right-arrow-alt'></i>login</span>
        </div>
    </div>

<section class="form-container">
   <div class="heading">
      <h1>welcome back</h1>
      <img src="image/spt.png" alt=""> 
   </div>
   <form action="" method="post" enctype="multipart/form-data" class="login">
      
      <p>your email <span>*</span></p>
      <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
      <p>your password <span>*</span></p>
      <input type="password" name="pass" placeholder="enter your password" maxlength="20" required class="box">
      <p class="link">don't have an account? <a href="register.php">register now</a></p>
      <input type="submit" name="submit" value="login now" class="btn">
   </form>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
   
</body>
</html>