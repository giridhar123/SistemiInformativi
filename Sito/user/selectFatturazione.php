<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Seleziona indirizzo di Fatturazione</title>
	</head>
	<body>
	    <div id = "wrapper">
	    	<div align ="center"><a href="newFatturazione.php"><button>Nuovo</button></a></div>
	    </div>
	    <br/>
		<?php
		$numIndirizzi = $_SESSION["utente"]->getIndirizziFatturazioneTotale();
		
		if ($numIndirizzi <= 0)
		{
		?>
		<div id = "wrapper">
		<div  align = "center">
		Nessuna indirizzo inserito
		</div>
		</div>
		<?php 
		}
		for ($i = 1; $i <= $numIndirizzi; $i++)
	    {
	        $indirizzo = new IndirizzoFatturazione($i, $_COOKIE["login"])
	            ?>
	            <div id = "wrapper">
					<div  align = "center">
						<form action = <?php echo "Pagamento.php" ?> method="post">
    						<input type = "hidden" name = "CodFatturazione" value = <?php echo $indirizzo->getCodIndirizzo();?> />
    						Indirizzo di fatturazione <?php echo $indirizzo->getCodIndirizzo();?><br/><br />
							<?php echo $indirizzo->getIndirizzo(); ?>
							<br />
							Citta: <?php echo $indirizzo->getCitta(); ?>
							<br />
							CAP: <?php echo $indirizzo->getCap(); ?>
							<br />
        					<input type = "submit" value = "Scegli indirizzo di fatturazione"/>
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