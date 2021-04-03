<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Indirizzi di Fatturazione</title>
	</head>
	<body>
	    <div id = "wrapper">
	    	<div align ="center"><a href="newFatturazione.php"><button>Nuovo</button></a></div>
	    </div>
	    <br/>
		<?php
		$indirizzi = $_SESSION["utente"]->getIndirizziFatturazioneTotale();
		
		if ($indirizzi <= 0)
		{
		?>
		<div id = "wrapper">
		<div  align = "center">
		Nessuna indirizzo inserito
		</div>
		</div>
		<?php 
		}
		for ($i = 1; $i <= $indirizzi; $i++)
	    {
	        $indirizzo = new IndirizzoFatturazione($i, $_COOKIE["login"])
	            ?>
	            <div id = "wrapper">
					<div  align = "center">
						Indirizzo di fatturazione <?php echo $indirizzo->getCodIndirizzo();?><br/><br />
						<?php echo $indirizzo->getIndirizzo(); ?>
						<br />
						Citta: <?php echo $indirizzo->getCitta(); ?>
						<br />
						CAP: <?php echo $indirizzo->getCap(); ?>
						
						<form action = <?php echo Globals::WEBSITE."command.php" ?> method="get">
    						<input type = "hidden" name = "comando" value = "setFatturazioneDefault" />
    						<input type = "hidden" name = "codFatturazione" value = "<?php echo $indirizzo->getCodIndirizzo()?>" />
        					<input type = "submit" value = "Imposta default"/>
               			</form>	
               			<form action = <?php echo Globals::WEBSITE."command.php" ?> method="get">
    						<input type = "hidden" name = "comando" value = "eliminaIndirizzoFatturazione" />
    						<input type = "hidden" name = "codFatturazione" value = "<?php echo $indirizzo->getCodIndirizzo();?>" />
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