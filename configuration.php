<?php
@session_start();
$conn 	= mysql_connect("localhost","id1927480_chouinad","Casino64")	or die('Could not connect: ' . mysql_error());
mysql_select_db('id1927480_chouinad') or die('Could not select database');

$item_per_page = 10;

if (isset($_SESSION['user_login'])) {
	$username 	= $_SESSION["user_login"];
	$user 		= $_SESSION["user_login"];
	
	
	$user_login = $_SESSION["user_login"];
	$redirect  =  $_SERVER['PHP_SELF'];
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
	
	
	
}else {
	$username = "";
}
?>
