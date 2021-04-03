<?php
// DA FINIRE

include "header.php";
session_start();
?>

<html>
	<head>
		<title>Selezione corriere</title>
	</head>
	<body>
	<br/>
	    <?php
	    $db = DBConnection::getInstance();
	    $mysqli = $db->getConnection();
	    $sql_query = "SELECT COUNT(*) FROM corriere";
	    $result = $mysqli->query($sql_query);
	    $numeroCorrieri = 0;
	    if($result->num_rows)
	    {
	        $row = $result->fetch_assoc();
	        $numeroCorrieri = $row["COUNT(*)"];
	    }
	    
        for ($i = 1; $i <= $numeroCorrieri; $i++)
        {
            $corriere = new Corriere($i);
            ?>
	        <div id = "wrapper">
				<div  align = "center">
					Nome Corriere: <?php echo $corriere->getNome(); ?>
					<br />
					Prezzo:  <?php echo $corriere->getPrezzoSpedizione();?>
					<form action="Pagamento.php" method ="post">
					<input type = "hidden" name ="CodCorriere" value = "<?php echo $corriere->getCod();?>"/>
					<input type = "submit" value = "Seleziona"/>
					</form>
				</div>		
			</div>
			<br />
			<br/>
			<?php
        }
        ?>
	    <br/>
	</body>
</html>

<?php
    include "footer.php";
?>