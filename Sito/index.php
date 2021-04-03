<?php
    require_once "header.php";
    session_start();
?>

<html>
	<head>
		<title>Homepage</title>
	</head>
	<body>
	
  		<?php
  		
  		$db = DBConnection::getInstance();
  		$mysqli = $db->getConnection();
  		
  		//Mostro le categorie
  		$sql_query = "SELECT NomeCategoria FROM categoriaProdotti";
  		$result = $mysqli->query($sql_query);
  		if ($result->num_rows)
  		{
  		    ?>
  		    <div >
            	<div align = "center">
            		<img id = "Logo" alt="s" src="<?php echo Globals::WEBSITE?>img/Logo1.jpg" width="200" height="200"></img><br /><br />
            		
            		<?php
                    for ($i = 0; $i < $result->num_rows; $i++)
  		            {
  		                $result->data_seek($i);
  		                $row = $result->fetch_assoc();
  		                ?>
  		                <?php
  		            }
  		            ?>
            	</div>            	
            </div>
            <br />
            <?php
  		}
  		
  		//Vedo quanti prodotti in vendita ci sono
  		$sql_query = "SELECT COUNT(*) FROM prodotto";
  		$result = $mysqli->query($sql_query);
  		$products = 0;
  		if ($result->num_rows)
  		{
  		    $row = $result->fetch_assoc();
  		    $products = ($row["COUNT(*)"]);
  		    $products = $products - ($products % 10);
  		    $i = 0;
  		}
  		
  		//Mostro gli ultimi 10 prodotti
  		if(isset($_GET['numPagina']))
  		{
  		    $products = ($_GET['numPagina'])*10;
  		    $i = $products - 9;
  		}
  		for ($i; $i <= $products; $i++)
  		{
  		    if ($i <= 0)
  		        $i=1;
  		        
  		    $prodotto = new Prodotto($i);
  		    if ($prodotto->getQuantita() <= 0)
  		    {
  		        continue;
  		    }
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
  		                	<img id = "image" alt="s" src="<?php echo Globals::WEBSITE?>img/<?php echo $prodotto->getNomeProdotto().".jpeg" ?>" width="200" height="200"></img><br /><br />
  		                	<?php 
  		                }
  		                ?>
  		                <form action= <?php echo Globals::WEBSITE."product.php" ?> method="get" >
  		                	<input type = "hidden" name = "codProdotto" value = "<?php echo $prodotto->getCodProdotto(); ?>"/>
  		                	<input type = "submit" value = "Maggiori dettagli"/>
						</form>
						<?php 
						if($_SESSION["utente"])
						{
						    ?>
						    
  		               		 <form action= <?php echo Globals::WEBSITE."command.php" ?> method="post">
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
						    <?php 
						}
						?>
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
    
    include "footerIndex.php";
    
?>