<?php include("header.inc.php");?>
<?php
if (!isset($_SESSION["user_login"])) {
echo "";
}
else
{
echo "<meta http-equiv=\"refresh\" content=\"0; url=profile.php\">";	
}
?>
<?php
$error = "";
$reg = @$_POST['reg'];
//declaring variables to prevent errors
$fn = ""; //First Name
$ln = ""; //Last Name
$un = ""; //Username
$em = ""; //Email
$em2 = ""; //Email 2
$pswd = ""; //Password
$pswd2 = ""; // Password 2
$d = ""; // Sign up Date
$u_check = ""; // Check if username exists
//registration form
$fn = strip_tags(@$_POST['fname']);
$ln = strip_tags(@$_POST['lname']);
$un = strip_tags(@$_POST['username']);
$em = strip_tags(@$_POST['email']);
$em2 = strip_tags(@$_POST['email2']);
$pswd = strip_tags(@$_POST['password']);
$pswd2 = strip_tags(@$_POST['password2']);
$mm = (int) @$_POST['month'];
$dd = (int) @$_POST['day'];
$yy = (int) @$_POST['year'];
$dob = "$yy-$mm-$dd"; // <- this is the format mysql expects for dates

if ($reg) {
if ($em==$em2) {
// Check if user already exists
$u_check = mysql_query("SELECT username FROM users WHERE username='$un'");
// Count the amount of rows where username = $un
$check = mysql_num_rows($u_check);
//Check whether Email already exists in the database
$e_check = mysql_query("SELECT email FROM users WHERE email='$em'");
//Count the number of rows returned
$email_check = mysql_num_rows($e_check);
if ($check == 0) {
if ($email_check == 0) {
//check all of the fields have been filled in
if ($fn&&$ln&&$un&&$em&&$em2&&$pswd&&$pswd2) {
// check that passwords match
if ($pswd==$pswd2) {
// check the maximum length of username/first name/last name does not exceed 25 characters
if (strlen($un)>25||strlen($fn)>25||strlen($ln)>25) {
$error = ("The maximum limit for username/first name/last name is 25 characters!");
}
else
{
// check the maximum length of password does not exceed 15 characters and is not less than 8 characters
if (strlen($pswd)>15||strlen($pswd)<8) {
$error = ("Your password must be between 8 and 30 characters long!");
}
else
{
//encrypt password and password 2 using md5 before sending to database
$pswd = $pswd;
$pswd2 = $pswd2;
$query = mysql_query("INSERT INTO users VALUES ('','$un','$fn','$ln','$em','$pswd','$dob','0','Write something about yourself.','','no')");
//$sqlCommand = "INSERT INTO posts VALUES('', 'Welcome to $fn!','$dob','$em','$em')";
header("Location: redirect2.php");

}
}
}
else {
$error = ("Your passwords don't match!");
}
}
else
{
$error = ("Please fill in all of the fields");
}
}
else
{
$error = ("Sorry, but it looks like someone has already used that email!");
}
}
else
{
$error = ("Username already taken ...");
}
}
else {
$error = ("Your E-mails don't match!");
}
}
?>



<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sign Up</title>
<link rel = "stylesheet" type = "text/css" href = "Style.css"/>
<script src="signup.js"> </script>
</head>
<body>
<div class ="headerMenu"> <!--Places and formats header-->
<div id ="wrapper">
<div class ="logo">
<img src="images/link.png" alt="" />
</div>
<div class="search_box"> <!--Places and formats search box-->
<form action="search.php"  method="GET" id="search">
<input type = "text" name = "q" size = "60" placeholder = "Search ..."/>

</form>
</div>

<div id="menu" > <!--Creates buttons on header menu-->

<a href="index.php" > Home </a>
<a href="signup.php" > Sign Up </a>
<a href="index.php" > Sign In </a>


</div>

</div>


</div>
<br>
<br>
<br>
<p class = "dis2" id="display"> </p>

<div style ="width: 1020px; margin: 0px auto 0px auto;">
<table>
<tr>
<td class = "td1">
<h2>Join Today!</h2>
</td>
<td class = "td1"> <!--Formats and creates the various styles of the sign up-->
<h2> Sign Up Below! </h2>
<form action="#" method = "POST" onsubmit="return validateFormOnSubmit(this)">
<input type ="text" name="fname" id="fname" size = "25" placeholder = "First Name" value="<?php echo $fn; ?>"><br />
<br>
<input type ="text" name="lname" id="lname" size = "25" placeholder = "Last Name" value="<?php echo $ln; ?>"> <br />
<br>
<input type ="text" name="username" id="username" size = "25" placeholder = "UserName" value="<?php echo $un; ?>"> <br />
<br>
<input type ="text" name="email" id="email" size = "25" placeholder = "Email" value="<?php echo $em; ?>"> <br />
<br>
<input type ="text" name="email2" id="email2" size = "25" placeholder = "Confim Email" value="<?php echo $em2; ?>"> <br />
<br>
<input type ="password" name="password" id = "password" size = "25" placeholder = "Password" /> <br />
<br>
<input type ="password" name="password2" id = "password2" size = "25" placeholder = "Confirm Password" /> <br />
<h2>Gender: </h2>


<div class="radio-toolbar"> <!--Creates and formats radio button-->

<input type="radio" id="radio1" name="radios" value="all" checked>
<label for="radio1">Male</label>

<input type="radio" id="radio2" name="radios" value="false">
<label for="radio2">Female</label>

<input type="radio" id="radio3" name="radios" value="true">
<label for="radio3">Other</label> 
</div>
<h2>Country: </h2> <!--Creates and formats country selector-->
<div class="styled-select">
<select name="choice"> 
<option value="Y" selected="selected">Canada</option>
<option value="N">America</option>
<option value="M">Britain</option>
<option value="P">France</option>
<option value="Z">Mexico</option>
</select>
</div>


<br>

<label for="day">Date of Birth:</label> <!--Creates and formats date of birth-->
<div id="date2" class="datefield">
<input name="month" id="month" type="tel" maxlength="2" placeholder="MM"/> /
<input name="day" id="day" type="tel" maxlength="2" placeholder="DD"/> /
<input name="year" id="year" type="tel" maxlength="4" placeholder="YYYY" />

</div>
<br>
<input class="move" type ="submit" name="reg" value="Sign Up!"/> <!--Formats and creates sign up button-->
<br>
<br>
&nbsp;
<?=$error?>
</form>
</td>

</tr>

</table>
</div>


</body>
</html>