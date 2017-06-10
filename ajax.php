<?php require_once('configuration.php');?>
<?php
$ajax_responce				= array();

//-----Login Function Starts
if(isset($_GET['typ']) && $_GET['typ'] == 'logi'){
	$user_login 		= trim($_GET["uname"]);
	$password_login 	= trim($_GET["pass"]);
	$sql 				= mysql_query("SELECT id FROM users WHERE email = '$user_login' AND password = '$password_login';"); // query the person
	//Check for their existance
	$userCount 			= mysql_num_rows($sql); //Count the number of rows returned
	if ($userCount == 1) {
		while($row = mysql_fetch_array($sql)){ 
			$id = $row["id"];
		}
		$_SESSION["id"] 			= $id;
		$_SESSION["user_login"] 	= $user_login;
		$_SESSION["password_login"] = $password_login; 

		$about_query 			= mysql_query("SELECT bio,profile_pic,first_name FROM users WHERE email='$user_login'");
		$get_result 			= mysql_fetch_assoc($about_query);
		
		$about_the_user 		= $get_result['bio'];
		$profile_pic_db 		= $get_result['profile_pic']; 
		$firstname 				= $get_result['first_name'];	
		if ($profile_pic_db == "") {
			$profile_pic = "w.jpg";
		}else{
			$profile_pic = "userdata/profile_pics/".$profile_pic_db;
		}
		$ajax_responce['error'] 		= '';
		$ajax_responce['bio'] 			= $about_the_user;
		$ajax_responce['pic'] 			= $profile_pic;
		$ajax_responce['first_name'] 	= $firstname;
		$ajax_responce['user_login'] 	= $user_login;
	} else {
		$ajax_responce['error'] 		= 'That information is incorrect, try again.';
	}
	echo json_encode($ajax_responce);exit;
}
//-----Login Function Starts



//-----Logout Function Starts
if(isset($_GET['typ']) && $_GET['typ'] == 'logout'){
	$_SESSION = array();
	session_destroy();
	$ajax_responce['error'] = '';
	echo json_encode($ajax_responce);exit;
}
//-----Logout Function Starts




//----Update Post
if(isset($_GET['typ']) && $_GET['typ'] == 'refresh'){
	$id 		= 	1;
	$start		=	0;
	$limit		=	10;
	$updated    = '';
	if(isset($_GET['id'])){
		$id			=	$_GET['id'];
		$start		=	($id-1)*$limit;
	}
	$query		=	mysql_query("SELECT * FROM posts where body !='' ORDER BY id DESC LIMIT $start, $limit");
	$updated    .= "<ol id='cont-dis'>";
		while($query2=mysql_fetch_array($query)){
			$cars = $query2['id'];
			$updated    .= "<li id='".$query2['id']."'>".$query2['added_by']."\r\n".$query2['date_added'];
			$updated    .= "</br>";
			$updated    .= $query2['body'];
			if(isset($_SESSION["user_login"])){
				$cars = $query2['id'];
				$updated    .= '<form action = "reply.php" method="post" style="width:30px;background:none;">';
				$updated    .= '<input type="hidden" name="id" value='.$cars.'>';
				$updated    .= '<input type ="submit" name='.$cars.' id='.$cars.' onclick="getid(this);" value="Comments!"/>';
				$updated    .= '</form>';
			}
		}
	$updated    .= "</ol>";
	
	$rows	=	mysql_num_rows(mysql_query("select * from posts"));
	$total	=	ceil($rows/$limit);
	
	if($id	>	1){
		//$updated    .= "<a href='?id=".($id-1)."' class='button pageCounter'>PREVIOUS</a>";
	}
	if($id!=$total){
	//$updated    .= "<a href='?id=".($id+1)."' class='button pageCounter'>NEXT</a>";
	}
	//$updated    .= "<ul class='page'>";
	for($i=1;$i<=$total;$i++){
		if($i==$id){ 
			//$updated    .= "<li class='pgNum current'>".$i."</li>"; 
		}else{ 	
			//$updated    .= "<li class='pgNum'><a href='?id=".$i."'>".$i."</a></li>"; 
		}
	}
	//$updated    .= "</ul>";
	echo $updated;exit;
}



?>