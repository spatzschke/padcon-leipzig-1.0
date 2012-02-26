<? 
session_start();
include("dbconnect.php");
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
			imageUploadSlide();	
		});
	</script>
</head>
<body>
	<div id="container">
		<div id="header"><? include("_header.php"); ?></div>
		
		<div id="navigationSidebar"><? include("_navigation.php"); ?></div>
		<div id="infoSidebar"><? include("_info.php"); ?></div>

		<div id="mainContent"> 
		<div id="breadcrump"><a href="index.php">Startseite</a> - Produkt-Setup</div>      
		<div id="einspaltig">
			<?
		
				// is the user in the secure area
				if($_POST['auslog'] != null)
				{
					unset($_SESSION["user"]);
					unset($_SESSION["pw"]);
					echo "<meta http-equiv=\"refresh\" content=\"0; URL=admin.php\">";
				}
				elseif (!isset($_SESSION['user'], $_SESSION['pw']) OR $_POST['auslog'] != null)
				{		
					echo "<meta http-equiv=\"refresh\" content=\"0; URL=admin.php\">";
				}
				else
				{	switch($_GET['action'])
					{
						case 0: newProd();
							break;
						case 1: editProd();
							break;
						case 2: deleteProd();
							break;
						case 3: statusProd();
							break;
							
						default: echo 'Funktion ist noch nicht vorhanden';
						
						
					}
				}
			  
		   	?>
		</div>	
		</div>
		 
			<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>
<?
/*
	*	the config_panel
	*
	*	
	*
	*/
	
	function newProd()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			echo '
		
		<form method="post" enctype="multipart/form-data">
		<input type="hidden" name="check" value="0">
		<table>
			<tr>
			<td>Kategorie:</td><td><select name="cboxTyp">';
			
			$query = mysql_query("SELECT * FROM typ;");
			
			while($row = mysql_fetch_array($query))
			{
				echo '<option value="'.$row['id'].'">'.$row['name'].'</option><br>';
			}	
			echo '</select></td></tr>
			<tr><td>Bilddatei:</td><td><input type="file" name="datei"></td></tr>
			<tr><td>Neuheit 2010</td><td><input type="checkbox" name="new" value="1"></td></tr>
			<tr><td>Produktnummer:</td><td>PD <input type="text" name="prodNr">-xx</td></tr>
			<tr><td>Produktname:</td><td><input type="text" name="name"></td></tr>
			<tr><td>Beschreibung:</td><td><textarea name="beschreibung" cols="30" rows="5"></textarea></td></tr>
			<tr><td>Bezug:</td><td><select name="bezug[]" size="3" multiple="multiple">';
			
			$query = mysql_query("SELECT * FROM bezug;");
			
			while($row = mysql_fetch_array($query))
			{
				echo '<option value="'.$row['id'].'">'.$row['name'].'</option><br>';
			}	
		echo '</select></td></tr>
			<tr><td>Zusatz:</td><td><textarea name="spezial" cols="30" rows="5"></textarea></td></tr>
			<tr><td>Maße:</td><td><input type="text" name="size"></td></tr>
			<tr><td>Preis:</td><td><input type="text" name="preis"> €</td></tr>
			<tr><td><input type="submit" name="enter" value="Speichern"></td></tr>
			</table>
		</form>

		';
		}	
	}

	function editProd()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM produkte WHERE produktNr ='".$_GET['editID']."' AND typ = ".$_GET['cboxTyp'].";");
				$sqlPROD = mysql_fetch_array($query);
				
				if(mysql_num_rows($query) < 1)
				{
					echo "Das Produkt ist nicht vorhanden!";	
				}
				else
				{
					$sqlImage = mysql_fetch_array(mysql_query("SELECT short FROM typ WHERE id='".$sqlPROD['typ']."';"));
								
					echo '
			
					<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="check" value="1">
					<input type="hidden" name="prodID" value="'.$sqlPROD['id'].'">
					<table>
						<tr>
						<td>Kategorie:</td><td><select name="cboxTyp">';
						
						$query = mysql_query("SELECT * FROM typ;");
						
						while($row = mysql_fetch_array($query))
						{
							echo '<option value="'.$row['id'].'"';
							
							if($sqlPROD['typ'] == $row['id'])
							{
								echo ' selected';	
							}
							
							echo '>'.$row['name'].'</option><br>';
						}	
						echo '</select></td></tr>
						
						
						<tr><td>Bilddatei:</td><td>
						
						<div id="imageUpload">
							<input type="file" name="datei">
						</div>
						<div id="imageFix">
							<img src="'._UPLOAD_PATH.$sqlImage['short'].'/'._THUMBS_DIR.$sqlPROD['imagePath'].'"/><br />
							<input class="imgEdit" type="button" name="imageEdit" value="Bild ändern">
							<input type="hidden" name="imageFix" value="1">
							<input type="hidden" name="imagePath" value="'.$sqlPROD['imagePath'].'">
						</div>
						
						</td></tr>
						<tr><td>Neuheit 2010</td><td><input type="checkbox" name="new" value="1" ';
							if($sqlPROD['new'] == 1)	{ echo 'checked'; }
						echo '></td></tr>
						<tr><td>Produktnummer:</td><td>PD <input type="text" name="prodNr" value='.$sqlPROD['produktNr'].'>-xx</td></tr>
						<tr><td>Produktname:</td><td><input type="text" name="name" value='.$sqlPROD['name'].'></td></tr>
						<tr><td>Beschreibung:</td><td><textarea name="beschreibung" cols="30" rows="5">'.strip_tags($sqlPROD['beschreibung']).'</textarea></td></tr>
						<tr><td>Bezug:</td><td><select name="bezug[]" size="3" multiple="multiple">';
						
						$query = mysql_query("SELECT * FROM bezug;");
						
						$bezugPart = split(',',$sqlPROD['bezug']);
						
						while($row = mysql_fetch_array($query))
						{
							$select = '';
							for($i = 0; $i < sizeof($bezugPart); $i++ )
							{
								if($bezugPart[$i] == $row['id'])
								{
									$select = ' selected';
								}
							}
							echo '<option value="'.$row['id'].'"'.$select.'>'.$row['name'].'</option><br>';
						}	
					echo '</select></td></tr>
						<tr><td>Zusatz:</td><td><textarea name="spezial" cols="30" rows="5">'.strip_tags($sqlPROD['spezial']).'</textarea></td></tr>
						<tr><td>Maße:</td><td><input type="text" name="size" value='.$sqlPROD['size'].'></td></tr>
						<tr><td>Preis:</td><td><input type="text" name="preis" value='.$sqlPROD['preis'].'> €</td></tr>
						<tr><td><input type="submit" name="enter" value="Ändern"></td></tr>
						</table>
					</form>
					';}
			}
				else {
					echo '	
				<form method="GET" enctype="multipart/form-data">
				<input type="hidden" name="action" value="1">
				<table>
					<tr>
						<td>Kategorie:</td><td><select name="cboxTyp">';
							
							$query = mysql_query("SELECT * FROM typ;");
							
							while($row = mysql_fetch_array($query))
							{
								echo '<option value="'.$row['id'].'"';							
								echo '>'.$row['name'].'</option><br>';
							}	
							echo '</select>
						</td>
					<tr>
					<tr>
					<td>Produktnummer:</td><td><input type="text" name="editID"></td></tr>
					
					<tr><td><input type="submit" name="search" value="Suchen"></td></tr>
				</table>
				</form>
			';	
			}
		}	
	}
	
	function deleteProd()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM produkte WHERE produktNr ='".$_GET['editID']."' AND typ = ".$_GET['cboxTyp'].";");
				$sqlPROD = mysql_fetch_array($query);
				
				if(mysql_num_rows($query) < 1)
				{
					echo "Das Produkt ist nicht vorhanden!";	
				}
				else
				{
					echo '
					<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="prodID" value="'.$sqlPROD['id'].'">
					<input type="hidden" name="check" value="2">
					<table width="460" border="0" cellspacing="1">
					<tr>
						<td width="15">&nbsp;</td>
						<td width="252"style="vertical-align:middle"><p><strong><br />
								'.$sqlPROD['name'].'</strong><strong> </strong><br />
								Bestellnummer: pd-'.$row['produktNr'].'-xx
							'.$sqlPROD['beschreibung'].'';
							
							$array=split(",",$sqlPROD['bezug']);
							foreach ($array as $t)
							{
								$bezugQuery = mysql_query("SELECT * FROM bezug WHERE id='".$t."';");
								while($row3 = mysql_fetch_array($bezugQuery))
								{
									echo '<br /><br /><div>Bezug: '.$row3['name'].'<br />';
									
									$farbQuery = mysql_query("SELECT * FROM color WHERE bezug='".$row3['id']."';");
									echo '<div style="float: left;">Farbe: </div>';
									while($row4 = mysql_fetch_array($farbQuery))
									{
										echo '<div style="float: left; margin-right: 3px; background-color:'.$row4['rgb'].'; height: 20px; width: 20px;"></div>';
									}
									echo '</div>';
								}
							}
							echo '<br /><br />
							'.$sqlPROD['spezial'].'<br />
							<br />
							Maße: '.$sqlPROD['size'].'</p></td>
						<td width="171"style="vertical-align:middle">';
				
				
				$typQuery = mysql_query("SELECT short FROM typ WHERE id='".$sqlPROD['typ']."';");
				while($row2 = mysql_fetch_array($typQuery))
				{
					echo '<img  src="'._UPLOAD_PATH.$row2['short'].'/'.$sqlPROD['imagePath'].'" alt="'.$sqlPROD['name'].'" width="100" height="75" />';
				}
				echo' <br /></td>
						<td width="16">&nbsp;</td>
					</tr>
					<tr><td><input type="submit" name="enter" value="Löschen"></td></tr>
				</table>';
				}
			}
			else {
				echo '	
			<form method="GET" enctype="multipart/form-data">
			<input type="hidden" name="action" value="2">
			<table>
				<tr>
						<td>Kategorie:</td><td><select name="cboxTyp">';
							
							$query = mysql_query("SELECT * FROM typ;");
							
							while($row = mysql_fetch_array($query))
							{
								echo '<option value="'.$row['id'].'"';							
								echo '>'.$row['name'].'</option><br>';
							}	
							echo '</select>
						</td>
					<tr>
				<tr>
				<td>Produktnummer:</td><td><input type="text" name="editID"></td></tr>
				
				<tr><td><input type="submit" name="search" value="Suchen"></td></tr>
			</table>
			</form>
			';	
			}
		}	
	}

function statusProd()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM produkte WHERE produktNr ='".$_GET['editID']."' AND typ = ".$_GET['cboxTyp'].";");
				$sqlPROD = mysql_fetch_array($query);
				echo '
					<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="check" value="3">
					<input type="hidden" name="prodID" value="'.$sqlPROD['id'].'">
					<table>
						<tr>
						<td>Produktnummer:</td><td>'.$sqlPROD['produktNr'].'</td></tr>
						<tr>
						<td>Produktname:</td><td>'.$sqlPROD['name'].'</td></tr>';
						if($sqlPROD['new'] == 1)
						{
							echo '<tr><td><input type="submit" name="enter" value="Deaktivieren"></td></tr>';
						}
						else
						{
							echo '<tr><td><input type="submit" name="enter" value="Aktivieren"></td></tr>';
						}
						
					echo '</table>
					</form>
				';
			}
			else {
				echo '	
			<form method="GET" enctype="multipart/form-data">
			<input type="hidden" name="action" value="3">
			<table>
				<tr>
						<td>Kategorie:</td><td><select name="cboxTyp">';
							
							$query = mysql_query("SELECT * FROM typ;");
							
							while($row = mysql_fetch_array($query))
							{
								echo '<option value="'.$row['id'].'"';							
								echo '>'.$row['name'].'</option><br>';
							}	
							echo '</select>
						</td>
					<tr>
				<tr>
				<tr>
				<td>Produktnummer:</td><td><input type="text" name="editID"></td></tr>
				
				<tr><td><input type="submit" name="search" value="Suchen"></td></tr>
			</table>
			</form>
			';	
			}
		}	
	}

	function check()
	{
		switch($_POST['check'])
		{
			case 0: checkNew(TRUE);
				break;
			case 1: checkNew(FALSE);
				break;
			case 2: checkDelete();
				break;
			case 3: checkStatus();
			 	break;
		}
	}
	
	function checkNew($bool)
	{		
		$bezug = "";
		$array=$_POST['bezug'];
		if ($array){
			foreach ($array as $t)
			{
				$bezug.= $t .",";
			}
			$bezug = substr($bezug, 0, -1);
		}
	if($bool)
	{
		$insert = mysql_query("INSERT INTO `produkte` (crdate, typ, produktNr, name, beschreibung, bezug, spezial, size, preis, imagePath, new) VALUES( now(), '".$_POST['cboxTyp']."', '".$_POST['prodNr']."', '".$_POST['name']."', '".nl2br($_POST['beschreibung'])."', '".$bezug."', '".nl2br($_POST['spezial'])."', '".$_POST['size']."', '".$_POST['preis']."', '".$_FILES['datei']['name']."', '".$_POST['new']."' )");
		
		$query = mysql_fetch_array(mysql_query("SELECT short FROM typ WHERE id='".$_POST['cboxTyp']."';"));

		move_uploaded_file($_FILES['datei']['tmp_name'], _UPLOAD_PATH.$query['short']."/".$_FILES['datei']['name']);
		echo 'DEBUG: Upload ready';
		genThumbs($query, $_FILES['datei']['name']);
	}
	else
	{
		$query = mysql_fetch_array(mysql_query("SELECT short FROM typ WHERE id='".$_POST['cboxTyp']."';"));
		$lookAtTyp = mysql_fetch_array(mysql_query("SELECT typ FROM produkte WHERE id='".$_POST['prodID']."';"));
		$lookTyp = mysql_fetch_array(mysql_query("SELECT short FROM typ WHERE id='".$lookAtTyp['typ']."';"));
		
		$insert = mysql_query("UPDATE `produkte` SET crdate = now(), typ = ".$_POST['cboxTyp'].", produktNr = '".$_POST['prodNr']."', name = '".$_POST['name']."', beschreibung = '".nl2br($_POST['beschreibung'])."', bezug = '".$bezug."', spezial = '".nl2br($_POST['spezial'])."', size = '".$_POST['size']."', preis = '".$_POST['preis']."', imagePath = '".$_FILES['datei']['name']."', new = '".$_POST['new']."' WHERE id = ".$_POST['prodID']);
		
		if(isset($_POST['imageFix']))
		{
			if($lookAtTyp['typ'] != $_POST['cboxTyp'])
			{				
				copy(_UPLOAD_PATH.$lookTyp['short']."/".$_POST['imagePath'], _UPLOAD_PATH.$query['short']."/".$_POST['imagePath']);	
				unlink(_UPLOAD_PATH.$lookTyp['short']."/".$_POST['imagePath']);
				unlink(_UPLOAD_PATH.$lookTyp['short'].'/'._THUMBS_DIR.$_POST['imagePath']);
				genThumbs($query, $_POST['imagePath']);
			}
			$insert = mysql_query("UPDATE `produkte` SET imagePath = '".$_POST['imagePath']."' WHERE id = ".$_POST['prodID']);		
		} else {
			$query = mysql_fetch_array(mysql_query("SELECT short FROM typ WHERE id='".$_POST['cboxTyp']."';"));

			move_uploaded_file($_FILES['datei']['tmp_name'], _UPLOAD_PATH.$query['short']."/".$_FILES['datei']['name']);
			echo 'DEBUG: Upload ready - '.$query['short'].' - '. _UPLOAD_PATH;	
			
			genThumbs($query, $_FILES['datei']['name']);
		}
	}	
	
	
	if($insert)
	{
		echo "Produkt eingetragen <hr></td></table>";
		
		$query = mysql_query("SELECT * FROM produkte WHERE produktNr ='".$_POST['prodNr']."' AND typ = ".$_POST['cboxTyp']." ORDER BY id DESC LIMIT 0,1;");
		
		while($row = mysql_fetch_array($query))
		{
			echo '<table width="460" border="0" cellspacing="1">
				<tr>
					<td width="15">&nbsp;</td>
					<td width="252"style="vertical-align:middle"><p><strong><br />
							'.$row['name'].'</strong><strong> </strong><br />
							Bestellnummer: pd-'.$row['produktNr'].'-xx
						'.$row['beschreibung'].'';
						
						$array=split(",",$row['bezug']);
						foreach ($array as $t)
						{
							$bezugQuery = mysql_query("SELECT * FROM bezug WHERE id='".$t."';");
							while($row3 = mysql_fetch_array($bezugQuery))
							{
								echo '<br /><br /><div>Bezug: '.$row3['name'].'<br />';
								
								$farbQuery = mysql_query("SELECT * FROM color WHERE bezug='".$row3['id']."';");
								echo '<div style="float: left;">Farbe: </div>';
								while($row4 = mysql_fetch_array($farbQuery))
								{
									echo '<div style="float: left; margin-right: 3px; background-color:'.$row4['rgb'].'; height: 20px; width: 20px;"></div>';
								}
								echo '</div>';
							}
						}
						echo '<br /><br />
						'.$row['spezial'].'<br />
						<br />
						Maße: '.$row['size'].'</p></td>
					<td width="171"style="vertical-align:middle">';
			
			
			$typQuery = mysql_query("SELECT short FROM typ WHERE id='".$row['typ']."';");
			while($row2 = mysql_fetch_array($typQuery))
			{
				echo '<img  src="'._UPLOAD_PATH.$row2['short'].'/'.$row['imagePath'].'" alt="'.$row['name'].'" width="100" height="75" />';
			}
			echo' <br /></td>
					<td width="16">&nbsp;</td>
				</tr>
			</table>';
		}
		echo '<hr><form name="logout" method="post" action="'.$_SERVER['PHP_SELF'].'">
			<input type="submit" name="auslog" value="ausloggen">
			<input type="submit" name="new" value="Neues Produkt anlegen">
			</form>';
		}

	}
	
	function checkDelete()
	{
		$delete = mysql_query("DELETE FROM produkte WHERE id=".$_POST['prodID']);
		
		if($delete)
		{
			echo 'Produkt erfolgreich gelöscht';	
		}
	}

	function checkStatus()
	{
		$curStatus = mysql_fetch_array(mysql_query("SELECT new FROM produkte WHERE id=".$_POST['prodID']));
		
		if($curStatus['new'] == 1)
		{
			$status = mysql_query("UPDATE `produkte` SET new = 0 WHERE id=".$_POST['prodID']);
		}	
		else
		{
			$status = mysql_query("UPDATE `produkte` SET new = 1 WHERE id=".$_POST['prodID']);
			
		}
		
		if($status)
		{
			echo 'Status geändert';	
		}
	}
	
	function genThumbs($sqlTyp, $imagePath)
	{			
		if(!is_dir(_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR))
		{
			mkdir(_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR,0777);
			copy(_UPLOAD_PATH.$sqlTyp['short']."/".$imagePath, _UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$imagePath);
		}
		else
		{
			copy(_UPLOAD_PATH.$sqlTyp['short']."/".$imagePath, _UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$imagePath);
		}
	
		$imagefile = _UPLOAD_PATH.$sqlTyp['short'].'/'.$imagePath;
		$imagesize = getimagesize($imagefile);
		$imagewidth = $imagesize[0];
		$imageheight = $imagesize[1];
		$imagetype = $imagesize[2];
		switch ($imagetype)
		{
		    // Bedeutung von $imagetype:
		    // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM
		    case 1: // GIF
			   $image = imagecreatefromgif($imagefile);
			   break;
		    case 2: // JPEG
			   $image = imagecreatefromjpeg($imagefile);
			   break;
		    case 3: // PNG
			   $image = imagecreatefrompng($imagefile);
			   break;
		    default:
			   //die('Unsupported imageformat');
			   $image = imagecreatefromjpeg($imagefile);
			   break;
		}

		// Maximalausmaße
		$maxthumbwidth = 171;
		$maxthumbheight = 128;
		// Ausmaße kopieren, wir gehen zuerst davon aus, dass das Bild schon Thumbnailgröße hat
		$thumbwidth = $imagewidth;
		$thumbheight = $imageheight;
		// Breite skalieren falls nötig
		if ($thumbwidth > $maxthumbwidth)
		{
		    $factor = $maxthumbwidth / $thumbwidth;
		    $thumbwidth *= $factor;
		    $thumbheight *= $factor;
		}
		// Höhe skalieren, falls nötig
		if ($thumbheight > $maxthumbheight)
		{
		    $factor = $maxthumbheight / $thumbheight;
		    $thumbwidth *= $factor;
		    $thumbheight *= $factor;
		}
		// Thumbnail erstellen
		$thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
	
		imagecopyresampled(
		    $thumb,
		    $image,
		    0, 0, 0, 0, // Startposition des Ausschnittes
		    $thumbwidth, $thumbheight,
		    $imagewidth, $imageheight
		);
	
		$thumbfile = _UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$imagePath;
		imagepng($thumb, $thumbfile);
	
		imagedestroy($thumb);
	}	
	
	
?>