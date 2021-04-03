<?php
include "header.php"
?>

<html>
	<head>
		<Title>Registration</Title>
	</head>
	<body>
		<div id = "wrapper">
			<div align = "center">
				<form action="command.php" method="post">
					<input type = "hidden" name = "comando" value = "signup" />
        			Nome:  <input type = "text" name = "Nome" required ="required" pattern=".{1,}" value = "<?php echo $_GET['Nome']; ?>"/> <br />
        			Cognome: <input type = "text" name = "Cognome" required ="required" pattern=".{1,}" value = "<?php echo $_GET['Cognome'];?>"/> <br />
        			Data di nascita: <input type = "date" name = "DataNascita" required ="required" value = "<?php echo $_GET['DataNascita'];?>" placeholder = "1900-01-01"pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" 
									title="Enter a date in this format YYYY-MM-DD"/> <br />
        			Email: <input type = "email" name = "Email" required ="required" placeholder = "silvio@gmail.com" value = "<?php echo $_GET['Email'];?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/> <br />
        			Password: <input type = "password" name = "Password" required ="required" pattern=".{6,}" title="Sei o più caratteri"/> <br />
        			Conferma Password: <input type = "password" name = "ConfermaPassword" required ="required" pattern=".{6,}" title="Sei o più caratteri"/> <br />
        			Domanda: <input type = "text" name = "Domanda" required ="required" pattern=".{1,}" value = "<?php echo $_GET['Domanda'];?>"/> <br /> 
        			Risposta: <input type = "text" name = "Risposta" required ="required" pattern=".{1,}" value = "<?php echo $_GET['Risposta'];?>"/> <br />
        		
        			<input type = "submit" value = "invia risposta"/>
        		</form>
        	</div>
        </div>
	</body>
</html>

<?php 
include "footer.php"
?>

