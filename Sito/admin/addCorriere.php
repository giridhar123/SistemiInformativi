<?php
include "header.php";
?>

<html>
	<head>
		<Title>Aggiungi nuovo corriere</Title>
	</head>

	<body>
		<div id = "wrapper">
			<div align = "center">
				<form action= <?php echo Globals::WEBSITE."command.php" ?> method="post">
				<input type = "hidden" name = "comando" value = "addCorriere" />
				Nome corriere:  <input type = "text" name = "NomeCorriere" required ="required" pattern=".{1,}"/> <br />
				Prezzo spedizione: <input type = "text" name = "PrezzoSpedizione" required ="required" min ="1" pattern="\d*" /> <br />
   				<input type = "submit" value = "aggiungi corriere"/>                       
				</form>
			</div>
		</div>
	</body>
</html>

<?php
include "footer.php"
?>







