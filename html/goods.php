<?php
	$db = new PDO("sqlite:../DB/pic");
	$q = $db -> prepare("SELECT * FROM picture");
	$count = 0;
	if($q -> execute())
	{
		echo '<ul class="Shop_List">';
		while ($p = $q->fetch())
		{
			echo "<li>".'<img src="'.$p["address"].'"'.' '.'alt='.'"'.$p["name"].'"'."/>"."<hr />".$p["name"]."</li>";
			$count++;
		}
		echo '</ul>';
	}
	echo "<div id='total'>Total: ".$count."</div>";
/*
	echo "\n";
	echo '<ul class="Shop_List">';
	$db = new PDO("sqlite:../DB/cart");
	$count = 0;
	echo "\n";
	$q = $db -> prepare("SELECT * FROM products WHERE catid = ?");
	if($q -> execute(array($_GET["catid"])))
	{
		while ($p = $q->fetch())
		{
			echo "<li>".'<img src="'.$p["pic"].'"'.' '.'alt='.'"'.$p["name"].'"'."/>"."\n"."<br />".$p["name"]."<br />"."HKD:"."<span>".$p["price"]."</span>"."<br />".'<button type="button" onclick="buySomething('.$p["pid"].','."'".$p["name"]."'".','.$p["price"].')">Buy!</button>'.'<button type="button" onclick="getDetail('.$p["pid"].')">See!</button>'."</li>";
			$count++;
		}
	}
	echo "</ul>";
	echo "\n";
	echo "<div id='total'>Total: ".$count."</div>";
*/
?>