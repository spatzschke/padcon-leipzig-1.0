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
<?
	$act = $_GET['action'];
?>
	<div id="container">
		<div id="header"><? include("_header.php"); ?></div>
		
		<div id="navigationSidebar"><? include("_navigation.php"); ?></div>
		<div id="infoSidebar"><? include("_info.php"); ?></div>

		<div id="mainContent"> 
		<?
			if(isset($act))
			{
						$sqlTYP = mysql_fetch_array(mysql_query("SELECT * FROM partnercategory WHERE id=".$act." AND status = 1;"));
						echo '<div id="breadcrump"><a href="index.php">Startseite</a> - <a href="vertriebspartner.php">Vertriebspartner</a> - '.$sqlTYP['name'].'</div>';
							
			}
			else{
					echo '<div id="breadcrump"><a href="index.php">Startseite</a> - Vertriebspartner</div>';
			}
			
					
		
		echo '<div id="einspaltig"><table>';
		
			if(!isset($act))
			{
				if(isset($_SESSION['user'], $_SESSION['pw']))
				{
					$partnerQuery = mysql_query("SELECT * FROM partnercategory;");
					while($row = mysql_fetch_array($partnerQuery))
					{
						if($row['status']==0) {echo '<div id="inactive">';}
						echo '<tr>
								<td width="80%">';
									if($row['status']==0) {
										echo '<div id="inactive"><a href="vertriebspartner.php?action='.$row['id'].'">'.$row['name'].'</a></div>';
									}
									else
									{
										echo '<a href="vertriebspartner.php?action='.$row['id'].'">'.$row['name'].'</a>';
									}
								echo'</td>
								<td width="20%">
									<a href="vertriebspartner.php?action='.$row['id'].'">
										<img src="'._PARTNER_CATEGORY_IMAGE_PATH.$row['imagePath'].'" alt="'.$row['name'].'" />
									</a>
								</td>
							</tr>';
						
					}
				}
				else
				{
					$partnerQuery = mysql_query("SELECT * FROM partnercategory WHERE status = 1;");
					while($row = mysql_fetch_array($partnerQuery))
					{
	
						echo '<tr>
								<td width="80%">
									<a href="vertriebspartner.php?action='.$row['id'].'">'.$row['name'].'</a>
								</td>
								<td width="20%">
									<a href="vertriebspartner.php?action='.$row['id'].'">
										<img src="'._PARTNER_CATEGORY_IMAGE_PATH.$row['imagePath'].'" alt="'.$row['name'].'" />
									</a>
								</td>
							</tr>';
					}
				}
			} 
			else {
				if(isset($_SESSION['user'], $_SESSION['pw']))
				{
					$partnerQuery = mysql_query("SELECT * FROM partner WHERE category=".$act.";");
					while($row = mysql_fetch_array($partnerQuery))
					{
						echo '<tr>
								<td width="80%">';
									if($row['status']==0) {
										echo '<div id="inactive"><br /><strong><a href="'.$row['url'].'" target="_blank">'.$row['name'].'</a></strong><br>'.$row['beschreibung'].'<br /></div>';
									}
									else
									{
										echo '<br /><strong><a href="'.$row['url'].'" target="_blank">'.$row['name'].'</a></strong><br>'.$row['beschreibung'].'<br />';
									}
								echo'</td>
								<td width="20%">
									<a href="'.$row['url'].'" target="_blank">
										<img src="'._PARTNER_IMAGE_PATH.$row['imagePath'].'" alt="'.$row['name'].'" />
									</a>
								</td>
							</tr>';
						
					}
				}
				else
				{
					$partnerQuery = mysql_query("SELECT * FROM partner WHERE category=".$act." AND status = 1;");
					while($row = mysql_fetch_array($partnerQuery))
					{
	
						echo '<tr>
								<td width="80%">
									<br /><strong><a href="'.$row['url'].'" target="_blank">'.$row['name'].'</a></strong><br>'.$row['beschreibung'].'<br />
								</td>
								<td width="20%">
									<a href="'.$row['url'].'" target="_blank">
										<img src="'._PARTNER_IMAGE_PATH.$row['imagePath'].'" alt="'.$row['name'].'" />
									</a>
								</td>
							</tr>';
					}
				}
			}								
			
		echo '</table>';
		  
		?>
		</div>
		</div>
		 
			<br class="clearfloat" />
			
		<div id="footer" />
	</div>
</body>
</html>
