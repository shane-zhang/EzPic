<?php
    $db = new PDO("sqlite:../DB/account");
	$q = $db -> prepare("SELECT * FROM user");
	$q -> execute();
	$string;
	while($p = $q -> fetch())
	{
		echo $p["uid"].",".$p["username"].",".$p["salt"].",".$p["password"].";";
	//	$string = md5($p["username"].$p['salt'].$p['password'],false);
		echo "<hr />";
	}
	/*
	$q = $db -> prepare("INSERT INTO user (username,salt,password) VALUES (?,?,?)");
	$q -> execute(array('zx0319@163.com',222,md5("zx0319@163.com"."222"."796801",false)));
	 *
	*/
?>