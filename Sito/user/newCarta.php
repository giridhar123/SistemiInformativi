<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Modalità di pagamento</title>
	</head>
	<body>
	    <div id = "wrapper">
	    	<div align = "center">
	    	<?php 
	    		if(isset($_COOKIE['login']))
	    		{
 	    		    $db = DBConnection::getInstance();
 	    		    $mysqli = $db->getConnection(); 	    		   
	    		    ?>
	    		    <form action="<?php echo Globals::WEBSITE; ?>/command.php" method = "post">
	    		    	<input type = "hidden" name = "comando" value = "newCarta" />
	    		    	Numero carta: <input type = "text" name = "NumeroCarta" required ="required" min ="1" pattern="[0-9]{16}" /> <br />
 	    		    	Tipo: <select name = "CodTipo">
						<?php
 					    $sql_query = "SELECT NomeTipo, CodTipo FROM tipoCarta ORDER BY CodTipo";
 					    $result = $mysqli->query($sql_query);
 					    if($result->num_rows)
 					    {
	                       for ($i = 0; $i < $result->num_rows; $i++)
	                       {
	                          $result->data_seek($i);
 	                          $row = $result->fetch_assoc();
 	                          ?>
 	   				  	   	  <option value="<?php echo ($i + 1); ?>"><?php echo $row['NomeTipo'];
 	                        }
	                     }
	                     ?>
	                     </select>
	                     <input type = "submit" value = "aggiungi prodotto"/>
	                	 <?php 
	    		  }
            ?>
	    			</form>
	    	</div>
	    </div>
	    <br/>
	</body>
</html>

<?php
    include "footer.php";
?>