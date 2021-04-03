<?php 
include "header.php";
?>

<html>
	<head>
		<Title>Modifica account utente</Title>
	</head>
	
	<body>
		<div id = "wrapper">
			<div align = "center">
				<form action="" method="post">
					Email utente: <input type = "email" name = "EmailUtente" required ="required" placeholder = "silvio@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value = "<?php echo $_POST["EmailUtente"]; ?>" />
					<input type = "submit" value = "invia risposta"/>
				</form>
		
				<?php 
                if (isset($_POST['EmailUtente']))
                {
                    $db = DBConnection::getInstance();
                    $mysqli = $db->getConnection();
                    $sql_query = "SELECT CodUtente FROM utente where Email = '".$_POST['EmailUtente']."'";
                    $result = $mysqli->query($sql_query);
                    if($result->num_rows)
                    {
                        $row = $result->fetch_assoc();
                        $utente = new Utente($row["CodUtente"]);
                        
                        $numeroOrdini = $utente->getOrdiniEffettuati();
                        if ($numeroOrdini <= 0)
                        {
                            ?>
		   					 <div id = "wrapper">
		    					<div align = "center">
		    							Nessun ordine Effettuato
		    					</div>
		    				</div>
		   					 <?php
		                } 
		                else
		                {
		                    for ($i = 1; $i <= $numeroOrdini; $i++)
		                    {
		                        $ordine = new Ordine($i, $utente->getCod());
		                        $indirizzoSpedizione = $ordine->getIndirizzoSpedizione();
		                        $indirizzoFatturazione = $ordine->getIndirizzoFatturazione();
		                        $corriere = $ordine->getCorriere();
		                        $carta = $ordine->getCarta();
		                        ?>
		      				    <form action= <?php echo Globals::WEBSITE."admin/infoOrdine.php"?> method = "post">
		        					<div id = "wrapper">
		        						<div align = "center">
		        						<fieldset>
										<legend><?php echo "Ordine ".$i; ?></legend>
										Indirizzo di spedizione: <?php echo $indirizzoSpedizione->getIndirizzo();?>
										<br />
										Indirizzo di fatturazione: <?php echo $indirizzoFatturazione->getIndirizzo();?>
										<br />
										Corriere: <?php echo $corriere->getNome(); ?>
										<br />
										Numero Carta: <?php echo $carta->getNumero();?>
										<br />
										Data: <?php echo $ordine->getData();?>
										<br />
										Prezzo Totale: <?php echo $ordine->getPrezzoTotale();?>€
										<br />
										<br />
										Sconto: <?php echo $ordine->getSconto()."%";
                                        if ($ordine->getSconto() > 0)
                                        {
                                            ?>
                                    		<br/>
                                   			Prezzo Scontato: <?php echo $ordine->getPrezzoScontato()."€";
                                        }
							         	?>
										<br />
										<br />
										<input type = "hidden" name = "CodUtente" value = "<?php echo $utente->getCod();?>" />
										<input type = "hidden" name = "Data" value = "<?php echo $ordine->getData();?>" />
										<input type = "hidden" name = "CodAcquisto" value = "<?php echo $i;?>" />
										<input type = "hidden" name = "CodSpedizione" value = "<?php echo $indirizzoSpedizione->getCodIndirizzo();?>" />
										<input type = "hidden" name = "CodFatturazione" value = "<?php echo $indirizzoFatturazione->getCodIndirizzo();?>" />
										<input type = "hidden" name = "CodCorriere" value = "<?php echo $corriere->getCod(); ?>" />
										<input type = "hidden" name = "CodCarta" value = "<?php echo $carta->getCodCarta();?>" />
										<input type = "submit" value ="Maggiori dettagli">
										</fieldset>
		        					</div>		        	
		        				</div>
							</form>
		     			   <br />
		    		    <?php
		                     }
	               	   }
            	 }
           		 else
                    echo "Utente non trovato";
            }
            ?>
        	</div>
        </div>
	</body>
</html>

<?php
include "footer.php"
?>







                        