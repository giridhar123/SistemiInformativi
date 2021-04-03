<?php
include "header.php";
session_start();
?>

<html>
	<head>
		<title>Caricamento...</title>
	</head>
	<body>
		<div id = "wrapper">
			<div align = "center">
<?php

//Prendo un'instanza della connessione al DB
$db = DBConnection::getInstance();
$mysqli = $db->getConnection();

$comando = $_POST["comando"];
//In base al comando ricevuto
switch ($comando)
{
    case "login":
        $sql_query = "SELECT codUtente FROM utente WHERE email = '".$_POST[email]. "' AND BINARY Password = '" .$_POST[password]. "'";
        $result = $mysqli->query($sql_query);
        if($result->num_rows)
        {
            $row = $result->fetch_assoc();
            $idUtente = $row["codUtente"];
            $scadenza = (int) 60*60*24 + time();
            setcookie("login", $idUtente, $scadenza);
            $_COOKIE["login"] = $idUtente;
            
            $utente = new Utente($idUtente);
            if ($utente->hasPasswordCambiata())
            {
                //Redirect in 3 secondi
                header( "refresh:3;url=".Globals::WEBSITE."user/adminCambioPass.php" );
                echo "Login in corso...";
            }
            else
            {
                //Redirect in 3 secondi
                header( "refresh:3;url=".Globals::WEBSITE."index.php" );
                echo "Login in corso... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            }
        }
        else
        {
            //Redirect in 3 secondi
            header( "refresh:3;url=index.php" );
            echo "Le credenziali non corrispondono oppure l'utente non è registrato... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "addProduct":
        if (Prodotto::addProductIntoDB($_POST['NomeProdotto'], $_POST['Categoria'], $_POST['Prezzo'], $_POST['Quantita'], $_POST['Descrizione']))
        {
            $sql_query1 = "SELECT CodProdotto FROM prodotto WHERE NomeProdotto = '".$_POST['NomeProdotto']."'";
            
            if($result = $mysqli->query($sql_query1))
            {
                $row = $result->fetch_assoc();
                $CodProdotto = $row['CodProdotto'];
                $prodotto = new Prodotto($CodProdotto);
            }
            header( "refresh:3;url=".Globals::WEBSITE."admin/index.php" );
            echo "Aggiungo il prodotto";echo "<br />";
        }
        else
        {
            header( "refresh:3;url=".Globals::WEBSITE."admin/Product.php" );
            echo "Si è verificato un errore...";echo "<br />";
        }
        
        //Se i file sono stati caricati correttamente aggiungo l'immagine
        if($_POST['scelta'] == "si")
        {
           $file_tmp = $_FILES["Immagine"]["tmp_name"];
           $file_name = $_FILES["Immagine"]["name"];
           $pathCartella = Globals::IMAGES_PATH.$_POST['NomeProdotto'].".jpeg";
           $uploadOk = 1;
           $imageFileType = strtolower(pathinfo($pathCartella,PATHINFO_EXTENSION));
           // Check if image file is a actual image or fake image
           if(isset($_POST["submit"])) {
               $check = getimagesize($_FILES["Immagine"]["tmp_name"]);
               if($check !== false) {
                   echo "Il file è un immagine - " . $check["mime"] . ".<br />";
                   $uploadOk = 1;
               }
               else {
                   echo "Il file selezionato non è una immagine.<br />";
                   $uploadOk = 0;
               }
           }
           
           // Check file size
           if ($_FILES["Immagine"]["size"] > 500000) {
               echo "Immagine troppo grande, dimensione massima = 5MB<br />";
               $uploadOk = 0;
           }
           // Allow certain file formats
           if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
               echo "E' possibile caricare solo JPG, JPEG e PNG<br />";
               $uploadOk = 0;
           }
           // Check if $uploadOk is set to 0 by an error
           if ($uploadOk == 0)
           {
               echo "L'immagine non è stata caricata<br />";
           }
           else
           {
               if (move_uploaded_file($file_tmp, $pathCartella))
               {
                   $prodotto->setHasImage(1);
                   echo "Il file $file_name è stato caricato<br />";
               }
               else
               {
                   echo "c'è stato un errore nel caricamento dell' immagine, riprovare";
                   //header( "refresh:3;url=addProduct.php" );
               }
           }
        }
        break;
    case "addCorriere":
        if(Corriere::addCorriereIntoDb($_POST['NomeCorriere'], $_POST['PrezzoSpedizione']))
        {
            header( "refresh:3;url=".Globals::WEBSITE."admin/index.php" );
            echo "Aggiungo il corriere...";
        }
        else
        {
            header( "refresh:3;url=".Globals::WEBSITE."admin/addCorriere.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "modifyAccount":
        if($_POST['Password'] != $_POST['ConfermaPassword'])
        {
            header( "refresh:1;url=signup.php?Nome=".$_POST["Nome"]."&Cognome=".$_POST['Cognome']."&DataNascita=".$_POST['DataNascita']."&Domanda=".$_POST['Domanda']."&Risposta=".$_POST['Risposta']."&Email=".$_POST['Email']);
            echo "Le password non combaciano";
        }
        else 
        {
            $utente = Utente::CreaUtenteDaEmail($_POST["EmailUtente"]);
            
            $error = true;
            if ($_POST['Password'] != $utente->getPassword())
            {
                if ($utente->setPassword($_POST["Password"]) && $utente->setPasswordCambiata(true))
                    $error = false;
            }
            
            if (!$error)
            {
                if ($utente->setNome($_POST["Nome"]) && 
                    $utente->setCognome($_POST["Cognome"]) &&
                    $utente->setNascita($_POST["DataNascita"]) &&
                    $utente->setEmail($_POST["Email"]) && 
                    $utente->setDomanda($_POST["Domanda"]) && 
                    $utente->setRisposta($_POST["Risposta"]) &&
                    $utente->setPermesso($_POST["CodPermesso"]))
                {
                    header( "refresh:3;url=index.php" );
                    echo "Modifica delle credenziali in corso...";
                }
                else
                {
                    header( "refresh:3;url=".Globals::WEBSITE."/index.php" );
                    echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
                }
            }
            else
            {
                header( "refresh:3;url=".Globals::WEBSITE."/index.php" );
                echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            }
        }
        break;
    case "resetPassword":
        if($_POST['Password'] != $_POST['ConfermaPassword'])
        {
            header( "refresh:1;url=".Globals::WEBSITE."resetPassword.php" );
            echo "Le password non combaciano";
        }
        else
        {
            $utente = Utente::CreaUtenteDaEmail($_POST['EmailUtente']); 
            if ($utente->setPassword($_POST['Password']))   
            {
                echo "Password modificata";
                header( "refresh:3;url=".Globals::WEBSITE."index.php" );
            }
            else
            {
                echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
                header( "refresh:3;url=".Globals::WEBSITE."index.php" );
            }
        }
        break;
    case "modifyProduct":
        $prodotto = new Prodotto($_POST["CodProdotto"]);
            
        if ($prodotto->setNomeProdotto($_POST['NomeProdotto']) &&
            $prodotto->setPrezzo($_POST['Prezzo']) &&
            $prodotto->setQuantita($_POST['Quantita']) &&
            $prodotto->setDescrizione($_POST['Descrizione']))
        {
            if($_POST['scelta'] == "si")
            {
                unlink(Globals::IMAGES_PATH.$_POST['NomePrecedenteProdotto'].".jpeg");
                    
                $file_tmp = $_FILES["ImmagineNuova"]["tmp_name"];
                $file_name = $_FILES["ImmagineNuova"]["name"];
                $pathCartella = Globals::IMAGES_PATH.$_POST['NomeProdotto'].".jpeg";
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($pathCartella,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"]))
                {
                    $check = getimagesize($_FILES["Immagine"]["tmp_name"]);
                    if($check !== false)
                    {
                        echo "Il file è un immagine - " . $check["mime"] . ".<br />";
                        $uploadOk = 1;
                    }
                    else
                    {
                        echo "Il file selezionato non è una immagine.<br />";
                        $uploadOk = 0;
                    }
                }
                    
                // Check file size
                if ($_FILES["Immagine"]["size"] > 500000)
                {
                    echo "Immagine troppo grande, dimensione massima = 5MB<br />";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
                {
                    echo "E' possibile caricare solo JPG, JPEG e PNG<br />";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0)
                {
                    $prodotto->setHasImage(false);
                    echo "L'immagine non è stata caricata<br />";
                }
                else
                {
                    if (move_uploaded_file($file_tmp, $pathCartella))
                    {
                        $prodotto->setHasImage(true);
                        echo "Il file $file_name è stato caricato<br />";
                    }
                    else
                    {
                        $prodotto->setHasImage(false);
                        echo "c'è stato un errore nel caricamento dell' immagine, riprovare";
                        header( "refresh:3;url=addProduct.php" );
                    }
                }
            }
            echo "Modifica effettuata";
            header( "refresh:1;url=index.php" );
        }
        else
        {
            //Redirect in 3 secondi
            header( "refresh:3;url=signup.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
        
        
    case "modifyCorriere":
        $Corriere = new corriere($_POST["CodCorriere"]);
        if ($Corriere->setNome($_POST["NomeCorriere"]) &&
            $Corriere->setPrezzo($_POST["Prezzo"]))
        {
            echo "Modifica effettuata";
            header( "refresh:1;url=index.php" );
        }
        else
        {
            //Redirect in 3 secondi
            header( "refresh:3;url=modifyCorriere.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            
        }
        break;
        
    case "signup":
        //Controllo se esiste già un account con questa e-mail
        $sql_query = "SELECT * FROM utente WHERE Email = '".$_POST['Email'];
        $result = $mysqli->query($sql_query);
        if($_POST['Password'] != $_POST['ConfermaPassword'])
        {
            header( "refresh:1;url=signup.php?Nome=".$_POST["Nome"]."&Cognome=".$_POST['Cognome']."&DataNascita=".$_POST['DataNascita']."&Domanda=".$_POST['Domanda']."&Risposta=".$_POST['Risposta']."&Email=".$_POST['Email']);
            echo "Le password non combaciano";
        }
        else if($result->num_rows)
        {   
            header( "refresh:1;url=signup.php?Nome=".$_POST["Nome"]."&Cognome=".$_POST['Cognome']."&DataNascita=".$_POST['DataNascita']."&Domanda=".$_POST['Domanda']."&Risposta=".$_POST['Risposta']);   
            echo "Utente gia registrato... reindirizzamento in corso";
        }
        else
        {
            if (Utente::addUtenteToDb($_POST['Nome'], $_POST['Cognome'], $_POST['DataNascita'], $_POST['Email'], $_POST['Password'], $_POST['Domanda'], $_POST['Risposta']))
            {
                //Redirect in 3 secondi
                header( "refresh:3;url=index.php" );
                echo "Registrazione in corso... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            }
            else
            {
                //Redirect in 3 secondi
                header( "refresh:3;url=signup.php" );
                echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            }
        }
        break;
    case "newCarta":
         if (Carta::addCartaIntoDb($_COOKIE['login'], $_POST['CodTipo'], $_POST['NumeroCarta']))
         {
             header( "refresh:3;url=user/manageAccount.php" );
             echo "Aggiunta carta in corso, sei pregato di attendere.";
         }
         else
         {
             header( "refresh:3;url=user/manageAccount.php" );
             echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
         }
        break;       
    case "changeNome":
        $utente = $_SESSION["utente"];
        if ($utente->setNome($_POST["nome"]))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Modifica in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "changeCognome":
        $utente = $_SESSION["utente"];
        if ($utente->setCognome($_POST["cognome"]))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Modifica in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "changePassword":
        $utente = $_SESSION["utente"];
        if ($utente->setPassword($_POST["password"]) && $utente->setPasswordCambiata(false))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Modifica in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "changeNascita":
        $utente = $_SESSION["utente"];
        if ($utente->setNascita($_POST["nascita"]))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Modifica in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "changeEmail":
        $utente = $_SESSION["utente"];
        if ($utente->setEmail($_POST["email"]))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Modifica in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "changeDomanda":
        $utente = $_SESSION["utente"];
        if ($utente->setDomanda($_POST["domanda"]))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Modifica in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "changeRisposta":
        $utente = $_SESSION["utente"];
        if ($utente->setRisposta($_POST["risposta"]))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Modifica in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "aggiungiAlCarrello":
            
        $prodotto = new Prodotto($_POST["codProdotto"]);
        $utente = $_SESSION["utente"];
        if ($utente->aggiungiProdottoAlCarrello($prodotto, $_POST["quantita"]))
        {
            header( "refresh:3;url=index.php" );
            echo "Aggiunta del prodotto in corso... Torna alla <a href=\"index.php\">homepage</a>.";
        }
        else
        {
            header( "refresh:3;url=index.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
        
    case "rimuoviDalCarrello":
        $prodotto = new Prodotto($_POST["codProdotto"]);
        $oldQuantita = 0;
        $carrello = $_SESSION["utente"]->getCarrello();
        for ($i = 0; $i < count($carrello); $i++)
        {
            if ($carrello[$i][0] == $_POST["codProdotto"])
            {
                $oldQuantita = $carrello[$i][1];
                break;
            }
        }
        if ($_SESSION["utente"]->rimuoviDalCarrello($prodotto) && $prodotto->setQuantita($prodotto->getQuantita() + $oldQuantita))
        {   
            header( "refresh:3;url=index.php" );
            echo "Rimuovo del prodotto dal carrello in corso... Torna alla <a href=\"index.php\">homepage</a>.";
        }
        else
        {
            header( "refresh:3;url=index.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "aggiornaQuantitaCarrello":
        if ($_SESSION["utente"]->setQuantitaProdottoCarrello(new Prodotto($_POST["codProdotto"]), $_POST["quantita"]))
        {
            header( "refresh:3;url=index.php" );
            echo "Aggiorno la quantità del prodotto dal carrello in corso... Torna alla <a href=\"index.php\">homepage</a>.";
        }
        else
        {
            header( "refresh:3;url=index.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "sceltaCategoria":
        break;
    case "deleteCarta":
        if (Carta::deleteCarta($_COOKIE['login'], $_POST['codCarta']))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Eliminazione carta in corso, sei pregato di attendere.";
        }
        break;
    case "pagamento":
        $date = date("Y")."/".date("m")."/".date("d");
        if ($_SESSION["utente"]->creaOrdine($_POST["CodSpedizione"], $_POST["CodFatturazione"], $_POST["CodCorriere"], $_POST["CodCarta"], $date))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Creazione dell'ordine in corso.";
        }
        else 
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
}

$comando = $_GET["comando"];

switch($comando)
{
    case "logout":
        //Redirect in 3 secondi
        header( "refresh:3;url=index.php" );
        echo "Logout in corso... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        
        unset($_COOKIE["login"]);
        setcookie("login", "", time() - 86400); //Imposta la scadenza al giorno prima
        unset($_SESSION["utente"]);
        break;
    case "newFatturazione":
        if (IndirizzoFatturazione::addIndirizzoFatturazioneIntoDB($_COOKIE['login'], $_GET['Indirizzo'], $_GET['Citta'], $_GET['CAP']))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Aggiunta nuovo indirizzo di fatturazione in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/newFatturazione.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "newSpedizione":
        if (IndirizzoSpedizione::addIndirizzoSpedizioneIntoDB($_COOKIE['login'], $_GET['Indirizzo'], $_GET['Citta'], $_GET['CAP']))
        {
            header( "refresh:3;url=user/manageAccount.php" );
            echo "Aggiunta nuovo indirizzo di spedizione in corso, sei pregato di attendere.";
        }
        else
        {
            header( "refresh:3;url=user/newSpedizione.php" );
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
        }
        break;
    case "setFatturazioneDefault":
        $sql_query ="SELECT CodFatturazione FROM indirizzoFatturazione WHERE Preferito = 1";
        if ($result = $mysqli->query($sql_query))
        {
            $row = $result->fetch_assoc();
            $oldPreferito = new IndirizzoFatturazione($row["CodFatturazione"], $_COOKIE["login"]);
            $newPreferito = new IndirizzoFatturazione($_GET["codFatturazione"], $_COOKIE["login"]);
            
            if ($oldPreferito->setDefault(false) && $newPreferito->setDefault(true))
            {
                header("refresh:3;url=user/indirizziSpedizione.php");
                echo "Impostato nuovo indirizzo di spedizione di default";
            }
            else
            {
                echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
                header("refresh:3;url=user/indirizziSpedizione.php");
            }
        }
        else
        {
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            header("refresh:3;url=user/indirizziSpedizione.php");
        }
        break;
    case "setSpedizioneDefault":
        $sql_query ="SELECT CodSpedizione FROM indirizzoSpedizione WHERE Preferito = 1";
        if ($result = $mysqli->query($sql_query))
        {
            $row = $result->fetch_assoc();
            $oldPreferito = new IndirizzoSpedizione($row["CodSpedizione"], $_COOKIE["login"]);
            $newPreferito = new IndirizzoSpedizione($_GET["codSpedizione"], $_COOKIE["login"]);
            
            if ($oldPreferito->setDefault(false) && $newPreferito->setDefault(true))
            {
                header("refresh:3;url=user/indirizziSpedizione.php");
                echo "Impostato nuovo indirizzo di spedizione di default";
            }
            else
            {
                echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
                header("refresh:3;url=user/indirizziSpedizione.php");
            }
        }
        else
        {
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            header("refresh:3;url=user/indirizziSpedizione.php");
        }
        break;
    case "eliminaIndirizzoSpedizione":
        if (IndirizzoSpedizione::deleteFromDB($_COOKIE["login"], $_GET["codSpedizione"]))
        {
            echo "Eliminicazione indirizzo di spedizione in corso...";
            header("refresh:3;url=user/indirizziSpedizione.php");
        }
        else 
        {
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            header("refresh:3;url=user/indirizziSpedizione.php");
        }        
        break;
    case "eliminaIndirizzoFatturazione":
        if (IndirizzoFatturazione::deleteFromDB($_COOKIE["login"], $_GET["codFatturazione"]))
        {
            echo "Eliminicazione indirizzo di fatturazione in corso...";
            header("refresh:3;url=user/indirizziFatturazione.php");
        }
        else
        {
            echo "Ops, qualcosa è andato storto... Se il tuo browser non supporta il redirect clicka <a href=\"index.php\">qui</a>.";
            header("refresh:3;url=user/indirizziFatturazione.php");
        }        
        break;
}
?>

</div>
</div>
</body>
</html>

<?php
include "footer.php";
?>


