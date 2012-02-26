<? 
include("dbconnect.php");
?> 

<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="language"    CONTENT="de">
<META NAME="robots"      CONTENT="index,follow"/>

<?
$url = $_SERVER['PHP_SELF'];
$func = $_SERVER['QUERY_STRING'];

$url_act = substr($func, strpos($func,'=')+1);
$url_array = parse_url ( $url );
$url_array = split('/', $url_array['path']);

for($i=0; $i < sizeof($url_array); $i++)
{
	if(substr($url_array[$i],-4)=='.php')
	{
		$meta_url = $url_array[$i];
	}
}

if($url_act!= "")
{
	$meta = mysql_fetch_array(mysql_query("SELECT * FROM meta WHERE url = '".$meta_url."' AND action=".$url_act.";"));
}
else
{
	$meta = mysql_fetch_array(mysql_query("SELECT * FROM meta WHERE url = '".$meta_url."';"));
}


echo '

<META NAME="description" CONTENT="'.$meta['description'].'"/>
<META NAME="keywords"    CONTENT="'.$meta['keyword'].'"/>

';
if($meta_url=="index.php")
{
	echo'<title>'.$meta['title'].'</title>';
}
else
{
	$title = mysql_fetch_array(mysql_query("SELECT * FROM meta WHERE url = 'index.php';"));
	echo'<title>'.$title['title'].' - '.$meta['title'].'</title>';
}	

?>
