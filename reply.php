<?php include("header.inc.php");?>
<?php
if(@$_SESSION["user_login"] == ''){
echo 'You must be logged in to view this page!</body></html>';
echo "<meta http-equiv=\"refresh\" content=\"5;url=index.php\"/>";
exit;
echo '</body></html>';
}
?>
<?php
$getid = @$_POST['id'];
if($getid == ""){
$getid = @$_GET['id'];
}
if (isset($getid)) {
	$post_body = $_POST['limitedtextarea'];
	$posted_to = "sinimma";
	if($post_body != ""){
		$insertPost = mysql_query("INSERT INTO post_comments VALUES ('','$post_body','$user','$posted_to','0','$getid')");
	}
}
$body 			= "";
$date_added 	= "";
?>
<script language="javascript">
function toggle() {
var ele = document.getElementById("toggleComment");
var text = document.getElementById("displayComment");
if (ele.style.display == "block") {
ele.style.display = "none";
}
else
{
ele.style.display = "block";
}
}
</script>

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




<!--POSTS ARE LISTED HERE -->
<div id="content2" style="<?php if (!isset($_SESSION["user_login"])) { echo "top:290px;left:-48px;"; } else { echo "top:90px;left:90px;"; } ?>">
<p class = "dis4" id="display"> </p>
<div class = "boxer2"> <!--Sets size and placement of post area-->
<div class = "scrollBox" style="margin-left:-474px;"> <!--Puts it into scrollbox-->
<div class="arrow"></div>
	<ul class="ChatLog"> <!--Formats visual of size area-->
		<li class="ChatLog__entry">
			<img class="ChatLog__avatar" src="<?php echo $profile_information['profile_pic'];?>" height = "50" width="50" alt="" />
			<p class="ChatLog__message">
			<?php  $get_comments = mysql_query("SELECT * FROM posts WHERE post_id='$getid'"); ?>
			<?php echo $body;?>
			<a class="ChatLog__timestamp"><?php echo $username; echo "\r\n"; echo "\r\n"; echo $date_added;?></a>
			</p>
		</li>
	</ul>
</div>
</div>


<div class ="dis5" id="hideaway" style="display:none;">Text is too long!</div>

<div class="postform" style="margin-left:-57px;"> <!--Post form-->
<br>
<a class = "center" href='javascript:;' onClick="javascript:toggle()" style="margin-left:44.2%;">
<div style='float: right; display: inline;margin-top:30px;background:none !important;'>Post Comment</div></a>
<br>
<div id='toggleComment'  style='display: none;'>
<form action="reply.php?id=<?php echo $getid; ?>" method="POST" name="postComment<?php echo $getid; ?>" onsubmit="return validateFormOnSubmit(this)">
<textarea name="limitedtextarea" rows = "2" cols = "60" onKeyDown="limitText(this.form.limitedtextarea,this.form.countdown,500);" 
onKeyUp="limitText(this.form.limitedtextarea,this.form.countdown,500);"></textarea><br>
<input type="submit" name="postComment<?php echo $getid; ?>" value="Post" style="background-color: #DCE5EE; float: right; border: 1px solid #666; color:#666;height:73px; width: 65px;" />
(Maximum characters: 500)<br>
You have <input readonly type="text" name="countdown" size="3" value="500"> characters left.
<br>
You have <input readonly type="text" name="displaycount" size="3" value="0"> characters.

<br>

</form>
</div>

<?php

//Get Relevant Comments
$get_comments = mysql_query("SELECT * FROM post_comments WHERE post_id='$getid' ORDER BY id DESC");
$count = mysql_num_rows($get_comments);
if ($count != 0) {
while ($comment = mysql_fetch_assoc($get_comments)) {

$comment_body = $comment['post_body'];
$posted_to = $comment['posted_to'];
$posted_by = $comment['posted_by'];
$removed = $comment['post_removed'];

echo "<b>$posted_by said: </b><br />";
echo '<p style="width:600px;word-wrap: break-word;">';
echo $comment_body;
echo '</p>';
echo "<hr /><br>";

}
}
else
{
echo "<center><br><br><br>No comments to display!</center>";
}
?>

</div>
</div>
<!--POSTS ARE LISTED HERE -->





<!--Join Today-->
<?php if(empty($_SESSION['user_login'])){?>
<div style ="width: 1020px; margin: 0px auto 0px auto;" class="ct-mn">
<table>
<tr>
<td class = "td1"><h2>Join Today!</h2><a href="postform.php" class="btn">Make A Post!</a></td>
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