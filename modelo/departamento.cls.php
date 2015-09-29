<?php

/**
* Classe para manipulação de dados referente ao departamento
* @author Silas Antônio Cereda da Silva
* @version 1.0
* since 09/02/2009
* Criação da classe
**/

require_once("../controle/conexao.gti.php");
require_once("../controle/valida.gti.php");

class clsDepartamento
{
	
	// CAMPOS PRIVADOS-----------------------------------------
	private $codigo;
	private $nome;
	private $email;
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
	
		//propriedade EMAIL
	public function SetEmail($value)
	{
		$this->email = $value;
	}
	public function GetEmail()
	{
		return $this->email;
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
		$this->email = "";
		$this->descricao = "";
	}

	// Método que captura os dados dos departramentos de acordo com o código informado  
    function SelecionaPorCodigo($codigo)
    {
        $SQL = 'SELECT departamento_id, nome, email, descricao FROM public.departamento WHERE departamento_id=\''.trim($codigo).'\';';
        
        $con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();	

		if($tbl->RecordCount()>0)
		{
			foreach($tbl as $chave => $linha)
			{
				$this->codigo = $linha['departamento_id'];
				$this->nome = $linha['nome'];
				$this->email = $linha['email'];
				$this->descricao = $linha['descricao'];
			}
		}
		else
		{
			$this->__construct();
		}
    }
    // Método para excluir um departamento de acordo com o código informado
	public function Excluir($codigo)
    {
    	$SQL = 'DELETE FROM "public"."departamento" WHERE "departamento_id"='.$codigo.';';
		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	
	// Mpetodo para alteração nos dados de um departamento
    function Alterar()
    {
        $SQL = 'UPDATE "public"."departamento" SET 
        "nome"=\''.$this->nome.'\', 
        "email"=\''.$this->email.'\',
        "descricao"=\''.$this->descricao.'\' 
        WHERE 
        "departamento_id"='.$this->codigo.';';
        
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	// Método que cadastra um novo departamento
	public function Salvar()
    {
    	$SQL = 'INSERT INTO 
					departamento (nome,email,descricao) 
				VALUES 
					(\''.$this->nome.'\',\''.$this->email.'\',\''.$this->descricao.'\');';
								
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	
	//Método que lista os departamentos em um array para preencher o grid
	 public function ListaDepartamentoArray()
    {
    	$SQL = 'SELECT * FROM departamento order by nome;';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$arr = "";
		$cont = -1;
		
    	foreach($tbl as $chave => $linha)
		{
			$lin[0] = $linha['departamento_id'];			
			$lin[1] = '<![CDATA[<span>'.$linha['nome'].'</span> ]]>';
			$lin[2] = '<![CDATA[<span>'.$linha['email'].'</span> ]]>';
			$lin[3] = '<![CDATA[<span>'.$linha['descricao'].'</span> ]]>';
			$arr[$cont++] = $lin;
		}
		
		return $arr;
    }
	
	
	public function FiltraDepartamentoArray($valor)
    {
    	$SQL = 'SELECT * FROM departamento WHERE lower(nome) LIKE \'%'.$valor.'%\' order by nome;';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$arr = "";
		$cont = -1;
		if ($tbl->RecordCount()!=0)
		{
			foreach($tbl as $chave => $linha)
			{
				$lin[0] = $linha['departamento_id'];			
				$lin[1] = '<![CDATA[<span>'.$linha['nome'].'</span> ]]>';
				$lin[2] = '<![CDATA[<span>'.$linha['email'].'</span> ]]>';
				$lin[3] = '<![CDATA[<span>'.$linha['descricao'].'</span> ]]>';
				$arr[$cont++] = $lin;
			}
		}
		else
		{
			$lin[0] = '';			
			$lin[1] = '';
			$lin[2] = '';
			$lin[3] = '';	
						
			$arr[$cont++] = $lin;
		}	
		
		return $arr;
    }
	
	
	//Método que lista os departamentos para preebcher um drop down (combo)
	public function ListaComboDepartamento()
    {
    	$SQL = 'SELECT departamento_id, nome FROM departamento ORDER BY nome;';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$drop = "";
		
    	foreach($tbl as $chave => $linha)
		{
			 $id = $linha['departamento_id'];
			$nome = $linha['nome'];
			$drop .= '<option value="'.$id.'">'.$nome.'</option>';
		}
		
		return $drop;
    }
	
	//Método para consultar os departamentos
	public function Consultar()
    {
    	$SQL = 'SELECT * FROM departamento WHERE departamento_id='.$this->codigo.';';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
				
    	foreach($tbl as $chave => $linha)
		{
			$this->codigo = $linha['departamento_id'];			
			$this->nome = $linha['nome'];
			$this->email = $linha['email'];
			$this->descricao = $linha['descricao'];
		}
		
    }		
}

?>