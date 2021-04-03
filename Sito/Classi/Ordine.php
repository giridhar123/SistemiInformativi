<?php
require_once "DBConnection.php";
require_once "indirizzoSpedizione.php";
require_once "indirizzoFatturazione.php";
require_once "corriere.php";
require_once "carta.php";
require_once "Prodotto.php";

class Ordine
{
    private $codAcquisto;
    private $codSpedizione;
    private $codFatturazione;
    private $codCorriere;
    private $codCarta;
    private $codUtente;
    private $data;
    private $sconto;
    private $prodotti;
    
    public function Ordine($codAcquisto, $codUtente)
    {
        $this->codAcquisto = $codAcquisto;
        $this->codUtente = $codUtente;
        
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "SELECT RefSpedizione, RefFatturazione, RefCorriere, RefCarta, Data, Sconto ".
		             "FROM acquisto WHERE codAcquisto = ".$codAcquisto." AND RefUtente = ".$codUtente;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $this->codSpedizione = $row["RefSpedizione"];
            $this->codFatturazione = $row["RefFatturazione"];
            $this->codCorriere = $row["RefCorriere"];
            $this->codCarta = $row["RefCarta"];
            $this->sconto = $row["Sconto"];
            
            $dataSplitted = explode("-", $row["Data"]);
            $this->data =  $dataSplitted[2]."-".$dataSplitted[1]."-".$dataSplitted[0];
        }
        
        $this->prodotti = array();
        $sql_query = "SELECT RefProdotto, Quantita ".
                    "FROM infoAcquisto WHERE refAcquisto = ".$codAcquisto." AND RefUtente = ".$codUtente;
        
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            for ($i = 0; $i < $result->num_rows; $i++)
            {
                $result->data_seek($i);
                $row = $result->fetch_assoc();
                $this->prodotti[$i][0] = $row["RefProdotto"];
                $this->prodotti[$i][1] = $row["Quantita"];
            }
        }            
    }
    
    public function getIndirizzoSpedizione()
    {
        return new IndirizzoSpedizione($this->codSpedizione, $this->codUtente);
    }
    
    public function getIndirizzoFatturazione()
    {
        return new IndirizzoFatturazione($this->codFatturazione, $this->codUtente);
    }
    
    public function getCorriere()
    {
        return new Corriere($this->codCorriere);
    }
    
    public function getCarta()
    {
        return new Carta($this->codCarta, $this->codUtente);
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function getSconto()
    {
        return $this->sconto;
    }
    
    public function getPrezzoTotale()
    {
        $prezzoTotale = 0;
        for ($i = 0; $i < count($this->prodotti); $i++)
        {
            $prodotto = new Prodotto($this->prodotti[$i][0]);
            $quantita = $this->prodotti[$i][1];
            $prezzoTotale += $prodotto->getPrezzo() * $quantita;
        }
        
        return $prezzoTotale;
    }
    
    public function getPrezzoScontato()
    {
        $prezzoTotale = $this->getPrezzoTotale();
        return $prezzoTotale - ($prezzoTotale * $this->getSconto() / 100);
    }
    
    public function getProdotti()
    {
        return $this->prodotti;
    }
}
?>