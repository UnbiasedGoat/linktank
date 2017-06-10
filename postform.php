<?php include("header.inc.php"); ?>
<?php
if (!isset($_SESSION["user_login"])) {
	echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
}else{
	echo "";	
}
?>
<style>.ct-<?php if (!isset($_SESSION["user_login"])) { echo "pr"; } else { echo "mn"; } ?>{}
#ad-port{position:relative;top:<?php if (!isset($_SESSION["user_login"])) { echo "-170"; } else { echo "-20"; } ?>px;padding:0 0 60px 40px;margin-left: 83%;}
</style>

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
<?php
	$post = @$_POST['limitedtextarea'];
	if ($post != "") {
		$date_added 			= date("y-m-d");
		$added_by 				= $user;
		$user_posted_to 		= $username;

		$sqlCommand 			= "INSERT INTO posts VALUES('', '$post','$date_added','$added_by','$user_posted_to')";  
		$query 					= mysql_query($sqlCommand) or die (mysql_error()); 
	}
	$check_pic 					= mysql_query("SELECT profile_pic FROM users WHERE email='$username'");
	$get_pic_row 				= mysql_fetch_assoc($check_pic);
	$profile_pic_db 			= $get_pic_row['profile_pic'];
	
	if ($profile_pic_db == "") {
		$profile_pic = "w.jpg";
	}else{
		$profile_pic = "userdata/profile_pics/".$profile_pic_db;
	}
?>

<?php
		$id 		= 	1;
		$start		=	0;
		$limit		=	10;
		if(isset($_GET['id'])){
			$id			=	$_GET['id'];
			$start		=	($id-1)*$limit;
		}
		$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC") or die(mysql_error());
		while ($row = mysql_fetch_assoc($getposts)) {
			$id2 				= $row['id'];
			$body 				= $row['body'];	
			$date_added 		= $row['date_added'];
			$added_by 			= $row['added_by'];
			$user_posted_to 	= $row['user_posted_to'];  
			$get_user_info 		= mysql_query("SELECT * FROM users WHERE username='$added_by'");
			$get_info 			= mysql_fetch_assoc($get_user_info);
			$profilepic_info 	= $get_info['profile_pic'];
			if ($profilepic_info == ""){
				$profilepic_info = "w.jpg";
			}else{
				$profilepic_info = "./userdata/profile_pics/".$profilepic_info;
			}
		}
?>

<div id="content2" style="<?php if (!isset($_SESSION["user_login"])) { echo "top:290px;left:-48px;"; } else { echo "top:90px;left:90px;"; } ?>">
	<?php 
	$id 		= 	1;
	$start		=	0;
	$limit		=	10;
	if(isset($_GET['id'])){
		$id			=	$_GET['id'];
		$start		=	($id-1)*$limit;
	}
	$query		=	mysql_query("SELECT * FROM posts where body !='' ORDER BY id DESC LIMIT $start, $limit");
	echo "<ol style='height:auto;'>";
		while($query2=mysql_fetch_array($query)){
			$cars = $query2['id'];
			echo "<li>".$query2['added_by']."\r\n".$query2['date_added'];
			echo "</br>";
			echo $query2['body'];
			echo '<form action = "reply.php" method="post" style="width:30px;background:none;">';
			echo '<input type="hidden" name="id" value='.$cars.'>';
			echo '<input type ="submit" name='.$cars.' id='.$cars.' onclick="getid(this);" value="Comments!"/>';
			echo '</form>';
		}
		echo "</ol>";
		$rows	=	mysql_num_rows(mysql_query("select * from posts"));
		$total	=	ceil($rows/$limit);
		if($id>1){
			echo "<a href='?id=".($id-1)."' class='button pageCounter'>PREVIOUS</a>";
		}
		if($id!=$total){
			echo "<a href='?id=".($id+1)."' class='button pageCounter'>NEXT</a>";
		}
		
		
		
		echo "<ul class='page'>";
		for($i=1;$i<=$total;$i++){
			if($i==$id) { echo "<li class='pgNum current'>".$i."</li>"; }
			else { echo "<li class='pgNum'><a href='?id=".$i."'>".$i."</a></li>"; }
		}
		echo "</ul>";
?>
</div>

<br>

<div class="dis6" id="hideaway" style="display: none;">Text is too long!</div>
<div class="postform2" style="margin-bottom:-100px;margin-top:1000px;float:left;">
<!--Post form-->
<br>
	<form name="posform" id="postform" action="postform.php" method="POST" onsubmit="return validateFormOnSubmit(this)">
	<textarea name="limitedtextarea" rows="2" cols="60" onKeyDown="limitText(this.form.limitedtextarea,this.form.countdown,500);" onKeyUp="limitText(this.form.limitedtextarea,this.form.countdown,500);"></textarea>
		<br> 
		<input type="submit" name="submit" value="POST" style="background-color: #DCE5EE; float: right; border: 1px solid #666; color: #666; height: 73px; width: 65px;" />(Maximum characters: 500)<br> You have 
		<input readonly type="text" name="countdown" size="3" value="500"> characters left. <br> You have <input readonly type="text" name="displaycount" size="3" value="0"> characters. <br>
	</form>
	<form action = "photo.php" method="post">
	<input type ="submit" name="Upload Image" value="Image"/>
	</form>
</div>



<div class="pro ct-pr">
<a href="postform.php" class="btn" style="position: relative;top: -15px;">Make A Post!</a><br>
<div class="prop">Hello <span id='sq-name'><?php echo $profile_information['first_name'];?></span>!</div>
<br>
<!--Formats ads, profile picture, and bottom images-->
<div class="logo2">
<img src="<?php echo $profile_information['profile_pic'];?>" id="sq-pic" alt="" height="250" width="200"/>
</div>
<br>
<div class="textheader"><span id='sq-uname'><?php echo $profile_information['username'];?></span></div>
<div class="profileLeftSideContent">
<span id='sq-abt'><?php echo $profile_information['bio'];?></span>
</div>
<div class="textheader"><span id='sq-uname'><?php echo $profile_information['username'];?></span></div>
<div class="profileLeftSideContent">
<img src="images/frank.jpg" alt="" height="50" width="40" />&nbsp;&nbsp; 
<img src="images/frank.jpg" alt="" height="50" width="40" />&nbsp;&nbsp; 
<img src="images/frank.jpg" alt="" height="50" width="40" />&nbsp;&nbsp; 
<img src="images/frank.jpg" alt="" height="50" width="40" />&nbsp;&nbsp; 
<img src="images/frank.jpg" alt="" height="50" width="40" />&nbsp;&nbsp; 
<img src="images/frank.jpg" alt="" height="50" width="40" />&nbsp;&nbsp;


</div>
</div>

<div class="imager3">
<h2>Ads</h2>
<img src="images/a.jpg" alt="" height="140" width="140" />&nbsp;&nbsp; <img
src="images/a.jpg" alt="" height="140" width="140" />&nbsp;&nbsp; <img
src="images/a.jpg" alt="" height="140" width="140" />&nbsp;&nbsp; <img
src="images/a.jpg" alt="" height="140" width="140" />&nbsp;&nbsp;
</div>


