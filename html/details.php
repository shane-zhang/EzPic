<?php
	include_once "pro_init.php";
	include_once "lib_base.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type"/>
		<title>Goods Details</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
	</head>
	
	<body>
		<div id="header">
			<span>lap-top Details</span>
		</div>

		<div id="main">
		<p>More Details About Goods:</p>
			<?php
			echo "\n";
			$db = new PDO("sqlite:../DB/cart");
			if(empty($_GET["pid"]))
			{
				$_GET["pid"] = 1;
			}
			echo "\n";
			$q = $db -> prepare("SELECT * FROM products WHERE pid = ?");
			if($q -> execute(array($_GET["pid"])))
			{
				$p = $q->fetch();
				echo "<div class='det'>".'<img src="'.$p["pic"].'"'.' '.'alt='.'"'.$p["name"].'"'." />"."<span>"."<br/>"."<hr/>".$p["name"]."<br />"."HKD:".$p["price"]."<br />".$p["description"]."</span>"."</div>"."\n";
			}
			echo "\n";
			?>
		</div>	
			
	</body>

</html>
