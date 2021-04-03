<?php
include "header.php";
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
  			
  		$sql_query = "SELECT CodProdotto FROM prodotto, categoriaProdotti WHERE RefCategoria = CodCategoria AND NomeProdotto LIKE '%".$_GET["NomeProdotto"]."%'";
  		$result = $mysqli->query($sql_query);
  		if ($result->num_rows)
  		{
  		    for ($i = 0; $i < $result->num_rows; $i++)
  		    {
  		        $result->data_seek($i);
  		        $row = $result->fetch_assoc();
  		        $prodotto = new Prodotto($row["CodProdotto"]);
  		        echo "<div id = \"wrapper\">";
  		        echo "<div align = \"center\">";
  		        echo $prodotto->getNomeProdotto();
  		        echo "<br />Categoria: ".$prodotto->getNomeCategoria();
  		        echo "<br />Quantità: ".$prodotto->getQuantita();
  		        echo "<br />Prezzo: ".$prodotto->getPrezzo()."€";
  		        echo "</div>";
  		        echo "</div>";
  		        echo "<br />";
  		    }
  		}
  		?>
	</body>
</html>

<?php
    include "footer.php";
?>