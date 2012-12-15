<?php
include_once "pro_init.php";
include_once "lib_base.php";
$db = new PDO("sqlite:../DB/account");
$q = $db -> prepare("SELECT * FROM user WHERE username = (?) ");
$q -> execute(array($_POST['email']));
if($p = $q -> fetch())
{
	if($_POST['salt']==$p['reset'])
	{
		echo $_POST['salt'];

		if($_POST["New1"]==$_POST["New2"])
		{
			$salt = mt_rand();
			$password=md5($_POST['email'].$salt.$_POST["New1"]);
			$db = new PDO("sqlite:../DB/account");
			$q = $db -> prepare("UPDATE user SET password=(?),salt=(?)  WHERE username=(?)");
			$q -> execute(array($password,$salt,$_POST['email']));
		}
		else
		{
			echo "problem";
		}
	}
}
?>