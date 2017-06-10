<?php
include ("header.inc.php");
if (isset($_POST['uploadpic'])) {
if (((@$_FILES["profilepic"]["type"]=="image/jpeg") || (@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]["type"]=="image/gif"))&&(@$_FILES["profilepic"]["size"] < 1048576)) //1 Megabyte
{
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$rand_dir_name = substr(str_shuffle($chars), 0, 15);
mkdir("userdata/user_photos/$rand_dir_name");

if (file_exists("userdata/user_photos/$rand_dir_name/".@$_FILES["profilepic"]["name"]))
{
echo @$_FILES["profilepic"]["name"]." Already exists";
}
else
{
move_uploaded_file(@$_FILES["profilepic"]["tmp_name"],"userdata/user_photos/$rand_dir_name/".$_FILES["profilepic"]["name"]);
echo "Uploaded and stored in: userdata/profile_pics/$rand_dir_name/".@$_FILES["profilepic"]["name"];
$profile_pic_name = @$_FILES["profilepic"]["name"];
$img_id_before_md5 = "$rand_dir_name/$profile_pic_name";
$img_id = $img_id_before_md5;
$description = "test";
$date = date("y-m-d");
$profile_pic_query = mysql_query("INSERT INTO photos VALUES ('','$img_id','$user','$date','$description','/user_photos/$rand_dir_name/$profile_pic_name')");
if (!$profile_pic_query) {
die('Invalid query: ' . mysql_error());
}
header("Location: redirect4.php");

}
}
}
?>
<h2>Upload your Photos:</h2>
<hr />
<form action="" method="POST" enctype="multipart/form-data">
<input type="file" name="profilepic" />
<input type="submit" name="uploadpic" value="Upload Image">
</form>