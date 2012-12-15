<?php
	function getNonce()
	{
		$nonce = md5(mt_rand().session_id());
		return $nonce;
	};
	
	function checkNonce($input)
	{
		if($input == $_SESSION['$nonce'])
		{
			return true;
		}
		else
		{
			return false;
		}
	};
	
    function userLogin($username,$password,$rad)
	{
		if($rad == $_SESSION['$nonce'])
		{
			$db = new PDO("sqlite:../DB/account");
			$q = $db -> prepare("SELECT * FROM user WHERE username = ? ");
			$q -> execute(array($username));
			if($p = $q -> fetch())
			{
				$password=md5($username.$p['salt'].$password);
				if($password == $p['password'])
				{
					return $password;
				}
				return false;
			}
			return false;
		}
		else
		{
			return false;	
		}
	}
	
	function userLogout()
	{
		$token = NULL;
		$exp = 0;
		setcookie('authtoken', json_encode($token), $exp,'','',false,true);
	}
	
	function checkCookie()
	{
		if(empty($_COOKIE['token']))
		{
			return false;
		}
		else
		{
			if($deToken = json_decode(stripslashes($_COOKIE['token']),true))
			{
				$db = new PDO("sqlite:../DB/account");
				$q = $db -> prepare("SELECT * FROM user WHERE username = ? ");
				$q -> execute(array($deToken['user']));
				$p = $q -> fetch();
				if($p['password'] == $deToken['pass'])
				{
					return $deToken;
				}
				else
				{
					return false;
				}
				return false;
			}
			return false;
		}
	}
	
	function logout()
	{
		setcookie('token',null,0,'','',false,true);
		session_destroy();
		header("Location:loginForm.php?statue=3");
		exit();
	}
	
	function auth()
	{
		$temp = userLogin($_POST['Username'],$_POST['Password'],$_POST['nonce']);
		if($temp != false)
		{
			$time_exp = time() + 2 * 60;
			$raw_user = $_POST['Username'];
			$raw_pass = $temp;
			$raw_token = array('user'=>$raw_user,'pass'=>$raw_pass,'exp'=>$time_exp);
			setcookie('token',json_encode($raw_token),$time_exp,'','',false,true);
			header("Location:index.php");
			exit();
		}
		else
		{
			header("Location:loginForm.php?statue=1");
			exit();
		}
	}
	
	function getURL() 
	{
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") 
		{
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80")
		{
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else
		{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
?>