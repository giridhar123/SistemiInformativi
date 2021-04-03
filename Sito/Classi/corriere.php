<?php
require_once 'DBConnection.php';

class Corriere
{
    private $cod;
    private $nome;
    private $prezzo;
    
    public function Corriere(int $cod)
    {
        $this->cod = $cod;
        
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "SELECT Nome, PrezzoSpedizione FROM corriere WHERE codCorriere = ".$this->cod;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $this->nome = $row["Nome"];
            $this->prezzo = $row["PrezzoSpedizione"];
        }
    }
    
    public static function addCorriereIntoDb(String $nomeCorriere, float $prezzoSpedizione)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        //Controllo che non ci siano altri corrierio con lo stesso nome
        $sql_query = "SELECT * FROM corriere WHERE NomeCorriere = ".$nomeCorriere;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
            return false;
        
        $codCorriere = 1;
        $sql_query = "SELECT COUNT(*) FROM corriere";
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $codCorriere = $row["COUNT(*)"] + 1;
        }
        
        $sql_query = "INSERT INTO Corriere (CodCorriere, Nome, PrezzoSpedizione) VALUES (".$codCorriere.", '".$nomeCorriere."', ".$prezzoSpedizione.")";
        return $mysqli->query($sql_query);;
    }
    
    public function getNome()
    {
        return $this->nome;
    }
    public function getCod()
    {
        return $this->cod;
    }
    
    public function getPrezzoSpedizione()
    {
        return $this->prezzo;
    }
    
    public function setNome(String $newNome)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "UPDATE corriere SET Nome = '".$newNome."' WHERE CodCorriere = ".$this->getCod();
        if ($mysqli->query($sql_query))
        {
            $this->nome = $newNome;
            return true;
        }
        
        return false;
    }
    
    public function setPrezzo(String $newPrezzo)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "UPDATE corriere SET PrezzoSpedizione = '".$newPrezzo."' WHERE CodCorriere = ".$this->getCod();
        if ($mysqli->query($sql_query))
        {
            $this->prezzo = $newPrezzo;
            return true;
        }
        
        return false;
    }
}
?>