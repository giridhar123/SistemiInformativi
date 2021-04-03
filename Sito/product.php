<?php
include "header.php"
?>

<html>
	<head>
		<title>Info prodotto</title>
	</head>
	<body>
	<?php 
	$prodotto = new Prodotto($_GET['codProdotto']);
// 	$db = DBConnection::getInstance();
// 	$mysqli = $db->getConnection();
// 	$sql_query = "SELECT* FROM prodotto WHERE CodProdotto = '".$_GET['codProdotto']."'";
// 	$result = $mysqli->query($sql_query);
// 	$row = $result ->fetch_assoc();
	?>
		<div id = "wrapper">
			<div align = "left">
				<fieldset>
						<article>
					    <img  align = "left" id = "image" alt="s" src="<?php echo Globals::WEBSITE?>img/<?php echo $prodotto->getNomeProdotto().".jpeg"?>"></img><br /><br />
						<p><strong>Nome: </strong><?php echo $prodotto->getNomeProdotto();?><p/>
						<p><strong>Categoria: </strong><?php echo $prodotto->getNomeCategoria();?> <p/>
						<p><strong>Prezzo: </strong><?php echo $prodotto->getPrezzo();?> €<p/>
						<p><strong>Descrizione: </strong><?php echo $prodotto->getDescrizione();?></p>
						
						</article>
					
					
					</fieldset>
			</div>
		</div>
	</body>
</html>

<?php 
include "footer.php"
?>