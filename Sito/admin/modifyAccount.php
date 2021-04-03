<?php 
include "header.php";
?>

<html>
	<head>
		<Title>Modifica account utente</Title>
	</head>
	
	<body>
		<div id = "wrapper">
			<div align = "center">
				<form action="" method="post">
				Email utente: <input type = "email" name = "EmailUtente" required ="required" placeholder = "silvio@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value = "<?php echo $_POST["EmailUtente"]; ?>"/>
				<input type = "submit" value = "invia risposta"/>
				</form>
		
				<?php 
                if (isset($_POST['EmailUtente']))
                {
                    $db = DBConnection::getInstance();
                    $mysqli = $db->getConnection();
                    $sql_query = "SELECT CodUtente FROM utente where Email = '".$_POST['EmailUtente']."'";
                    $result = $mysqli->query($sql_query);
                    if($result->num_rows)
                    {
                        $row = $result->fetch_assoc();
                        $utente = new Utente($row["CodUtente"]);
                        ?>
    					<form action= <?php echo Globals::WEBSITE."command.php" ?> method="post">
						<input type = "hidden" name = "comando" value = "modifyAccount" />
						<input type = "hidden" name = "EmailUtente" value = "<?php echo $utente->getEmail();?>" />
        				Nome:  <input type = "text" name = "Nome" required ="required" pattern=".{1,}" value = "<?php echo $utente->getNome(); ?>"/> <br />
        				Cognome: <input type = "text" name = "Cognome" required ="required" pattern=".{1,}" value = "<?php echo $utente->getCognome();?>"/> <br />
        				Data di nascita: <input type = "date" name = "DataNascita" required ="required" value = "<?php echo $utente->getNascita();?>" placeholder = "1900-01-01"pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" 
										title="Enter a date in this format YYYY-MM-DD"/> <br />
        				Email: <input type = "email" name = "Email" required ="required" placeholder = "silvio@gmail.com" value = "<?php echo $utente->getEmail();?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/> <br />
        				Password: <input type = "password" name = "Password" pattern=".{6,}" title="Sei o più caratteri"/> <br />
        				Conferma Password: <input type = "password" name = "ConfermaPassword" pattern=".{6,}" title="Sei o più caratteri"/> <br />
        				Domanda: <input type = "text" name = "Domanda" required ="required" pattern=".{1,}" value = "<?php echo $utente->getDomanda();?>"/> <br /> 
        				Risposta: <input type = "text" name = "Risposta" required ="required" pattern=".{1,}" value = "<?php echo $utente->getRisposta();?>"/> <br />
        				Permesso:
        				<select name = "CodPermesso"  onchange="printValue(this.value)">
        					<option value="1">Utente
        					<option value="2">Amministratore
						</select>
						<br />
        				<input type = "submit" value = "Modifica Dati"/>
                		</form>
						<?php  
                    }
                    else
                        echo "Utente non trovato";
                }
                ?>
        	</div>
        </div>
	</body>
</html>

<?php
include "footer.php"
?>







