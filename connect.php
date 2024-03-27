<?php 
	$db_name = 'mysql:host=localhost;dbname=flowershop_db';
	$user_name = 'root';
	$user_password = '';

	$conn = new PDO($db_name, $user_name, $user_password);

	if(!$conn){
		echo "Connection failed!";
	}

	function unique_id(){
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charLength = strlen($chars);
		$randomString = '';
		// Change the loop condition to generate a 4-character ID
		for ($i=0; $i < 4; $i++) { 
			$randomString .= $chars[mt_rand(0, $charLength - 1)];
		}
		return $randomString;
	}
?>