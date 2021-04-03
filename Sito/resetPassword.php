<?php
include "header.php";
?>

<html>
	<head>
		<Title>Reset password</Title>
	</head>
	
	<body>
		<div id = "wrapper">
			<div align = "center">
				<form action="" method="post">
				Email: <input type = "email" name = "EmailUtente" required ="required" placeholder = "silvio@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value = "<?php echo $_POST['EmailUtente']?>"/>
				<input type = "submit" value = "Submit"/>
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
    					<form action= "" method="post">
    					<input type = "hidden" name = "EmailUtente" value = "<?php echo $utente->getEmail();?>" />
        				Domanda: <?php echo $utente->getDomanda();?> <br /> 
        				Risposta: <input type = "text" name = "Risposta" required ="required" pattern=".{1,}" value = "<?php echo $_POST['Risposta']?>" /> <br />
        				<input type = "submit" value = "Submit"/>
                		</form>
						<?php 
				        if(isset($_POST['Risposta']))
				        {
				            if ($utente->getRisposta() == $_POST['Risposta'])
				            {
				                ?>
				            	<form action= <?php echo Globals::WEBSITE."command.php"?> method = "post">
				                <input type = "hidden" name = "comando" value = "resetPassword" />
				            	<input type = "hidden" name = "EmailUtente" value = "<?php echo $_POST['EmailUtente']?>" />
				          	  
								Nuova Password: <input type = "password" name = "Password" required ="required" pattern=".{6,}" title="Sei o più caratteri"/> <br />
        						Conferma Password: <input type = "password" name = "ConfermaPassword" required ="required" pattern=".{6,}" title="Sei o più caratteri"/> <br />				            
				                <input type = "submit" value = "Cambia Password"/>
				        	    </form>
				        	    <?php
				            }
				            else
				                echo "Risposta non corretta";				        
				        }
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