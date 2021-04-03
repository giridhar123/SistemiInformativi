<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Modifica Account</title>
	</head>
	
	<body>
		<div id = "wrapper">
			<div align = "center">
				<form action="../command.php" method="post">
				<?php 
	               $comando = $_GET["comando"];
	   
	               switch ($comando)
	               {
	                    case "nome":
                            ?>Il tuo nome è: <?php echo $_SESSION["utente"]->getNome(); ?><br />
		    	       	   	<input type = "hidden" name = "comando" value = "changeNome" />
						   	Nuovo nome:  <input type = "text" name = "nome" required ="required" pattern=".{1,}"/> <br /><?php
	                       break;
    	                case "cognome":
	                        ?>Il tuo cognome è: <?php echo $_SESSION["utente"]->getCognome(); ?><br />
	   	            		<input type = "hidden" name = "comando" value = "changeCognome" />
	           				Nuovo cognome:  <input type = "text" name = "cognome" required ="required" pattern=".{1,}"/> <br /><?php
                            break;
                        case "password":
                            ?>
	   	            		<input type = "hidden" name = "comando" value = "changePassword" />
	           				Nuova password:  <input type = "password" name = "password" required ="required" pattern=".{1,}"/> <br /><?php
                            break;
	                    case "nascita":
       	                   ?>La tua data di nascita è: <?php echo $_SESSION["utente"]->getNascita(); ?><br />
	   	    	    	   <input type = "hidden" name = "comando" value = "changeNascita" />
	    	    	   	   Nuova data di nascita:  <input type = "text" name = "nascita" required ="required" pattern=".{1,}"/> <br /><?php
	                       break;
    	               case "email":
	                       ?>La tua e-mail è: <?php echo $_SESSION["utente"]->getEmail(); ?><br />
	   	        	   	   <input type = "hidden" name = "comando" value = "changeEmail" />
		    	       	   Nuova e-mail:  <input type = "text" name = "email" required ="required" pattern=".{1,}"/> <br /><?php
	                       break;
	                   case "domanda":
    	                   ?>La tua domanda di sicurezza è: <?php echo $_SESSION["utente"]->getDomanda(); ?><br />
		       	    	   <input type = "hidden" name = "comando" value = "changeDomanda" />
	    	    	   	   Nuova domanda di sicurezza:  <input type = "text" name = "domanda" required ="required" pattern=".{1,}"/> <br /><?php
	                       break;
    	               case "risposta":
	                       ?>La tua risposta di sicurezza è: <?php echo $_SESSION["utente"]->getRisposta(); ?><br />
			           	   <input type = "hidden" name = "comando" value = "changeRisposta" />
		    	       	   Nuova risposta di sicurezza:  <input type = "text" name = "risposta" required ="required" pattern=".{1,}"/> <br /><?php
	                      break;
	               }
	           ?>
		   	   		<input type = "submit" value = "Conferma"/>
				</form>
			</div>
		</div>
	</body>
</html>

<?php
    include "footer.php";
?>