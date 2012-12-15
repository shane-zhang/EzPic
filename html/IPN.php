<?php

$email = $_GET['ipn_email'];
$email = "zx0319@gmail.com";

$emailtext = "Some thing was wrong";
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) 
{
	$value = urlencode(stripslashes($value)); 
	$req .= "&".$key."=".$value; 
}

error_log("===START===\n", 3, "log.txt");
$header = "";
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n"; 
$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n"; 
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); 

if (!$fp) 
{ 
	error_log("Fail to connect", 3, "log.txt");
} 
else
{ 
	fputs ($fp, $header . $req);
	while (!feof($fp))
	{
		$res = fgets ($fp, 1024);
		//error_log("Already get socket".$res."\n", 3, "log.txt");
		if (strcmp ($res, "VERIFIED") == 0)
		{
			if($_POST['payment_status']=='Pending')
			{
				error_log("A new payment have been PENDING \n", 3, "log.txt");
				$db = new PDO('sqlite:../DB/bill');
				$q = $db -> prepare("UPDATE bill SET txn=(?),FINISH=(?) WHERE bid = (?)");
				$q -> execute(array($_POST["txn_id"],"Pending",$_POST["invoice"]));
				$q = $db -> prepare("SELECT * FROM bill WHERE txn=(?)");
				$q -> execute(array("'".$_POST["txn_id"]."'"));
				if($q -> rowCount() == 1)
				{
					$q = $db -> prepare("UPDATE bill SET NOPAS=(?) WHERE bid = (?)");
					$q -> execute(array("PASS1",$_POST["invoice"]));

					$json -> {"currency"} = $_POST["mc_currency"];
					$json -> {"merchant"} = $_POST["business"];
					for($i=1;$i<$_POST["num_cart_items"]+1;$i++)
					{
						$temp[$i] -> {"pid"} = $_POST["item_number".$i];
						$temp[$i] -> {"num"} = $_POST["quantity".$i];
						$temp[$i] -> {"price"} = number_format($_POST["mc_gross_".$i]/$_POST["quantity".$i],1,'.','');
//						error_log("ALL_JSON \n".json_encode($temp), 3, "log.txt");
						$json -> {"cart"}[$i-1] = $temp[$i];
					}
					
					function my_sort($a, $b)
					{
						if (intval($a->{"pid"}) < intval($b->{"pid"})) 
						{
							return -1;
						}
						else if (intval($a->{"pid"}) > intval($b->{"pid"}))
						{
							return 1;
						} 
						else 
						{
							return 0;
						}
					}

					usort($json -> {"cart"}, 'my_sort');
					
					$str = json_encode($json);
//					error_log("JSON \n".$str, 3, "log.txt");
					$db = new PDO('sqlite:../DB/bill');
					$q = $db -> prepare("SELECT * FROM bill WHERE bid=(?)");
					$q -> execute(array($_POST["invoice"]));
					$p = $q->fetch();
					error_log("\nJSON:".$str."\n", 3, "log.txt");
					$str = $str.$p["salt"];
					$str = md5($str);
					if($str==$p["goods"])
					{
						error_log("\nFinish SQL Operation\n", 3, "log.txt");
					}
					else
					{
						$q = $db -> prepare("UPDATE bill SET NOPAS=(?) WHERE bid = (?)");
						$q -> execute(array("ERROR1",$_POST["invoice"]));
					}
				}
				else
				{
					$q = $db -> prepare("UPDATE bill SET NOPAS=(?) WHERE bid = (?)");
					$q -> execute(array("NMAC1",$_POST["invoice"]));
					exit();
				}
			}
			if($_POST['payment_status']=='Completed')
			{
				error_log("A payment have COMPLETED \n", 3, "log.txt");
				$db = new PDO('sqlite:../DB/bill');
				$q = $db -> prepare("UPDATE bill SET FINISH=(?) WHERE bid = (?)");
				$q -> execute(array("Compelete",$_POST["invoice"]));

				$q = $db -> prepare("SELECT * FROM bill WHERE txn=(?)");
				$q -> execute(array("'".$_POST["txn_id"]."'"));
				if($q -> rowCount() == 1)
				{
					$q = $db -> prepare("UPDATE bill SET NOPAS=(?) WHERE bid = (?)");
					$q -> execute(array("PASS2",$_POST["invoice"]));

					$json -> {"currency"} = $_POST["mc_currency"];
					$json -> {"merchant"} = $_POST["business"];
					for($i=1;$i<$_POST["num_cart_items"]+1;$i++)
					{
						$temp[$i] -> {"pid"} = $_POST["item_number".$i];
						$temp[$i] -> {"num"} = $_POST["quantity".$i];
						$temp[$i] -> {"price"} = number_format($_POST["mc_gross_".$i]/$_POST["quantity".$i],1,'.','');
//						error_log("ALL_JSON \n".json_encode($temp), 3, "log.txt");
						$json -> {"cart"}[$i-1] = $temp[$i];
					}
					function my_sort($a, $b)
					{
						if (intval($a->{"pid"}) < intval($b->{"pid"})) 
						{
							return -1;
						}
						else if (intval($a->{"pid"}) > intval($b->{"pid"}))
						{
							return 1;
						} 
						else 
						{
							return 0;
						}
					}

					usort($json -> {"cart"}, 'my_sort');
					$str = json_encode($json);
//					error_log("JSON \n".$str, 3, "log.txt");
					$db = new PDO('sqlite:../DB/bill');
					$q = $db -> prepare("SELECT * FROM bill WHERE bid=(?)");
					$q -> execute(array($_POST["invoice"]));
					$p = $q->fetch();
					$str = $str.$p["salt"];
					$str = md5($str);
					if($str==$p["goods"])
					{
						error_log("\nFinshed This Bill \n======\n", 3, "log.txt");
					}
					else
					{
						$q = $db -> prepare("UPDATE bill SET NOPAS=(?) WHERE bid = (?)");
						$q -> execute(array("ERROR2",$_POST["invoice"]));
					}
				}
				else
				{
					$q = $db -> prepare("UPDATE bill SET NOPAS=(?) WHERE bid = (?)");
					$q -> execute(array("NMAC2",$_POST["invoice"]));
					exit();
				}
			}
			error_log("AAA Pass".$res."\n", 3, "log.txt");
		}
		else if(strcmp ($res, "INVALID") == 0)
		{
			error_log("CCC Not Pass".$res."\n", 3, "log.txt");
		}
	}
	fclose ($fp); 
	error_log("===FINISH===\n", 3, "log.txt");
}
?>