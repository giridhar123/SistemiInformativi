<?php
include "header.php";
//require_once "DBConnection.php";
session_start();
?>

<html>
	<head>
		<title>Indirizzi di Spedizione</title>
	</head>
	<body>
	    <div id = "wrapper">
	    	<div align = "center">
	    	<?php 
	    	if(isset($_COOKIE['login']))
	    	{
// 	    	    require_once "DBConnection.php";
// 	    	    $db = DBConnection::getInstance();
// 	    	    $mysqli = $db->getConnection();
	    	    ?>
	    	    <form action= <?php echo Globals::WEBSITE."command.php" ?> method = "get">
	    	     <input type = "hidden" name = "comando" value = "newSpedizione" />
	    	     Indirizzo spedizione: <input type = "text" name = "Indirizzo" pattern=".{1,}" placeholder = "Via palermo"><br />
	    	     Citta: <input type = "text" name = "Citta" pattern=".{1,}" placeholder = "Palermo"><br />
	    	     CAP:  <input type = "text" name = "CAP" pattern = "[0-9]{5}" placeholder = "90100"><br />
	    	     <input type = "submit" value = "Aggiungi"/>
	    	     
	    	     </form>
	    	    
	    	    
	    	    <?php 
	    	    
	    	}
	    	
	    	
	    	
	    	?>
	    	
	    	
	    	
	    	
	    	</div>
	    </div>
	    <br/>
	</body>
</html>

<?php
    include "footer.php";
?>