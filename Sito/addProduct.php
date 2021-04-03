
<html>
<head>
<Title>Aggiungi prodotto</Title>
</head>
<body>
<?php 
include'select_value.php';
require_once "DBConnection.php";
$db = DBConnection::getInstance();
$mysqli = $db->getConnection();
$sql_query = "select NomeCategoria from categoriaProdotti order by NomeCategoria";
$result = $mysqli->query($sql_query);


?>

<form action="command.php" method="post">

	<input type = "hidden" name = "comando" value = "addProduct" />
	Nome prodotto:  <input type = "text" name = "NomeProdotto" required ="required" pattern=".{1,}"/> <br />
	Prezzo: <input type = "text" name = "Prezzo" required ="required" min ="1" pattern="\d*" /> <br />
	Quantità: <input type = "number" name = "Quantita" required ="required" pattern=".{1,}" min = "1"/> <br />
	Categoria: 
	<!-- La select non mette nulla nella post -->
	<select name = "Categoria">
	
	<?php
	if ($result->num_rows > 0)
	{
	   for ($i = 0; $i < $result->num_rows; $i++)
	   {
	   $result->data_seek($i);
	   $array = $result->fetch_assoc();
	   ?>
 	   <option value=""><?php echo $array["NomeCategoria"]?></option>
 		<?php
	   }
	}
  
  ?>
</select>
   <input type = "submit" value = "aggiungi prodotto"/>
                        
</form>


</body>
</html>







