<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title><?php echo $_GET["nomeCategoria"]; ?></title>
	</head>
	<body>
  		<?php
  		
  		$db = DBConnection::getInstance();
  		$mysqli = $db->getConnection();
  		
  		//Vedo quanti prodotti in vendita ci sono per quella categoria
  		$sql_query = "SELECT codProdotto ". 
                     " FROM prodotto, categoriaProdotti ".
  		             " WHERE refCategoria = codCategoria AND nomeCategoria = '".$_GET["nomeCategoria"]."'";
  		$result = $mysqli->query($sql_query);
  		$codProdotti = array();
  		if ($result->num_rows)
  		{
  		    for ($i = 0; $i < $result->num_rows; $i++)
  		    {
  		        $result->data_seek($i);
  		        $row = $result->fetch_assoc();
  		        array_push($codProdotti, $row["codProdotto"]);
  		    }
  		}
  		$numeroProdotti = count($codProdotti);
  		//Mostro gli ultimi 10 prodotti
  		for ($i = $numeroProdotti - 10; $i < $numeroProdotti; $i++)
  		{
  		    if ($i < 0)
  		        continue;
  		    
  		    $prodotto = new Prodotto($codProdotti[$i]);
  		    if ($prodotto->getQuantita() <= 0)
  		        continue;
  		    ?> 		        
  		        <div id = "wrapper">
  		        	<div align = "center">
  		        	
  		        	<fieldset>
						<legend><?php echo $prodotto->getNomeProdotto();?></legend>
  		        		<?php
  		                echo "<br />Categoria: ".$prodotto->getNomeCategoria();
  		                echo "<br />Quantità: ".$prodotto->getQuantita();
  		                echo "<br />Prezzo: ".$prodotto->getPrezzo()."€";
  		                ?>
  		                <br />
  		                
  		                <?php
  		                if ($prodotto->hasImage())
  		                {
  		                    ?>
  		                	<img id = "image" alt="s" src="<?php echo Globals::WEBSITE?>img/<?php echo $prodotto->getNomeProdotto().".jpeg"?>"  width="200" height="200"></img><br /><br />
  		                	<?php 
  		                }
  		                ?>
  		                <form action= "<?php echo Globals::WEBSITE."product.php"; ?>" method="get" >
  		                	<input type = "hidden" name = "codProdotto" value = "<?php echo $prodotto->getCodProdotto(); ?>"/>
  		                	<input type = "submit" value = "Maggiori dettagli"/>
						</form>
						
  		                <form action= "<?php echo Globals::WEBSITE."command.php"; ?>" method="post">
							<input type = "hidden" name = "comando" value = "aggiungiAlCarrello" />
							<input type = "hidden" name = "codProdotto" value = "<?php echo $i; ?>" />
							<select name = "quantita"  onchange="printValue(this.value)">
							<?php
						    for ($j = 1; $j <= $prodotto->getQuantita(); $j++)
						    {
						        ?><option value="<?php echo ($j); ?>"><?php echo $j;
						    }
						    ?>
						    </select>
							<input type = "submit" value = "Metti nel carrello"/>
						</form>
					</fieldset>
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