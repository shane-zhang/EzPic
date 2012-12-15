<?php
	include_once "pro_init.php";
	include_once "lib_base.php";
	$_SESSION['$nonce'] = getNonce();
?>
<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
			<title>Reset Password</title>
			<link href="style.css" rel="stylesheet" type="text/css"/>
		</head>
		
		<body>
			<div id="header">
				<span>Reset Password</span>
			</div>
	
			<div id="main">
				Reset your password<hr />
				<div class="baseform">
					<fieldset>
						<legend>Email</legend>
						<form id="baseform" method="post" action="check.php">
							<label for="email">Email*</label>
							<br />
							<input id="email" type="text" name="email" required="required"/>
							<br />
							
							<input type="hidden" name="nonce" value="<?php echo $_SESSION['$nonce']; ?>"/>
							<input type="hidden" name="action" value="reset"/>
							<input type="submit" value="Reset" />
							
						</form>
					</fieldset>
				</div>
				
		<div id="footer">
			<?php include 'footer.php' ?>
		</div>
	</body>
</html>
