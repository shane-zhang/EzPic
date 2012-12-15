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
echo "<pre>";
	if(move_uploaded_file($_FILES["pic"]["tmp_name"],"images/"."test.jpg"))
	{
		system("cd images;./Engine ".$count." test.jpg");
	}
echo "</pre>";

?>

<div id="Result">Hello</div>
<script type="text/javascript">
var Res = document.getElementsByTagName('pre')[0];
Res = Res.innerHTML;
Res = eval('('+Res+')');
alert(Res.UploadPicture);
for (x in Res.Compare)
{
  document.write(Res.Compare[x].Method+Res.Compare[x].Choice);
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
    document.write(Res.Compare[x].Result[y].CompareResult+"<li><img src=images/"+Res.Compare[x].Result[y].PictureName+"></img></li>");
  }
}

</script>

<?php

?>