<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Account</title>
	</head>
	<body>
		<div id = "wrapper">
			<div align ="center">
				<a href = "manageAccount.php">Gestione Account</a><br /><br />
				<a href = "indirizziSpedizione.php">Indirizzi di spedizione</a><br /><br />
				<a href = "indirizziFatturazione.php">Indirizzi di fatturazione</a><br /><br />
				<a href = "modalitaPagamento.php">Modalità di pagamento</a><br /><br />
			</div>
		</div>
	</body>
</html>

<?php
    include "footer.php";
?>