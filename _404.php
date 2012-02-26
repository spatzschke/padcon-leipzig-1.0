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
		<div id="breadcrump"><a href="index.php">Startseite</a> - Seite wurde nicht gefunden</div>      
		<span class="center">   
			<p><img src="<?=_IMAGE_PATH?>logo/padcon-Logo.png" alt="padcon Leipzig" /></p>
			<p>padcon Leipzig-Ralf Patzschke</p>
			<p>Ihr Fachhändler</p>
			<p>für  druckentlastende Lagerungshilfsmittel</p>
			<p> u.v.m.</p>
		
		<hr />
		<h2>Seite wurde nicht gefunden</h2>
		</span>
		</div>
		 
			<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>
