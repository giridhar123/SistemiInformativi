<?php
require_once __DIR__."/globals.php";
?>
<html>
	<body>
	<div align = "center">
		<?php
		  session_start();
		  $db = DBConnection::getInstance();
		  $mysqli = $db->getConnection();
		  $sql_query = "SELECT COUNT(*) FROM prodotto";
		  $result = $mysqli->query($sql_query);
		  $products = 0;
		  if ($result->num_rows)
		  {
		      $row = $result->fetch_assoc();
		      $products = $row["COUNT(*)"];
		  }
		  $numPagina = $products / 10;
		  if(($products % 10)!= 0)
		  {
		      $numPagina++;
		  }
		  for ($i =1; $i <= $numPagina; $i++) {
		      ?>
              <a href=<?php echo Globals::WEBSITE."index.php?numPagina=$i" ?>><?php echo $i; ?></a>
        
        <?php 
        
        
    }
    ?>
	</div>
	</body>
</html>
<?php 
include "footer.php"
?>