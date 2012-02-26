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
		<div id="breadcrump"><a href="index.php">Startseite</a> - Bestellung</div>    
		<div id="grosseSpalte">
		<?
			if(isset($_POST['submit']))
			{
				send();	
			}
			else
			{
			echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">
				Name<br>
				<input type="text" name="name" size="30">
				<br>
				Email<br>
				<input type="text" name="email" size="30" />
				<br>
				Einrichtung<br>
				<input type="text" name="einrichtung" size="30">
				<br>
				Bestellung<br>
				<textarea name="bestellung" rows="6" cols="23" wrap="hard"></textarea>
				<br>
				<br>
				<input name="submit" type="submit" value="Bestellung abschicken" />
				<br>
				Alle Felder m&uuml;ssen ausgef&uuml;llt werden!
          	</form>';
			}
		?>
		</div>
		<div id="kleineSpalte">
			<img class="imageRightAlign" src="<?=_IMAGE_PATH?>bestellung.png" alt="Bestellung" width="180" height="183" />
		</div>	
		</div>
		 
			<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>

<?php

function send() {

$name = $_POST['name'];
$email = $_POST['email'];
$bestellung = $_POST['bestellung'];
$einrichtung = $_POST['einrichtung'];

$empfaenger = "bestellung@padcon-leipzig.de";



if ($name == "" || $email == "" OR $bestellung == "" || $einrichtung == "") {

  $check = "no";

}



list($user, $host) = explode("@", $email);

if (checkdnsrr($host, "MX") or checkdnsrr($host, "A")) {

  echo "";

} else {

  $check2 = "no";

}



////////////////////////////



if ($check == "no") {

  echo ("<br>Bitte alle Felder ausf&uuml;llen.<br><br>");

  

}



else if ($check2 == "no") {

  echo ("<Die E-mail Adresse, die Sie eingef&uuml;gt haben, scheint falsch zu sein.<br><br>Bitte korrekt einf&uuml;gen.");

  

}



else {



////////////////////////////



$ip = getenv("REMOTE_ADDR");

$datum=(date("d.m.y"));

$zeit=(date("G:i:s"));



$mail_absender="bestellung@padcon-leipzig.de";



$betreff="Bestellung von $name / $einrichtung";



$textmail="Bestellung:\n

		\n

		Name: $name\n\n

		Einrichtung: $einrichtung\n\n

		E-Mail: $email\n\n

		$bestellung



------------------------------------------\n



$datum, $zeit\n



Identitat: $ip";







mail($empfaenger, $betreff, $textmail,"from:$mail_absender");







// Autoresponder



$inhalt = "padcon Leipzig bedankt sich bei Ihnen für Ihre Bestellung.\n

Folgende Bestellung wurde an uns übermittelt:\n

Name: $name

Einrichtung: $einrichtung

E-Mail: $email\n

Bestellung:\n\n$bestellung\n

Wir werden Ihre Anforderung so schnell wie möglich bearbeiten und Ihnen ein Angebot unterbreiten.\n

Sollten Sie Änderungen zu Ihrer Bestellung haben, dann schicken Sie uns bitte ein E-Mail an bestellung@padcon-leipzig.de\n

Mit freundlichen Grüßen\n\n

Ralf Patzschke";





$betreff = "padcon Leipzig - Danke fuer Ihre Bestellung.";











@mail("$email", "$betreff", "$inhalt\n\n","From:bestellung@padcon-leipzig.de");







echo nl2br("<p>Vielen Dank f&uuml;r Ihre Bestellung<br><br>Folgende Daten haben Sie in Ihrer Bestellung angegeben:<br><br>

			$name<br>$einrichtung<br>$email<br><br>$bestellung<br><br>Wir werden Ihnen schnellstm&ouml;glich ein Angebot unterbreiten.
			
			<p>Mit freundlichen Gr&uuml;&szlig;en</p>

        	<p>Ralf Patzschke<br />

       		</p>

       		<a href='javascript:window.back()'>Zur&uuml;ck</a>
			
			</p>");



$dateiname = "index.php";







$fp = fopen($dateiname, "r") or exit();



}

}
?>
