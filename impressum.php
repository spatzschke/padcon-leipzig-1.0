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
		<div id="breadcrump"><a href="index.php">Startseite</a> - Impressum</div>    
		
		<div id="einspaltig">
			<img class="imageRightAlign" src="<?=_IMAGE_PATH?>impressum.png" alt="Impressum" />
			<strong>Impressum: </strong><br />
			<br />
			Ralf Patzschke<br />
			Holunderweg 4 <br />
			04416 Markkleeberg<br />
			<br />
			<strong>Telefon:</strong> +49 341 358 18 02 <br />
			<strong>Fax:</strong> +49 341 358 18 95 <br />
			<strong>E-Mail:</strong> <a href="mailto:info@padcon-leipzig.de">info@padcon-leipzig.de</a><br />
			<strong>Internet:</strong> www.padcon-leipzig.de <br />
			<br />
			
			<strong>Vertretungsberechtigter: </strong><br />
			Inhaber Ralf Patzschke<br />
			<br />		
			<strong>Inhaltlich Verantwortlicher gemäß § 6 MDStV: </strong><br />
			Ralf Patzschke<br />
			<br />
			<strong>Haftungshinweis:</strong><br />
			Trotz sorgfältiger inhaltlicher Kontrolle übernehmen
			wir keine Haftung für die Inhalte externer Links.		
			Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber verantwortlich.<br />
			<br />
			Mit Urteil vom 12.Mai 1998 - 312 O 85/98 - "Haftung für Links" hat das Landgericht Hamburg entschieden, 
			dass man durch die Anbringung eines Links die Inhalte der gelinkten Seite ggf. mit zu verantworten hat. 
			Dies kann nur dadurch verhindert werden, dass man sich ausdrücklich von diesen Inhalten distanziert. Hiermit 
			distanzieren wir uns ausdrücklich von allen Inhalten aller gelinkten Seiten auf unserer Internetpräsenz 
			und machen uns diese Inhalte nicht zu eigen. Diese Erklärung gilt für alle auf unserer Internetpräsenz 
			publizierten Links und für alle Inhalte der Seiten, zu denen die bei uns veröffentlichten Links führen. 
		</div>			
		</div>
		 
			<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>
