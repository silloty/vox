<?php

session_start();

/**
* Classe para manipula��o de dados referente a clientela, 
* ou seja as formas em que o ouvidor recebeu a manifesta��o
* @author Silas Ant�nio Cereda da Silva
* @version 1.0
* since 09/02/2009
* Cria��o da classe
**/

require_once("../controle/conexao.gti.php");
require_once("../controle/valida.gti.php");

class clsClientela
{
	
	// CAMPOS PRIVADOS-----------------------------------------
	private $codigo;
	private $nome;
	
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
	

    //M�TODOS------------------------------------------------------
	
	
	public function __construct()
	{
		$this->codigo = "";
		$this->nome = "";
	}

	// M�todo que captura os dados da clientela de acordo com o c�digo informado   
    function SelecionaPorCodigo($codigo)
    {
        $SQL = 'SELECT clientela_id, nome FROM public.clientela WHERE clientela_id=\''.trim($codigo).'\';';
        
        $con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();	

		if($tbl->RecordCount()>0)
		{
			foreach($tbl as $chave => $linha)
			{
				$this->codigo = $linha['clientela_id'];
				$this->nome = $linha['nome'];
			}
		}
		else
		{
			$this->__construct();
		}
    }
    
	//M�todo para excluir uma clientela de acordo com o c�digo
	public function Excluir($codigo)
    {
    	$SQL = 'DELETE FROM "public"."clientela" WHERE "clientela_id"='.$codigo.';';
		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	
	//M�todo para alterar um tipo de clientela
    function Alterar()
    {
        $SQL = 'UPDATE "public"."clientela" SET 
        "nome"=\''.$this->nome.'\' 
        WHERE 
        "clientela_id"='.$this->codigo.';';
        
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	//M�todo que realiza o cadastro de um novo tipo de clientela
	public function Salvar() 
    {
				
		$SQL = 'INSERT INTO 
					"public"."clientela" ("nome") 
				VALUES 
					(\''.$this->nome.'\');';

		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	
	//M�todo que lista a clientela em um array para preencher o grid
	 public function ListaClientelaArray()
    {
    	$SQL = 'SELECT * FROM "public"."clientela" order by "nome";';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$arr = "";
		$cont = -1;
		
    	foreach($tbl as $chave => $linha)
		{
			$lin[0] = $linha['clientela_id'];			
			$lin[1] = '<![CDATA[<span>'.$linha['nome'].'</span> ]]>';
			$arr[$cont++] = $lin;
		}
		
		return $arr;
    }
	
	//M�todo que lista a clientela para preebcher um drop down (combo)
	public function ListaComboClientela()
    {
    	$SQL = 'SELECT clientela_id, nome FROM public.clientela ORDER BY nome;';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$drop = "";
		
    	foreach($tbl as $chave => $linha)
		{
			 $id = $linha['clientela_id'];
			$nome = $linha['nome'];
			
			if ($_SESSION['vox_clientela']<>"")
			{
				$drop .='<option value="'.$id.'"'.($id==$_SESSION['vox_clientela']?' selected':'').'>'.$nome.'</option>';
			}
			else
			{
				$drop .= '<option value="'.$id.'">'.$nome.'</option>';
			}		
		}
		
		return $drop;
    }
	
	// M�todo que pega o total de manifesta��es por tipo de clientela
	public function TotalPorClientela($data_inicial, $data_final)
	{
			
		$data_inicial = implode("-",array_reverse(explode("/",$data_inicial)));
		$data_final = implode("-",array_reverse(explode("/",$data_final)));
		
		$SQL = 'SELECT * FROM clientela;';
		$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		
		$cont=0;		
		
		foreach($tbl as $chave => $linha)
		{			
			$cod = $linha['clientela_id'];
			
			$SQL = 'SELECT 
						count(manifestacao_id) as total 
					FROM 
						manifestacao 
					WHERE 
						ref_clientela = '.$cod.'
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