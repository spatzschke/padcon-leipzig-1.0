<? 
session_start();
include("dbconnect.php"); 
include("_CONSTANTS.php");

	switch($_POST['action'])
	{

			case 0: 	move_uploaded_file($_FILES['uploaded']['tmp_name'], $_FILES['uploaded']['name']);
					header("Location:http://web302.server90.greatnet.de/site-10/");
					exit; 
					break;
			default: echo 'default';
					break;
		
				  
	}
	
	
?>