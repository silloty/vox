<?php

/**
* Classe para manipula��o de dados referente
* aos tipos de manifesta��es poss�veis
* @author Silas Ant�nio Cereda da Silva
* @version 1.0
* since 09/02/2009
* Cria��o da classe
**/

require_once("../controle/conexao.gti.php");
require_once("../controle/valida.gti.php");

class clsTipo
{
	
	// CAMPOS PRIVADOS-----------------------------------------
	private $codigo;
	private $nome;
	private $visivel;
	
	//PROPRIEDADES----------------------------------------------
	
	//propriedade CODIGO
	public function SetCodigo($value)
	{
		$this->codigo= $value;
	}
	public function GetCodigo()
	{
		return $this->codigo;
	}
	
		
	//propriedade NOME
	public function SetNome($value)
	{
		$this->nome = $value;
	}
	public function GetNome()
	{
		return $this->nome;
	}
	
	//propriedade VISIVEL
	public function SetVisivel($value)
	{
		$this->visivel = $value;
	}
	public function GetVisivel()
	{
		return $this->visivel;
	}
	

    //M�TODOS------------------------------------------------------
	
	public function __construct()
	{
		$this->codigo = "";
		$this->nome = "";
		$this->visivel = "";
	}

	// M�todo que captura os tipos de manifesta��es de acordo com o c�digo informado     
    function SelecionaPorCodigo($codigo)
    {
        $SQL = 'SELECT tipo_id, nome, visivel FROM public.tipo WHERE tipo_id=\''.trim($codigo).'\';';
        
        $con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();	

		if($tbl->RecordCount()>0)
		{
			foreach($tbl as $chave => $linha)
			{
				$this->codigo = $linha['tipo_id'];
				$this->nome = $linha['nome'];
				$this->mostrar = $linha['visivel'];
			}
		}
		else
		{
			$this->__construct();
		}
    }

	//M�todo para excluir um tipo de manifestacao de acordo com o c�digo
	public function Excluir($codigo)
    {
    	$SQL = 'DELETE FROM "public"."tipo" WHERE "tipo_id"='.$codigo.';';
		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }

	//M�todo para alterar um tipo de manifestacao
    function Alterar()
    {
        $SQL = 'UPDATE tipo SET 
        nome=\''.$this->nome.'\',
		visivel='.$this->visivel.'  
        WHERE 
        tipo_id='.$this->codigo.';';
        
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }

	//M�todo que realiza o cadastro de um novo tipo de manifestacao
	public function Salvar()
    {
				
		$SQL = 'INSERT INTO 
					tipo (nome, visivel) 
				VALUES 
					(\''.$this->nome.'\','.$this->visivel.');';

		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	
	//M�todo que lista os tipos de manifestacoes em um array para preencher o grid
	public function ListaTipoArray()
    {
    	$SQL = 'SELECT * FROM tipo order by nome;';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$arr = "";
		$cont = -1;
		
    	foreach($tbl as $chave => $linha)
		{
			$lin[0] = $linha['tipo_id'];			
			$lin[1] = '<![CDATA[<span>'.$linha['nome'].'</span> ]]>';
			$lin[2] = '<![CDATA[<span>'."Nao".'</span> ]]>';
			if($linha['visivel']==1)
			{
				$lin[2] = '<![CDATA[<span>'."Sim".'</span> ]]>';
			}
			$arr[$cont++] = $lin;
		}
		
		return $arr;
    }
	
	//M�todo que lista os tipos de manifestacoes para preebcher um drop down (combo)
	public function ListaComboTipo($valor)
    {
		$SQL = 'SELECT tipo_id, nome FROM tipo ORDER BY nome;';
		
		if ($valor == 1)
		{
			$SQL = 'SELECT tipo_id, nome FROM tipo WHERE visivel = 1 ORDER BY nome;';
		}
    	
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$drop = "";
		
    	foreach($tbl as $chave => $linha)
		{
			 $id = $linha['tipo_id'];
			$nome = $linha['nome'];
			if ($_SESSION['vox_clientela']<>"")
			{
				$drop .='<option value="'.$id.'"'.($id==$_SESSION['vox_tipo']?' selected':'').'>'.$nome.'</option>';
			}
			else
			{
				$drop .= '<option value="'.$id.'">'.$nome.'</option>';
			}
		}
		
		return $drop;
    }
	
	// Fun��o que captura a quentidade de manifestacoes por tipo
	
	public function TotalPorTipo($data_inicial, $data_final)
	{
			
		$SQL = 'SELECT * FROM tipo;';
		$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$data_inicial = implode("-",array_reverse(explode("/",$data_inicial)));
		$data_final = implode("-",array_reverse(explode("/",$data_final)));
		
		$cont=0;		
		
		foreach($tbl as $chave => $linha)
		{			
			$cod = $linha['tipo_id'];
			
			$SQL = 'SELECT 
						count(manifestacao_id) as total 
					FROM 
						manifestacao 
					WHERE 
						ref_tipo = '.$cod.'
					AND
						data_criacao >= \''.$data_inicial.'\'
					AND 
						data_criacao <= \''.$data_final.'\' 
				
					;';
			$total = $con->gtiPreencheTabela($SQL);	
			
			foreach($total as $chave => $linha2)
			{
				$nome = utf8_decode($linha['nome']);
				$qtde = $linha2['total'];
			}	
			
			$arr[$cont][0] = $nome;
			$arr[$cont][1] = $qtde;
			$cont++;
		}
		
		$con->gtiDesconecta();
		return $arr;
	
	}
}


?>