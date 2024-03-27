<?php 
	include 'components/connect.php';
	if(isset($_COOKIE['user_id'])){
      $user_id = $_COOKIE['user_id'];
   }else{
      $user_id = '';
   }

	//send message
	if (isset($_POST['send_message'])) {
		if ($user_id != '') {
			$id = unique_id();
			$name = $_POST['name'];
			$name = filter_var($name, FILTER_SANITIZE_STRING);

			$email = $_POST['email'];
			$email = filter_var($email, FILTER_SANITIZE_STRING);

			$contact_number = $_POST['contact_number']; // New input field for contact number
			$contact_number = filter_var($contact_number, FILTER_SANITIZE_STRING);

			$subject = $_POST['subject'];
			$subject = filter_var($subject, FILTER_SANITIZE_STRING);

			$message = $_POST['message'];
			$message = filter_var($message, FILTER_SANITIZE_STRING);

			$verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id=? AND name = ? AND email = ? AND contact_number = ? AND subject = ? AND message = ?");
			$verify_message->execute([$user_id, $name, $email, $contact_number, $subject, $message]);

			if ($verify_message->rowCount() > 0) {
				$warning_msg[] = 'message already exist';
			} else {
				$insert_message = $conn->prepare("INSERT INTO `message`(id,user_id,name,email,contact_number,subject,message) VALUES(?,?,?,?,?,?,?)");
				$insert_message->execute([$id, $user_id, $name, $email, $contact_number, $subject, $message]);
				$success_msg[] = 'message sent successfully';
			}
		} else {
			$warning_msg[] = 'please login first';
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
   <link rel="stylesheet" href="css/user_style.css">
	<title>The Moon Florist - Contact Us Page</title>
</head>
<body>
	<?php include 'components/user_header.php'; ?>
	
	<div class="banner">
        <div class="detail">
            <h1>contact us</h1>
            <p>Let's Bloom Together: <br>
            Reach Out and Let Us Bring Your <br>
            Floral Visions to Life!</p>
            <span><a href="home.html">home</a><i class='bx bx-right-arrow-alt'></i>contact us</span>
        </div>
    </div>
	<div class="contact">
		<div class="heading">
            <h1>Drop Us A Line</h1>
            <p style="text-align: center;">Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
            <img src="image/separator-img.png" alt="">
        </div>
		<div class="form-container">
			<form action="" method="post" class="register">
				
				<div class="input-field">
					<label>Name <sup>*</sup></label>
					<input type="text" name="name" required placeholder="Enter Your Name">
				</div>
				<div class="input-field">
					<label>Email <sup>*</sup></label>
					<input type="email" name="email" required placeholder="Enter Your Email">
				</div>
				<div class="input-field">
					<label>Contact Number <sup>*</sup></label>
					<input type="text" name="contact_number" required placeholder="Enter Your Contact Number">
				</div>
				<div class="input-field">
					<label>Subject <sup>*</sup></label>
					<input type="text" name="subject" required placeholder="Reason">
				</div>
				<div class="input-field">
					<label>Comment <sup>*</sup></label>
					<textarea name="message" cols="30" rows="10" required placeholder="Add any comment you think necessary"></textarea>
				</div>
				<input type="submit" name="send_message" value="send message" class="btn">
			</form>
		</div>
	</div>
	<div class="address">
		<div class="heading">
            <h1>our contact details</h1>
            <p style="text-align: center;">Just A Few Click To Make The Reservation Online For Saving Your Time And Money</p>
            <img src="image/separator-img.png" alt="">
        </div>
		<div class="box-container">
			<div class="box">
				<i class="bx bxs-map-alt"></i>
				<div>
					<h4>address</h4>
					<p>49, Jln Pendekar 2, <br> Taman Ungku Tun Aminah</p>
				</div>
			</div>
			<div class="box">
				<i class="bx bxs-phone-incoming"></i>
				<div>
					<h4>phone number</h4>
					<p>018-9754739</p>
				</div>
			</div>
			<div class="box">
				<i class="bx bxs-envelope"></i>
				<div>
					<h4>email</h4>
					<p>moonflorist@gmail.com</p>
				</div>
			</div>
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
