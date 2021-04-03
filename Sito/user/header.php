<?php
session_start();
include __DIR__."/../header.php";
?>

<html>
	<body>
	<?php
	//Se l'utente non è loggato verrà reindirizzato alla home
	if (!isset($_COOKIE["login"]))
	{
	    header( "refresh:1;url=".Globals::WEBSITE."index.php" );
	    ?>
	    <div id = "wrapper">
	        <div align = "center">
	            Utente non autorizzato... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.
	        </div>
	    </div>
	    <?php
	}
	?>
	</body>
</html>	