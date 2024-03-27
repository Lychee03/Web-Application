<?php
include '../components/connect.php';

if(isset($_COOKIE['seller_id'])){
   $seller_id = $_COOKIE['seller_id'];
}else{
   $seller_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = ($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = ($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$image;

   $select_seller = $conn->prepare("SELECT * FROM `sellers` WHERE email = ?");
   $select_seller->execute([$email]);
   
   if($select_seller->rowCount() > 0){
      $warning_msg[] = 'Email already taken!';
   }else{
      if($pass != $cpass){
         $warning_msg[] = 'Confirm password not matched!';
      }else{
         $insert_seller = $conn->prepare("INSERT INTO `sellers` (name, email, password, image) VALUES (?, ?, ?, ?)");
         $insert_seller->execute([$name, $email, $cpass, $image]); 
         move_uploaded_file($image_tmp_name, $image_folder);
         $update_image = $conn->prepare("UPDATE `sellers` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $seller_id]); 
         $success_msg[] = 'New seller registered! Please login now';
      }
   }
}
?>
<style type="text/css">
   <?php include '../css/admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body style="padding-left: 0;">



<!-- register section starts  -->

<div class="form-container">
   
   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>register new</h3>
      <div class="flex">
         <div class="col">
            <p>your name <span>*</span></p>
            <input type="text" name="name" placeholder="enter your name" maxlength="50" required class="box">
            <p>your email <span>*</span></p>
            <input type="email" name="email" placeholder="enter your email" maxlength="25" required class="box">
         </div>
         <div class="col">
            <div class="input-field">
               <p>your password <span>*</span></p>

               <input type="password" name="pass" placeholder="enter your password" maxlength="20" required class="box">
            </div>
            <div class="input-field">
               <p>confirm password <span>*</span></p>
               <input type="password" name="cpass" placeholder="confirm your password" maxlength="20" required class="box">
            </div>
         </div>
      </div>
      <div class="input-field">
         <p>select pic <span>*</span></p>
         <input type="file" name="image" accept="image/*" required class="box">
      </div>
      
      <p class="link">already have an account? <a href="login_admin.php">login now</a></p>
      <input type="submit" name="submit" value="register now" class="btn">
   </form>
</div>

<!-- register section ends -->

<!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <!-- custom js link  -->
   <script type="text/javascript" src="script.js"></script>

   <?php include '../components/alert.php'; ?>
   
</body>
</html>