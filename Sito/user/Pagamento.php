<?php
// DA FINIRE
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Pagamento</title>
	</head>
	<body>
	<?php
	    
	    $numeroCarteTotali = $_SESSION["utente"]->getNumeroCarteTotali();
	    $codFatturazionePreferito =  $_SESSION["utente"]->getIndirizzoFatturazionePreferito();
	    $codSpedizionePreferito = $_SESSION["utente"]->getIndirizzoSpedizionePreferito();
	    if ($numeroCarteTotali <= 0)
	    {
	        ?>
	        <div id = "wrapper">
				<div align = "center">
					Nessuna carta Inserita, impossibile continuare
					<br />
					<a href="newCarta.php"><button>Nuova</button></a>
				</div>
			</div>
			<?php
	    }
	    else if ($codFatturazionePreferito <= 0)
	    {
	        ?>
	        <div id = "wrapper">
				<div align = "center">
					Nessun indirizzo di fatturazione inserito, impossibile continuare
					<br />
					<a href="newFatturazione.php"><button>Nuovo</button></a>
				</div>
			</div>
			<?php
	    }
	    else if ($codSpedizionePreferito <= 0)
	    {
	        ?>
	        <div id = "wrapper">
				<div align = "center">
					Nessun indirizzo di spedizione inserito, impossibile continuare
					<br />
					<a href="newSpedizione.php"><button>Nuovo</button></a>
				</div>
			</div>
			<?php
	    }
	    else 
	    {
	        	        
// 	    BRUTALE MA FUNZIONANTE

// 	        SETTO CARTA
	        if(isset($_POST['Carta']))
	        {
	            $_SESSION['codCarta'] = $_POST['Carta'];
	            $carta = new Carta($_SESSION['codCarta'], $_SESSION['utente']->getCod());
	        }
	        else if ($_SESSION['codCarta'] > 0)
	            $carta = new Carta($_SESSION['codCarta'], $_SESSION['utente']->getCod());
	        else
	        {
	            $carta = new Carta(1, $_COOKIE["login"]);
	            $_SESSION['CodCarta'] = $carta->getCodCarta();
	        }
// 	        SETTO CORRIERE
	        if(isset($_POST['CodCorriere']))
	        {
	            $_SESSION['CodCorriere'] = $_POST['CodCorriere'];
	            $corriere = new Corriere($_SESSION['CodCorriere']);
	        }
	        else if ($_SESSION['CodCorriere'] > 0)
	            $corriere = new Corriere($_SESSION['CodCorriere']);
	        else
	        {
	            $corriere = new Corriere(1);
	            $_SESSION['CodCorriere'] = $corriere->getCod();
	        }
	        
// 	        SETTO INDIRIZZO FATTURAZIONE
	        if(isset($_POST['CodFatturazione']))
	        {
	            $_SESSION['CodFatturazione'] = $_POST['CodFatturazione'];
	            $fatturazione = new IndirizzoFatturazione($_SESSION['CodFatturazione'], $_SESSION['utente']->getCod());
	        }
	        else if ($_SESSION['CodFatturazione'] > 0 && !isset($_POST['CodFatturazione']))
	            $fatturazione = new IndirizzoFatturazione($_SESSION['CodFatturazione'], $_SESSION['utente']->getCod());
	        else
	        {
	            $fatturazione = new IndirizzoFatturazione($codFatturazionePreferito, $_SESSION['utente']->getCod());
	            $_SESSION['CodFatturazione'] = $fatturazione->getCodIndirizzo();
	        }
	        
// 	        SETTO INDIRIZZO SPEDIZIONE
	        if(isset($_POST['CodSpedizione']))
	        {
	            $_SESSION['CodSpedizione'] = $_POST['CodSpedizione'];
	            $spedizione = new IndirizzoSpedizione($_SESSION['CodSpedizione'], $_SESSION['utente']->getCod());
	        }
	        else if ($_SESSION['CodSpedizione'] > 0 && !isset($_POST['CodSpedizione']))
	            $spedizione = new IndirizzoSpedizione($_SESSION['CodSpedizione'], $_SESSION['utente']->getCod());
	        else
	        {
	            $spedizione = new IndirizzoSpedizione($codSpedizionePreferito, $_SESSION['utente']->getCod());
	            $_SESSION['CodSpedizione'] = $spedizione->getCodIndirizzo();
	        }
	        
	        ?>
			<div id = "wrapper">
				<div align = "center">
					<b><strong>Carta:</strong></b> <br />
					Tipo: <?php echo $carta->getNomeTipo();?><br />
					Numero: <?php echo $carta->getNumero();?><br />
					<a href="selectCarta.php"><button>Altro metodo di pagamento</button></a><br /><br />
					
					<b><strong>Indirizzo Fatturazione</strong></b> <br /><br />
					Indirizzo: <?php echo $fatturazione->getIndirizzo();?> <br />
					Città: <?php echo $fatturazione->getCitta();?><br />
					CAP: <?php echo $fatturazione->getCap();?><br /> <a href="selectFatturazione.php"><button>Modifica</button></a><br /><br />
				
					<b><strong>Indirizzo Spedizione:</strong></b><br /><br />
					Indirizzo: <?php echo $spedizione->getIndirizzo();?> <br />
					Città: <?php echo $spedizione->getCitta();?><br />
					CAP: <?php echo $spedizione->getCap();?><br />  <a href="selectSpedizione.php"><button>Modifica</button></a><br /><br />					
					
					<b><strong>Corriere:</strong></b><br /><br />
					Nome: <?php echo $corriere->getNome(); ?><br />
					Spesa di spedizione: <?php echo $corriere->getPrezzoSpedizione(); ?><br />
					<a href="selectCorriere.php?"><button>Seleziona corriere</button></a><br /><br />
				
					<form action= <?php echo Globals::WEBSITE."command.php"?> method = "post">
						<input type = "hidden" name = "comando" value = "pagamento" />
						<input type = "hidden" name = "CodCarta" value = "<?php echo $_SESSION['CodCarta'];?>" />
						<input type = "hidden" name = "CodCorriere" value = "<?php echo $_SESSION['CodCorriere']; ?>" />
						<input type = "hidden" name = "CodFatturazione" value = "<?php echo $_SESSION['CodFatturazione'];?>" />
						<input type = "hidden" name = "CodSpedizione" value = "<?php echo $_SESSION['CodSpedizione'];?>" />
						<input type = "submit" value ="Paga">
					</form>
				</div>
			</div>
			<?php 
	    }
	    ?>			
	</body>
</html>

<?php
    include "footer.php";
?>