<?php
require_once 'DBConnection.php';

class Prodotto
{
    private $codProdotto;
    private $nomeProdotto;
    private $codCategoria;
    private $nomeCategoria;
    private $prezzo;
    private $quantita;
    private $descrizione;
    private $hasImage;
    
    public function Prodotto(int $codProdotto)
    {
        $this->codProdotto = $codProdotto;
        
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "SELECT NomeProdotto, CodCategoria, NomeCategoria, Prezzo, Quantita, Descrizione, HasImage ".
                    " FROM prodotto, categoriaProdotti ".
                    " WHERE refCategoria = CodCategoria AND CodProdotto = ".$this->codProdotto;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $this->nomeProdotto = $row["NomeProdotto"];
            $this->codCategoria = $row["CodCategoria"];
            $this->nomeCategoria = $row["NomeCategoria"];
            $this->prezzo = $row["Prezzo"];
            $this->quantita = $row["Quantita"];
            $this->descrizione = $row["Descrizione"];
            
            if ($row["HasImage"])
                $this->hasImage = true;
            else
                $this->hasImage = false;
        }
    }
    
    public static function addProductIntoDB(String $nomeProdotto, int $codCategoria, float $prezzo, int $quantita, String $descrizione)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        //Controllo che non ci siano altri prodotti con lo stesso nome
        $sql_query = "SELECT * FROM prodotto WHERE NomeProdotto = ".$nomeProdotto;
        $result = $mysqli->query($sql_query);
        if ($result->num_rows)
            return false;
        
        $sql_query = "SELECT COUNT(*) FROM prodotto";
        $result = $mysqli->query($sql_query);
        $lastCode = 1;
        if ($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $lastCode = $row["COUNT(*)"] + 1;
        }
        $sql_query = "INSERT INTO prodotto(CodProdotto, NomeProdotto,RefCategoria,Prezzo,Quantita,Descrizione) ".
                     " VALUES(".($lastCode).", '".$nomeProdotto."','".$codCategoria."','".$prezzo.
                     "','".$quantita."','".$descrizione."')";
        return $mysqli->query($sql_query);;
    }
    
    public function getCodProdotto()
    {
        return $this->codProdotto;
    }
    
    public function getNomeProdotto()
    {
        return $this->nomeProdotto;
    }
    
    public function getCodCategoria()
    {
        return $this->codCategoria;
    }
    
    public function getNomeCategoria()
    {
        return $this->nomeCategoria;
    }
    
    public function getPrezzo()
    {
        return $this->prezzo;
    }
    
    public function getQuantita()
    {
        return $this->quantita;
    }
    
    public function getDescrizione()
    {
        return $this->descrizione;
    }
    
    public function hasImage()
    {
        return $this->hasImage;
    }
    
    public function setNomeProdotto(String $newNomeProdotto)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "UPDATE prodotto SET NomeProdotto = '".$newNomeProdotto."' WHERE CodProdotto = ".$this->getCodProdotto();
        if ($mysqli->query($sql_query))
        {
            $this->nomeProdotto = $newNomeProdotto;
            return true;
        }
        
        return false;
    }
    
    public function setCodCategoria(int $newCodCategoria)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "SELECT NomeCategoria FROM CategoriaProdotti WHERE CodCategoria = '".$newCodCategoria;
        $result = $mysqli->query($sql_query);
        
        $sql_query = "UPDATE prodotto SET RefCategoria = '".$newCodCategoria."' WHERE CodProdotto = ".$this->getCodProdotto();
        if ($mysqli->query($sql_query) && $result->num_rows)
        {
            $this->codCategoria = $newCodCategoria;
            $row = $result->fetch_assoc();
            $this->nomeCategoria = $row["NomeCategoria"];
            return true;
        }
        
        return false;
    }
    
    public function setNomeCategoria(String $newNomeCategoria)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "SELECT CodCategoria FROM CategoriaProdotti WHERE NomeCategoria = '".$newNomeCategoria;
        $result = $mysqli->query($sql_query);
        if ($result->num_rows)
        {
            $row = $result->fetch_assoc();
            return setCodCategoria($row["CodCategoria"]);
        }
        
        return false;
    }
    
    public function setPrezzo(float $newPrezzo)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "UPDATE prodotto SET Prezzo = '".$newPrezzo."' WHERE CodProdotto = ".$this->getCodProdotto();
        if ($mysqli->query($sql_query))
        {
            $this->prezzo = $newPrezzo;
            return true;
        }
        
        return false;
    }
    
    public function setQuantita(int $newQuantita)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "UPDATE prodotto SET Quantita = '".$newQuantita."' WHERE CodProdotto = ".$this->getCodProdotto();
        if ($mysqli->query($sql_query))
        {
            $this->quantita = $newQuantita;
            return true;
        }
        
        return false;
    }
    
    public function setDescrizione(String $newDescrizione)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "UPDATE prodotto SET descrizione = '".$newDescrizione."' WHERE CodProdotto = ".$this->getCodProdotto();
        if ($mysqli->query($sql_query))
        {
            $this->descrizione = $newDescrizione;
            return true;
        }
        
        return false;
    }
    
    public function setHasImage(bool $newHasImage)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        if ($newHasImage)
            $hasImage = 1;
        else
            $hasImage = 0;
        
        $sql_query = "UPDATE prodotto SET HasImage = '".$hasImage."' WHERE CodProdotto = ".$this->getCodProdotto()."";
        if ($mysqli->query($sql_query))
        {
            $this->hasImage = $newHasImage;
            return true;
        }
        
        return false;
    }
}

?>