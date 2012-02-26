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
							  

		});
	</script>
</head>
<body>
	<div id="container">
		<div id="header"><? include("_header.php"); ?></div>
		
		<div id="navigationSidebar"><? include("_navigation.php"); ?></div>
		<div id="infoSidebar"><? include("_info.php"); ?></div>

		<div id="mainContent"> 
		<div id="breadcrump"><a href="index.php">Startseite</a> - Suchergebnisse</div>      
		
		<? 
				echo "<h3>Suchergebnisse</h3>";
				
				$query = mysql_query("SELECT produkte.*, typ.status FROM produkte, typ WHERE produkte.typ = typ.id AND typ.status = 1 AND ( produktNr LIKE '%".$_POST['searchContent']."%' OR produkte.name LIKE '%".$_POST['searchContent']."%' );");
				$sqlPROD = mysql_fetch_array($query);
				
				if(mysql_num_rows($query) < 1)
				{
					echo "Das Produkt ist nicht vorhanden!";	
				}
				else
				{
					while( $row =  mysql_fetch_array($query))
					{
						$sql = mysql_query("SELECT * FROM typ WHERE id ='".$row['typ']."';");
						$sqlUPLOAD = mysql_fetch_array($sql);
							
						echo '
						<div id="einspaltig">  
						<hr /> ';  
								if($row['imagePath'] == "")
								{
									echo '<img class="imageRightAlign" src="img/no-pic.png" alt="Produktbild nicht vorhanden" height="128" width="171" /></a>';
								}
								else 
								{
									echo '<a id="fancy-'.$row['id'].'" class="image-holder" href="'._UPLOAD_PATH.$sqlUPLOAD['short'].'/'.$row['imagePath'].'"><img class="imageRightAlign" src="'._UPLOAD_PATH.$sqlUPLOAD['short'].'/'._THUMBS_DIR.$row['imagePath'].'" alt="'.$row['name'].'" height="128" width="171" /></a>';
								}
								echo '<strong><u><a href="produkte.php?action='.$sqlUPLOAD['id'].'">'.$sqlUPLOAD['name'].'</a></u> <br /><br />
								'.$row['name'].'</strong> <br />
								Bestellnummer: PD '.$row['produktNr'].'-xx</p>
								<p>'.$row['beschreibung'];
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
									echo'Ma&szlig;e: '.$row['size'].'</p>';
								}
						echo'</div>
						';	
					}
				}	
		?>		
			
		</div>
		 
			<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>
