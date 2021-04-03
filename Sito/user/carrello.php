<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Il mio carrello</title>
	</head>
	<body>  
		<?php
		$carrello = $_SESSION["utente"]->getCarrello();
		if (count($carrello) <= 0)
		{
		    ?>
			<div id = "wrapper">
				<div align = "center">
					Nessun prodotto presente nel carrello
				</div>
			</div>
			<?php
		}
		else
		{
		    ?>
		    <div id = "wrapper">
		    	<div align = "center">
		    		<a href = "<?php echo Globals::WEBSITE."user/pagamento.php"?>"><button>Acquista</button></a>
		    	</div>
		    </div>
		    <?php 
		}
			
		for ($i = 0; $i < count($carrello); $i++)
		{
		    $prodotto = new Prodotto($carrello[$i][0]);
		    $quantita = $carrello[$i][1];
  		    ?>
  		    <div id = "wrapper">
  		      	<div align = "center">
  		       		<?php
  		        		   
  		       		echo "Nome Prodotto: ". $prodotto->getNomeProdotto();
  		       		echo "<br />Categoria: ".$prodotto->getNomeCategoria();
  		            echo "<br />Quantità: ".$quantita;
  		            echo "<br />Prezzo totale: ".($prodotto->getPrezzo() * $quantita)."€";
  		            
  		            if ($prodotto->hasImage())
  		            {
  		                ?>
  		                <br /><img id = "image" alt="s" src="<?php echo Globals::WEBSITE?>img/<?php echo $prodotto->getNomeProdotto().".jpeg" ?>" width="200" height="200"></img><br /><br />
  		                <?php
  		            }
  		            ?>
  		            <form action = <?php echo Globals::WEBSITE."command.php" ?> method = "post">
						<input type = "hidden" name = "comando" value = "rimuoviDalCarrello" />
						<input type = "hidden" name = "quantita" value = "<?php echo $quantita; ?>" />
						<input type = "hidden" name = "codProdotto" value = "<?php echo $prodotto->getCodProdotto(); ?>" />
						<input type = "submit" value = "Rimuovi"/>
					</form>
						
					<?php 
					if ($quantita > 1)
					{
					    ?>
						<form action = <?php echo Globals::WEBSITE."command.php" ?> method = "post">
							<input type = "hidden" name = "comando" value = "aggiornaQuantitaCarrello" />
							<input type = "hidden" name = "codProdotto" value = "<?php echo $prodotto->getCodProdotto(); ?>" />
							<select name = "quantita"  onchange="printValue(this.value)">
							<?php
						    for ($j = 1; $j < $quantita; $j++)
						    {
					       	    ?><option value="<?php echo ($j); ?>"><?php echo $j;
						    }
						    ?>
							</select>
							<input type = "submit" value = "Aggiorna Quantità"/>
						</form>
						<?php 
					}
					?>
  		        </div>
  		    </div>
  		    <br />
  		    <?php
  		    }
  		    ?>
	</body>
</html>

<?php
    include "footer.php";
?>