<?php 
include "header.php";
?>

<html>
	<head>
		<Title>Aggiungi prodotto</Title>
	</head>

	<body>
		<div id = "wrapper">
			<div  align = "center">
				<form  action= <?php echo Globals::WEBSITE."command.php" ?> method="post" enctype="multipart/form-data" >
				<fieldset>
				<legend>Aggiunta prodotto:</legend>
				<input type = "hidden" name = "comando" value = "addProduct" />
				Nome prodotto:  <input type = "text" name = "NomeProdotto" required ="required" pattern=".{1,}"/> <br />
				Prezzo: <input type = "text" name = "Prezzo" required ="required" min ="1" pattern="\d*" /> <br />
				Quantità: <input type = "number" name = "Quantita" required ="required" pattern=".{1,}" min = "1"/> <br />
				Categoria: 
				<select name = "Categoria"  onchange="printValue(this.value)">
				<?php
				$db = DBConnection::getInstance();
				$mysqli = $db->getConnection();
				$sql_query = "select NomeCategoria from categoriaProdotti order by CodCategoria";
				$result = $mysqli->query($sql_query);
        	    if ($result->num_rows > 0)
	            {
    	           for ($i = 0; $i < $result->num_rows; $i++)
	               {
        	            $result->data_seek($i);
	                    $array = $result->fetch_assoc();
	                    ?>
 	   		    		<option value="<?php echo ($i + 1); ?>"><?php echo $array["NomeCategoria"]?>
 			    		<?php
	               }
	           }
                ?>
				</select><br />
				<input type="radio" name="scelta" value="si"> Seleziona per caricare un immagine<br>
				
				Scegli immagine:<br /> <input type ="file" name= "Immagine"/><br />
				<textarea name ="Descrizione" required = "required" rows="5" cols="40" placeholder ="Inserisci una descrizione"></textarea><br />
   				<input type = "submit" value = "aggiungi prodotto"/> 
   				</fieldset>                      
				</form>
				
				
			</div>
		</div>
	</body>
</html>

<?php
include "footer.php"
?>







