<?php
session_start();
include __DIR__."/../header.php";
?>

<html>
	<body>
	<?php
	   $error = true;
	   
	   //Se l'utente loggato è un amministratore allora può proseguire, altrimenti verrà reindirizzato alla home
	   if (isset($_COOKIE["login"]) && $_SESSION["utente"]->getPermesso() == 2)
	       $error = false;
	   
	   if ($error)
	   {
	       //Redirect alla home
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