<?php

/**
* Classe para manipulação de dados referente a um usuário
* @author Silas Antônio Cereda da Silva
* @version 1.0
* since 06/02/2009
* Criação da classe
**/


require_once("../controle/conexao.gti.php");
require_once("../controle/valida.gti.php");

class clsUsuario
{
	
	// CAMPOS PRIVADOS-----------------------------------------
	private $codigo;
	private $login;
	private $senha;
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
	
	//propriedade LOGIN
	public function SetLogin($value)
	{
		$this->login = $value;
	}
	public function GetLogin()
	{
		return $this->login;
	}
	
	//propriedade SENHA
	public function SetSenha($value)
	{
		$this->senha = $value;
	}
	public function GetSenha()
	{
		return $this->senha;
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
	

    //MÉTODOS------------------------------------------------------
	
	public function __construct()
	{
		$this->codigo = "";
		$this->login = "";
		$this->senha = "";
		$this->nome = "";
	}
	
	//Método para autenticar os usuarios cadastrados para acessar o sistema 
	function Autentica($login, $senha)
    {
        $SQL = 'SELECT * FROM public.usuario WHERE login=\''.trim($login).'\' AND 
        senha=md5(\''.trim($senha).'\');';
		
        $con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();	
		
		$existe = false;

		if($tbl->RecordCount()>0)
		{
			foreach($tbl as $chave => $linha)
			{
				$this->codigo = $linha['usuario_id'];
				$this->login = $linha['login'];
				$this->senha = $linha['senha'];
				$this->nome = $linha['nome'];
			}
			$existe = true;
		}
		
		return $existe;
    }
    
	// Método que captura os usuario de acordo com o código informado 
	
    function SelecionaPorCodigo($codigo)
    {
        $SQL = 'SELECT usuario_id, login, senha, nome FROM public.usuario WHERE usuario_id=\''.trim($codigo).'\';';
        
        $con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();	

		if($tbl->RecordCount()>0)
		{
			foreach($tbl as $chave => $linha)
			{
				$this->codigo = $linha['usuario_id'];
				$this->login = $linha['login'];
				$this->senha = $linha['senha'];
				$this->nome = $linha['nome'];
			}
		}
		else
		{
			$this->__construct();
		}
    }
    
	//Método para excluir um usuario de acordo com o código
	public function Excluir($codigo)
    {
    	$SQL = 'DELETE FROM "public"."usuario" WHERE "usuario_id"='.$codigo.';';
		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	

	//Método para alterar um usuario
    function Alterar()
    {
        $SQL = 'UPDATE "public"."usuario" SET 
        "login"=\''.$this->login.'\', 
        "senha"=md5(\''.$this->senha.'\'),
        "nome"=\''.$this->nome.'\' 
        WHERE 
        "usuario_id"='.$this->codigo.';';
        
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	//Metod que cadastra um novo usuario no sistema
	public function Salvar()
    {
    	$SQL = 'INSERT INTO 
					"public"."usuario" ("login","senha","nome") 
				VALUES 
					(\''.$this->login.'\', md5(\''.$this->senha.'\'),\''.$this->nome.'\');';
		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
    }
	
	//Método que lista os usuarios em um array para preencher o grid
	public function ListaUsuarioArray()
    {
    	$SQL = 'SELECT * FROM "public"."usuario" order by "nome";';
    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$arr = "";
		$cont = -1;
		
    	foreach($tbl as $chave => $linha)
		{
			$lin[0] = $linha['usuario_id'];			
			$lin[1] = '<![CDATA[<span>'.$linha['nome'].'</span> ]]>';
			$lin[2] = '<![CDATA[<span>'.$linha['login'].'</span> ]]>';
			$arr[$cont++] = $lin;
		}
		
		return $arr;
    }
}


?>