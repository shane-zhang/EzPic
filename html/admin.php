<?php
	include_once "pro_init.php";
	include_once "lib_base.php";
	$temp = checkCookie();

	if($temp == false)
	{
		header("Location:loginForm.php");
		exit();
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<title>Admin Panel</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
	</head>
	
	<body>
		<div id="header">
			<span>Admin	Panel For <?php echo $temp['user'];?></span>
		</div>

		<div id="main">
			Manage Your Picture. <hr />
			
			<div class="baseform">
				<fieldset>
					<legend>Upload a Picture</legend>
						<form id="Insert_Product" method="post" action="process.php"  enctype="multipart/form-data">
							<label for="Selector">Category*</label>
							<br />
							
							<label for="Name_Picture">Name*</label>
							<br />
							<input id="Name_Picture" type="text" name="Name_Picture" pattern="[a-zA-Z0-9]+" required="required"/>
							<br />
							
							<label for="Description_Picture">Description</label>
							<br />
							<textarea id="Description_Picture" name="Description_Picture" rows="10" cols="10">Tell something about the picture.</textarea>
							<br />
							
							<label for="Upload_Pic">Image</label>
							<br />
							<input id="Upload_Pic" type="file" name="pic" accept="image/*" />
							<br />
							
							<input type="hidden" name="choice" value="4"/>
							<input type="hidden" name="nonce" value="<?php echo $tempNonce ?>"/>
							<input type="submit" value="Create" />
						</form>
				</fieldset>
			</div>
<hr />
			<div class="baseform">
				<fieldset>
					<legend>Update a Product</legend>
						<form id="Update_Product" method="post" action="process.php">
							<label for="Selector_Product">Products*</label>
							<br />
							<select id="Selector_Product" name="Selector_Product" required="required">
								<option value="" selected="selected"></option>
								<?php
								$db = new PDO("sqlite:../DB/cart");
								echo "\n";
								$q = $db -> prepare("SELECT pid,name FROM products");
								$q -> execute();
								while ($p = $q->fetch())
								{
									echo '<option value="'.$p["pid"].'">'.$p["name"]."</option>"."\n";
								}
								?>
							</select>
							<br />
							
							<label for="Selector">New Category*</label>
							<br />
							<select name="Selector" required="required">
								<option value="" selected="selected"></option>
								<?php
								$db = new PDO("sqlite:../DB/cart");
								echo "\n";
								$q = $db -> prepare("SELECT catid,name FROM categories");
								$q -> execute();
								while ($p = $q->fetch())
								{
									echo '<option value="'.$p["catid"].'">'.$p["name"]."</option>"."\n";
								}
								?>
							</select>
							<br />
							
							<label for="Name_Product_Update">Name*</label>
							<br />
							<input id="Name_Product_Update" type="text" name="Name_Product_Update" pattern="[a-zA-Z0-9]+" required="required"/>
							<br />
							
							<label for="Price_Product_Update">Price*</label>
							<br />
							<input id="Price_Product_Update" pattern="\d{1,}(\.\d+)?" name="Price_Product_Update" required="required"/>
							<br />
							
							<label for="Description_Product_Update">Description</label>
							<br />
							<textarea id="Description_Product_Update" name="Description_Product_Update" rows="10" cols="10">Tell something about the product.</textarea>
							<br />
							
							<input type="hidden" name="choice" value="5"/>
							<input type="hidden" name="nonce" value="<?php echo $tempNonce ?>"/>
							<input type="submit" value="Update" />
						</form>
				</fieldset>
			</div>
		    <hr />
			<div class="baseform">
				<fieldset>
					<legend>Delete a Product</legend>
						<form id="Delete_Product" method="post" action="process.php">
							<label for="Selector_Product">Products*</label>
							<br />
							<select name="Selector_Product" required="required">
								<option value="" selected="selected"></option>
								<?php
								$db = new PDO("sqlite:../DB/cart");
								echo "\n";
								$q = $db -> prepare("SELECT pid,name FROM products");
								$q -> execute();
								while ($p = $q->fetch())
								{
									echo '<option value="'.$p["pid"].'">'.$p["name"]."</option>"."\n";
								}
								?>
							</select>
							<input type="hidden" name="choice" value="6"/>
							<input type="hidden" name="nonce" value="<?php echo $tempNonce ?>"/>
							<input type="submit" value="Delete" />
						</form>
				</fieldset>
			</div>
		</div>
		
		<div id="left" class="sur">
			<div id="nav">
				<ul>
					<li><a href="index.php">Home</a></li>
				</ul>
			</div>
		</div>
		
		<div id="footer">
			<?php include 'footer.php' ?>
		</div>
	</body>
</html>
