<?php
require('../biblioteca/fpdf/fpdf.php');

class gtiRelatorio extends FPDF
{
	
	private $nome;
	private $cabecalho;
	private $tam_fonte_cab;
	private $tamanho;
	
	public function SetNome($value)
	{
		$this->nome = $value;
	}
	
	public function SetCabecalho($value)
	{
		$this->cabecalho = $value;
	}
	
	public function SetTamanho($value)
	{
		$this->tamanho = $value;
	}
	
	public function SetTamFonteCabecalho($value)
	{
		$this->tam_fonte_cab = $value;
	}
	
	public function Header()
	{
		require_once("../config.cls.php");
		$config = new clsConfig();
		
	    //$this->Image('../visao/imagens/logo.jpg',10,8,33);
		$this->Image('../visao/imagens/logovox.jpg',160,10,40);

	    $this->SetFont('Arial','B',10);

	    $this->Cell(201,10,'VOX SISTEMA DE OUVIDORIA',0,0,'L');
	    $this->Ln(5);

	    $this->Cell(205,10,$config->GetNomeInstituicao(),0,0,'L');
	    $this->Ln(2);
	    $this->Cell(220,10,'_____________________________________________________________________',0,0,'L');
	    $this->Ln(8);

	    $this->SetFont('Arial','',12);
	    $this->Cell(165,10,$this->nome,0,0,'L');	    

	    $this->Ln(5);
	    $this->SetFont('Arial','',$this->tam_fonte_cab);
	    
$this->Cell(0,10,'________________________________________________________________________________________________________________________',0,0,'L');
	    $this->Ln(4);
	    
	    //ajustando cabeçalho
	    $tam = count($this->cabecalho);
	    $cab = "";
	    
	    for ($i=0;$i<=($tam-1);$i++)
	    {
	    	$tamCampo = strlen($this->cabecalho[$i]);
	    	
	    	if ($tamCampo < $this->tamanho[$i])
	    	{
	    		$comp = str_pad($this->cabecalho[$i], ($this->tamanho[$i]-$tamCampo), " ", STR_PAD_RIGHT); 
	    	}
	    	
	    	$cab .= ($comp);
	    }
	    
	    $this->Cell(0,10,$cab,0,0,'L');
	    $this->Ln(1);
	    $this->Cell(0,10,'________________________________________________________________________________________________________________________',0,0,'L');
	    
	    $this->Ln();
	}
	
	public function Footer()
	{
	    //Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Page number
	    $this->Cell(0,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
	}
}

?>