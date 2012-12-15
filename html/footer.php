<?php
	include_once "lib_base.php";
	echo '2012 EzPic <a href="http://svr6.haohaizi.us">Shane_Wayne</a> <hr />';
//	echo '<a href="http://www.shop60.ierg4210.org/shaneShop.apk">Android User</a> <hr />';
?>
<?php
	$t = checkCookie();
	if( $t != false)
	{
		$temp = $t['exp']-time();
		echo "Hello User:".$t['user'].$temp;
?>
<form method="post" action="changepassword.php">
	<input type="hidden" name="action" value="change"/>
	<input type="submit" value="change"/>
</form>
<form method="post" action="check.php">
	<input type="hidden" name="action" value="logout"/>
	<input type="submit" value="logout"/>
</form>
<?php
	}
	else
	{
		echo 'Not logged yet.';
	};
?> 