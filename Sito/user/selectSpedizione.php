<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Selezione indirizzi di Spedizione</title>
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
				Nessuna carta inserita
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
						
						<form action = <?php echo "Pagamento.php" ?> method="post">
    						<input type = "hidden" name = "CodSpedizione" value = "<?php echo $indirizzo->getCodIndirizzo();?>" />
        					<input type = "submit" value = "Scegli indirizzo di spedizione"/>
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