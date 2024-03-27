<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
   $select_user->execute([$user_id]);
   $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

   $prev_pass = $fetch_user['password'];
   $prev_image = $fetch_user['image'];
   $users_id = $fetch_user['id'];

   $name = isset($_POST['name']) ? $_POST['name'] : '';
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
   $old_pass = isset($_POST['old_pass']) ? $_POST['old_pass'] : '';
   $new_pass = isset($_POST['new_pass']) ? $_POST['new_pass'] : '';
   $cpass = isset($_POST['cpass']) ? $_POST['cpass'] : '';


      if (!empty($name) && !empty($email)) {
         $update_user = $conn->prepare("UPDATE `users` SET `name` = ?, `email` = ? WHERE id = ?");
         $update_user->execute([$name, $email, $users_id]);
         $success_msg[] = 'Username and Email updated successfully!';
     }

   if (!empty($image)) {
      $ext = pathinfo($image, PATHINFO_EXTENSION);
      $rename = unique_id().'.'.$ext;
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_files/'.$rename;

      if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
         if (move_uploaded_file($image_tmp_name, $image_folder)) {
            $update_image = $conn->prepare("UPDATE `users` SET `image` = ? WHERE id = ?");
            $update_image->execute([$rename, $users_id]);
            $success_msg[] = 'Image updated successfully!';
            if ($prev_image != '' && $prev_image != $users_id) {
               unlink('uploaded_files/'.$prev_image);
            }
         } else {
            $warning_msg[] = 'Failed to move uploaded file!';
         }
      } else {
         $error_msg[] = 'Invalid image format! Only JPG, JPEG, PNG, GIF allowed.';
      }
   } else {
      $warning_msg[] = 'No image selected!';
   }

   if (!empty($old_pass) && !empty($new_pass) && !empty($cpass)) {
      if ($old_pass != $prev_pass) {
         $error_msg[] = 'Old password not matched!';
      } elseif ($new_pass != $cpass) {
         $error_msg[] = 'Confirm password not matched!';
      } else {
         $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_pass->execute([$new_pass, $users_id]);
         $success_msg[] = 'Information updated successfully!';

      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>
<?php include 'components/user_header.php'; ?>
   <div class="banner">
        <div class="detail">
            <h1>update profile</h1>
            <p>Keep Your Blooms Fresh <br>
            Update Your Profile Information Here!
            </p>
            <span><a href="home.html">home</a><i class='bx bx-right-arrow-alt'></i>update profile</span>
        </div>
    </div>
<section class="form-container">
   <div class="heading">
      <span>join the moon florist</span>
      <h1>update profile</h1>
   </div>
   <form class="register" action="" method="post" enctype="multipart/form-data">
      
      <div class="flex">
         <div class="col">
            <p>your name <span>*</span></p>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name'] ?>" maxlength="50"  class="box">
            <p>your email <span>*</span></p>
            <input type="email" name="email" placeholder="<?= $fetch_profile['email'] ?>" maxlength="50" class="box">
            <p>update pic <span>*</span></p>
            <input type="file" name="image" accept="image/*" class="box">
         </div>
         <div class="col">
            <p>old password <span>*</span></p>
            <input type="password" name="old_pass" placeholder="enter your password" maxlength="20" required class="box">
            <p>your password <span>*</span></p>
            <input type="password" name="new_pass" placeholder="enter your password" maxlength="20" required class="box">
            <p>confirm password <span>*</span></p>
            <input type="password" name="cpass" placeholder="confirm your password" maxlength="20" required class="box">
         </div>
      </div>
      <input type="submit" name="submit" value="update profile" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alert.php'; ?>
   
</body>
</html>