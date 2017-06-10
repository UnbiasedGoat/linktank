<?php	include_once("header.inc.php"); ?>
<style>.ct-<?php if (!isset($_SESSION["user_login"])) { echo "pr"; } else { echo "mn"; } ?>{}
#ad-port{position:relative;top:<?php if (!isset($_SESSION["user_login"])) { echo "-170"; } else { echo "-20"; } ?>px;padding:0 0 60px 40px;margin-left: 83%;}
</style>
<?php

if($_SESSION["user_login"] == ''){
	echo 'You must be logged in to view this page!</body></html>';exit;
}else{
	$user_login = $_SESSION["user_login"];
	//$redirect  =  'http://'.$_SERVER['HTTP_HOST'].''.$_SERVER['PHP_SELF'];
	$redirect  =  'http://'.$_SERVER['HTTP_HOST'].''.$_SERVER['PHP_SELF'];

	$sql 				= mysql_query("SELECT id FROM users WHERE email = '$user_login'"); // query the person
	$userCount 			= mysql_num_rows($sql); //Count the number of rows returned
	if ($userCount == 1) {
		while($row = mysql_fetch_array($sql)){ 
			$id = $row["id"];
		}
		$_SESSION["id"] 			= $id;
		$_SESSION["user_login"] 	= $user_login;

		$about_query 			= mysql_query("SELECT * FROM users WHERE email='$user_login'");
		$get_result 			= mysql_fetch_assoc($about_query);
		if ($get_result['profile_pic'] == "") {
			$get_result['profile_pic'] = "images/w.jpg";
		}else{
			$get_result['profile_pic'] = "userdata/profile_pics/".$get_result['profile_pic'];
		}
		$profile_information					= array();
		$profile_information					= $get_result;
	}
}
?>

<?php
//---Update Information
if(isset($_POST['update_type']) && $_POST['update_type'] != ""){
	$upType 			= $_POST['update_type'];
	$error_message 		= '';
	$success_message 	= '';
	
	if($upType == 'photo_update'){
		if (isset($_FILES['profilepic'])) {
			if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)){ //1 Megabyte{
				$chars 			= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				$main_dir 		= '/userdata/profile_pics/';
				$rand_dir_name 	= substr(str_shuffle($chars), 0, 15);
				$uploadDir      = "userdata/profile_pics/$rand_dir_name";
				mkdir($uploadDir);
				if (file_exists("$uploadDir/".@$_FILES["profilepic"]["name"])){
					$_SESSION['success_message'] =  @$_FILES["profilepic"]["name"]." Already exists";
				}else{
					$profile_picture = str_replace('userdata/profile_pics/', '', "$uploadDir/".$_FILES["profilepic"]["name"]);
					move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"$uploadDir/".$_FILES["profilepic"]["name"]);
					$profile_pic_query = mysql_query("UPDATE users SET profile_pic='$profile_picture' WHERE id='$id'");
					$_SESSION['success_message']	=	 "Your profile picture has been updated!!";
				}
			}else{
				$_SESSION['error_message'] =  "Invailid File! Your image must be no larger than 1MB and it must be either a .jpg, .jpeg, .png or .gif";
			}
		}
echo '<script type="text/javascript"> window.location.href="'.$redirect.'";</script>';exit;

	}else if($upType == 'password_update'){
			//If the form has been submitted ...
			$password_query = mysql_query("SELECT * FROM users WHERE id='$id'");
			while ($row = mysql_fetch_assoc($password_query)) {
				$db_password = $row['password'];
				//md5 the old password before we check if it matches
				$old_password_md5 = $old_password;

				//Check whether old password equals $db_password
				if ($old_password_md5 == $db_password) {
					//Continue Changing the users password ...
					//Check whether the 2 new passwords match
					if ($new_password == $repeat_password) {
						if (strlen($new_password) <= 4) {
							$_SESSION['error_message'] =  "Sorry! But your password must be more than 4 character long!";
						}else{
								//md5 the new password before we add it to the database
								$new_password_md5 = $new_password;
								//Great! Update the users passwords!
								$password_update_query = mysql_query("UPDATE users SET password='$new_password_md5' WHERE id='$id'");
								$_SESSION['success_message'] =  "Success! Your password has been updated!";
						}
					}else{
						$_SESSION['error_message'] =  "Your two new passwords don't match!";
					}
				}else{
					$_SESSION['error_message'] =  "The old password is incorrect!";
				}
			}
echo '<script type="text/javascript"> window.location.href="'.$redirect.'";</script>';exit;
	}else if($upType == 'bio_update'){
		$firstname 		= strip_tags(@$_POST['fname']);
		$lastname 		= strip_tags(@$_POST['lname']);
		$bio 			= @$_POST['bio'];
		if (strlen($firstname) < 3) {
			$_SESSION['error_message']  = "Your first name must be 3 more more characters long.";
		}else if (strlen($lastname) < 4) {
			$_SESSION['error_message'] =  "Your last name must be 4 more more characters long.";
		}else{
			//Submit the form to the database
			$info_submit_query = mysql_query("UPDATE users SET first_name='$firstname', last_name='$lastname', bio='$bio' WHERE id='$id'");
			$_SESSION['success_message'] =  "Your profile has been updated!.";
		}
	echo '<script type="text/javascript"> window.location.href="'.$redirect.'";</script>';exit;
	}else{
	
	}
}
//---Update Information
?>

<!--HEADER MENUS -->
<div class ="headerMenu">
	<input type="hidden" value="<?php if (!isset($_SESSION["user_login"])) { echo "1"; } else { echo "0"; } ?>" id="sts">
	<div id ="wrapper">
		<div class ="logo"><a style="background:none;" href="index.php"><img src="images/link.png" alt="TheLinkTank"/></a></div>
		<div class="search_box"><form action="search.php"  method="GET" id="search"><input type = "text" name = "q" size = "60" placeholder = "Search ..."/></form></div>	
		<div id="menu" >
			<a href="index.php" class="ct-mn"> Home </a>

			<?php if(!isset($_SESSION["user_login"]) || empty($_SESSION["user_login"])){ ?>
			<a href="signup.php" class="ct-mn"> Sign Up </a>
			<a href="index.php" class="ct-mn"> Sign In </a>
			<?php } else { ?>
			<a href="profile.php" class="ct-mn"> Profile </a>			
			<a class="ct-pr" onclick="logout()" style="cursor:pointer;"> Logout </a>
			<?php } ?>
		</div>
	</div>
</div>
<!--HEADER MENUS -->


<!--Setting Section -->
<div id="content2" style="<?php if (!isset($_SESSION["user_login"])) { echo "top:290px;left:-48px;"; } else { echo "top:90px;left:90px;"; } ?>">
	<?php if(isset($_SESSION['success_message']) && $_SESSION['success_message'] != ""){ echo '<p style="color:green;">'.$_SESSION['success_message'].'</p>'; unset($_SESSION['success_message']);} ?>
	<?php if(isset($_SESSION['erroe_message']) && $_SESSION['erroe_message'] != ""){ echo '<p style="color:red;">'.$_SESSION['erroe_message'].'</p>'; unset($_SESSION['erroe_message']);} ?>
	
	<h2>Edit your Account Settings below</h2><hr />
	<p>UPLOAD YOUR PROFILE PHOTO:</p>
		<form action="account.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="update_type" value="photo_update">
		<img src="<?php echo $profile_information['profile_pic']; ?>" height="120" width="120" />
		<input type="file" name="profilepic" /><br />
		<input type="submit" name="uploadpic" value="Upload Image">
		</form>
		
		<hr />
		
		<form action="account.php" method="post">
		<input type="hidden" name="update_type" value="password_update">
		<p>CHANGE YOUR PASSWORD:</p> <br />
		Your Old Password: <input type="text" name="oldpassword" id="oldpassword" size="40"><br />
		Your New Password: <input type="text" name="newpassword" id="newpassword" size="40"><br />
		Repeat Password  : <input type="text" name="newpassword2" id="newpassword2" size="40"><br />
		<input type="submit" name="senddata" id="senddata" value="Update Information">
		</form>
		
		<hr />

		<form action="account.php" method="post">
		<input type="hidden" name="update_type" value="bio_update">
		<p>UPDATE YOUR PROFILE INFO:</p> <br />
			First Name: <input type="text" name="fname" id="fname" size="40" value="<?php echo $profile_information['first_name']; ?>"><br />
			Last Name: <input type="text" name="lname" id="lname" size="40" value="<?php echo $profile_information['last_name']; ?>"><br />
			About You: <textarea name="bio" id="bio" rows="7" cols="40"><?php echo $profile_information['bio']; ?></textarea>
			<hr />
			<input type="submit" name="updateinfo" id="updateinfo" value="Update Information">
		</form>
		<hr />
		<br />
		<br />
</div>
<!--Setting Section -->
