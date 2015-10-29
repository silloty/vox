<?php

/**
* Classe para manipulação de dados referente aos status das manifestações
* @author Silas Antônio Cereda da Silva
* @version 1.0
* since 06/02/2009
* Criação da classe
**/


require_once("../controle/conexao.gti.php");
require_once("../controle/valida.gti.php");

class clsStatus
{
	
	// CAMPOS PRIVADOS-----------------------------------------
	private $codigo;
	private $nome;
	private $descricao;
		
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
	
	//propriedade DESCRIÇÃO
	public function SetDescricao($value)
	{
		$this->descricao = $value;
	}
	public function GetDescricao()
	{
		return $this->descricao;
	}
	

    //MÉTODOS------------------------------------------------------
	
	public function __construct()
	{
		$this->codigo = "";
		$this->nome = "";
		$this->descricao = "";
	}

	// Método que captura os tipos de status de acordo com o código informado 
    function SelecionaPorCodigo($codigo)
    {
        $SQL = 'SELECT status_id, nome, descricao FROM public.status WHERE status_id=\''.trim($codigo).'\';';
        
        $con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();	

		if($tbl->RecordCount()>0)
		{
			foreach($tbl as $chave => $linha)
			{
				$this->codigo = $linha['status_id'];
				$this->nome = $linha['nome'];
				$this->descricao = $linha['descricao'];
			}
		}
		else
		{
			$this->__construct();
		}
    }
    
	//Método para excluir um tipo de status de acordo com o código
	public function Excluir($codigo)
    {
    	$SQL = 'DELETE FROM "public"."status" WHERE "status_id"='.$codigo.';';
		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	
	//Método para alterar um tipo de status
    function Alterar()
    {
        $SQL = 'UPDATE "public"."status" SET 
        "nome"=\''.$this->nome.'\', 
        "descricao"=\''.$this->descricao.'\' 
        WHERE 
        "status_id"='.$this->codigo.';';
        
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	//Método que realiza o cadastro de um novo tipo de status
	public function Salvar()
    {
    	$SQL = 'INSERT INTO 
					"public"."status" ("nome","descricao") 
				VALUES 
					(\''.$this->nome.'\', \''.$this->descricao.'\');';
		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	
	//Método que lista os status em um array para preencher o grid
	 public function ListaStatusArray()
    {
    	$SQL = 'SELECT * FROM "public"."status" order by "nome";';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$arr = "";
		$cont = -1;
		
    	foreach($tbl as $chave => $linha)
		{
			$lin[0] = $linha['status_id'];			
			$lin[1] = '<![CDATA[<span>'.$linha['nome'].'</span> ]]>';
			$lin[2] = '<![CDATA[<span>'.$linha['descricao'].'</span> ]]>';
			$arr[$cont++] = $lin;
		}
		
		return $arr;
    }
	
	//Método que lista os status para preebcher um drop down (combo)
	public function ListaComboStatus()
    {
    	$SQL = 'SELECT status_id, nome FROM status ORDER BY nome;';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$drop = "";
		
    	foreach($tbl as $chave => $linha)
		{
			 $id = $linha['status_id'];
			$nome = $linha['nome'];
			$drop .= '<option value="'.$id.'">'.$nome.'</option>';
		}
		
		return $drop;
    }
	
	// Método que pega o total de manifestações por status
	public function TotalPorStatus($data_inicial, $data_final)
	{
			
		$SQL = 'SELECT * FROM status;';
		$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$data_inicial = implode("-",array_reverse(explode("/",$data_inicial)));
		$data_final = implode("-",array_reverse(explode("/",$data_final)));
		
		$cont=0;		
		
		foreach($tbl as $chave => $linha)
		{			
			$cod = $linha['status_id'];
			
			$SQL = 'SELECT 
						count(manifestacao_id) as total 
					FROM 
						manifestacao 
					WHERE 
						ref_status = '.$cod.'
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