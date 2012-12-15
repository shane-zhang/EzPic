<?php
	include_once "pro_init.php";
	
	if($_SESSION['nonce'] != $_POST['nonce'])
	{
		header("Location:loginForm.php?statue=2");
		exit();
	}
	
	function Con_DB()
	{
		$db = new PDO('sqlite:../DB/cart');
		$db -> query('PRAGMA foreign_keys = ON;');
		return $db;
	}
	
	function RET_BAK()
	{
		header('Location: admin.php');
	}
	
	switch($_POST["choice"])
	{		
		case 4:
		{
			$db = new PDO('sqlite:../DB/pic');
			$q = $db -> prepare("INSERT INTO picture (name,description) VALUES (?,?)");
			if($q -> execute(array($_POST["Name_Picture"],$_POST["Description_Picture"])))
			{
				echo "DONE!";
				$LastId = $db->lastInsertId();
				echo $LastId;
				if($_FILES["pic"]["error"]==0&&$_FILES["pic"]["size"]<10000000)
				{
					$FileType=substr($_FILES["pic"]["name"],-4);
					if($FileType==".jpg"||$FileType==".png"||$FileType==".gif")
					{
						if(move_uploaded_file($_FILES["pic"]["tmp_name"],"images/".$LastId.$FileType))
						{
							$q = $db -> prepare("UPDATE picture SET address = (?) WHERE pid = (?)");
							if($q -> execute(array("images/".$LastId.$FileType,$LastId)))
							{
								echo "UpLoaded Success!";
								RET_BAK();
							}
						}
						else
						{
							echo "Move fail!";
						}
					}
					else
					{
						echo "Type fail?";
					}
				}
				else
				{
					echo $_FILES["pic"]["error"];
					echo "Upload Fail";
				}
			}
			else
			{
				echo "ERROR!";
				print_r($db->errorInfo());
			}
	
			break;
		}
		
		case 5:
		{
			if(empty($_POST["Selector"]))
			{
				echo "Sorry,You have not selected any thing.\n";
			}
			if(empty($_POST["Selector_Product"]))
			{
				echo "Sorry,You have not selected any Product.\n";
			}
			else if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST["Name_Product_Update"]))
			{
				echo "Name_Product_NOT_Match\n";
			}
			else if(!preg_match("/^\d{1,}(\.\d+)?$/",$_POST["Price_Product_Update"]))
			{
				echo "Price_Product_NOT_Match\n";
			}
			else if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST["Description_Product_Update"]))
			{
				echo "Description_Product_NOT_Match\n";			
			}
			else
			{
				$db = Con_DB();
				$q = $db -> prepare("UPDATE products SET catid = (?),name = (?),price = (?),description = (?) WHERE pid = (?)");
				if($q -> execute(array($_POST["Selector"],$_POST["Name_Product_Update"],$_POST["Price_Product_Update"],$_POST["Description_Product_Update"],$_POST["Selector_Product"])))
				{
					echo "DONE!";
					RET_BAK();
				}
				else
				{
					echo "ERROR!";
					print_r($db->errorInfo());
				}
			}
			break;
			break;
		}
	
		case 6:
		{
			if(empty($_POST["Selector_Product"]))
			{
				echo "Sorry,You have not selected any thing.\n";
			}
			else
			{
				$db = Con_DB();
				$q = $db -> prepare("DELETE FROM products WHERE pid = (?)");
				if($q -> execute(array($_POST["Selector_Product"])))
				{
					if(unlink('images/'.$_POST["Selector_Product"].'.jpg'))
					{
						echo "Delete Well";
					}
					else
					{
						echo "No_Such_File";
					}
					echo "DONE!";
				}
				else
				{
					echo "ERROR!";
					print_r($db->errorInfo());
				}
			}
			break;
		}
		
		default:
		{
			echo "Invalide choice?!";
		}
	}


?>