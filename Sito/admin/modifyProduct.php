<?php
include "header.php";
?>

<html>
	<head>
		<Title>Modifica dati prodotto</Title>
	</head>
	
	<body>
		<div id = "wrapper">
			<div align = "center">
				<form action="" method = "get">
					<fieldset>
						<legend>Nome prodotto</legend>
						Nome prodotto<input type = "text" name ="NomePrecedenteProdotto" required ="required" placeholder = "Iphone" />
						<input type = "submit" value = "invia risposta"/>
					</fieldset>
				</form>
				
				<?php 
				if ($_GET["NomePrecedenteProdotto"] != '')
				{
    				$db = DBConnection::getInstance();
	       			$mysqli = $db->getConnection();
			 	   $sql_query = "SELECT CodProdotto FROM prodotto WHERE NomeProdotto LIKE '%".$_GET["NomePrecedenteProdotto"]."%'";;
				    $result = $mysqli->query($sql_query);
				    if ($result->num_rows)
				    {
				        $row = $result->fetch_assoc();
				        $prodotto = new Prodotto($row["CodProdotto"]);
				        ?>
				    	<fieldset>
							<legend>Modifica prodotto</legend>
							<form action="<?php echo Globals::WEBSITE."command.php"?>" method = "post"  enctype="multipart/form-data">
				    			<input type = "hidden" name = "CodProdotto" value = "<?php echo $prodotto->getCodProdotto();?>">
					    		<input type = "hidden" name = "comando" value = "modifyProduct">
							    Nome prodotto: <input type = "text" name = "NomeProdotto" required ="required" pattern=".{1,}" value = "<?php echo $prodotto->getNomeProdotto(); ?>"><br />
							    Quantità: <input type = "number" name = "Quantita" required ="required" pattern="[0-9]" value = "<?php echo $prodotto->getQuantita(); ?>"><br />
							    Prezzo: <input type = "number" name = "Prezzo" required ="required" pattern="[0-9]" value = "<?php echo $prodotto->getPrezzo(); ?>"><br />
					    		<input type="radio" name="scelta" value="si"> Seleziona se vuoi modificare anche l'immagine<br>
				
								Scegli immagine: <input type ="file" name= "ImmagineNuova"/><br />
								<textarea name ="Descrizione" required = "required" rows="5" cols="40"><?php echo $prodotto->getDescrizione(); ?></textarea><br />
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







