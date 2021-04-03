<?php
include "header.php";
?>

<html>
	<head>
		<title>Cambio Password</title>
	</head>
	
	<body>
		<div id = "wrapper">
			<div align = "center">
				Un amministratore ha cambiato la password, devi modificarla obbligatoriamente per poter proseguire.
				<br />
				<form action="../command.php" method="post">
					<input type = "hidden" name = "comando" value = "changePassword" />
	           		Nuova password:  <input type = "password" name = "password" required ="required" pattern=".{1,}"/> <br />
	           		<input type = "submit" value = "Conferma"/>
	           	</form>
			</div>
		</div>
	</body>
</html>

<?php 
include "footer.php"
?>