<?php
require_once 'DBConnection.php';
require_once "Prodotto.php";

class Utente
{
    private $id;
    private $password;
    private $nome;
    private $cognome;
    private $nascita;
    private $email;
    private $permesso;
    private $domanda;
    private $risposta;
    private $passwordCambiata;
    private $carrello;
    private $indirizziFatturazioneTotale;
    private $indirizziSpedizioneTotale;
    private $indirizzoFatturazionePreferito;
    private $indirizzoSpedizionePreferito;
    private $numeroCarteTotali;
    private $ordiniEffettuati;
    
    public function Utente(int $id)
    {
        $this->id = $id;
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "SELECT Password, Nome, Cognome, dataNascita, email, refpermesso, domanda, risposta, PasswordCambiata FROM utente WHERE codUtente = ".$this->id;
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $this->password = $row["Password"];
            $this->nome = $row["Nome"];
            $this->cognome = $row["Cognome"];
            $this->nascita = $row["dataNascita"];
            $this->email = $row["email"];
            $this->permesso = $row["refpermesso"];
            $this->domanda = $row["domanda"];
            $this->risposta = $row["risposta"];

            if ($row["PasswordCambiata"] == 0)
                $this->passwordCambiata = false;
            else 
                $this->passwordCambiata = true;
        }
        
        $this->carrello = array();
        $sql_query = "SELECT codProdotto, carrello.quantita FROM carrello, prodotto WHERE RefProdotto = codProdotto AND refutente = ".$this->id;
        $result = $mysqli->query($sql_query);
        
        for ($i = 0; $i < $result->num_rows; $i++)
        {
            $result->data_seek($i);
            $row = $result->fetch_assoc();
            $this->carrello[$i][0] = $row["codProdotto"];
            $this->carrello[$i][1] = $row["quantita"];
        }
        
        $this->indirizziFatturazioneTotale = 0;
        $sql_query = "SELECT COUNT(*) FROM indirizzoFatturazione WHERE refutente = ".$this->id;
        $result = $mysqli->query($sql_query);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $this->indirizziFatturazioneTotale = $row["COUNT(*)"];
        }
        
        $this->indirizziSpedizioneTotale = 0;
        $sql_query = "SELECT COUNT(*) FROM indirizzoSpedizione WHERE refutente = ".$this->id;
        $result = $mysqli->query($sql_query);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $this->indirizziSpedizioneTotale = $row["COUNT(*)"];
        }
        
        $this->numeroCarteTotali = 0;
        $sql_query = "SELECT COUNT(*) FROM carta WHERE refutente = ".$this->id;
        $result = $mysqli->query($sql_query);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $this->numeroCarteTotali = $row["COUNT(*)"];
        }
        
        $this->ordiniEffettuati = 0;
        $sql_query = "SELECT COUNT(*) FROM acquisto WHERE refutente = ".$this->id;
        $result = $mysqli->query($sql_query);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $this->ordiniEffettuati = $row["COUNT(*)"];
        }
    }
    
    public static function CreaUtenteDaEmail(String $email)
    {        
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "SELECT CodUtente FROM utente WHERE email = '".$email."'";
        $result = $mysqli->query($sql_query);
        
        if($result->num_rows)
        {   
            $row = $result->fetch_assoc();
            return new Utente($row["CodUtente"]);
        }
        return null;
    }
    
    public static function addUtenteToDb(String $nome, String $cognome, String $dataNascita, String $email, String $password, String $domanda, String $risposta)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        //Controllo che non ci siano altri utenti con la stessa e-mail
        $sql_query = "SELECT * FROM utente WHERE Email = '".$email."'";
        $result = $mysqli->query($sql_query);
        if ($result->num_rows)
            return false;
        
        //Cerco il valore di codutente
        $codUtente = 1;
        $sql_query = "SELECT COUNT(*) FROM utente";
        $result = $mysqli->query($sql_query);
        $row = $result->fetch_assoc();
        $codUtente = $row["COUNT(*)"] + 1;
        
        $sql_query = "INSERT INTO utente (CodUtente,Nome,Cognome,DataNascita,Email,Password,RefPermesso,Domanda,Risposta,PasswordCambiata)
                    VALUES ".
                    "(".$codUtente.", '".$nome."','".$cognome."','".$dataNascita."','".$email."','".$password."', 1 ,'".$domanda."','".$risposta."',false)";
        return $mysqli->query($sql_query);;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getNome()
    {
        return $this->nome;
    }
    
    public function getCognome()
    {
        return $this->cognome;    
    }
    public function getCod()
    {
        return $this->id;
    }
    
    public function getNascita()
    {
        return $this->nascita;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    
    public function getPermesso()
    {
        return $this->permesso;
    }
    
    public function getDomanda()
    {
        return $this->domanda;
    }
    
    public function getRisposta()
    {
        return $this->risposta;
    }

    public function hasPasswordCambiata()
    {
        return $this->passwordCambiata;
    }
    
    public function getCarrello()
    {
        return $this->carrello;   
    }
    
    public function getIndirizziFatturazioneTotale()
    {
        return $this->indirizziFatturazioneTotale;
    }
    
    public function getIndirizziSpedizioneTotale()
    {
        return $this->indirizziSpedizioneTotale;
    }
    
    public function getNumeroCarteTotali()
    {
        return $this->numeroCarteTotali;
    }
    public function getIndirizzoFatturazionePreferito()
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "SELECT CodFatturazione FROM indirizzoFatturazione WHERE RefUtente = ".$this->id." AND Preferito = 1";
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $this->indirizzoFatturazionePreferito = $row['CodFatturazione'];
        }
        
        return $this->indirizzoFatturazionePreferito;
    }
    public function getIndirizzoSpedizionePreferito()
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "SELECT CodSpedizione FROM indirizzoSpedizione WHERE RefUtente = ".$this->id." AND Preferito = 1";
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $this->indirizzoSpedizionePreferito = $row['CodSpedizione'];
        }
        
        return $this->indirizzoSpedizionePreferito;
    }
    
    public function getOrdiniEffettuati()
    {
        return $this->ordiniEffettuati;
    }
    
    public function setNome(String $newNome)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE utente SET nome = '".$newNome."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->nome = $newNome;
            return true;
        }
        return false;
    }
    
    public function setCognome(String $newCognome)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE utente SET cognome = '".$newCognome."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->cognome = $newCognome;
            return true;
        }
        
        return false;
    }
    
    public function setNascita(String $newNascita)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE utente SET dataNascita = '".$newNascita."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->nascita = $newNascita;
            return true;
        }
        
        return false;
    }
    
    public function setEmail(String $newEmail)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE utente SET email = '".$newEmail."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->email = $newEmail;
            return true;
        }
        
        return false;
    }
    
    public function setPermesso(int $newPermesso)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE utente SET refPermesso = '".$newPermesso."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->permesso = $newPermesso;
            return true;
        }
        
        return false;
    }
    
    public function setDomanda(String $newDomanda)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE utente SET domanda = '".$newDomanda."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->domanda = $newDomanda;
            return true;
        }
        
        return false;
    }
    
    public function setRisposta(String $newRisposta)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE utente SET risposta = '".$newRisposta."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->risposta = $newRisposta;
            return true;
        }
        
        return false;
    }
    
    public function setPasswordCambiata(bool $status)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $passCambiata = 0;
        if ($status)
            $passCambiata = 1;
        
        $sql_query = "UPDATE utente SET passwordCambiata = '".$passCambiata."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->passwordCambiata = $status;
            return true;
        }
        
        return false;
    }
    
    public function setPassword(String $newPassword)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "UPDATE utente SET password = '".$newPassword."' WHERE codUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $this->password = $newPassword;
            return true;
        }
        
        return false;
    }
    
    public function aggiungiProdottoAlCarrello(Prodotto $prodotto, int $quantita)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        if ($this->isProdottoNelCarrello($prodotto))
        {
            //Cerco la quantita corrente nel carrello
            $oldQuantita = 0;
            $sql_query = "SELECT Quantita FROM Carrello WHERE RefUtente = ".$this->id." AND RefProdotto = ".$prodotto->getCodProdotto();
            $result = $mysqli->query($sql_query);
            if ($result->num_rows)
            {
                $row = $result->fetch_assoc();
                $oldQuantita = $row["Quantita"];
            }
            $newQuantita = $oldQuantita + $quantita;
            
            $sql_query = "UPDATE Carrello SET Quantita = ".$newQuantita." WHERE RefUtente = ".$this->id." AND RefProdotto = ".$prodotto->getCodProdotto();
            if ($mysqli->query($sql_query))
            {
                for ($i = 0; $i < count($this->carrello); $i++)
                {
                    if ($this->carrello[$i][0] == $prodotto->getCodProdotto())
                    {
                        $this->carrello[$i][1] = $newQuantita;
                        $prodotto->setQuantita($prodotto->getQuantita() - $quantita);
                        break;
                    }
                }
                return true;
            }
            
            return false;
        }
        else
        {
            $sql_query = "INSERT INTO Carrello VALUES (".$this->id.", ".$prodotto->getCodProdotto().", ".$quantita.")";
            if ($mysqli->query($sql_query))
            {
                $count = count($this->carrello) + 1;
                $this->carrello[$count][0] = $prodotto->getCodProdotto();
                $this->carrello[$count][1] = $quantita;
                $prodotto->setQuantita($prodotto->getQuantita() - $quantita);
                return true;
            }
           
            return false;
        }
    }
    
    public function isProdottoNelCarrello(Prodotto $prodotto)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        $sql_query = "SELECT * FROM Carrello WHERE RefUtente = ".$this->id." AND RefProdotto = ".$prodotto->getCodProdotto();
        $result = $mysqli->query($sql_query);
        if ($result->num_rows)
            return true;
        
        return false;
    }
    
    public function setQuantitaProdottoCarrello(Prodotto $prodotto, int $quantita)
    {
        $codProdotto = $prodotto->getCodProdotto();
        $carrello = $this->getCarrello();
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        for ($i = 0; $i < count($this->getCarrello()); $i++)
        {
            if ($carrello[$i][0] == $codProdotto)
            {
                $sql_query = "UPDATE Carrello SET Quantita = ".$quantita." WHERE RefUtente = ".$this->id." AND RefProdotto = ".$codProdotto;
                if ($mysqli->query($sql_query))
                {
                    $oldQuantita = $carrello[$i][1];
                    if ($prodotto->setQuantita($prodotto->getQuantita() + ($oldQuantita - $quantita)))
                    {
                        $carrello[$i][1] = $quantita;
                        return true;
                    }
                }
                return false;
            }
        }
        
        return false;
    }
    
    public function rimuoviDalCarrello(Prodotto $prodotto)
    {
        $this->carrello;
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "DELETE FROM carrello WHERE RefProdotto = ".$prodotto->getCodProdotto()." AND RefUtente = ".$this->id;
        if ($mysqli->query($sql_query))
        {
            $indice = 0;
            for ($i = 1; $i < count($this->getCarrello()); $i++)
            {
                if ($this->carrello[$i][0] == $prodotto->getCodProdotto())
                    $indice = $i;
            }
            unset($this->carrello[$indice][0]);
            unset($this->carrello[$indice][1]);
            return true;
        }
        return false;
    }
    
    public function creaOrdine(int $codIndirizzoSpedizione, int $codIndirizzoFatturazione, int $codCorriere, int $codCarta, String $data)
    {
        $db = DBConnection::getInstance();
        $mysqli = $db->getConnection();
        
        //Se il prezzo totale supera il prezzo minimo per ricevere lo sconto random applico lo sconto random
        $sconto = 0;
        $prezzoTotale = 0;
        for ($i = 0; $i < count($this->carrello); $i++)
        {
            $prodotto = new Prodotto($this->carrello[$i][0]);
            $prezzoProdotto = $prodotto->getPrezzo();
            $quantita = $this->carrello[$i][1];
            $prezzoTotale += $prezzoProdotto * $quantita;
        }
        
        if ($prezzoTotale >= Globals::PREZZO_MINIMO_SCONTO)
            $sconto = rand(1, 20);
        
        $codAcquisto = 1;
        $sql_query = "SELECT COUNT(*) FROM acquisto WHERE RefUtente = ".$this->getCod();
        $result = $mysqli->query($sql_query);
        if ($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $codAcquisto = $row["COUNT(*)"] + 1;
        }
        $sql_query = "INSERT INTO acquisto VALUES ".
                     "(".$codAcquisto.", ".$codIndirizzoSpedizione.", ".$codIndirizzoFatturazione.", ".$codCorriere.", ".$codCarta.", ".$this->getCod().", '".$data."', ".$sconto.")";
        
        if ($mysqli->query($sql_query))
        {
            for ($i = 0; $i < count($this->carrello); $i++)
            {
                $prodotto = new Prodotto($this->carrello[$i][0]);
                $sql_query = "INSERT INTO infoAcquisto VALUES (".$this->getCod().", ".$codAcquisto.", ".$prodotto->getCodProdotto().", ".$this->carrello[$i][1].")";
                
                if (!$mysqli->query($sql_query) || !$this->rimuoviDalCarrello($prodotto))
                    return false;
            }
            $this->ordiniEffettuati += 1;
            
            if ($sconto > 0)
                echo "Congratulazioni, è stato applicato uno sconto del ".$sconto."%.<br/>";
            
            return true;
        }        
        return false;
    }
}
?>