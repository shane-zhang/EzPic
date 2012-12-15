<?php
	include_once "pro_init.php";
	$db = new PDO("sqlite:../DB/pic");
	$q = $db -> prepare("SELECT * FROM picture WHERE description LIKE '%".$_POST["Query_String"]."%'");
	$count = 0;
echo "<pre hidden='hidden'>";

//
	if($q -> execute())
	{
echo "[";
		while ($p = $q->fetch())
		{
			echo "{\"name\":\"".$p["name"]."\",\"PictureName\":\"".$p["address"]."\"},";
			$count++;
		}
	}
echo "]";
echo "</pre>";

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
			<span>Search Result</span>
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
<script type="text/javascript">
var div = document.getElementById("main");
var Res = document.getElementsByTagName('pre')[0];
Res = Res.innerHTML;
Res = eval('('+Res+')');
alert(Res[0].name);
var botton = document.createElement("botton");
botton.innerHTML="Hello"; 
div.appendChild(botton);
var ul = document.createElement("ul");
ul.className = "Shop_List";
div.appendChild(ul);
for (x in Res)
{
  var li = document.createElement("li");
  var img = document.createElement("img");
  img.src = Res[x].PictureName;
  li.appendChild(img);
  ul.appendChild(li);
//    document.write(Res.Compare[x].Result[y].CompareResult+"<li><img src=images/"+Res.Compare[x].Result[y].PictureName+"></img></li>");
}

</script>
</ul>
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


<?php

?>