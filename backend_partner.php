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
						case 3: newPart();
							break;
						case 4: editPart();
							break;
						case 5: statusPart();
							break;
						case 0: mainNewPart();
							break;
						case 1: mainEditPart();
							break;
						case 2: mainStatusPart();
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
	
	function newPart()
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
			<td>Partnerkategorie:</td><td><select name="cboxTyp">';
			
			$query = mysql_query("SELECT * FROM partnerCategory;");
			
			while($row = mysql_fetch_array($query))
			{
				echo '<option value="'.$row['id'].'">'.$row['name'].'</option><br>';
			}	
			echo '</select></td></tr>
			<tr><td>Partnername: </td><td><input type="text" name="name"></td></tr>
			<tr><td>Namesbeschreibung:</td><td><input type="text" name="spezial"></td></tr>
			<tr><td>Webseite:</td><td><input type="text" name="url"></td></tr>
			<tr><td>Firmenlogo:</td><td><input type="file" name="image"></td></tr>
			<tr><td><input type="submit" name="enter" value="Speichern"></td></tr>
			</table>
		</form>

		';
		}	
	}

	function editPart()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM partner WHERE id ='".$_GET['cboxTyp']."';");
				$sqlPart = mysql_fetch_array($query);
			
				echo '
		
				<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="check" value="1">
				<input type="hidden" name="partID" value="'.$sqlPart['id'].'">
				<table>
					<tr>
						<td>Partnerkategorie:</td><td><select name="cboxTyp" style="width: 300px">';
						
						$query = mysql_query("SELECT * FROM partnercategory;");
						
						while($row = mysql_fetch_array($query))
						{
							echo '<option value="'.$row['id'].'"';
							
							if($sqlPart['typ'] == $row['id'])
							{
								echo ' selected';	
							}
							
							echo '>'.$row['name'].'</option><br>';
						}	
						echo '</select></td></tr>
					<tr><td>Partnername: </td><td><input type="text" name="name" value="'.$sqlPart['name'].'"></td></tr>
					<tr><td>Namensbeschreibung:</td><td><input type="text" name="short" value="'.$sqlPart['beschreibung'].'"></td></tr>
					<tr><td>Webseite:</td><td><input type="text" name="catName" value="'.$sqlPart['url'].'"></td></tr><tr><td>Bilddatei:</td><td>
						
					<div id="imageUpload">
						<input type="file" name="datei">
					</div>
					<div id="imageFix">
						<img src="'._PARTNER_IMAGE_PATH.$sqlPart['imagePath'].'"/><br />
						<input class="imgEdit" type="button" name="imageEdit" value="Bild ändern">
						<input type="hidden" name="imageFix" value="1">
						<input type="hidden" name="imagePath" value="'._PARTNER_IMAGE_PATH.$sqlPart['imagePath'].'">
					</div>
					<tr><td><input type="submit" name="enter" value="Ändern"></td></tr>
				</table>
				</form>
				';
			}
				else {
					echo '	
				<form method="GET" enctype="multipart/form-data">
				<input type="hidden" name="action" value="4">
				<tr>
					<td>Kategorie:</td><td><select name="cboxTyp">';
					
					$query = mysql_query("SELECT * FROM partner;");
					
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

function statusPart()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM partner WHERE id ='".$_GET['cboxTyp']."';");
				$sqlPart = mysql_fetch_array($query);
				echo '
					<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="check" value="2">
					<input type="hidden" name="partID" value="'.$sqlPart['id'].'">
					<table>
						<tr>
						<td>Kategorie:</td><td>'.$sqlPart['name'].'</td></tr>
						<tr>';
						if($sqlPart['status'] == 1)
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
				<input type="hidden" name="action" value="5">
				<tr>
					<td>Kategorie:</td><td><select name="cboxTyp">';
					
					$query = mysql_query("SELECT * FROM partner;");
					
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
	
	function mainNewPart()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			echo '
		
		<form method="post" enctype="multipart/form-data">
		<input type="hidden" name="check" value="3">
		<table>
			<tr><td>Kategoriename: </td><td><input type="text" name="name"></td></tr>
			<tr><td>Kategoriebild:</td><td><input type="file" name="image"></td></tr>
			<tr><td><input type="submit" name="enter" value="Speichern"></td></tr>
			</table>
		</form>

		';
		}	
	}

	function mainEditPart()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM partnercategory WHERE id ='".$_GET['cboxTyp']."';");
				$sqlPartCat = mysql_fetch_array($query);
			
				echo '
		
				<form method="post" enctype="multipart/form-data">
				<input type="hidden" name="check" value="4">
				<input type="hidden" name="partID" value="'.$sqlPartCat['id'].'">
				<table>
					<tr><td>Kategoriename: </td><td><input type="text" name="name" value="'.$sqlPartCat['name'].'"></td></tr>
					<tr><td>Bilddatei:</td><td>
						
					<div id="imageUpload">
						<input type="file" name="datei">
					</div>
					<div id="imageFix">
						<img src="'._PARTNER_CATEGORY_IMAGE_PATH.$sqlPartCat['imagePath'].'"/><br />
						<input class="imgEdit" type="button" name="imageEdit" value="Bild ändern">
						<input type="hidden" name="imageFix" value="1">
						<input type="hidden" name="imagePath" value="'._PARTNER_CATEGORY_IMAGE_PATH.$sqlPartCat['imagePath'].'">
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
					
					$query = mysql_query("SELECT * FROM partnercategory;");
					
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

function mainStatusPart()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			if(isset($_GET['search']))
			{
				$query = mysql_query("SELECT * FROM partnercategory WHERE id ='".$_GET['cboxTyp']."';");
				$sqlPart = mysql_fetch_array($query);
				echo '
					<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="check" value="5">
					<input type="hidden" name="partID" value="'.$sqlPart['id'].'">
					<table>
						<tr>
						<td>Kategorie:</td><td>'.$sqlPart['name'].'</td></tr>
						<tr>';
						if($sqlPart['status'] == 1)
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
					
					$query = mysql_query("SELECT * FROM partnercategory;");
					
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
			case 0: checkNewPart(TRUE);
				break;
			case 1: checkNewPart(FALSE);
				break;
			case 2: checkStatusPart();
			 	break;
			case 3: checkNewPartCat(TRUE);
				break;
			case 4: checkNewPartCat(FALSE);
				break;
			case 5: checkStatusPartCat();
			 	break;
		}
	}
	
	function checkNewPart($bool)
	{		
				
		if($bool)
		{			
			move_uploaded_file($_FILES['image']['tmp_name'], _PARTNER_IMAGE_PATH.$_FILES['image']['name']);

			$insert = mysql_query("INSERT INTO `partner` (category, name, beschreibung, url, imagePath, status) VALUES('".$_POST['cboxTyp']."', '".$_POST['name']."', '".$_POST['spezial']."', '".$_POST['url']."', '".$_FILES['image']['name']."', '1')");
			
			$query = mysql_fetch_array(mysql_query("SELECT * FROM partner ORDER BY id DESC LIMIT 1;"));
			
			$image = substr($_FILES['image']['name'],0,-4);
			
			$bild=@imagecreatefromjpeg(_PARTNER_IMAGE_PATH.$image.".jpg");
			@imagepng($bild,_PARTNER_IMAGE_PATH.$image.".png"); 
			
			imageResize(100,125,_PARTNER_IMAGE_PATH.$_FILES['image']['name'],_PARTNER_IMAGE_PATH.$_FILES['image']['name']);
		}
		else
		{			
			$insert = mysql_query("UPDATE `partner` SET category = '".$_POST['cboxTyp']."' , name = '".$_POST['name']."' WHERE id = ".$_POST['partID']);
			
			if(!isset($_POST['imageFix']))
			{
				move_uploaded_file($_FILES['image']['tmp_name'], _PARTNER_IMAGE_PATH.$_FILES['image']['name']);			
				$query = mysql_fetch_array(mysql_query("SELECT * FROM partner WHERE id=".$_POST['partID'].""));
			
				$image = substr($_FILES['image']['name'],0,-4);
						
				$bild=@imagecreatefromjpeg(_PARTNER_IMAGE_PATH.$image.".jpg");
				@imagepng($bild,_PARTNER_IMAGE_PATH.$image.".png");  
				
				imageResize(100,125, _PARTNER_IMAGE_PATH.$_FILES['image']['name'], _PARTNER_IMAGE_PATH.$_FILES['image']['name']);
				
				$insert = mysql_query("UPDATE `partner` SET imagePath = '".$_FILES['image']['name']."' WHERE id = ".$_POST['partID']);
			}
			
		}	
		
		
		if($insert)
		{
			echo "Kategorie eingetragen <hr></td></table>";
						
		}

	}

	function checkStatusPart()
	{
		$curStatus = mysql_fetch_array(mysql_query("SELECT status FROM partner WHERE id=".$_POST['partID']));
		
		if($curStatus['status'] == 1)
		{
			$status = mysql_query("UPDATE `partner` SET status = 0 WHERE id=".$_POST['partID']);
		}	
		else
		{
			$status = mysql_query("UPDATE `partner` SET status = 1 WHERE id=".$_POST['partID']);
			
		}
		
		if($status)
		{
			echo 'Status geändert';	
		}
	}
	
	function checkNewPartCat($bool)
	{		
				
		if($bool)
		{			
			move_uploaded_file($_FILES['image']['tmp_name'], _PARTNER_CATEGORY_IMAGE_PATH.$_FILES['image']['name']);

			$insert = mysql_query("INSERT INTO `partnercategory` (name ,imagePath, status) VALUES('".$_POST['name']."', '".$_FILES['image']['name']."', '1')");
			
			$query = mysql_fetch_array(mysql_query("SELECT * FROM partnercategory ORDER BY id DESC LIMIT 1;"));
			
			$image = substr($query['imagePath'],0,-4);
						
			$bild=@imagecreatefromjpeg(_PARTNER_CATEGORY_IMAGE_PATH.$image.".jpg");
			@imagepng($bild,_PARTNER_CATEGORY_IMAGE_PATH.$image.".png"); 
		
			imageResize(100,125,_PARTNER_CATEGORY_IMAGE_PATH.$query['imagePath'],_PARTNER_CATEGORY_IMAGE_PATH.$query['imagePath']);
		}
		else
		{
			
			$insert = mysql_query("UPDATE `partnercategory` SET name = '".$_POST['name']."' WHERE id = ".$_POST['partID']);
			
			if(!isset($_POST['imageFix']))
			{
				move_uploaded_file($_FILES['image']['tmp_name'], _PARTNER_CATEGORY_IMAGE_PATH.$_FILES['image']['name']);
				
				$query = mysql_fetch_array(mysql_query("SELECT * FROM partnercategory WHERE id=".$_POST['partID'].""));
			
				$image = substr($_FILES['image']['name'],0,-4);
						
				$bild=@imagecreatefromjpeg(_PARTNER_CATEGORY_IMAGE_PATH.$image.".jpg");
				@imagepng($bild,_PARTNER_CATEGORY_IMAGE_PATH.$image.".png"); 
	
				imageResize(100,125, _PARTNER_CATEGORY_IMAGE_PATH.$_FILES['image']['name'], _PARTNER_CATEGORY_IMAGE_PATH.$_FILES['image']['name']);
				$insert = mysql_query("UPDATE `partnercategory` SET imagePath = '".$image.".png' WHERE id = ".$_POST['partID']);	
			
			}
			
		}	
		
		
		if($insert)
		{
			echo "Kategorie eingetragen <hr></td></table>";
						
		}

	}

	function checkStatusPartCat()
	{
		$curStatus = mysql_fetch_array(mysql_query("SELECT status FROM partnercategory WHERE id=".$_POST['partID']));
		
		if($curStatus['status'] == 1)
		{
			$status = mysql_query("UPDATE `partnercategory` SET status = 0 WHERE id=".$_POST['partID']);
		}	
		else
		{
			$status = mysql_query("UPDATE `partnercategory` SET status = 1 WHERE id=".$_POST['partID']);
			
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