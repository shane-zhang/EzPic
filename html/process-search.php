<?php
	include_once "pro_init.php";
	
	$db = new PDO("sqlite:../DB/pic");
	$q = $db -> prepare("SELECT * FROM picture");
	$count = 0;
	if($q -> execute())
	{
		while ($p = $q->fetch())
		{
			$count++;
		}
	}
echo "<pre hidden='hidden'>";
	if(move_uploaded_file($_FILES["pic"]["tmp_name"],"images/"."test.jpg"))
	{
		system("cd images;./Engine ".$count." test.jpg");
	}
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
alert(Res.UploadPicture);
for (x in Res.Compare)
{

  var botton = document.createElement("botton");
  botton.innerHTML="Hello";
  
  div.appendChild(botton);
  var ul = document.createElement("ul");
  ul.className = "Shop_List";
  div.appendChild(ul);
//  document.write(Res.Compare[x].Method+Res.Compare[x].Choice);
  if(Res.Compare[x].Choice == "Max")
  {
//    alert("Max");
    Res.Compare[x].Result.sort(function(a,b){return parseFloat(b.CompareResult)-parseFloat(a.CompareResult)} );
  }
  else
  {
//    alert("Min");
    Res.Compare[x].Result.sort(function(a,b){return parseFloat(a.CompareResult)-parseFloat(b.CompareResult)} );
  }
  for(y in Res.Compare[x].Result)
  {
    var li = document.createElement("li");
    var img = document.createElement("img");
    img.src = "images/"+Res.Compare[x].Result[y].PictureName;
    li.appendChild(img);
    ul.appendChild(li);
//    document.write(Res.Compare[x].Result[y].CompareResult+"<li><img src=images/"+Res.Compare[x].Result[y].PictureName+"></img></li>");
  }
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