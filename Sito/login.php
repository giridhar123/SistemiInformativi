<?php 
include "header.php";
?>

<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<div id = "wrapper">
		<div align ="center">
		<?php
            if (!isset($_COOKIE["login"]))
            {
                ?>
    			<form action = "command.php" method = "post">
				<input type = "hidden" name = "comando" value = "login" />
				Email:
				<input type = "text" name = "email" value = "" />
				Password:
				<input type = "password" name = "password" value = "" /><br />
				<input type = "submit" value = "Accedi" />
				</form>
				<a href="resetPassword.php" >Password dimenticata</a>
				<?php
            }
        else
        {
            ?>Utente già loggato
    		<?php
        } ?>
        </div>
		</div>
	</body>
</html>

<?php 
include "footer.php";
?>