<?php
require_once "DBConnection.php";

class IndirizzoFatturazione
{
    private $codUtente;
    private $codIndirizzo;
    private $indirizzo;
    private $citta;
    private $cap;
    private $isDefault;
    
    public function IndirizzoFatturazione(int $codIndirizzo, int $codUtente)
    {
        $this->codUtente = $codUtente;
        $this->codIndirizzo = $codIndirizzo;
        
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "SELECT Indirizzo, Citta, CAP, Preferito FROM indirizzoFatturazione WHERE CodFatturazione = ".$this->codIndirizzo." AND refUtente = ".$codUtente;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $this->indirizzo = $row["Indirizzo"];
            $this->citta = $row["Citta"];
            $this->cap = $row["CAP"];
            
            if ($row["Preferito"] == 1)
                $this->isDefault = true;
            else
                $this->isDefault = false;
        }
    }
    
    public static function addIndirizzoFatturazioneIntoDB(int $codUtente, String $indirizzo, String $citta, String $cap)
    {        
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "SELECT * FROM indirizzoFatturazione ".
                     " WHERE Indirizzo = '".$indirizzo."' AND Citta = '".$citta."' AND Cap = '".$cap."' AND RefUtente = ".$codUtente;
        $result = $mysqli->query($sql_query);
        if ($result->num_rows)
            return false;
       
        $sql_query = "SELECT COUNT(*) FROM indirizzoFatturazione WHERE RefUtente = ".$codUtente;
        $codice = 1;
        $result = $mysqli->query($sql_query);
        if ($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $codice = $row["COUNT(*)"] + 1;
        }
        
        $preferito = 0;
        if ($codice == 1)
            $preferito = 1;
        
        $sql_query = "INSERT INTO indirizzoFatturazione (RefUtente, Indirizzo, Citta, CAP, CodFatturazione, Preferito) VALUES ".
                     "(".$codUtente.", '".$indirizzo."', '".$citta."', '".$cap."', ".$codice.", ".$preferito.")";
        return $mysqli->query($sql_query);
    }
    
    public static function deleteFromDB(int $codUtente, int $codFatturazione)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "DELETE FROM indirizzoFatturazione WHERE CodFatturazione = ".$codFatturazione." AND RefUtente = ".$codUtente;
        return $mysqli->query($sql_query);
    }
    
    public function getCodIndirizzo()
    {
        return $this->codIndirizzo;
    }
    
    public function getIndirizzo()
    {
        return $this->indirizzo;
    }
    
    public function getCitta()
    {
        return $this->citta;
    }
    
    public function getCap()
    {
        return $this->cap;
    }
    
    public function isDefault()
    {
        return $this->isDefault;
    }
    
    public function setIndirizzo(String $newIndirizzo)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE indirizzoFatturazione SET Indirizzo = '".$newIndirizzo."' WHERE CodFatturazione = ".$this->codIndirizzo." AND refUtente = ".$this->codUtente;
        if($mysqli->query($sql_query))
        {
            $this->indirizzo = $newIndirizzo;
            return true;
        }
        
        return false;
    }
    
    public function setCitta(String $newCitta)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE indirizzoFatturazione SET citta = '".$newCitta."' WHERE CodFatturazione = ".$this->codIndirizzo." AND refUtente = ".$this->codUtente;
        if($mysqli->query($sql_query))
        {
            $this->citta = $newCitta;
            return true;
        }
        
        return false;
    }
    
    public function setCap(String $newCap)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE indirizzoFatturazione SET cap = '".$newCap."' WHERE CodFatturazione = ".$this->codIndirizzo." AND refUtente = ".$this->codUtente;
        if($mysqli->query($sql_query))
        {
            $this->cap = $newCap;
            return true;
        }
        
        return false;
    }
    
    public function setDefault(bool $isDefault)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $preferito = 0;
        if ($isDefault)
            $preferito = 1;
        
        $sql_query = "UPDATE indirizzoFatturazione SET preferito = '".$preferito."' WHERE CodFatturazione = ".$this->codIndirizzo." AND refUtente = ".$this->codUtente;
        if($mysqli->query($sql_query))
        {
            $this->isDefault = $isDefault;
            return true;
        }
        
        return false;
    }
}
?>