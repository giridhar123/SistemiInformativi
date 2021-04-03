<?php
    include "header.php"
?>

<html>
	<head>
		<title>Info ordine</title>
	</head>
	<body>
	<div id = "wrapper">
		<div align = "center">
			<fieldset>
				<?php
				$spedizione = new IndirizzoSpedizione($_POST["CodSpedizione"], $_COOKIE["login"]);
				$fatturazione = new IndirizzoFatturazione($_POST["CodFatturazione"], $_COOKIE["login"]);
				$carta = new Carta($_POST["CodCarta"], $_COOKIE["login"]);
				$corriere = new Corriere($_POST["CodCorriere"]);
			    ?>
				<legend>Info ordine</legend>
				<b>Data:</b> <?php echo $_POST["Data"];?>
				<br />								
				<b>Indirizzo di Spedizione</b><br />
				Indirizzo: <?php echo $spedizione->getIndirizzo();?><br />
				Città: <?php echo $spedizione->getCitta();?><br />
				Cap: <?php echo $spedizione->getCap();?><br />
				<br />
				<b>Indirizzo di Fatturazione</b><br />
				Indirizzo: <?php echo $fatturazione->getIndirizzo();?><br />
				Città: <?php echo $fatturazione->getCitta();?><br />
				Cap: <?php echo $fatturazione->getCap();?><br />
				<br />
				<b>Carta utilizzata</b><br />
				Numero: <?php echo $carta->getNumero();?><br />
				Tipo: <?php echo $carta->getNomeTipo();?><br />
				<br />
				<b>Corriere</b><br />
				Nome: <?php echo $corriere->getNome();?><br />
				Spesa di spedizione: <?php echo $corriere->getPrezzoSpedizione();?><br />
			</fieldset>
		</div>
	</div>
	<br />
	<?php
	   $ordine = new Ordine($_POST["CodAcquisto"], $_POST["CodUtente"]);
	   $prodotti = $ordine->getProdotti();
	   if ($prodotti != null)
	   {
	       $utente = new Utente($_POST["CodUtente"]);
	       $fattura = new Fattura($utente->getNome(), $utente->getCognome(), $fatturazione, $spedizione, $corriere, $carta, $ordine);
	       $nomeFile = $utente->getNome().$utente->getCognome().$_POST["CodAcquisto"].".pdf";
	       $pathFattura = Globals::FATTURA_PATH.$nomeFile;
	       $fattura->createFile($pathFattura)
	       ?>
	       
			<div id = "wrapper">
				<div align = "center">
					<a href="<?php echo Globals::WEBSITE."fatture/".$nomeFile;?>" download><button>Scarica Fattura</button> </a>
				</div>
			</div>
			<br />
	       <?php
	       
    	   for ($i = 0; $i < count($prodotti); $i++)
	       {
	           $prodotto = new Prodotto($prodotti[$i][0]);
	           $quantita = $prodotti[$i][1];
	           ?>
	           <div id = "wrapper">
		       		<div align = "center">
			        	<fieldset>
			       			<legend>Prodotto <?php echo ($i + 1) ;?></legend>
							Nome: <?php echo $prodotto->getNomeProdotto();?><br />
							Categoria: <?php echo $prodotto->getNomeCategoria();?><br />
							Prezzo: <?php echo $prodotto->getPrezzo();?><br />
							Quantita: <?php echo $quantita;?><br />
							Prezzo Totale: <?php echo $prodotto->getPrezzo() * $quantita;?><br />
							
							<br />
							<?php 
							if ($prodotto->hasImage())
  		                    {
  		                    ?>
  		                		<br /><img id = "image" alt="s" src="<?php echo Globals::WEBSITE?>img/<?php echo $prodotto->getNomeProdotto().".jpeg" ?>" width="200" height="200"></img><br /><br />
  		                	<?php
  		                    }
  		                    ?>
						</fieldset>
					</div>
				</div>
				<br />
				<?php 
	       }
	   }
	?>
	</body>
</html>

<?php 
    include "footer.php"
?>