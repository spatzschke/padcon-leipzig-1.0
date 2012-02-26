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
						case 0: newCat();
							break;
						case 1: editCat();
							break;
						case 2: statusCat();
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
	
	function newCat()
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
			<tr><td>Kategoriename: </td><td><input type="text" name="name"></td></tr>
			<tr><td>Kategorieabkürzung <br> (Ordnername):</td><td><input type="text" name="short"></td></tr>
		</table>
		<br>
		<table>
			<tr><td>Katalogname:</td><td><input type="text" name="catName"></td></tr>
			<tr><td>Katalogbild:</td><td><input type="file" name="catImage"></td></tr>
			<tr><td>Katalogdatei (PDF):</td><td><input type="file" name="catFile"></td></tr>
			<tr><td>Katalogdatum:</td><td><input type="text" name="catDate"></td></tr>
			<tr><td><input type="submit" name="enter" value="Speichern"></td></tr>
			</table>
		</form>

		';
		}	
	}

	function editCat()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM typ WHERE id ='".$_GET['cboxTyp']."';");
				$sqlCat = mysql_fetch_array($query);
			
				echo '
		
				<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="check" value="1">
				<input type="hidden" name="catID" value="'.$sqlCat['id'].'">
				<table>
					<tr><td>Kategoriename: </td><td><input type="text" name="name" value="'.$sqlCat['name'].'"></td></tr>
					<tr><td>Kategorieabkürzung <br> (Ordnername):</td><td><input type="text" name="short" value="'.$sqlCat['short'].'"></td></tr>
				</table>
				<br>
				<table>
					<tr><td>Katalogname:</td><td><input type="text" name="catName" value="'.$sqlCat['catalog'].'"></td></tr><tr><td>Bilddatei:</td><td>
						
					<div id="imageUpload">
						<input type="file" name="datei">
					</div>
					<div id="imageFix">
						<img src="'._CATALOG_IMAGE_PATH.$sqlCat['short'].'.png"/><br />
						<input class="imgEdit" type="button" name="imageEdit" value="Bild ändern">
						<input type="hidden" name="imageFix" value="1">
						<input type="hidden" name="imagePath" value="'._CATALOG_IMAGE_PATH.$sqlCat['short'].'.png">
					</div>
					<tr><td><input type="submit" name="enter" value="Ändern"></td></tr>
				</table>
				</form>
				';
			}
				else {
					echo '	
				<form method="GET" enctype="multipart/form-data">
				<input type="hidden" name="action" value="1">
				<tr>
					<td>Kategorie:</td><td><select name="cboxTyp">';
					
					$query = mysql_query("SELECT * FROM typ;");
					
					while($row = mysql_fetch_array($query))
					{
						echo '<option value="'.$row['id'].'">'.$row['name'].'</option><br>';
					}	
					echo '</select></td></tr>
					<tr><td><input type="submit" name="search" value="Ändern"></td></tr>
				</table>
				</form>
			';	
			}
		}	
	}

function statusCat()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM typ WHERE id ='".$_GET['cboxTyp']."';");
				$sqlCat = mysql_fetch_array($query);
				echo '
					<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="check" value="2">
					<input type="hidden" name="catID" value="'.$sqlCat['id'].'">
					<table>
						<tr>
						<td>Kategorie:</td><td>'.$sqlCat['name'].'</td></tr>
						<tr>';
						if($sqlCat['status'] == 1)
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
				<input type="hidden" name="action" value="2">
				<tr>
					<td>Kategorie:</td><td><select name="cboxTyp">';
					
					$query = mysql_query("SELECT * FROM typ;");
					
					while($row = mysql_fetch_array($query))
					{
						echo '<option value="'.$row['id'].'">'.$row['name'].'</option><br>';
					}	
					echo '</select></td></tr>
					<tr><td><input type="submit" name="search" value="Ändern"></td></tr>
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
			case 0: checkNewCat(TRUE);
				break;
			case 1: checkNewCat(FALSE);
				break;
			case 2: checkStatusCat();
			 	break;
		}
	}
	
	function checkNewCat($bool)
	{		
				
		if($bool)
		{			
			move_uploaded_file($_FILES['catImage']['tmp_name'], CATALOG_IMAGE_PATH.$_FILES['catImage']['name']);
			rename(_CATALOG_IMAGE_PATH.$_FILES['catImage']['name'],_CATALOG_IMAGE_PATH.$_POST['short'].'.png');
			
			move_uploaded_file($_FILES['catFile']['tmp_name'], _CATALOG_PATH.$_FILES['catFile']['name']);
			
			$insert = mysql_query("INSERT INTO `typ` (name, short, catalog, catalogPath, catalogDate, status) VALUES('".$_POST['name']."', '".$_POST['short']."', '".$_POST['catName']."', '".$_FILES['catFile']['name']."', '".$_POST['catDate']."', '1')");
			
			$query = mysql_fetch_array(mysql_query("SELECT * FROM typ ORDER BY id DESC LIMIT 1;"));
			
			$bild=@imagecreatefromjpeg(_CATALOG_IMAGE_PATH.$query['short'].".jpg");
			@imagepng($bild,_CATALOG_IMAGE_PATH.$query['short'].".png"); 
			
			imageResize(144,112,_CATALOG_IMAGE_PATH.$query['short'].".png",_CATALOG_IMAGE_PATH.$query['short'].".png");
		}
		else
		{
			$query = mysql_fetch_array(mysql_query("SELECT short FROM typ WHERE id='".$_POST['cboxTyp']."';"));
			$lookAtTyp = mysql_fetch_array(mysql_query("SELECT typ FROM produkte WHERE id='".$_POST['prodID']."';"));
			$lookTyp = mysql_fetch_array(mysql_query("SELECT short FROM typ WHERE id='".$lookAtTyp['typ']."';"));
			
			$insert = mysql_query("UPDATE `typ` SET name = '".$_POST['name']."', short = '".$_POST['short']."', catalog = '".$_POST['catName']."' WHERE id = ".$_POST['catID']);
			
			if(!isset($_POST['imageFix']))
			{
				move_uploaded_file($_FILES['catImage']['tmp_name'], _CATALOG_IMAGE_PATH.$_FILES['catImage']['name']);
				rename(_CATALOG_IMAGE_PATH.$_FILES['catImage']['name'],_CATALOG_IMAGE_PATH.$_POST['short'].'.png');
				
				$query = mysql_fetch_array(mysql_query("SELECT * FROM typ WHERE id=".$_POST['catID'].""));
			
				$bild=@imagecreatefromjpeg(_CATALOG_IMAGE_PATH.$query['short'].".jpg");
				@imagepng($bild,_CATALOG_IMAGE_PATH.$query['short'].".png"); 
				
				imageResize(144,112,_CATALOG_IMAGE_PATH.$query['short'].".png",_CATALOG_IMAGE_PATH.$query['short'].".png");
			}
			
		}	
		
		
		if($insert)
		{
			echo "Kategorie eingetragen <hr></td></table>";
						
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

	function checkStatusCat()
	{
		$curStatus = mysql_fetch_array(mysql_query("SELECT status FROM typ WHERE id=".$_POST['catID']));
		
		if($curStatus['status'] == 1)
		{
			$status = mysql_query("UPDATE `typ` SET status = 0 WHERE id=".$_POST['catID']);
		}	
		else
		{
			$status = mysql_query("UPDATE `typ` SET status = 1 WHERE id=".$_POST['catID']);
			
		}
		
		if($status)
		{
			echo 'Status geändert';	
		}
	}
		
	function imageResize($h, $w, $src, $target)
	{
		$imagefile = $src;
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
			   die('Unsupported imageformat');
		}

		// Maximalausmaße
		$maxthumbwidth = $w;
		$maxthumbheight = $h;
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
	
		$thumbfile = $target;
		imagepng($thumb, $thumbfile);
	
		imagedestroy($thumb);	
	}
	
	
?>