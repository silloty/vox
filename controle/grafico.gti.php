<?php

class gtiGrafico
{
	private $titulo;
	private $subtitulo;
	private $dados_eixoX;
	private $dados_eixoY;
	private $largura;
	private $altura;
	private $label_eixoX;
	private $label_eixoY;
	private $cor_barra;
	private $cor_sombra;
	private $nome;
	private $largura_barra;
	private $formato;
	private $label_formato;
	
	//PROPRIEDADES----------------------------------------------
	
	//propriedade TITULO
	public function SetTitulo($value)
	{
		$this->titulo = $value;
	}
	public function GetTitulo()
	{
		return $this->titulo;
	}
	
	//propriedade SUBTITULO
	public function SetSubTitulo($value)
	{
		$this->subtitulo = $value;
	}
	public function GetSubTitulo()
	{
		return $this->subtitulo;
	}
	
	//propriedade DADOS DO EIXO X
	public function SetDadosEixoX($value)
	{
		$this->dados_eixoX = $value;
	}
	public function GetDadosEixoX()
	{
		return $this->dados_eixoX;
	}
	
	//propriedade DADOS DO EIXO Y
	public function SetDadosEixoY($value)
	{
		$this->dados_eixoY = $value;
	}
	public function GetDadosEixoY()
	{
		return $this->dados_eixoY;
	}
	
	//propriedade LARGURA
	public function SetLargura($value)
	{
		$this->largura = $value;
	}
	public function GetLargura()
	{
		return $this->largura;
	}
	
	//propriedade ALTURA
	public function SetAltura($value)
	{
		$this->altura = $value;
	}
	public function GetAltura()
	{
		return $this->altura;
	}

	//propriedade LABEL DO EIXO X
	public function SetLabelEixoX($value)
	{
		$this->label_eixoX = $value;
	}
	public function GetLabelEixoX()
	{
		return $this->label_eixoX;
	}
	
	//propriedade LABEL DO EIXO Y
	public function SetLabelEixoY($value)
	{
		$this->label_eixoY = $value;
	}
	public function GetLabelEixoY()
	{
		return $this->label_eixoY;
	}
	
	//propriedade COR DAS BARRAS
	public function SetCorBarra($value)
	{
		$this->cor_barra = $value;
	}
	public function GetCorBarra()
	{
		return $this->cor_barra;
	}
	
	//propriedade COR DA SOMBRA
	public function SetCorSombra($value)
	{
		$this->cor_sombra = $value;
	}
	public function GetCorSombra()
	{
		return $this->cor_sombra;
	}
	
	//propriedade NOME DA FIGURA
	public function SetNome($value)
	{
		$this->nome = $value;
	}
	public function GetNome()
	{
		return $this->nome;
	}
	
	//propriedade LARGURA DA BARRA
	public function SetLarguraBarra($value)
	{
		$this->largura_barra = $value;
	}
	public function GetLarguraBarra()
	{
		return $this->largura_barra;
	}
	
	//propriedade FORMATO NUMEROS
	public function SetFormato($value)
	{
		$this->formato = $value;
	}
	public function GetFormato()
	{
		return $this->formato;
	}
	
	//propriedade LABEL FORMATO
	public function SetLabelFormato($value)
	{
		$this->label_formato = $value;
	}
	public function GetLabelFormato()
	{
		return $this->label_formato;
	}
		
	//MÉTODOS------------------------------------------------------
	
	//METODO CONSTRUTOR
	public function __construct()
	{
		$this->titulo = "";
		$this->subtitulo = "";
		$this->dados_eixoX = "";
		$this->dados_eixoY = "";
		$this->largura = "";
		$this->altura = "";
		$this->label_eixoX = "";
		$this->label_eixoY = "";
		$this->cor_barra = "orange";
		$this->cor_sombra = "gray2";
		$this->nome = "";
		$this->largura_barra="60";
		$this->formato = "";
		$this->label_formato ="";
				
	}
	
	function GerarGraficoBarra()
	{
		require_once("../biblioteca/jpgraph/jpgraph.php");
		require_once ("../biblioteca/jpgraph/jpgraph_bar.php");
		
		$grafico = new graph($this->largura,$this->altura,"png");
		
		/* Margem das partes principais do gráfico (dados), o que está
		* fora da margem fica separado para as labels, títulos, etc
		* Este valor ficará como padrão para todos os gráficos
		*/ 
		$grafico->img->SetMargin(40,30,20,40);
		$grafico->SetScale("textlin");
		$grafico->SetShadow();
		
		//Define Titulo e Subtitulo
				
		$grafico->title->Set($this->titulo);
		$grafico->subtitle->Set($this->subtitulo);
		
		// pedir para mostrar os grides no fundo do gráfico,
		// o ygrid é marcado como true por padrão
		$grafico->ygrid->Show(true);
		$grafico->xgrid->Show(true);
		
		
		 
		$gBarras = new BarPlot($this->dados_eixoY);
		
		$gBarras->SetFillColor($this->cor_barra);
		$gBarras->SetShadow($this->cor_sombra);
		$gBarras->SetAbsWidth($this->largura_barra);
		$gBarras->value->Show();
		$gBarras->value->SetFormat('%d');
		$gBarras->SetValuePos('center');
		$gBarras->value->SetFont(FF_FONT1,FS_BOLD);
		
		
		// título dos vértices
		$grafico->yaxis->title->Set($this->label_eixoY);
		$grafico->xaxis->title->Set($this->label_eixoX);
		// título das barras
		$grafico->xaxis->SetTickLabels($this->dados_eixoX);
				
		$grafico->Add($gBarras);
		
		
		
		$grafico->Stroke("imagens/graficos/".$this->nome);			
	}
	
	function GerarGraficoBarraHorizontal()
	{
	
		require_once("../biblioteca/jpgraph/jpgraph.php");
		require_once ("../biblioteca/jpgraph/jpgraph_bar.php");
				
		$graph = new Graph($this->largura,$this->altura,"png");
		$graph->SetScale("textlin");
	
		$graph->Set90AndMargin(600,40,40,40);
		
		$graph->xaxis->SetPos('min');
		
		$graph->SetShadow($this->cor_sombra);
		
		
		$graph->title->Set($this->titulo);
		$graph->subtitle->Set($this->subtitulo);
		
		$graph->xaxis->SetTickLabels($this->dados_eixoX);
		$graph->xaxis->SetLabelMargin(15);
		$graph->xaxis->SetLabelAlign('right','center');
		$graph->xaxis->SetLabelFormat($this->label_formato); 

		$graph->yaxis->SetPos('max');
		$graph->yaxis->SetLabelAlign('center','top');
		$graph->yaxis->SetLabelSide(SIDE_RIGHT);
		$graph->yaxis->SetTickSide(SIDE_LEFT);
		$graph->yaxis->SetTitleSide(SIDE_RIGHT);
		$graph->yaxis->SetTitleMargin(50);
		$graph->yaxis->SetTitle("");
		$graph->yaxis->title->Align('left');
		
		$graph->yaxis->title->SetAngle(0);

		$bplot = new BarPlot($this->dados_eixoY);
		$bplot->SetFillColor($this->cor_barra);
		$bplot->SetShadow($this->cor_sombra);
		
		
		$bplot->value->Show();
		$bplot->value->SetAlign('left','center');
		$bplot->value->SetColor("black","darkred");
		$bplot->value->SetFormat($this->formato);
		
		// Add the bar to the graph
		$graph->Add($bplot);
		
		
		$graph->Stroke("imagens/graficos/".$this->nome);
	
	
	}

}

?>