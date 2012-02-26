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
	<div id="header">
		<? include("_header.php"); ?>
	</div>
	<div id="navigationSidebar">
		<? include("_navigation.php"); ?>
	</div>
	<div id="infoSidebar">
		<? include("_info.php"); ?>
	</div>
	<div id="mainContent">
		<div id="breadcrump"><a href="index.php">Startseite</a> - &Uuml;ber uns</div>
		<div id="grosseSpalte"> Die Firma padcon wurde als padcon GmbH Dresden im Jahre
			1991 in Dresden gegründet. 1995 verlegte die Firma ihren Sitz nach Leipzig/Markkleeberg.
			Im Jahre 2003 strukturierte sie sich um und firmierte fortan unter padcon
			Leipzig-Ralf Patzschke.<br />
			<br />
			Die Firma wird von Beginn an von Herrn Ralf Patzschke geleitet. <br />
			Als mittelständiges Unternehmen suchen wir mit unserem eigenen
			Produkten vordergründig den Direktkontakt zu unseren Kunden, schließen aber
			die Unterstützung durch andere Fachhändler nicht aus.<br />
			<br />
			In den letzten 10 Jahren konzentrierte sich padcon schwerpunktmäßig
			auf den Vertrieb von Lagerungshilfsmitteln speziell zur druckentlastenden
			Lagerung. Bei unseren eigen entwickelten Sortiment arbeiten wir ausschließlich
			mit Produzenten aus unserer Region zusammen.<br />
			<br />
			Unsere Vertriebsprodukte sind vorrangig Medizinprodukte für den
			Krankenhaus- und Altenpflegebereich. Dabei dienen wir einer Vielzahl von renommierten
			Firmen als Vertriebspartner. <br />
			<br />
			Folgende Produkte und Dienstleistungen bieten wir an:
			<p class="absatzGray"> Hilfsmittel für die Lagerung <br />
				Hilfsmittel für den Patiententransfer <br />
				Hilfsmittel für den Patiententransport <br />
				Produkte aus Edelstahl <br />
				Div. Medizinprodukte </p>
		</div>
		<div id="kleineSpalte"><img class="imageRightAlign" src="<?=_IMAGE_PATH?>ralf.png" width="140" height="182" alt="Geschäftsführer - Ralf Patzschke" />
		</div>
	</div>
		<br class="clearfloat" />
	<div id="footer" />
</div>
</body>
</html>
