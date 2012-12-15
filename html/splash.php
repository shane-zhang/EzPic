<?php
	include_once "pro_init.php";
	include_once "lib_base.php";
	$_SESSION['$nonce'] = getNonce();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<meta name="google-site-verification" content="CXRIDN6MXICtQkkuG1l1Elu0Pnc_WKg8SvwwiGKGVug" />
		<title>Online Shopping</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="cart.js"></script>
	</head>
	
	<body>
		
		<div id="header">
			<span>Online Shopping Splash</span>
		</div>

	<div id="contain">
		
		<div id="main">
			<p id = "test">
			New Arrrival!
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
	
		<div id="right" class="sur Shopping_List">
			<p>What You Have Bought</p>
			<div id="Shopping_List">
			<p>Still Nothing.</p>
			</div>
			<div id = "checkout">
			<form method="post" action="https://www.sandbox.paypal.com/cgi-bin/websc" onsubmit="return buyThem(this)">
				<ul id="list">
				</ul>
				<input type="hidden" name="cmd" value="_cart">
				<input type="hidden" name="upload" value="1">
				<input type="hidden" name="business" value="zx0319_1333078500_biz@gmail.com">
				<input type="hidden" name="currency_code" value="HKD">
				<input type="hidden" name="charset" value="utf-8">
				<input type="hidden" name="custom" value="0">
				<input type="hidden" name="invoice" value="0">
				<input type="hidden" name="nonce" value="<?php echo $_SESSION['$nonce']; ?>"/>
				<input type="submit" value="BUY THEM!">
			</form>
			</div>
		</div>
		<div id="box">
		show it!;
		</div>
	</body>

</html>
