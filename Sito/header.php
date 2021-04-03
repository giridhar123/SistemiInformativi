<?php
session_start();
require_once __DIR__."/globals.php";
require_once __DIR__."/Classi/DBConnection.php";
require_once __DIR__."/Classi/Utente.php";
require_once __DIR__."/Classi/Prodotto.php";
require_once __DIR__.'/Classi/indirizzoFatturazione.php';
require_once __DIR__.'/Classi/indirizzoSpedizione.php';
require_once __DIR__.'/Classi/carta.php';
require_once __DIR__.'/Classi/corriere.php';
require_once __DIR__.'/Classi/Ordine.php';
require_once __DIR__.'/Classi/fattura.php';

$db = DBConnection::getInstance();
$mysqli = $db->getConnection();
$sql_query = "SELECT NomeCategoria FROM categoriaProdotti";
$result = $mysqli->query($sql_query);
$row = $result->fetch_assoc();
?>
<html>
	<head>
	<?php echo "<link rel=\"stylesheet\" href = \"".Globals::WEBSITE."/css/style.css\">"; ?>
	</head>
	<body>
		<ul id="menu">
    		<li><a href=<?php echo Globals::WEBSITE."index.php" ?>>Home</a></li>
    		<li><a href=<?php echo Globals::WEBSITE."chiSiamo.php" ?>>Chi siamo</a></li>
    		<li>
    			<a href="#">Prodotti</a>
    			<ul>
    				<?php for ($i = 0; $i < $result->num_rows; $i++)
	                {
	                    $result->data_seek($i);
	                    $row = $result->fetch_assoc();
	                    ?>
    					<li><a href="<?php echo Globals::WEBSITE?>categoriaSelezionata.php?nomeCategoria=<?php echo $row["NomeCategoria"];?>"><?php echo $row["NomeCategoria"];?></a></li>
    					<?php 
	                }
       				?>
    			</ul>
    		</li>
    		<?php
    		//Se l'utente non è loggato
		    if (!isset($_COOKIE["login"]))
		    {
               ?>
        	   <li><a href=<?php echo Globals::WEBSITE."login.php" ?>>Login</a></li>
        	   <li><a href=<?php echo Globals::WEBSITE."signup.php" ?>>Registrati</a></li>
               <?php
		    }
		    else //Se l'utente è loggato
		    {
		        $_SESSION["utente"] = new Utente($_COOKIE["login"]);
		        
                ?>
		        <li><a href=<?php echo Globals::WEBSITE."user/carrello.php" ?>>Carrello
		        <?php 
		            $carrello = $_SESSION["utente"]->getCarrello();
		            if (count($carrello) > 0)
		            {	
		                $prodottiTotali = 0;
		                for ($i = 0; $i < count($carrello); $i++)
		                    $prodottiTotali += $carrello[$i][1];
		                
		                echo $prodottiTotali;
		            }
		        ?>
		        </a></li>
		        <li>
		        	<a href="#"><?php echo $_SESSION["utente"]->getNome();?></a>
    				<ul>	
    					<li><a href=<?php echo Globals::WEBSITE."user/index.php" ?>>Il mio Account</a></li>
    					<li><a href=<?php echo Globals::WEBSITE."user/ordini.php" ?>>I miei ordini</a></li>
    					<li><a href=<?php echo Globals::WEBSITE."command.php?comando=logout" ?>>Logout</a></li>
    				</ul>
    			</li>	        
		        <?php
		    }
		    ?>
		</ul>
		
		<div align = "center">
		    <form action= <?php echo Globals::WEBSITE."search.php" ?> method="get">
			<input type = "text" name = "NomeProdotto" required ="required" pattern=".{1,}" placeholder = "Cerca"/>
			<input type = "submit" value = "cerca"/>
			</form>
		</div>
		
		<?php
		//Se l'utente è loggato e non mi trovo nella pagina admin/cambioPass.php
		if (isset($_COOKIE["login"]) && "admin/".basename($_SERVER['PHP_SELF']) != "admin/adminCambioPass.php")
		{
		    $utente = $_SESSION["utente"];
		    if ($utente->hasPasswordCambiata())
		    {
		    ?>
				<div id = "wrapper">
					<div align = "center">
						Un amministratore ha cambiato la password, devi modificarla obbligatoriamente per poter proseguire.<br />
						Verrai reindirrizzato alla pagina di modifica password a breve.						
					</div>
				</div>
				<?php
				header( "refresh:5;url=".Globals::WEBSITE."user/adminCambioPass.php" );
		    }
		}
		?>
		<br />
	</body>
</html>	