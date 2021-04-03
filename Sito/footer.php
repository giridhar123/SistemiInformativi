<?php
require_once __DIR__."/globals.php";
?>
<html>
	<body>
	<div align = "center">
		<?php
		  session_start();
		  
		  if (isset($_COOKIE["login"]))
		  {
		      if ($_SESSION["utente"]->getPermesso() == 2)
		      {
		          ?>
		          <a href =<?php echo Globals::WEBSITE."admin/index.php" ?>>Amministrazione</a>
		          <?php
		      }
		  }
		  ?>
	</div>
	</body>
</html>