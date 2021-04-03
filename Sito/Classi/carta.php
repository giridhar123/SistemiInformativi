<?php
require_once 'DBConnection.php';

class Carta
{
    private $codCarta;
    private $codUtente;
    private $codTipo;
    private $nomeTipo;
    private $numero;
    
    public function Carta(int $codCarta, int $codUtente)
    {
        $this->codCarta = $codCarta;
        $this->codUtente = $codUtente;
        
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "SELECT CodTipo, NomeTipo, NumeroCarta ".
                     " FROM carta, tipoCarta ".
                     " WHERE refTipo = codTipo AND CodCarta = ".$this->codCarta." AND refUtente = ".$this->codUtente;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $this->codTipo = $row["CodTipo"];
            $this->nomeTipo = $row["NomeTipo"];
            $this->numero = $row["NumeroCarta"];
        }
    }
    
    public static function addCartaIntoDb(int $codUtente, int $codTipo, String $numero)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        //Controllo che non ci siano carte uguali per quell'account
        $sql_query = "SELECT * FROM carta WHERE Numero = '".$numero."', AND codTipo = ".$codTipo." AND RefUtente = ".$codUtente;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
            return false;
        
        $codCarta = 1;
        $sql_query = "SELECT COUNT(*) FROM carta WHERE RefUtente = ".$codUtente;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $codCarta = $row["COUNT(*)"] + 1;
        }
        
        $sql_query = "INSERT INTO carta (CodCarta, RefUtente, RefTipo, NumeroCarta) VALUES ".
            " (".$codCarta.", ".$codUtente.", ".$codTipo.", '".$numero."')";
        return $mysqli->query($sql_query);
    }
    
    public static function deleteCarta(int $codUtente, int $codCarta)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $codCarta = 1;
        $sql_query = "SELECT COUNT(*) FROM carta WHERE RefUtente = ".$codUtente;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $numCarte = $row["COUNT(*)"];
        }
        $sql_query = "DELETE FROM carta WHERE RefUtente = ".$codUtente." AND CodCarta = ".$codCarta."";
        if($result = $mysqli->query($sql_query))
        {
            for($i = ($numCarte - $codCarta); $i<= $numCarte; $i++)
            {
                $sql_query = "UPDATE carta SET CodCarta = ".($i-1)." WHERE CodCarta = ".$i."";
                $result = $mysqli->query($sql_query);
            }
            
            return 1;
        }
        else
            return 0;
        }
    public function getCodCarta()
    {
        return $this->codCarta;
    }
    
    public function getCodUtente()
    {
        return $this->codUtente;
    }
    
    public function getCodTipo()
    {
        return $this->codTipo;
    }
    
    public function getNomeTipo()
    {
        return $this->nomeTipo;
    }
    
    public function getNumero()
    {
        return $this->numero;
    }
}
?>