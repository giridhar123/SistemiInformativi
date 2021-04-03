<?php
// DA FINIRE

include "header.php";
session_start();
?>

<html>
	<head>
		<title>Selezione modalità di pagamento</title>
	</head>
	<body>
		<br/>
	    <div id = "wrapper">
	    	<div align ="center"><a href="newCarta.php"><button>Nuovo</button></a></div>
	    </div>
	    <br/>
	    <?php
        $numeroCarte = $_SESSION["utente"]->getNumeroCarteTotali();
        if ($numeroCarte <= 0)
        {
            ?>
            <div id = "wrapper">
				<div  align = "center">
					Nessuna carta inserita
				</div>
			</div>
			<?php
        }
        
        for ($i = 1; $i <= $numeroCarte; $i++)
        {
            $carta = new Carta($i, $_COOKIE["login"]);
            ?>
	        <div id = "wrapper">
				<div  align = "center">
					Numero Carta: <?php echo $carta->getNumero(); ?>
					<br />
					Tipo: <?php echo $carta->getNomeTipo(); ?>
				</div>
  		    	<div align = "center">
  		    		<form action = "<?php echo Globals::WEBSITE."user/Pagamento.php";?>" method = "post">
						<input type = "hidden" name = "Carta" value = "<?php echo $carta->getCodCarta();?>" />
						<input type = "submit" value = "Seleziona"/>
					</form>
				</div>		
			</div>
			<br/>
			<?php
        }
        ?>
	    <br/>
	</body>
</html>

<?php
include "footer.php";
?>