<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Gestione Account</title>
	</head>
	<body>
		<div id = "wrapper">
			<div align = "center">
				<b>Nome:</b> <?php echo $_SESSION["utente"]->getNome(); ?> <a href="changeInfo.php?comando=nome"><button>Modifica</button></a><br /><br />
				<b>Cognome:</b> <?php echo $_SESSION["utente"]->getCognome(); ?> <a href="changeInfo.php?comando=cognome"><button>Modifica</button></a><br /><br />
				<b>Password:</b> <?php echo $_SESSION["utente"]->getPassword(); ?> <a href="changeInfo.php?comando=password"><button>Modifica</button></a><br /><br />
				<b>Data di nascita:</b> <?php echo $_SESSION["utente"]->getNascita(); ?> <a href="changeInfo.php?comando=nascita"><button>Modifica</button></a><br /><br />
				<b>Email:</b> <?php echo $_SESSION["utente"]->getEmail(); ?> <a href="changeInfo.php?comando=email"><button>Modifica</button></a><br /><br />
				<b>Domanda:</b> <?php echo $_SESSION["utente"]->getDomanda(); ?> <a href="changeInfo.php?comando=domanda"><button>Modifica</button></a><br /><br />
				<b>Risposta:</b> <?php echo $_SESSION["utente"]->getRisposta(); ?> <a href="changeInfo.php?comando=risposta"><button>Modifica</button></a><br /><br />
			</div>
		</div>
	</body>
</html>

<?php
    include "footer.php";
?>