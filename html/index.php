<?php
	include_once "pro_init.php";
	include_once "lib_base.php";
	$_SESSION['$nonce'] = getNonce();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<title>EzPic</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="cart.js"></script>
	</head>
	
	<body>	
		<div id="header">
			<span>EzPic</span>
		</div>

	<div id="contain">
		
		<div id="left" class="sur">
			<div id="nav">
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="admin.php">Manage</a></li>
					<li><a href="loginForm.php">Login</a></li>
					<hr />
					<li><a href="search.php">Search</a></li>
					
				</ul>
			</div>
		</div>
		
		<div id="main">
			<p id = "test">
			Choose Your Own Goods!
			</p>
			<div id="Goods">
			<?php
				include 'goods.php';
			?>
			</div>
		</div>
		
	</div>
	
	<div id="footer">
		<?php include 'footer.php' ?>
	</div>
		<div id="box">
		show it!;
		</div>
	</body>

</html>
