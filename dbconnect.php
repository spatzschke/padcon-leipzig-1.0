<?php
	
	$key = 'live';
	
	switch($key)
	{
		case 'live': 	//LIVE
					$host = "localhost";
					$user = "";
					$pw = "";
					$schema = "padconLive";
					break;
					
		case 'test':	// Local - Test
					$host = "localhost";
					$user = "";
					$pw = "";
					$schema = "";
					break;		
	}
	
	$conID = mysql_connect($host,$user,$pw) or die ("Keine Verbindung moeglich");
	
	if (is_resource( $conID ))
	{
 	   mysql_select_db( $schema, $conID ) or die ("Die Datenbank existiert nicht");
 	   mysql_query( "SET NAMES 'utf8'", $conID );
	}

/*
	mysql_query( "SET NAMES 'utf8'", $schema );
	$ftp_server = "padcon-leipzig.de";
	$benutzername = "";
	$passwort = "";
	 
	// Die Verbindung herstellen
	$connection_id = ftp_connect($ftp_server);
	 
	// Mit Benutzername und Kennwort anmelden
	$login_result = ftp_login($connection_id, $benutzername, $passwort);
	 
	// überprüfen ob alles gutgegangen ist
	if ((!$connection_id) || (!$login_result)) {
	  echo "<H1>Ftp-Verbindung nicht hergestellt!<H1>";
	  echo "<P>Verbindung mit ftp_server als Benutzer $benutzername nicht möglich!</P>";
		die;
	}
	*/
?>
