<?php
    include "header.php";
    session_start();
?>

<html>
	<head>
		<title>Indirizzi di Spedizione</title>
	</head>
	<body>
	    <div id = "wrapper">
	    	<div align ="center"><a href="newSpedizione.php"><button>Nuovo</button></a></div>
	    </div>
	    <br/>
		<?php
		$indirizzi = $_SESSION["utente"]->getIndirizziSpedizioneTotale();
		if ($indirizzi <= 0)
		{
		    ?>
		    <div id = "wrapper">
			<div  align = "center">
				Nessun indirizzo di spedizione inserito
			</div>
		</div>
		<?php
		}
		for ($i = 1; $i <= $indirizzi; $i++)
		{
	        $indirizzo = new IndirizzoSpedizione($i, $_COOKIE["login"])
	            ?>
	            <div id = "wrapper">
					<div  align = "center">
						Indirizzo di spedizione <?php echo $indirizzo->getCodIndirizzo();?><br/><br />
						<?php echo $indirizzo->getIndirizzo(); ?>
						<br />
						Citta: <?php echo $indirizzo->getCitta(); ?>
						<br />
						CAP: <?php echo $indirizzo->getCap(); ?>
						
						<form action = <?php echo Globals::WEBSITE."command.php" ?> method="get">
    						<input type = "hidden" name = "comando" value = "setSpedizioneDefault" />
    						<input type = "hidden" name = "codSpedizione" value = "<?php echo $indirizzo->getCodIndirizzo();?>" />
        					<input type = "submit" value = "Imposta default"/>
               			</form>	
               			<form action = <?php echo Globals::WEBSITE."command.php" ?> method="get">
    						<input type = "hidden" name = "comando" value = "eliminaIndirizzoSpedizione" />
    						<input type = "hidden" name = "codSpedizione" value = "<?php echo $indirizzo->getCodIndirizzo();?>" />
        					<input type = "submit" value = "Elimina"/>
               			</form>	
					</div>
				</div>
				<br />
				<?php
	        }
	        ?>
	    <br/>
	</body>
</html>

<?php
    include "footer.php";
?>