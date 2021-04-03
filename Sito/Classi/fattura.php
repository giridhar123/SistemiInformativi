<?php
require_once ('fpdf.php');

class Fattura
{
    private $pdf;
    
    public function Fattura(String $nome, String $cognome, IndirizzoFatturazione $indirizzoFatturazione, IndirizzoSpedizione $indirizzoSpedizione, Corriere $corriere, Carta $carta, Ordine $ordine)
    {
        define('FPDF_FONTPATH', Globals::FONT_PATH);
        $this->pdf = new FPDF('P','mm','A4');
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->MultiCell(5, 5, "");
        
        $this->pdf->Cell(13,10, "Nome:");
        $this->pdf->Cell(25,10, $nome);
        $this->pdf->Cell(20,10, "Cognome:");
        $this->pdf->Cell(40,10, $cognome);
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->MultiCell(5, 5, "");
        
        
        $this->pdf->Cell(40,10, "Indirizzo Fatturazione:");
        $this->pdf->Cell(40,10, $indirizzoFatturazione->getIndirizzo());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->Cell(10,10, "Citta:");
        $this->pdf->Cell(40,10, $indirizzoFatturazione->getCitta());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->Cell(10,10, "CAP:");
        $this->pdf->Cell(40,10, $indirizzoFatturazione->getCap());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->MultiCell(5, 5, "");
        
        $this->pdf->Cell(40,10, "Indirizzo Spedizione:");
        $this->pdf->Cell(40,10, $indirizzoSpedizione->getIndirizzo());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->Cell(10,10, "Citta:");
        $this->pdf->Cell(40,10, $indirizzoSpedizione->getCitta());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->Cell(10,10, "CAP:");
        $this->pdf->Cell(40,10, $indirizzoSpedizione->getCap());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->MultiCell(5, 5, "");
        
        $this->pdf->Cell(20,10, "Corriere:");
        $this->pdf->Cell(40,10, $corriere->getNome());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->MultiCell(5, 5, "");
        
        $this->pdf->Cell(40,10, "Metodo di pagamento:");
        $this->pdf->Cell(10,10, $carta->getNomeTipo());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->Cell(30,10, "Numero carta:");
        $this->pdf->Cell(10,10, $carta->getNumero());
        $this->pdf->MultiCell(5, 5, "");
        $this->pdf->MultiCell(5, 5, "");
        
        $this->pdf->Cell(30,10, "Totale pagato:");
        $this->pdf->Cell(8,10, $ordine->getPrezzoTotale());
        $this->pdf->Cell(5,10, "Euro");
    }
    
    public function createFile(String $pathFattura)
    {
        unlink($pathFattura);
        $this->pdf->Output($pathFattura,'F');
        $this->pdf->Close();
    }
}
?>