<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Homepage</title>
	</head>
	<body>
	    <div id = "wrapper">
	    	<div align = "center">
	    	<fieldset>
					<legend>Amministrazione</legend>
	    		<a href = "addCorriere.php">Aggiungi corriere</a>
	    		<br /><br />
	    		<a href = "addProduct.php">Nuovo prodotto</a>
	    		<br /><br />
	    		<a href = "modifyCorriere.php">Modifica corriere</a>
	    		<br /><br />
	    		<a href = "modifyAccount.php">Gestione Utenti</a>
	    		<br /><br />
	    		
	    		<a href = "modifyProduct.php">Gestione prodotti</a>
	    		<br /><br />
	    		<a href = "visualizeProduct.php">Visualizza ordini</a>
	    		</fieldset>
	    	</div>
	    </div>
	    <br/>
	</body>
</html>

<?php
    include "footer.php";
?>