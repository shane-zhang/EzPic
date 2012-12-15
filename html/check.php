<?php
	include_once "pro_init.php";
	include_once "lib_base.php";
	
	if(isset($_POST['action']))
	{
		switch ($_POST['action'])
		{
			case 'auth':
				{
					auth();
					break;
				}
			case 'change':
				{
					$json = json_decode($_COOKIE["token"]);
					echo($json -> {'user'});
					echo($_POST["Old"]);
					echo($_POST["New1"]);
					echo($_POST["New2"]);
					if($_POST["New1"]==$_POST["New2"])
					{
					
						$temp = userLogin($json -> {'user'},$_POST["Old"],$_POST['nonce']);
						if($temp != false)
						{
							echo "pass";
							$salt = mt_rand();
							$password=md5($json -> {'user'}.$salt.$_POST["New1"]);
							$db = new PDO("sqlite:../DB/account");
							$q = $db -> prepare("UPDATE user SET password=(?),salt=(?)  WHERE username=(?)");
							$q -> execute(array($password,$salt,$json -> {'user'}));
							logout();
						}
						else
						{
							echo "problem";
						}
					}
					else
					{
						echo ("Error Occur!");
					}
					break;
				}
				
			case 'change2':
				{
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
				}
			case 'reset':
				{
					echo ("IN!");
					echo ($_POST["email"]);
					$db = new PDO("sqlite:../DB/account");
					$q = $db -> prepare("SELECT * FROM user WHERE username = (?) ");
					$q -> execute(array($_POST['email']));
					if($p = $q -> fetch())
					{
						$reset_salt = mt_rand();
						$q = $db -> prepare("UPDATE user set reset = (?) WHERE username = (?) ");
						$q -> execute(array($reset_salt,$_POST['email']));
						
$fp = fsockopen("smtp.163.com",25); 
fwrite($fp,"HELO 163.com\r\n");
echo fgets($fp, 128);
fwrite($fp,"AUTH LOGIN\r\n");
echo fgets($fp, 128);
fwrite($fp,"engwMzE5\r\n");
echo fgets($fp, 128);
fwrite($fp,"MTk5MTAzMTlh\r\n");
echo fgets($fp, 128);
fwrite($fp,"MAIL FROM:<zx0319@163.com>\r\n");
echo fgets($fp, 128);
fwrite($fp,"RCPT TO:<".$_POST['email'].">\r\n");
echo fgets($fp, 128);
fwrite($fp,"DATA\r\n");
echo fgets($fp, 128);
fwrite($fp,"TEST FROM WEBQ"."Click the link\n"."http://www.shop60.ierg4210.org/check.php?email=".$_POST['email']."&key=".$reset_salt."\n Good Luck"."\r\n.\r\n");
echo fgets($fp, 128);
fwrite($fp,"QUIT\r\n");
echo fgets($fp, 128);

fclose($fp);

						
						
						if(mail($_POST['email'],"Reset Your Password","Click the link\n"."http://www.shop60.ierg4210.org/check.php?email=".$_POST['email']."&key=".$reset_salt."\n Good Luck")==false)
						{
							echo "http://www.shop60.ierg4210.org/check.php?email=".$_POST['email']."&key=".$reset_salt."\n Good Luck";
						}
					}
					else
					{
						echo "error";
					}
					break;
				}
			case 'reset2':
				{
					echo ($_GET["email"]);
					$db = new PDO("sqlite:../DB/account");
					$q = $db -> prepare("SELECT * FROM user WHERE username = (?) ");
					$q -> execute(array($_POST['email']));
					if($p = $q -> fetch())
					{
						if($_GET['key']==$q['reset'])
						{
							echo "begin";
						}
					}
					else
					{
						echo "error";
					}
					break;
				}
			case 'logout':
				{
					logout();
					break;
				}
		}
	}
	else
	{
	if(isset($_GET['email'])&&isset($_GET['key']))
	{
		echo $_GET['email'];
		$db = new PDO("sqlite:../DB/account");
		$q = $db -> prepare("SELECT * FROM user WHERE username = (?) ");
		$q -> execute(array($_GET['email']));
		if($p = $q -> fetch())
		{
			echo "IN!";
			echo $p['reset'];
			if($_GET['key']==$p['reset'])
			{
				echo "begin";
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
						<form id="baseform" method="post" action="pare.php">
							
							<label for="New1">New1*</label>
							<br />
							<input id="New1" type="password" name="New1" required="required"/>
							<br />
							
							<label for="New2">New2*</label>
							<br />
							<input id="New2" type="password" name="New2" required="required"/>
							<br />
							
							<input type="hidden" name="nonce" value="<?php echo $_SESSION['$nonce']; ?>"/>
							<input type="hidden" name="email" value="<?php echo $_GET['email']; ?>"/>
							<input type="hidden" name="salt" value="<?php echo $_GET['key']; ?>"/>
							<input type="submit" value="Change" />
							
						</form>
					</fieldset>
				</div>
				
		<div id="footer">
			<?php include 'footer.php' ?>
		</div>
	</body>
</html>
<?php
			}
			else
			{
				echo "error";
			}
		}
		
	}
	}
?>