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
						case 0: newCatalog();
							break;
						case 1: newCatalogNews();
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

	function newCatalog()
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
				<input type="hidden" name="check" value="0">
				<input type="hidden" name="catID" value="'.$sqlCat['id'].'">
				<table>
					<tr><td>Katalogdatei (PDF): </td><td><input type="file" name="catFile"></td></tr>
					<tr><td>Katalogdatum:</td><td><input type="text" name="catDate"></td></tr>
					<tr><td><input type="submit" name="enter" value="Aktualisieren"></td></tr>
				</table>
				</form>
				';
			}
				else {
					echo '	
				<form method="GET" enctype="multipart/form-data">
				<input type="hidden" name="action" value="0">
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
	
	function newCatalogNews()
	{
		if(isset($_POST['enter']))
		{
			check();
		}
		else
		{
			echo '
	
			<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="check" value="1">
			<table>
				<tr><td>Katalogdatei (PDF): </td><td><input type="file" name="catFile"></td></tr>
				<tr><td>Katalogjahr:</td><td><input type="text" name="catDate"></td></tr>
				<tr><td><input type="submit" name="enter" value="Aktualisieren"></td></tr>
			</table>
			</form>
			';
		}	
	}


	function check()
	{
		switch($_POST['check'])
		{
			case 0: checkNewCatalog(TRUE);
				break;
			case 1: checkNewCatalogNews();
				break;
		}
	}
	
	function checkNewCatalog($bool)
	{		
				
		if($bool)
		{			
			if(move_uploaded_file($_FILES['catFile']['tmp_name'], _CATALOG_PATH.$_FILES['catFile']['name']))
			{			
				$insert = mysql_query("UPDATE `typ` SET catalogPath = '".$_FILES['catFile']['name']."', catalogDate = '".$_POST['catDate']."' WHERE id=".$_POST['catID']);
			}
			else
			{
				echo ' Upload fehlgeschlagen !';
			}
		}
		else
		{
						
		}	
				
		if($insert)
		{
			echo "Katalog aktualisiert<hr></td></table>";		
		}
	}
	
	function checkNewCatalogNews()
	{		
				
		if(move_uploaded_file($_FILES['catFile']['tmp_name'], _CATALOG_PATH.$_FILES['catFile']['name']))
		{		
			$insert = mysql_query("INSERT INTO `news` (year, name, catalog, catalogPath) VALUES( '".$_POST['catDate']."', 'Neuigkeiten ".$_POST['catDate']."', 'Neuigkeiten ".$_POST['catDate']."', '".$_FILES['catFile']['name']."')");
		}
		else
		{
			echo ' Upload fehlgeschlagen !';
		}		
		
		if($insert)
		{
			echo "Katalog hinzugefügt<hr></td></table>";		
		}

	}
	
?>