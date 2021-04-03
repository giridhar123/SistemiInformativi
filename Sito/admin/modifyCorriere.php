<?php
include "header.php";
?>

<html>
	<head>
		<Title>Modifica corriere</Title>
	</head>
	
	<body>
		<div id = "wrapper">
			<div align = "center">
				<form action="" method = "get">
					<fieldset>
						<legend>Nome corriere</legend>
						Nome corriere<input type = "text" name ="NomePrecedenteCorriere" required ="required" placeholder = "DHL" />
						<input type = "submit" value = "invia risposta"/>
					</fieldset>
				</form>
				
				<?php 
				if ($_GET["NomePrecedenteCorriere"] != '')
				{
				    $db = DBConnection::getInstance();
				    $mysqli = $db->getConnection();
    				$sql_query = "SELECT CodCorriere FROM corriere WHERE Nome LIKE '%".$_GET["NomePrecedenteCorriere"]."%'";
				    $result = $mysqli->query($sql_query);
				    if ($result->num_rows)
				    {
    				    $row = $result->fetch_assoc();
	   	       		    $corriere = new Corriere($row["CodCorriere"]);
		  		        ?>
				    	<fieldset>
							<legend>Modifica corriere</legend>
							<form action="<?php echo Globals::WEBSITE."command.php"?>" method = "post">
								<input type = "hidden" name = "comando" value = "modifyCorriere">
				    			<input type = "hidden" name = "CodCorriere" value = "<?php echo $corriere->getCod();?>">
						    	Nome corriere: <input type = "text" name = "NomeCorriere" required ="required" pattern=".{1,}" value = "<?php echo $corriere->getNome(); ?>"><br />
						    	Prezzo spedizione: <input type = "number" name = "Prezzo" required ="required" pattern="[0-9]" value = "<?php echo $corriere->getPrezzoSpedizione(); ?>"><br />
						    	<input type = "submit" value = "Modifica"/>
				    		</form>
				    	</fieldset>
				    	<?php 
				    }
				}
                ?>
        	</div>
        </div>
	</body>
</html>

<?php
include "footer.php"
?>







