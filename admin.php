<? 
session_start();

$user_name = "padcon"; 
$user_pass = "padcon2010"; 

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
		<div id="breadcrump"><a href="index.php">Startseite</a> - Adminbereich</div>      
		
		<div id="einspaltig">
		<?
			if(isset($_GET['action']))
			{
				unset($_SESSION["user"]);
				unset($_SESSION["pw"]);
				echo "<meta http-equiv=\"refresh\" content=\"0; URL=index.php\">";
			}
			 
			//login Funktionen
			//post variablen einfach speichern
			$user = $_POST['user'];
			$pw = $_POST['pw'];
			   
			//nun kommen die if abfragen die das ganze relativ sicher machen
			if (isset($user, $pw))
			{
				if ($user == "" OR $pw == "")
				{
					echo "<b>Bitte fülle beide Felder aus!</b>";
				}
				elseif ($user == $user_name AND $pw == $user_pass)
				{
					$_SESSION['user'] = $user;
					$_SESSION['pw'] = $pw;
					extract($_GET);
					echo "<meta http-equiv=\"refresh\" content=\"0; URL=backend.php\">";
				}
				else
				{
					echo "<meta http-equiv=\"refresh\" content=\"0; URL=admin.php\">";	
				}
			}
			   
			//dann kommt das Formular
			if(!isset($user, $pw))
			{
				echo '<form name="login" method="post" action="'.$_SERVER['PHP_SELF'].'">
						<fieldset>
							<span style="width: 100px; padding-top:6px; float: left;">User Name:</span><input style="margin-right: 90px; float: left;" type="text" name="user"><br>
							<span style="width: 100px; padding-top:6px; float: left;">Passwort:</span><input style="margin-right: 90px; float: left;" type="password" name="pw"><br>
							<input type="submit" name="Submit" value="einloggen">
						</fieldset>
					</form>';
			}   
?>
		</div>	
		</div>
		 
		<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>
