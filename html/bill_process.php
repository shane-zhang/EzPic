<?php
	include_once "pro_init.php";
	
	//could contain some checking here.
	
	if($_SESSION['nonce'] != $_POST['nonce'])
	{
		header("Location:loginForm.php?statue=2");
		exit();
	}
	
	$json = json_decode($_POST["bill"]);
	
	for($i=0;$i<sizeof($json -> {"cart"});$i++)
	{
		$db = new PDO("sqlite:../DB/cart");
		$q = $db -> prepare("SELECT * FROM products WHERE pid = (?)");
		if($q -> execute(array($json->{"cart"}[$i]->{"pid"})))
		{
			$p = $q->fetch();
			$json->{"cart"}[$i]->{"price"} = $p["price"];
		}
	}
	
	$str_json = json_encode($json);
	error_log("ABAPRE JSON \n".$str_json,3,"log.txt");
	$salt = mt_rand();
	$goods = md5($str_json.$salt);
	echo $goods.";";
	
	$db = new PDO('sqlite:../DB/bill');
	$q = $db -> prepare("INSERT INTO bill (goods,salt,FINISH) VALUES (?,?,?)");
	$q -> execute(array($goods,$salt,"NOTPAID"));
	$LastId = $db->lastInsertId();
	echo $LastId;
?>