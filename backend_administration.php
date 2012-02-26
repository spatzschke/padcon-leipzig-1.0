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
		$(document).ready(function();
					

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
				{	
					if(isset($_POST['check']))
					{
						check();
					}
					else
					{
						switch($_GET['action'])
						{
							case 0: genThumbs();
								break;
							case 1: renameImageFiles();
								break;
							case 2: importImageFiles();
								break;
							case 10: truncate();
								break;
													
							default: echo 'Funktion ist noch nicht vorhanden';		
						}
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
	
	function genThumbs()
	{
		if(isset($_GET['search']))
		{
			$sqlImage = mysql_query("SELECT * FROM produkte WHERE typ = ".$_GET['cboxTyp']);	
			$c = 0;
			
			while($row = mysql_fetch_array($sqlImage))
			{
				$new = false;
				if($row['imagePath'] != '')
				{	
							
					$sqlTyp = mysql_fetch_array(mysql_query("SELECT * FROM typ WHERE id=".$row['typ'].""));
					
					if(!is_dir(_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR))
					{
						mkdir(_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR,0777);
					}
					
					if (!file_exists(_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$row['imagePath'])) 
					{
						copy(_UPLOAD_PATH.$sqlTyp['short']."/".$row['imagePath'],_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$row['imagePath']);					$new = true;
					}
							
					$imagefile = _UPLOAD_PATH.$sqlTyp['short'].'/'.$row['imagePath'];
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
						  // die('Unsupported imageformat');
					}
				}
				else {
					echo $c . ': '.$row['id'].' | Kein Image vorhanden<br />';	
				}
				
				if ($new) 
				{
					
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
		
							$thumbfile = _UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$row['imagePath'];
							imagepng($thumb, $thumbfile);
		
					imagedestroy($thumb);
		
		
					echo $c . ': '.$row['id'].' | '.$row['imagePath'].'<br />';
					$c++;
				}
			}	
		}
		else
		{
			echo '	
				<form method="GET" enctype="multipart/form-data">
				<input type="hidden" name="action" value="0">
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
					<td>
						<input type="submit" name="search" value="Initialisieren">
					</td>
					</tr>
				</table>
				</form>
			';
		}
		
		
	}
	
	function truncate()
	{
		//login Funktionen
		//post variablen einfach speichern
		$user = $_POST['user'];
		$pw = $_POST['pw'];
		
		//nun kommen die if abfragen die das ganze relativ sicher machen
		if (isset($user, $pw))
		{	
			$user_admin_name = "admin"; 
			$user_admin_pass = "m4rtcvqd32im214sG53";
			if ($user == "" OR $pw == "")
			{
				echo "<b>Bitte fülle beide Felder aus!</b>";
			}
			elseif ($user == $user_admin_name AND $pw == $user_admin_pass)
			{				
				$sqlImage = mysql_query("TRUNCATE TABLE produkte");
				echo 'Datenbank wurde geleert';
			}
		}
		   
		//dann kommt das Formular
		if(!isset($user, $pw))
		{
			echo '<form name="login" method="post" action="'.$_SERVER['PHP_SELF'].'?action=10">
					<fieldset>
						<span style="width: 100px; padding-top:6px; float: left;">User Name:</span><input style="margin-right: 90px; float: left;" type="text" name="user"><br>
						<span style="width: 100px; padding-top:6px; float: left;">Passwort:</span><input style="margin-right: 90px; float: left;" type="password" name="pw"><br>
						<input type="submit" name="Submit" value="einloggen">
					</fieldset>
				</form>';
		} 
		
	}
	
	function renameImageFiles()
	{
		$sqlImage = mysql_query("SELECT * FROM produkte");
		$c = 0;
		$altImage = "";
		$altID;
		
		while($row = mysql_fetch_array($sqlImage))
		{
			if($row['imagePath'] != '')
			{	
						
				$sqlTyp = mysql_fetch_array(mysql_query("SELECT * FROM typ WHERE id=".$row['typ'].""));
				
				if(!is_dir(_BACKUP_IMAGE_PATH))
				{
					mkdir(_BACKUP_IMAGE_PATH,0777);
					if(!is_dir(_BACKUP_IMAGE_PATH.$sqlTyp['short']))
					{
						mkdir(_BACKUP_IMAGE_PATH.$sqlTyp['short'],0777);
						mkdir(_BACKUP_IMAGE_PATH.$sqlTyp['short'].'/'._THUMBS_DIR,0777);
					}
				}
			
				if (!is_numeric(substr($row['imagePath'],0,-3)))
				{
			
					echo $c.': '.$row['imagePath'].' -> ';			
						
					//rename
					if($altImage != $row['imagePath'])
					{
						//backup
						copy(_UPLOAD_PATH.$sqlTyp['short']."/".$row['imagePath'],_BACKUP_IMAGE_PATH.$sqlTyp['short']."/".$row['imagePath']);					
						copy(_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$row['imagePath'],_BACKUP_IMAGE_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$row['imagePath']);			
						rename(_UPLOAD_PATH.$sqlTyp['short']."/".$row['imagePath'],_UPLOAD_PATH.$sqlTyp['short']."/".$row['produktNr'].".jpg");					
						rename(_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$row['imagePath'],_UPLOAD_PATH.$sqlTyp['short'].'/'._THUMBS_DIR.$row['produktNr'].".jpg");			
						//update Database
						mysql_query('UPDATE produkte SET imagePath="'.$row['produktNr'].'.jpg" WHERE id='.$row['id'].';');
						
						$altImage = $row['imagePath'];
						$altID = $row['produktNr'];
					}
					else
					{
						//update Database
						mysql_query('UPDATE produkte SET imagePath="'.$altID.'.jpg" WHERE id='.$row['id'].';');	
					}
									
					$sqlNew = mysql_fetch_array(mysql_query("SELECT * FROM produkte WHERE id='".$row['id']."'"));
					echo $sqlNew['imagePath'].'<br>';
		
					$c++;
				}
			}		
		}
	}
	
	function importImageFiles()
	{
			echo'
			<form id="uploadForm" enctype="multipart/form-data" action="http://web302.server90.greatnet.de/mediaFileSystem/upload.php" method="POST">
			Please choose a file: <input name="uploaded" type="file" /><br />
			<input type="submit" value="Upload" />
			
			</form>';
	}
	
	function check()
	{
		switch($_POST['check'])
		{
			case 0: 	ftp_put($connection_id, '../html/mediaFileSystem/', $_FILES['uploaded']['tmp_name'], FTP_ASCII);

					break;
			default: echo 'default';
					break;
		}
				  
	}
	
	
?>