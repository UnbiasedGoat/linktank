<?php include("header.inc.php");?>
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
//Login Script
	$error = "";
	if (isset($_POST["user_login"]) && isset($_POST["password_login"])) {
		$user_login 	= trim($_POST["user_login"]);	
		$password_login = trim($_POST["password_login"]);
		$sql 			= mysql_query("SELECT id FROM users WHERE email = '$user_login' AND password = '$password_login';"); // query the person
		//Check for their existance
		$userCount = mysql_num_rows($sql); //Count the number of rows returned
		if ($userCount == 1) {
			while($row = mysql_fetch_array($sql)){ 
				$id = $row["id"];
			}
			$_SESSION["id"] 			= $id;
			$_SESSION["user_login"] 	= $user_login;
			$_SESSION["password_login"] = $password_login;
			header("Location: redirect.php");
		} else {
			$error = ('That information is incorrect, try again.');
		}
	}
?>

<!--POSTS ARE LISTED HERE -->
<div  class="ajaxDiv" id="content2" style="<?php if (!isset($_SESSION["user_login"])) { echo "top:290px;left:-48px;"; } else { echo "top:90px;left:90px;"; } ?>">
	<?php 
	$id 		= 	1;
	$start		=	0;
	$limit		=	10;
	if(isset($_GET['id'])){
		$id			=	$_GET['id'];
		$start		=	($id-1)*$limit;
	}
	$query		=	mysql_query("SELECT * FROM posts where body !='' ORDER BY id DESC LIMIT $start, $limit");
	echo "<ol id='cont-dis'>";
		while($query2=mysql_fetch_array($query)){
			$cars = $query2['id'];
			echo "<li id='".$query2['id']."'>".$query2['added_by']."\r\n".$query2['date_added'];
			echo "</br>";
			echo $query2['body'];
			if(isset($_SESSION["user_login"])){
				$cars = $query2['id'];
				echo '<form action = "reply.php" method="post" style="width:30px;background:none;">';
				echo '<input type="hidden" name="id" value='.$cars.'>';
				echo '<input type ="submit" name='.$cars.' id='.$cars.' onclick="getid(this);" value="Comments!"/>';
				echo '</form>';
			}
		}
	echo "</ol>";
	
	$rows	=	mysql_num_rows(mysql_query("select * from posts"));
	$total	=	ceil($rows/$limit);
	
	if($id	>	1){
		//echo "<a href='?id=".($id-1)."' class='button pageCounter'>PREVIOUS</a>";
	}
	if($id!=$total){
		//echo "<a href='?id=".($id+1)."' class='button pageCounter'>NEXT</a>";
	}
	//echo "<ul class='page'>";
	for($i=1;$i<=$total;$i++){
		if($i==$id){ 
			//echo "<li class='pgNum current'>".$i."</li>"; 
		}else{ 	
			//echo "<li class='pgNum'><a href='?id=".$i."'>".$i."</a></li>"; 
		}
	}
	//echo "</ul>";
?>
</div>
<!--POSTS ARE LISTED HERE -->





<!--Join Today-->
<?php if(empty($_SESSION['user_login'])){?>
<div style ="width: 1020px; margin: 0px auto 0px auto;" class="ct-mn">
	<table>
	<tr>
		<td class = "td1"><h2><a href="signup.php"> Join Today!</a></h2>
		<br>
		<a href="javascript:void(0);" class="btn" onclick="alert('You need to login to Make a Post');" >Make A Post!</a></td>
		<td class="td2"><h2> Sign In! </h2>
			<input type ="text" name="user_login" id="user_login" size = "25" placeholder = "Email"/> <br/>
			<input type ="password" name="password_login" id="password_login" size = "25" placeholder = "Password"/> <br/>
			<input type ="button" name="submit" value="Sign In!"  onclick="return login();" style="padding:5px 8px;border:0;background:green;color:#fff;border-radius:3px;cursor:pointer">
			<p id="error-m" style="margin-top:5px;color:red;"></p>
		</td>
	</tr>
	</table>
</div>
<?php } ?>
<!--Join Today-->

<p class = "dis" id="display"> </p>




<div id="ad-port"> 

<h2>Ads</h2>
<img src="images/a.jpg" alt="" height="140" width="140"/>&nbsp;&nbsp;
<img src="images/a.jpg" alt="" height="140" width="140"/>&nbsp;&nbsp;
<img src="images/a.jpg" alt="" height="140" width="140"/>&nbsp;&nbsp;
<img src="images/a.jpg" alt="" height="140" width="140"/>&nbsp;&nbsp;
</div>











<?php if(isset($_SESSION['user_login'])){?>
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
<?php } ?>






<?php include("footer.inc.php");?>