<? 
session_start();
include("_CONSTANTS.php");
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include("_head.php"); ?>
	<link href="css/padcon.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/padcon.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function(){							  
			<?php
				if($_GET['action'] == 0)
				{
					$fancyQuery = mysql_query("SELECT * FROM produkte WHERE new='1';");
				}
				else
				{
					$fancyQuery = mysql_query("SELECT * FROM produkte WHERE typ='".$_GET['action']."';");	
				}
				
				
				while($row = mysql_fetch_array($fancyQuery))
				{
					echo 'jQuery("#fancy-'.$row['id'].'").fancybox();';
				}
			?>
		});

		var i = 0;//initialize
		var int=0;//Internet Explorer Fix
		jQuery(window).bind("load", function() {//The load event will only fire if the entire page or document is fully loaded
			var int = setInterval("doThis(i)",500);//500 is the fade in speed in milliseconds
		});
	
		function doThis() {
			var images = jQuery('img').length;//count the number of images on the page
			if (i >= images) {// Loop the images
				clearInterval(int);//When it reaches the last image the loop ends
			}
			jQuery('img:hidden').eq(0).fadeIn(500);//fades in the hidden images one by one
			i++;//add 1 to the count
		}

	</script>
</head>
<body>
<?
	$act = $_GET['action'];
	$let = $_GET['letter'];
?>
	<div id="container">
		<div id="header"><? include("_header.php"); ?></div>
		
		<div id="navigationSidebar"><? include("_navigation.php"); ?></div>
		<div id="infoSidebar"><? include("_info.php"); ?></div>

		<div id="mainContent"> 
		<?
			if(isset($act)){
				if($act == 0){
					if(isset($let)){
						$sqlTYP = mysql_fetch_array(mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 0,1;"));
						echo '<div id="breadcrump"><a href="index.php">Startseite</a> - <a href="produkte.php?action=0">'.$sqlTYP['name'].'</a> - '.$let.'</div>';
					}
					else {
						$sqlTYP = mysql_fetch_array(mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 0,1;"));
						echo '<div id="breadcrump"><a href="index.php">Startseite</a> - '.$sqlTYP['name'].'</div>';
					}		
				}
				else{
					if(isset($let)){
						$sqlTYP = mysql_fetch_array(mysql_query("SELECT * FROM typ WHERE id=".$act.";"));
						echo '<div id="breadcrump"><a href="index.php">Startseite</a> - <a href="produkte.php?action='.$act.'">'.$sqlTYP['name'].'</a> - '.$let.'</div>';
					}
					else {
						$sqlTYP = mysql_fetch_array(mysql_query("SELECT * FROM typ WHERE id=".$act.";"));
						echo '<div id="breadcrump"><a href="index.php">Startseite</a> - '.$sqlTYP['name'].'</div>';
					}
				}
			}
			else{
				echo "<meta http-equiv=\"refresh\" content=\"0; URL=_404.php\">";
			}			
		?>
		<div id="einspaltig">
			<div id="zeile">
				<a href="<?=_CATALOG_PATH.$sqlTYP['catalogPath']?>" target="_blank">
					<img class="imageRightAlign" style="border: 1px solid grey;" src="<? echo _CATALOG_IMAGE_PATH; if($act!=0){echo $sqlTYP['short'];}else{echo "news";}?>.png" alt="padcon Leipzig Katalog <?=$sqlTYP['catalog']?> <?=$sqlTYP['catalogDate']?>" />
				</a>
				<br />
				<br />
				<br />				
				Hier haben Sie die Möglichkeit den Gesamten Produktkatalog &quot;<?=$sqlTYP['catalog']?>&quot; <?=$sqlTYP['catalogDate']?> 
				zu downloaden.<br />
				<br />				
				Zum öffnen wird der Acrobat Reader benötigt 
				<a href="http://www.adobe.com/de/products/acrobat/readstep2.php" target="_blank">
					<img src="<?=_IMAGE_PATH?>acrobat.png" alt="Adobe Acrobat Reader" align="absmiddle"/>
				</a>
			</div>
		</div>
		<div id="zeile">
		<hr />
			<div id="letterNavigation">
					<?php foreach(range('A','Z') as $l) echo '<div id="letter"><a href="'.$_SESSION['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&letter='.$l.'">'.$l.'</a></div>'; ?>
			</div>
		</div>  
		<?  
			if($act == 0)
			{
				if(isset($let))
				{
					$sql = mysql_query("SELECT * FROM produkte WHERE new=1 AND name LIKE '".$let."%' ORDER BY name;");
				} else {
					$sql = mysql_query("SELECT * FROM produkte WHERE new=1 ORDER BY name;");
				}
			} else {
				if(isset($let))
				{
					$sql = mysql_query("SELECT * FROM produkte WHERE typ=".$act." AND name LIKE '".$let."%' ORDER BY name;");
				} else {
					$sql = mysql_query("SELECT * FROM produkte WHERE typ=".$act." ORDER BY produktNr;");
				}
			}
			
			while( $row =  mysql_fetch_array($sql))
			{	if($act == 0) {
					$sqlUPLOAD = mysql_fetch_array(mysql_query("SELECT * FROM typ WHERE id=".$row['typ'].";"));
				} else {
					$sqlUPLOAD = mysql_fetch_array(mysql_query("SELECT * FROM typ WHERE id=".$act.";"));
				}
				
				echo '
				<div id="einspaltig">  
				<hr />  ';
					if($row['imagePath'] == "")
					{
						echo '<img class="imageRightAlign" src="img/no-pic.png" alt="Produktbild nicht vorhanden" height="128" width="171" /></a>';
					}
					else 
					{
						echo '<a id="fancy-'.$row['id'].'" class="image-holder" href="'._UPLOAD_PATH.$sqlUPLOAD['short'].'/'.$row['imagePath'].'"><img class="imageRightAlign" src="'._UPLOAD_PATH.$sqlUPLOAD['short'].'/'._THUMBS_DIR.$row['imagePath'].'" alt="'.$row['name'].'" height="128" width="171" /></a>';
					}						
						echo '<strong>'.$row['name'].'</strong> <br />
						Bestellnummer: PD '.$row['produktNr'].'-xx<br />
						'.$row['beschreibung'];
						$array=split(",",$row['bezug']);
									foreach ($array as $t)
									{
										$bezugQuery = mysql_query("SELECT * FROM bezug WHERE id='".$t."';");
										while($row3 = mysql_fetch_array($bezugQuery))
										{
											echo '<table><tr><td>Bezug:</td><td>'.$row3['name'].'</td></tr>';
											
											$farbQuery = mysql_query("SELECT * FROM color WHERE bezug LIKE '%".$row3['id']."%';");
											echo '<tr><td>Farbe:</td><td>';
											while($row4 = mysql_fetch_array($farbQuery))
											{
												echo '<div class="vtip" title="'.$row4['name'].'" style="float: left; margin: 0 3px 3px 0; background-color:'.$row4['rgb'].'; height: 15px; width: 15px; border:1px #999 solid"></div>';
											}
											echo '</td><td  class="rowSize"></td></tr></table>';
										}
									}
						echo $row['spezial'].'<br />';
						if(strlen($row['size'])>0)
						{
							echo'Ma&szlig;e: '.$row['size'].'';
						}
				echo'</div>
				';	
			}
		
		?> 
		</div>
		 
			<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>
