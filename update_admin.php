<?php

include '../components/connect.php';

if(isset($_COOKIE['seller_id'])){
   $seller_id = $_COOKIE['seller_id'];
}else{
   $seller_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){
   $select_user = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? LIMIT 1");
   $select_user->execute([$seller_id]);
   $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

   $prev_pass = $fetch_user['password'];
   $prev_image = $fetch_user['image'];
   $id = $fetch_user['id'];

   $name = isset($_POST['name']) ? $_POST['name'] : '';
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
   $old_pass = isset($_POST['old_pass']) ? $_POST['old_pass'] : '';
   $new_pass = isset($_POST['new_pass']) ? $_POST['new_pass'] : '';
   $cpass = isset($_POST['cpass']) ? $_POST['cpass'] : '';


      if (!empty($name) && !empty($email)) {
         $update_user = $conn->prepare("UPDATE `sellers` SET `name` = ?, `email` = ? WHERE id = ?");
         $update_user->execute([$name, $email, $seller_id]);
         $success_msg[] = 'Username and Email updated successfully!';
     }

   if (!empty($image)) {
      $ext = pathinfo($image, PATHINFO_EXTENSION);
      $rename = unique_id().'.'.$ext;
      $image_size = $_FILES['image']['size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = '../uploaded_files/'.$rename;

      if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
         if (move_uploaded_file($image_tmp_name, $image_folder)) {
            $update_image = $conn->prepare("UPDATE `sellers` SET `image` = ? WHERE id = ?");
            $update_image->execute([$rename, $seller_id]);
            $success_msg[] = 'Image updated successfully!';
            if ($prev_image != '' && $prev_image != $id) {
               unlink('../uploaded_files/'.$prev_image);
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
         $update_pass = $conn->prepare("UPDATE `sellers` SET password = ? WHERE id = ?");
         $update_pass->execute([$new_pass, $seller_id]);
         $success_msg[] = 'Information updated successfully!';
         header("refresh:2;url=dashboard.php");
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
   <title>update</title>

   <!-- box icon -->
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>


<body style="padding-left: 0;">
<div class="form-container" style="padding-left: 10rem;">
   <form class="register" action="" method="post" enctype="multipart/form-data">
   <h3>update personal details</h3>
      <div class="flex">
         <div class="col">
            <p>Your name <span>*</span></p>
            <input type="text" name="name" placeholder="<?= isset($fetch_user['name']) ? $fetch_user['name'] : '' ?>" maxlength="50"  class="box">
            <p>Your email <span>*</span></p>
            <input type="email" name="email" placeholder="<?= isset($fetch_user['email']) ? $fetch_user['email'] : '' ?>" maxlength="50" class="box">
            <p>Update picture <span>*</span></p>
            <input type="file" name="image" accept="image/*" class="box">
         </div>
         <div class="col">
            <p>Old password <span>*</span></p>
            <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" required class="box">
            <p>New password <span>*</span></p>
            <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" required class="box">
            <p>Confirm password <span>*</span></p>
            <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" required class="box">
         </div>
      </div>
      <input type="submit" name="submit" value="Update Profile" class="btn">
      <div style="text-align:center; padding-top:3rem;">
			<a href="dashboard.php" class="btn">go back</a>
		</div>
   </form>

</div>

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js link  -->
<script type="text/javascript" src="script.js"></script>

<?php include '../components/alert.php'; ?>
</div>
</body>
</html>