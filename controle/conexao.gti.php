<?php
//IMPORTACAO da ADODB
require_once('../biblioteca/adodb5/adodb.inc.php');
require_once('../biblioteca/adodb5/adodb-pager.inc.php'); 

require_once('../config.cls.php');

/**
 * Classe que efetua processos controlados em bancos de dados.
 *
 * ------------------------------------------------------------
 *
 *		CLASSE PARA CONEXAO COM BANCOS DE DADOS DIVERSOS
 *		Facade sobre a classe ADODB5
 *		Propriedade da GTI - Criacao:18/12/2007
 *		Ultima Modificacao: 10/09/2009
 *		Modificacdo por: Silas Antonio Cereda da Silva
 */

class gtiConexao
{
	//variaveis privadas
    private $m_host;
	private $m_usuario;
	private $m_senha;
	private $m_esquema;
	private $m_driver;

	//objeto de conexao
	private $m_conexao;
	
	private $m_conf;

	//construtor
	function __Construct()
    {
    	$this->gtiDefineConexao();
    	$m_conexao = false;
		set_exception_handler(array("gtiConexao", "catchException"));
    	$this->m_conf = new clsConfig();
    }
	
	//Captura excecoes
	function catchException($exception)
	{
		$m_conf = new clsConfig();
		$m_conf->ExibeErro($m_conf->GetPaginaRetorno(),$exception->getMessage());
	}
	
	//PROPRIEDADES----------------------------------------------
	
	public function SetConf($value)
    {
    	$this->m_conf = $value;
    }
    
    public function GetConf()
    {
    	return $this->m_conf;
    }
        
	//propriedade HOST
	public function SetHost($value)
	{
		$this->m_host = $value;
	}
	
	public function GetHost()
	{
		return $this->m_host;
	}
	
	//propriedade USUARIO
	public function SetUsuario($value)
	{
		$this->m_usuario = $value;
	}
	
	public function GetUsuario()
	{
		return $this->m_usuario;
	}
	
	//propriedade SENHA
	public function SetSenha($value)
	{
		$this->m_senha = $value;
	}
	public function GetSenha()
	{
		return $this->m_senha;
	}
	
	//propriedade ESQUEMA
	public function SetEsquema($value)
	{
		$this->m_esquema = $value;
	}
	
	public function GetEsquema()
	{
		return $this->m_esquema;
	}
	
	//propriedade DRIVER
	public function SetDriver($value)
	{
		$this->m_driver = $value;
	}
	
	public function GetDriver()
	{
		return $this->m_driver;
	}
	
	//propriedade CONEXÃO
	public function SetConexao($value)
	{
		$this->m_conexao = $value;
	}
	
	public function GetConexao()
	{
		return $this->m_conexao;
	}	

	
	/**
	* -------------------------------------------------------------------------------
	* Metodo para ser usado com a string montada diretamente no codigo. Abra a classe
	* gtiConexao.class.php para editar essas informacoes.
	*---------------------------------------------------------------------------------
	*PARAMETROS (nenhum)*/

	public function gtiDefineConexao()
	{
		$conf = new clsConfig();
		$this->m_host = $conf->GetHost();
		$this->m_usuario = $conf->GetUsuario();
		$this->m_senha = $conf->GetSenha();
		$this->m_esquema = $conf->GetEsquema();

		$this->m_driver = $conf->GetDriver();
	}

	/**
	* -------------------------------------------------------------------------------
	* Metodo que cria a conexao com o banco definido e em seguida se conecta a ele.
	* Para modificar a conexao utilize o metodo gtiDefineConexao().
	*---------------------------------------------------------------------------------
	*PARAMETROS (nenhum)*/

	public function gtiConecta()
	{
		$this->m_conexao = &ADONewConnection($this->m_driver);
		if(!$this->m_conexao->PConnect($this->m_host, $this->m_usuario,$this->m_senha,$this->m_esquema))		
			throw new Exception($this->m_conexao->ErrorMsg());
		 
	}

	/**
	* -------------------------------------------------------------------------------
	* Metodo que desconecta do banco de dados utilizado.
	*---------------------------------------------------------------------------------
	*PARAMETROS (nenhum)*/

	public function gtiDesconecta()
	{
		$this->m_conexao->close();
	}

	/**
	* -------------------------------------------------------------------------------
	* Metodo que executa uma string SQL qualquer no banco de dados, sem retornar
	* nenhum tipo de valor. (INSERT, UPDATE e DELETE)
	*---------------------------------------------------------------------------------
	*PARAMETROS ($sql)
	*1: $sql: String SQL a ser executada.
	**/

	public function gtiExecutaSQL($sql)
	{
		if(!$this->m_conexao->Execute($sql))
			throw new Exception($this->m_conexao->ErrorMsg());
	
	}
	
	/**
	* -------------------------------------------------------------------------------
	* Metodo que com base em uma consulta SQL retorna uma tabela preechida com os d
	* dados pesquisados no banco.
	*---------------------------------------------------------------------------------
	*PARAMETROS ($sql)
	*1:$sql: String SQL a ser executada
	**/
	public function gtiPreencheTabela($sql)
	{
		$tbl = $this->m_conexao->Execute($sql);	
		if(!$tbl)
			throw new Exception($this->m_conexao->ErrorMsg());
		else
			return $tbl;
	}
	
	
	/**
	* -------------------------------------------------------------------------------
	* Metodo que com base em uma consulta SQL retorna uma array preechido com os d
	* dados pesquisados no banco.
	*---------------------------------------------------------------------------------
	*PARAMETROS ($sql)
	*1:$sql: String SQL a ser executada
	**/
	public function gtiPreencheArray($sql)
	{
		$tbl = $this->m_conexao->GetAll($sql);			 
		if(!$tbl)
			throw new Exception($this->m_conexao->ErrorMsg());
		else
			return $tbl;
	}
}
?>