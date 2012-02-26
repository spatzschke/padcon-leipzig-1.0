<img src="img/navigation.png" alt="Navigation" width="186" height="27" />
<a href="index.php">Startseite</a>
<a href="ueber-uns.php">Über uns</a>
<a href="vertriebspartner.php">Vertriebspartner</a>
<a href="bestellung.php">Bestellung</a>
<a href="impressum.php">Impressum</a>
<a href="agb.php">AGB</a>
<img src="img/shadow.png" alt="" width="186" height="20" />
<?
if (isset($_SESSION['user'], $_SESSION['pw']))
{	
	echo '<img src="img/administration.png" alt="Administration" width="186" height="27" />';	
	echo '<a href="backend.php">Admin-Bereich</a>';
	echo '<a href="admin.php?action=0">Logout</a>';
	echo '<img src="img/shadow.png" alt="" width="186" height="20" />';
}
?>
<img src="img/produktubersicht.png" width="186" height="27" />
<?
	echo '
	<a id="searchBar">Produkt suchen</a>
	<div id="search">
		<form method="post" action="suche.php" >
			<input name="searchContent" type="text" size="25" />
			<br />
			<input name="search" type="submit" id="send" value="Produkt suchen"/>
		</form>
	</div>
	';
	$query = mysql_query("SELECT * FROM produkte WHERE new = 1;");
	$t = mysql_num_rows($query);
	/*
	if($t > 0)
	{
		$y = getdate();
		echo'<a href="produkte.php?action=0">Neuheiten '.$y[year].'</a>';
	}
	*/
	
	if(isset($_SESSION['user'], $_SESSION['pw']))
	{
		$query = mysql_query("SELECT * FROM typ;");
	}
	else
	{
		$query = mysql_query("SELECT * FROM typ WHERE status=1;");
	}
	
	while($row = mysql_fetch_array( $query, MYSQL_ASSOC))
	{
		if($row['status']==1)
		{
			echo '<a href="produkte.php?action='.$row['id'].'">'.$row['name'].'</a>';	
		}
		else
		{
			echo '<div id="inactive"><a href="produkte.php?action='.$row['id'].'">'.$row['name'].'</a></div>';	
		}
	}
?>
<img src="img/shadow.png" alt="" width="186" height="20" /><br />
<img id="lineLeft" src="img/lineleft.png" width="186"/>
