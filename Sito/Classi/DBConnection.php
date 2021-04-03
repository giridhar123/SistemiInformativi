<?php
require_once __DIR__."/../globals.php";
class DBConnection
{
   /**
   * La variabile statica privata che conterrà l’istanza univoca
   * della nostra classe.
   */
   private static $_instance = null;
   private $_connection;
   
   /**
   * Il costruttore in cui ci occuperemo di inizializzare la nostra
   * classe. E’ opportuno specificarlo come privato in modo che venga
   * visualizzato automaticamente un errore dall’interprete se si cerca
   * di istanziare la classe direttamente.
   */
   private function DBConnection()
   {
       $this->_connection = new mysqli(Globals::DB_HOSTNAME, Globals::DB_USERNAME, Globals::DB_PASSWORD, Globals::DB_NAME);
       if (mysqli_connect_error()) {
           trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
               E_USER_ERROR);   
       }
   }
   
   /**
   * Il metodo statico che si occupa di restituire l’istanza univoca della classe.
   * per facilitare il riutilizzo del codice in altre situazioni, si frutta la
   * costante __CLASS__ che viene valutata automaticamente dall’interprete con il
   * nome della classe corrente (ricordo che “new $variabile” crea un’istanza della classe
   * il cui nome è specificato come stringa all’interno di $variabile)
   */
   public static function getInstance()
   {
       if(self::$_instance == null) { // If no instance then make one
           self::$_instance = new DBConnection();
       }
       return self::$_instance;
   }
   
   public function getConnection() {
       return $this->_connection;
   }
}

?>