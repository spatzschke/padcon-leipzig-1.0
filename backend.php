<? 
session_start();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include("_head.php"); ?>
	<link href="css/padcon.css" rel="stylesheet" type="text/css" />
	<link href="css/backend.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/padcon.js"></script>
	<script type="text/javascript">	
				
		jQuery(document).ready(function(){					  
			
			$(".content h3").eq(2).addClass("active");
			$(".content div").eq(2).show();
		
			$(".content h3").click(function(){
				$(this).next("div").slideToggle("slow")
				.siblings("div:visible").slideUp("slow");
				$(this).toggleClass("active");
				$(this).siblings("h3").removeClass("active");
			});
			

		});	
	</script>
</head>
<body>
	<div id="container">
		<div id="header"><? include("_header.php"); ?></div>
		
		<div id="navigationSidebar"><? include("_navigation.php"); ?></div>
		<div id="infoSidebar"><? include("_info.php"); ?></div>

		<div id="mainContent"> 
		<div id="breadcrump"><a href="index.php">Startseite</a> - Adminpanel</div>      
		
<?		if (!isset($_SESSION['user'], $_SESSION['pw']) OR $_POST['auslog'] != null)
		{		
			echo "<meta http-equiv=\"refresh\" content=\"0; URL=admin.php\">";
		}
		else
		{
		echo'
			<div id="einspaltig">
			
			Produkte
			<ul>
				<li><a href="backend_produktInput.php?action=0"> Produkt anlegen </a></li>
				<li><a href="backend_produktInput.php?action=1"> Produkt bearbeiten </a></li>
				<li><a href="backend_produktInput.php?action=2"> Produkt löschen </a></li>
				<li><a href="backend_produktInput.php?action=3"> Produkt Status ändern </a></li>
			</ul>
			<br />
			Kategorie
			<ul>
				<li><a href="backend_category.php?action=0"> Kategorie anlegen </a></li>
				<li><a href="backend_category.php?action=1"> Kategorie bearbeiten </a></li>
				<li><a href="backend_category.php?action=2"> Kategorie Status ändern </a></li>
			</ul>
			<br />
			Kataloge
			<ul>
				<li><a href="backend_catalog.php?action=0"> Produktkataloge aktualisieren </a></li>
				<li><a href="backend_catalog.php?action=1"> Neuen "Neuigkeiten"-Kataloge hinzufügen </a></li>
			</ul>
			<br />
			Vertriebspartner
			<ul>
				<li><a href="backend_partner.php?action=0"> Hauptkategorie anlegen </a></li>
				<li><a href="backend_partner.php?action=1"> Hauptkategorie bearbeiten </a></li>
				<li><a href="backend_partner.php?action=2"> Hauptkategorie Status ändern </a></li>
				<br>				
				<li><a href="backend_partner.php?action=3"> Vertriebspartner anlegen </a></li>
				<li><a href="backend_partner.php?action=4"> Vertriebspartner bearbeiten </a></li>
				<li><a href="backend_partner.php?action=5"> Vertriebspartner Status ändern </a></li>
			</ul>
			<br />
			SEO - Metacontent
			<ul>
				<li><s><a href="backend_partner.php?action=0"> Meta-Tags bearbeiten </a></s></li>
			</ul>
			
			Admin
			<ul>
				<li><a href="backend_administration.php?action=0"> Thumbnails generieren </a></li>
				<li><a href="backend_administration.php?action=1"> Rename Imagefiles Produktname -> Produktnummer </a></li>
				<br>
				<li><a href="backend_administration.php?action=2"> Imageimport zu MediaFileSystem </a></li>
				<br>
				<li><a href="http://83.133.96.186/phpMyAdmin/"> PHP My Admin </a></li>
				<li><a href="http://web302.server90.greatnet.de/mysqlDumper/index.php"> Datenbank Backup erstellen </a></li>
				<li><a href="backend_administration.php?action=10"> Produktdatenbank löschen </a></li>
			</ul>
			<br />			
				<!--<div class="content">
					<h3>Neues Produkt eintragen</h3>
					<div title="content">s</div>
					<h3>This is Question Two</h3>
					<div title="content"><? include("backend/produktInputCompact.php"); ?></div>
					<h3>Another Questio here</h3>
					<div title="content"</div>
					<h3>Sample heading</h3>
					<div title="content"></div>
					<h3>Sample Question Heading</h3>
					<div title="content"></div>
				</div>-->
			</div>';
		}
?>
		
		</div>
		 
			<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>
