<?php
	include_once "pro_init.php";
	include_once "lib_base.php";
	$_SESSION['$nonce'] = getNonce();
?>
<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
			<title>Change Password</title>
			<link href="style.css" rel="stylesheet" type="text/css"/>
		</head>
		
		<body>
			<div id="header">
				<span>Change Password</span>
			</div>
	
			<div id="main">
				Change your password<hr />
				<div class="baseform">
					<fieldset>
						<legend>Log In</legend>
						<form id="change" method="post" action="check.php">
						
							<label for="Old">Old*</label>
							<br />
							<input id="Old" type="password" name="Old" required="required"/>
							<br />
							
							<label for="New1">New1*</label>
							<br />
							<input id="New1" type="password" name="New1" required="required"/>
							<br />
							
							<label for="New2">New2*</label>
							<br />
							<input id="New2" type="password" name="New2" required="required"/>
							<br />
							
							<input type="hidden" name="nonce" value="<?php echo $_SESSION['$nonce']; ?>"/>
							<input type="hidden" name="action" value="change"/>
							<input type="submit" value="Change" />
							
						</form>
					</fieldset>
				</div>
				
		<div id="footer">
			<?php include 'footer.php' ?>
		</div>
	</body>
</html>
