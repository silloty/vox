<?php

/**
* Classe para manipulação de dados referente a realização de uma manifestação
* @author Silas Antônio Cereda da Silva
* @version 1.0
* since 10/02/2009
* Criação da classe
**/


require_once("../controle/conexao.gti.php");
require_once("../controle/valida.gti.php");
require_once("../funcao.php");

class clsManifestacao
{
	
	// CAMPOS PRIVADOS-----------------------------------------
	
	private $codigo;
	private $nome;
	private $cpf;
	private $endereco;
	private $telefone;	
	private $email;
	private $data_criacao;
	private $data_finalizacao;
	private $registro;
	private $assunto;
	private $conteudo;	
	private $identificacao;
	private $resposta_final;
	private $anonimato;
	private $feedback;
	
	private $clientela;
	private $codigo_clientela;
	
	private $status;
	private $codigo_status;
	
	private $tipo;
	private $codigo_tipo;
	
	private $departamentos;	
	private $departamentos_simples;
	
	private $data_envio;
	private $data_resposta;
	private $hora_envio;
	private $hora_resposta;
	private $resposta;
	
	private $visualizado;
	
	
	
	
		
	//PROPRIEDADES----------------------------------------------
	
	//propriedade CODIGO
	public function SetCodigo($value)
	{
		$this->codigo = $value;
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
	
	//propriedade CPF
	public function SetCpf($value)
	{
		$this->cpf = $value;
	}
	public function GetCpf()
	{
		return $this->cpf;
	}
	
	//propriedade ENDEREÇO
	public function SetEndereco($value)
	{
		$this->endereco = $value;
	}
	public function GetEndereco()
	{
		return $this->endereco;
	}
	
	//propriedade TELEFONE
	public function SetTelefone($value)
	{
		$this->telefone = $value;
	}
	public function GetTelefone()
	{
		return $this->telefone;
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
	
	//propriedade DATA CRIAÇÃO
	public function SetDataCriacao($value)
	{
		$this->data_criacao = $value;
	}
	public function GetDataCriacao()
	{
		return $this->data_criacao;
	}
	
	//propriedade DATA FINALIZAÇÃO
	public function SetDataFinalizacao($value)
	{
		$this->data_finalizacao = $value;
	}
	public function GetDataFinalizacao()
	{
		return $this->data_finalizacao;
	}
	
	//propriedade REGISTRO
	public function SetRegistro($value)
	{
		$this->registro = $value;
	}
	public function GetRegistro()
	{
		return $this->registro;
	}
	
	//propriedade ASSUNTO
	public function SetAssunto($value)
	{
		$this->assunto = $value;
	}
	public function GetAssunto()
	{
		return $this->assunto;
	}
	
	//propriedade CONTEUDO
	public function SetConteudo($value)
	{
		$this->conteudo = $value;
	}
	public function GetConteudo()
	{
		return $this->conteudo;
	}
	
	//propriedade IDENTIFICAÇÃO
	public function SetIdentificacao($value)
	{
		$this->identificacao = $value;
	}
	public function GetIdentificacao()
	{
		return $this->identificacao;
	}
	
	//propriedade RESPOSTA FINAL
	public function SetRespostaFinal($value)
	{
		$this->resposta_final = $value;
	}
	public function GetRespostaFinal()
	{
		return $this->resposta_final;
	}
	
	//propriedade ANONIMATO
	public function SetAnonimato($value)
	{
		$this->anonimato = $value;
	}
	public function GetAnonimato()
	{
		return $this->anonimato;
	}
	
	
	//propriedade CLIENTELA
	public function SetClientela($value)
	{
		$this->clientela = $value;
	}
	public function GetClientela()
	{
		return $this->clientela;
	}
	
	//propriedade CÓDIGO DA CLIENTELA
	public function SetCodigoClientela($value)
	{
		$this->codigo_clientela = $value;
	}
	public function GetCodigoClientela()
	{
		return $this->codigo_clientela;
	}
	
	//propriedade STATUS
	public function SetStatus($value)
	{
		$this->status = $value;
	}
	public function GetStatus()
	{
		return $this->status;
	}
	
	//propriedade CÓDIGO DO STATUS
	public function SetCodigoStatus($value)
	{
		$this->codigo_status = $value;
	}
	public function GetCodigoStatus()
	{
		return $this->codigo_status;
	}
	
	//propriedade TIPO
	public function SetTipo($value)
	{
		$this->tipo = $value;
	}
	public function GetTipo()
	{
		return $this->tipo;
	}
	
	//propriedade CÓDIGO DO TIPO
	public function SetCodigoTipo($value)
	{
		$this->codigo_tipo = $value;
	}
	public function GetCodigoTipo()
	{
		return $this->codigo_tipo;
	}
	
	
	//propriedade DEPARTAMENTOS
	public function SetDepartamentos($value)
	{
		$this->departamentos = $value;
	}
	public function GetDepartamentos()
	{
		return $this->departamentos;
	}
	
	//propriedade DEPARTAMENTOS SEM HTML
	public function SetDepartamentosSimples($value)
	{
		$this->departamentos_simples = $value;
	}
	public function GetDepartamentosSimples()
	{
		return $this->departamentos_simples;
	}
	
	//propriedade DATA ENVIO
	public function SetDataEnvio($value)
	{
		$this->data_envio = $value;
	}
	public function GetDataEnvio()
	{
		return $this->data_envio;
	}
	
	//propriedade DATA RESPOSTA
	public function SetDataResposta($value)
	{
		$this->data_resposta = $value;
	}
	public function GetDataResposta()
	{
		return $this->data_resposta;
	}
	
	//propriedade RESPOSTA DO DEPARTAMENTO
	public function SetResposta($value)
	{
		$this->resposta = $value;
	}
	public function GetResposta()
	{
		return $this->resposta;
	}
	
	//propriedade FEEDBACK
	public function SetFeedback($value)
	{
		$this->feedback = $value;
	}
	public function GetFeedback()
	{
		return $this->feedback;
	}
	public function SetHoraEnvio($hora_envio)
	{
		$this->hora_envio = $hora_envio;
	}
	public function GetHoraEnvio()
	{
		return $this->hora_envio;
	}
	public function SetHoraResposta($hora_resposta)
	{
		$this->hora_resposta = $hora_resposta;
	}
	public function GetHoraResposta()
	{
		return $this->hora_resposta;
	}
	public function GetDataHora(){
		return $this->data_hora;
	}
	public function SetDataHora($data_hora){
		$this->data_hora = $data_hora;
	}
	public function GetVisualizado(){
		return $this->visualizado;
	}
	public function SetVisualizado($visualizado){
		$this->visualizado = $visualizado;
	}
    //MÉTODOS------------------------------------------------------
	
	//METODO CONSTRUTOR
	public function __construct()
	{

		$this->codigo= "";
		$this->nome= "";
		$this->cpf= "";
		$this->endereco= "";
		$this->telefone= "";
		$this->email= "";
		$this->data_criacao= "";
		$this->data_finalizacao= "";
		$this->registro= "";
		$this->assunto= "";
		$this->conteudo= "";
		$this->identificacao= "";
		$this->resposta_final="Sua manifesta&ccedil;&atilde;o ainda n&atilde;o teve uma resposta final.";
		$this->anonimato="";
		$this->feedback="O manifestante n&atilde;o enviou um feedback ";
		
		$this->clientela= "";
		$this->codigo_clientela= "";
		
		$this->status= "";
		$this->codigo_status= "";
		
		$this->tipo="";
		$this->codigo_tipo="";
		
		$this->departamentos="";
		$this->departamentos_simples="";
		
		$this->data_envio="";
		$this->data_resposta="";
		
		$this->hora_envio="";
		$this->hora_resposta="";
		
		$this->data_hora="";
		
		$this->resposta="";
		$this->visualizado="";
		
	}
	public function MarcarComoVisto(){
		$con = new gtiConexao();
		$con->gtiConecta();
		$sql = 'UPDATE public.manifestacao SET visualizado = TRUE WHERE manifestacao_id = '.$this->codigo;		
		$con->gtiExecutaSQL($sql);
		$this->visualizado = 't';
	}
	public function DesmarcarComoVisto(){
		$con = new gtiConexao();
		$con->gtiConecta();
		$sql = 'UPDATE public.manifestacao SET visualizado = FALSE WHERE manifestacao_id = '.$this->codigo;
		$con->gtiExecutaSQL($sql);		
		$this->visualizado = 'f';
	}
	//METODO QUE ENVIA UMA MANIFESTACAO AO SISTEMA
	public function Enviar()
    {
		require_once("../controle/util.gti.php");

		$reg= new gtiUtil();	
		
		// Variavél status recebe 2 porque corresponde a uma manifestação do tipo aberta
		$this->status = 2;
		
		//gerando registro unico para a manifestacao e para o andamento da ouvidoria
		$this->registro = $reg->GeraRegistroUnico();
		//$reg_andamento = $reg->GeraRegistroUnico();
		
		$con = new gtiConexao();
		$con->gtiConecta();
		//$data_hora = date("d/m/y H:m:s");
		$data_hora = date("H:m:s");		
		//gravando manifestacao do manifestante no banco de dados
    	$SQL = 'INSERT INTO 
					public.manifestacao (forma_identificacao, nome, email, cpf, telefone,
					ref_tipo, assunto, conteudo, ref_clientela, registro,
					anonimato, data_criacao, ref_status, endereco, data_hora, visualizado) 
				VALUES 
					(\''.$this->identificacao.'\', \''.$this->nome.'\' , \''.$this->email.'\'
					, \''.$this->cpf.'\', \''.$this->telefone.'\', '.$this->tipo.'
					, \''.$this->assunto.'\', \''.$this->conteudo.'\'
					, '.$this->clientela.', \''.$this->registro.'\' 
					, \''.$this->anonimato.'\', \''.$this->data_criacao.'\'
					,'.$this->status.', \''.$this->endereco.'\', now(), false) RETURNING manifestacao_id;';
					
					
					
		//$con->gtiExecutaSQL($SQL);	 
 		$dados = $con->gtiPreencheTabela($SQL);	
		
		/* COMENTADO DEVIDO A Leíse não achar que o primeiro 
		departamento que a manifestação passa seja ouvidoria
		//O campo ref_departamento recebe 1 pois é o codigo padrão correspondente a ouvidoria.
		$SQL = 'INSERT INTO public.andamento (ref_manifestacao, ref_departamento, registro, data_envio, resposta, data_resposta) VALUES ((SELECT max(manifestacao_id) FROM manifestacao),1,\''.$reg_andamento.'\', now(), \'A sua manifestacao foi recebida com sucesso\', now());';
		
		$con->gtiExecutaSQL($SQL);
		*/
		
		$con->gtiDesconecta();  
		
		//envio de dados por email para o manifestante
		require_once("../controle/email.gti.php");
		require_once("../config.cls.php");
		
		$config = new clsConfig();
		
		$email = new gtiMail();
		
		//TEXTO QUE SERA ENVIADO VIA EMAIL PARA O MANIFESTANTE
		$texto_email = '
		<table width="100%" border="1">
  <tr>
    <td><div align="center"><strong>SUA MANIFESTA&Ccedil;&Atilde;O FOI ENCAMINHADA COM SUCESSO!</strong></div></td>
  </tr>
  <tr>
    <td><p align="center">--------------------------------------------------------------------------------------------------------------------------</p>
    <p align="justify">Caro manifestante, o '.utf8_encode($config->GetNomeInstituicao()).' agradece a sua manifesta&ccedil;&atilde;o. Suas considera&ccedil;&otilde;es foram imediatamente remetidas a nosso departamento de ouvidoria e ser&atilde;o analisadas por nosso(a) ouvidor(a). Para ter acesso ao andamento de sua manifesta&ccedil;&atilde;o entre com o seguinte n&uacute;mero <span style="font-size: large;	color: #FF0000;	font-weight: bold;">'.$this->registro.'</span> na nossa p&aacute;gina de acompanhamento <a href="'.$config->GetRaiz().'/visao/consulta.frm.php" target="_blank">'.$config->GetRaiz().'/visao/consulta.frm.php</a>.</p>
    <p align="justify">Assim que a sua manifesta&ccedil;&atilde;o for analisada e tiver uma resposta, cujo prazo é de 20 dias, prorrogáveis por mais 10 dias, um segundo email sera enviado para esta caixa de mensagem. A ouvidoria agradece a sua participa&ccedil;&atilde;o no crescimento de nossa institui&ccedil;&atilde;o.</p>
	<p align="justify">C&oacute;digo da Manifesta&ccedil;&atilde;o: '.$dados->fields["manifestacao_id"].'</p>
    <p align="center">--------------------------------------------------------------------------------------------------------------------------</p>
    </td>
  </tr>
  <tr>
    <td><div align="center">
      <p><strong>VOX - Sistema de Ouvidoria</strong></p>
      <p><strong>'.utf8_encode($config->GetNomeInstituicao()).'</strong></p>
    </div></td>
  </tr>
</table>
		';
		
		$email->AdicionarTexto($texto_email);
		if($email->Enviar($config->GetEmailOuvidoria(), $this->email, utf8_encode('Dados da sua manifestação'), $config->GetEmailOuvidoria())==false)
		{
			$this->DeletaManifestacao($this->registro);
			$config->ExibeErro($config->GetPaginaRetorno(), utf8_encode("Erro ao enviar o email. Manifestação não realizada"));
		}
	
		
    }
	
	//METODO QUE DELETA A MANIFESTACAO CASO OCORRA ERRO NO ENVIO DO EMAIL
	function DeletaManifestacao($registro)
	{
		$SQL = 'DELETE FROM manifestacao
				WHERE registro = \''.$this->registro.'\';';
				
		$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
	}
	
	
	//METODO PARA CONSULTAR MANIFESTACAO A PARTIR DE UM REGISTRO JÁ SETADO
	public function Consultar()
	{
	
		$con = new gtiConexao();
		$con->gtiConecta();
		
		require_once("../controle/hora.gti.php");
		require_once("../controle/data.gti.php");
		$data = new gtiData();
		$hora = new gtiHora();
		
		//PREENCHER POR COMPLETO O OBJETO MANIFESTACAO
		
		//Capturando dados basicos de uma manifestacao
		$SQL = 'SELECT * from vw_manifestacao WHERE registro=\''.$this->registro.'\';';						
		
		$dados = $con->gtiPreencheTabela($SQL);
		
		if($dados->RecordCount()>0)
		{
			foreach($dados as $chave => $linha)
			{
				$this->codigo = $linha['manifestacao_id'];
				$this->nome = $linha['nome'];
				$this->cpf = $linha['cpf'];
				$this->endereco = $linha['endereco'];
				$this->telefone = $linha['telefone'];
				$this->email = $linha['email'];
				$this->data_criacao = $linha['data_criacao'];
				$this->data_finalizacao = $linha['data_finalizacao'];
				$this->registro = $linha['registro'];
				$this->assunto = $linha['assunto'];
				$this->conteudo = $linha['conteudo'];
				$this->identificacao = $linha['forma_identificacao'];
				$this->feedback = $linha['feedback'];
				
				if (trim($linha['resposta_final']) != '')
				{
					$this->resposta_final = $linha['resposta_final'];
				}				
				
				$this->anonimato = $linha['anonimato'];
				
				$this->nome_clientela = $linha['nome_clientela'];
				$this->codigo_clientela = $linha['codigo_clientela'];
				
				$this->nome_status = $linha['nome_status'];
				$this->codigo_status = $linha['codigo_status'];
				
				$this->nome_tipo = $linha['nome_tipo'];
				$this->codigo_tipo = $linha['codigo_tipo'];		
				$this->visualizado = $linha['visualizado'];
			}
		} 
		
		//capturando os departamentos por quais a manifestacao passou
		$SQL = '
		SELECT 
		d.nome, 
		a.resposta,
		a.data_envio
		FROM 
		departamento as d, 
		andamento as a 
		WHERE 
		a.ref_manifestacao=(select manifestacao_id from manifestacao where registro=\''.$this->registro.'\')
		AND
		d.departamento_id=a.ref_departamento;';
		
		$depto = $con->gtiPreencheTabela($SQL);
		$this->departamentos = "";
		
		if($depto->RecordCount()>0)
		{
			foreach($depto as $chave => $linha)
			{
			
				$dif = $hora->difDataHora($data->ConverteDataBR($linha['data_envio']),"","d");
				$depto = "";
				if ((trim($linha['resposta']) == '') and ($dif>5))
				{
					$depto = '<span style="color:#FF0000;">'.$linha['nome'].'</span>';
				} 
				else if((trim($linha['resposta']) == '') and ($dif<=5))
				{
					$depto = '<span style="color:#FFCC33;">'.$linha['nome'].'</span>';
				}
				else
				{
					$depto = '<span style="color:#009900;">'.$linha['nome'].'</span>';
				}
			
				$this->departamentos .= $depto . ', ';
			}
		} 
		
		$this->departamentos = substr($this->departamentos, 0, -2);
		


	$con->gtiDesconecta();  

 
	}
	
	//METODO PARA CONSULTAR A MANIFESTACAO A PARTIR DO CODIGO JÁ SETADO 
	public function ConsultarPorCodigo()
	{
	
		require_once("../controle/hora.gti.php");
		require_once("../controle/data.gti.php");
		$data = new gtiData();
		$hora = new gtiHora();
		
		//PREENCHER POR COMPLETO O OBJETO MANIFESTACAO
		
		//Capturando dados basicos de uma manifestacao
		$SQL = 'SELECT * from vw_manifestacao WHERE manifestacao_id='.$this->codigo.';';
		
		$con = new gtiConexao();
		$con->gtiConecta();
						
		$dados = $con->gtiPreencheTabela($SQL);
					
		if($dados->RecordCount()>0)
		{
			foreach($dados as $chave => $linha)
			{
				$this->codigo = $linha['manifestacao_id'];
				$this->nome = $linha['nome'];
				$this->cpf = $linha['cpf'];
				$this->endereco = $linha['endereco'];
				$this->telefone = $linha['telefone'];
				$this->email = $linha['email'];
				$this->data_criacao = $linha['data_criacao'];
				$this->data_finalizacao = $linha['data_finalizacao'];
				$this->registro = $linha['registro'];
				$this->assunto = $linha['assunto'];
				$this->conteudo = $linha['conteudo'];
				$this->identificacao = $linha['forma_identificacao'];
				$this->feedback = $linha['feedback'];
				$this->data_hora = substr($linha['hora_criacao'], 0 , 8);
				$this->visualizado = $linha['visualizado'];
				if (trim($linha['resposta_final']) != '')
				{
					$this->resposta_final = $linha['resposta_final'];
				}				
				
				$this->anonimato = $linha['anonimato'];
				
				$this->clientela = $linha['nome_clientela'];
				$this->codigo_clientela = $linha['codigo_clientela'];
				
				$this->status = $linha['nome_status'];
				$this->codigo_status = $linha['codigo_status'];
				
				$this->tipo = $linha['nome_tipo'];
				$this->codigo_tipo = $linha['codigo_tipo'];		
			}
		} 
		
		//capturando os departamentos por quais a manifestacao passou
		$SQL = '
		SELECT 
		d.nome, 
		a.resposta,
		a.data_envio
		FROM 
		departamento as d, 
		andamento as a 
		WHERE 
		a.ref_manifestacao=(select manifestacao_id from manifestacao where registro=\''.$this->registro.'\')
		AND
		d.departamento_id=a.ref_departamento;';
		
		$depto = $con->gtiPreencheTabela($SQL);
		
		$this->departamentos = "";
		$this->departamentos_simples = "";
		
		if($depto->RecordCount()>0)
		{
			foreach($depto as $chave => $linha)
			{
			
				$dif = $hora->difDataHora($data->ConverteDataBR($linha['data_envio']),"","d");
				
				$depto = "";
				$depto_simples = "";
				
				if ((trim($linha['resposta']) == '') and ($dif>5))
				{
					$depto = '<span style="color:#FF0000;">'.$linha['nome'].'</span>';
					$depto_simples = $linha['nome'];
				} 
				else if((trim($linha['resposta']) == '') and ($dif<=5))
				{
				 	//Alteração em 08/10/2014 - Cor original #FFCC00 - COLÉGIO PEDRO II
					$depto = '<span style="color:#FFCC00;">'.$linha['nome'].'</span>';
					$depto_simples = $linha['nome'];
				}
				else
				{
					$depto = '<span style="color:#009900;">'.$linha['nome'].'</span>';
					$depto_simples = $linha['nome'];
				}
				
				$this->departamentos .= $depto . ', ';
				$this->departamentos_simples .= $depto_simples . ', ';
			}
		} 
		
		$this->departamentos = substr($this->departamentos, 0, -2);
		$this->departamentos_simples = substr($this->departamentos_simples, 0, -2);


	$con->gtiDesconecta();  

 
	}
	
	
	//METODO PARA LISTAR DADOS DAS MANIFESTACÕES ABERTAS PARA PREENCHER SEU RESPECTIVO GRID
	public function ListaManifestacaoAbertasArray()
    {
		require_once("../controle/data.gti.php");
		$data = new gtiData();
		
	
    	$SQL = 
		'
		SELECT 
		m.manifestacao_id, 
		m.assunto, 
		c.nome as nome_clientela, 
		t.nome as nome_tipo, 
		m.forma_identificacao, 
		m.data_criacao,
    	m.visualizado
		FROM 
		manifestacao as m, tipo as t, clientela as c
		WHERE
		m.ref_tipo = t.tipo_id
		AND
		m.ref_clientela = c.clientela_id
		AND 
		m.ref_status = 2 
		order by "visualizado" desc, "data_criacao" desc;
		';
    	
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
				$lin[0] = $linha['manifestacao_id'];			
				$lin[1] = '<![CDATA[<span>'.$linha['assunto'].'</span> ]]>';
				$lin[2] = '<![CDATA[<span>'.$linha['nome_clientela'].'</span> ]]>';
				$lin[3] = '<![CDATA[<span>'.$linha['nome_tipo'].'</span> ]]>';	
				
				switch ($linha['forma_identificacao'])
				{
					case 'A':
						$lin[4] = '<![CDATA[<span>Anonimo</span> ]]>';
					break;
					case 'S':
						$lin[4] = '<![CDATA[<span>Sigiloso</span> ]]>';
					break;
					default:
						$lin[4] = '<![CDATA[<span>Identificado</span> ]]>';
					break;
				}
				
				$lin[5] = '<![CDATA[<span>'.$data->ConverteDataBR($linha['data_criacao']).'</span> ]]>';								
				if ($linha['visualizado'] == 't')
					$lin[6] = '<![CDATA[<span><img src="imagens/finalizar.png" width="16px" heigth="16px"></span> ]]>';
				else
					$lin[6] = '<![CDATA[<span><img src="imagens/cancelar.png"></span> ]]>';
				$lin[7] = '<![CDATA[ver^abertas_detalhes.frm.php?codigo='.$linha['manifestacao_id'].'^_self]]>';
				
				$arr[$cont++] = $lin;
			}
		}
		else
		{
			$lin[0] = '';			
			$lin[1] = '';
			$lin[2] = '';
			$lin[3] = '';	
			$lin[4] = '';
			$lin[5] = '';
			$lin[6] = '';
			$lin[7] = '';
			
			$arr[$cont++] = $lin;
		}
		return $arr;
    }
	
	
	//METODO PARA LISTAR DADOS DAS MANIFESTACÕES EM ANDAMENTO PARA PREENCHER SEU RESPECTIVO GRID
	public function ListaManifestacaoAndamentoArray()
    {
		require_once("../controle/data.gti.php");
		$data = new gtiData();		
	
    	$SQL = 
		'
		SELECT 
		m.manifestacao_id, 
		m.assunto, 
		c.nome as nome_clientela, 
		t.nome as nome_tipo, 
		m.forma_identificacao, 
		m.data_criacao,
		a.data_resposta,
    	a.hora_resposta,
    	m.visualizado
FROM 
		manifestacao as m LEFT JOIN (SELECT DISTINCT ON (ref_manifestacao)
							ref_manifestacao,
							data_resposta,
    						hora_resposta
						FROM
							andamento
						WHERE 
							data_resposta is not null
						ORDER BY
							ref_manifestacao desc) as a ON a.ref_manifestacao = m.manifestacao_id,
		tipo as t,
		clientela as c
		WHERE
		m.ref_tipo = t.tipo_id
		AND
		m.ref_clientela = c.clientela_id
		AND 
		m.ref_status = 1 
		order by "visualizado" desc, data_resposta, hora_resposta desc NULLS LAST;
		';
		    	
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
				$lin[0] = $linha['manifestacao_id'];			
				$lin[1] = '<![CDATA[<span>'.$linha['assunto'].'</span> ]]>';
				$lin[2] = '<![CDATA[<span>'.$linha['nome_clientela'].'</span> ]]>';
				$lin[3] = '<![CDATA[<span>'.$linha['nome_tipo'].'</span> ]]>';	
				
				switch ($linha['forma_identificacao'])
				{
					case 'A':
						$lin[4] = '<![CDATA[<span>Anonimo</span> ]]>';
					break;
					case 'S':
						$lin[4] = '<![CDATA[<span>Sigiloso</span> ]]>';
					break;
					default:
						$lin[4] = '<![CDATA[<span>Identificado</span> ]]>';
					break;
				}
				
				$lin[5] = '<![CDATA[<span>'.$data->ConverteDataBR($linha['data_criacao']).'</span> ]]>';
				if ($linha['visualizado'] == 't')
					$lin[6] = '<![CDATA[<span><img src="imagens/finalizar.png" width="16px" heigth="16px"></span> ]]>';
				else
					$lin[6] = '<![CDATA[<span><img src="imagens/cancelar.png"></span> ]]>';
				$lin[7] = '<![CDATA[ver^andamento_detalhes.frm.php?codigo='.$linha['manifestacao_id'].'^_self]]>';
				
				$arr[$cont++] = $lin;
			}
		}
		else
		{
			$lin[0] = '';			
			$lin[1] = '';
			$lin[2] = '';
			$lin[3] = '';	
			$lin[4] = '';
			$lin[5] = '';
			$lin[6] = '';
			$lin[7] = '';
			
			$arr[$cont++] = $lin;
		}
		return $arr;
    }
	
	
	//METODO PARA LISTAR DADOS DAS MANIFESTACÕES FECHADAS PARA PREENCHER SEU RESPECTIVO GRID
	public function ListaManifestacaoFechadasArray()
    {
		require_once("../controle/data.gti.php");
		require_once("../modelo/status.cls.php");
		
		$data = new gtiData();
		$status = new clsStatus();
	
    	$SQL = 
		'
		SELECT 
		m.manifestacao_id, 
		m.assunto, 
		c.nome as nome_clientela, 
		t.nome as nome_tipo,
		m.forma_identificacao, 
		m.data_criacao,
		m.data_finalizacao,
		m.ref_status,
    	m.visualizado
		FROM 
		manifestacao as m, tipo as t, clientela as c
		WHERE
		m.ref_tipo = t.tipo_id
		AND
		m.ref_clientela = c.clientela_id
		AND 
		m.ref_status = 3 
		order by "visualizado" desc, "data_criacao" desc;
		';
		    	
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
				$lin[0] = $linha['manifestacao_id'];			
				$lin[1] = '<![CDATA[<span>'.$linha['assunto'].'</span> ]]>';
				$lin[2] = '<![CDATA[<span>'.$linha['nome_clientela'].'</span> ]]>';
				$lin[3] = '<![CDATA[<span>'.$linha['nome_tipo'].'</span> ]]>';	
				
				switch ($linha['forma_identificacao'])
				{
					case 'A':
						$lin[4] = '<![CDATA[<span>Anonimo</span> ]]>';
					break;
					case 'S':
						$lin[4] = '<![CDATA[<span>Sigiloso</span> ]]>';
					break;
					default:
						$lin[4] = '<![CDATA[<span>Identificado</span> ]]>';
					break;
				}
				
				$status->SelecionaPorCodigo($linha['ref_status']);
				
				$lin[5] = '<![CDATA[<span>'.$data->ConverteDataBR($linha['data_criacao']).'</span> ]]>';
				$lin[6] = '<![CDATA[<span>'.$data->ConverteDataBR($linha['data_finalizacao']).'</span> ]]>';				
				$lin[7] = '<![CDATA[<span>'.$status->GetNome().'</span> ]]>';
				
				//Verifica se há um feedback
				// S - Sim e N = Não
				$feedback = "N";
				$verifica= $this->VerificaFeedback2($linha['manifestacao_id']);
				if ($verifica==true)
				{
					$feedback = "S";
				}
				
				
				$lin[8] = '<![CDATA[<span>'.$feedback.'</span> ]]>';
				if ($linha['visualizado'] == 't')
					$lin[9] = '<![CDATA[<span><img src="imagens/finalizar.png" width="16px" heigth="16px"></span> ]]>';
				else
					$lin[9] = '<![CDATA[<span><img src="imagens/cancelar.png"></span> ]]>';
				
				$lin[10] = '<![CDATA[ver^fechadas_detalhes.frm.php?codigo='.$linha['manifestacao_id'].'^_self]]>';
				
				
				$arr[$cont++] = $lin;
			}
		}
		else
		{
			$lin[0] = '';			
			$lin[1] = '';
			$lin[2] = '';
			$lin[3] = '';	
			$lin[4] = '';
			$lin[5] = '';
			$lin[6] = '';
			
			$arr[$cont++] = $lin;
		}
		return $arr;
    }
	
	
	//METODO PARA ALTERAR DADOS DE UMA MANIFESTACAO EM ABERTO
	function Alterar()
    {
    	if ($this->visualizado == 't')
    		$visualizado = '"visualizado" = TRUE';
    	else 
    		$visualizado = '"visualizado" = FALSE';
        $SQL = 'UPDATE manifestacao SET 
        "ref_tipo"=\''.$this->codigo_tipo.'\', 
        "ref_clientela"=\''.$this->codigo_clientela.'\',
        "visualizado"='.$visualizado.'
        WHERE 
        "manifestacao_id"='.$this->codigo.';';
        
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	//METODO PARA ALTERAR O STATUS DE UMA MANIFESTACAO
	function AlterarStatus()
    {
        $SQL = 'UPDATE manifestacao SET 
        ref_status='.$this->codigo_status.' 
        WHERE 
        manifestacao_id='.$this->codigo.';';
		        
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	//METODO PARA ALTERAR O STATUS E O TIPO DE MANIFESTACAO FECHADA
	function AlterarFechadas()
    {
        $SQL = 'UPDATE manifestacao SET 
        "ref_tipo"=\''.$this->codigo_tipo.'\', 
        "ref_status"=\''.$this->codigo_status.'\' 
        WHERE 
        "manifestacao_id"='.$this->codigo.';';
		        
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	//METODO QUE ENCAMINHA UMA MANIFESTACAO PARA UM DETERMINADO DEPARTAMENTO
	function EncaminharDepto($cod_depto)
	{
		require_once("../modelo/departamento.cls.php");		
		require_once("../controle/util.gti.php");	
		$departamento= new clsDepartamento();
		$departamento->SetCodigo($cod_depto);
		$departamento->Consultar();

		// Variavél status recebe 1 porque a manifestacao passara para em andamento
		$this->status = 1;
		
		$con = new gtiConexao();
		$con->gtiConecta();
		
		//Alterando o status da manifestação
    	$SQL =  $SQL = 'UPDATE manifestacao SET 
				ref_status='.$this->status.' 
				WHERE 
				manifestacao_id='.$this->codigo.';';
		
		$con->gtiExecutaSQL($SQL);		

		//gera um registro unico para o andamento
		$util = new gtiUtil();
		$reg_andamento = $util->GeraRegistroUnico();
		
		//Inserindo Novo Departamento para Manifestacao
		$SQL = 'INSERT INTO andamento (ref_manifestacao, ref_departamento, data_envio, registro, hora_envio) VALUES 
				('.$this->codigo.','.$departamento->GetCodigo().',\''.$this->data_envio.'\',\''.$reg_andamento.'\',\''.$this->hora_envio.'\');';
		
		$con->gtiExecutaSQL($SQL);			
		
		$con->gtiDesconecta();
		
		//envio de dados por email para o Departamento
		require_once("../controle/email.gti.php");
		require_once("../config.cls.php");
		
		$config = new clsConfig();
		
		$email = new gtiMail();
		
		//TEXTO QUE SERA ENVIADO VIA EMAIL PARA O DEPARTAMENTO
		if ($cod_depto != 1){
			$texto_email = '
			<table width="100%" border="1">
	  <tr>
	    <td><div align="center"><strong>A OUVIDORIA NECESSITA DE SUA RESPOSTA</strong></div></td>
	  </tr>
	  <tr>
	    <td><p align="center">--------------------------------------------------------------------------------------------------------------------------</p>
	    <p align="justify">Caro respons&aacute;vel pelo(a) <strong>' .utf8_decode($departamento->GetNome()). '</strong>, encaminho a V.Sa. a presente manifesta&ccedil;&atilde;o para que analise a sua proced&ecirc;ncia e import&acirc;ncia, e solicito a gentileza de apresentar, no prazo de 05 (cinco) dias &uacute;teis, a partir da data de recebimento deste email, seu parecer &agrave; Se&ccedil;&atilde;o de Ouvidoria, que responder&aacute; diretamente ao manifestante ou enviar&aacute; o processo a outra se&ccedil;&atilde;o caso seja necess&aacute;rio.	</p>
	    <p align="justify">Para dar seu parecer, entre no endere&ccedil;o:</p>
	    <p align="justify">
		<a href="'.$config->GetRaiz().'/visao/acompanha_depto.frm.php">'.$config->GetRaiz().'/visao/acompanha_depto.frm.php</a>
		</p>
	    <p align="justify">e digite o c&oacute;digo do seu ticket que &eacute; 
		<span style="font-size: large;	color: #FF0000;	font-weight: bold;">' .$reg_andamento. '</span></p>
	    <p align="justify">Favor n&atilde;o retornar esse email</p>
	    <p align="justify">Atenciosamente</p>
	    <p align="justify">&quot;Ouvidoria do '.utf8_encode($config->GetNomeInstituicao()).'</p>
	    <p align="center">--------------------------------------------------------------------------------------------------------------------------</p>
	    </td>
	  </tr>
	  <tr>
	    <td><div align="center">
	      <p><strong>VOX - Sistema de Ouvidoria</strong></p>
	      <p><strong>'.utf8_encode($config->GetNomeInstituicao()).'</strong></p>
	    </div></td>
	  </tr>
	</table>
			';
			
			$email->AdicionarTexto($texto_email);
			if($email->Enviar($config->GetEmailOuvidoria(), $departamento->GetEmail(), utf8_encode('Existe uma manifestação para o seu departamento'), $config->GetEmailOuvidoria())==false)
			{
				$this->DeletaAndamento($reg_andamento);
				$config->ExibeErro($config->GetPaginaRetorno(), "Erro ao enviar o email para o departamento");
				
			}
		}
		else
			return $reg_andamento;
	}
	
	//METODO QUE DELETA O ANDAMENTO DA MANIFESTACAO CASO OCORRA ERRO NO ENVIO DO EMAIL
	function DeletaAndamento($registro)
	{
		$SQL = 'DELETE FROM andamento
				WHERE registro = '.$registro.';';
		
		$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
	}
	
	
	//METODO QUE ENVIA UMA RESPOSTA DO DEPARTAMENTO PARA A MANIFESTACAO RECEBIDA POR ELE
	function Responder($reg_andamento)
    {
    	require_once("../controle/hora.gti.php");
    	$data = new gtiHora();
        $SQL = 'UPDATE andamento SET 
        resposta=\''.$this->resposta.'\', 
        data_resposta=now(),
        hora_resposta=\''.$data->GetHora().'\'
        WHERE 
        registro=\''.$reg_andamento.'\';';
		
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	//METODO QUE ENVIA UM FEEDBACK DO USUARIO PARA A OUVIDORIA AO ENCERRAR A MANIFESTACAO
	function EnviarFeedback()
    {
			
		$con = new gtiConexao();
		$con->gtiConecta();
				
		$SQL = 'SELECT * from vw_manifestacao WHERE registro=\''.$this->registro.'\';';
		$dados = $con->gtiPreencheTabela($SQL);
		
		
		
		if($dados->RecordCount()>0)
		{
			foreach($dados as $chave => $linha)
			{	
				if (trim($linha['feedback']) != '')
				{
					$feedback1 = $linha['feedback'].'<br><br>';
				}				
				
			}
		} 	
		
		$SQL = 'UPDATE manifestacao SET 
        feedback=\''.$this->feedback.'\' 
        WHERE 
        registro=\''.$this->registro.'\';';
				
		if ($feedback1!='')
		{
			$SQL = 'UPDATE manifestacao SET 
			feedback=\''.$feedback1.' '.$this->feedback.'\' 
			WHERE 
			registro=\''.$this->registro.'\';';
		}
				
    	$con = new gtiConexao();
		$con->gtiConecta();
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
    }
	
	
	// METODO QUE CAPTURA O CODIGO DE UMA MANIFESTACAO EM ANDAMENTO A PARTIR DO SEU REGISTRO
	
	function PegaCodManifestacaoPorRegAndamento($registro)
	{
	
		$con = new gtiConexao();
		$con->gtiConecta();
		
		$SQL = 'SELECT ref_manifestacao as codigo FROM andamento WHERE registro=\''.$registro.'\';';						
		
		$andamento = $con->gtiPreencheTabela($SQL);		
		foreach($andamento as $chave => $linha)
		{
			$cod_manifestacao = $linha['codigo'];
		}		
		
		$con->gtiDesconecta();
		
		return $cod_manifestacao;
	}
	
	
	// METODO QUE VERIFICA SE UMA MANIFESTACAO JÁ FOI RESONDIDA POR 
	// UM DETERMINADO DEPARTAMENTO
	function VerificaRespondida($reg_andamento)
	{
		$con = new gtiConexao();
		$con->gtiConecta();
		
		$SQL = 'SELECT resposta FROM andamento WHERE registro=\''.$reg_andamento.'\';';						
		
		$andamento = $con->gtiPreencheTabela($SQL);	
		$existe=false;
			
		foreach($andamento as $chave => $linha)
		{
			if (($linha['resposta']) != '')
			{
				$existe=true;			
			}
		}		
		
		$con->gtiDesconecta();
		return $existe;
	
	}
	
	// METODO QUE FINALIZA UMA MANIFESTACAO E ENVIA UMA RESPOSTA FINAL PARA A MANIFESTACAO
	// ASSIM COMO UM EMAIL PARA O MANMIFESTANTE 
	function Finalizar()
    {
		$con = new gtiConexao();
		$con->gtiConecta();
		
		$SQL = 'SELECT * from vw_manifestacao WHERE manifestacao_id='.$this->codigo.';';
		$dados = $con->gtiPreencheTabela($SQL);
					
		if($dados->RecordCount()>0)
		{
			foreach($dados as $chave => $linha)
			{	
				if (trim($linha['resposta_final']) != '')
				{
					$resposta1 =anti_injection($linha['resposta_final']) .'<br><br>';
				}				
				
			}
		} 	
		$resposta_final = anti_injection($this->resposta_final);
		$SQL = 'UPDATE manifestacao SET 
        resposta_final=\''.$resposta_final.'\', 
        data_finalizacao=now(),
		ref_status=3 
        WHERE 
        manifestacao_id='.$this->codigo.';';
		
		if ($resposta1!='')
		{
			 $SQL = 'UPDATE manifestacao SET 
        resposta_final=\''.$resposta1 .' '. $resposta_final.'\', 
        data_finalizacao=now(),
		ref_status=3 
        WHERE 
        manifestacao_id='.$this->codigo.';';
			
		}
		   	
		$con->gtiExecutaSQL($SQL);
		$con->gtiDesconecta();
		
				//envio de dados por email para o Manifestante
		require_once("../controle/email.gti.php");
		require_once("../config.cls.php");
		
		$config = new clsConfig();
		
		$email = new gtiMail();
		
		//TEXTO QUE SERA ENVIADO VIA EMAIL PARA O MANIFESTANTE
		$texto_email = '
		<table width="100%" border="1">
  <tr>
    <td><div align="center"><strong>A SUA MANIFESTA&Ccedil;&Atilde;O TEM UMA RESPOSTA FINAL</strong></div></td>
  </tr>
  <tr>
    <td><p align="center">--------------------------------------------------------------------------------------------------------------------------</p>
    <p align="justify">Caro manifestante, o '.utf8_encode($config->GetNomeInstituicao()).' agradece a sua manifesta&ccedil;&atilde;o. H&aacute; uma resposta final para sua manifesta&ccedil;&atilde;o. Para consultar a resposta entre com n&uacute;mero do seu registro <span style="font-size: large;	color: #FF0000;	font-weight: bold;">' .$this->registro. '</span> na nossa p&aacute;gina de acompanhamento <a href="'.$config->GetRaiz().'/visao/consulta.frm.php" target="_blank">'.$config->GetRaiz().'/visao/consulta.frm.php</a>.</p>
    <p align="justify">A ouvidoria gostaria muito de saber a sua opini&atilde;o sobre este processo. Se voc&ecirc; desejar utilize o campo de resposta que se encontra no final da nossa p&aacute;gina de acompanhamento. </p>
	<p align="justify">A Ouvidoria do '.utf8_encode($config->GetNomeInstituicao()).' agradece</p>
    <p align="center">--------------------------------------------------------------------------------------------------------------------------</p>
    </td>
  </tr>
  <tr>
    <td><div align="center">
      <p><strong>VOX - Sistema de Ouvidoria</strong></p>
      <p><strong>'.utf8_encode($config->GetNomeInstituicao()).'</strong></p>
    </div></td>
  </tr>
</table>
		';
		
		$email->AdicionarTexto($texto_email);
		$email->Enviar($config->GetEmailOuvidoria(), $this->email, utf8_encode('Existe uma resposta final para a sua manifestação'),$config->GetEmailOuvidoria());
		
    }
	
	
	//METODO QUE VERIFICA SE A OUVIDORIA ENVIOU UMA RESPOSTA FINAL
	function VerificaRespostaFinal()
	{
		$con = new gtiConexao();
		$con->gtiConecta();
		
		$SQL = 'SELECT resposta_final FROM manifestacao WHERE registro=\''.$this->registro.'\';';						
		
		$manifestacao = $con->gtiPreencheTabela($SQL);	
		$existe=false;
			
		foreach($manifestacao as $chave => $linha)
		{
			if (($linha['resposta_final']) != '')
			{
				$existe=true;			
			}
		}		
		
		$con->gtiDesconecta();
		return $existe;
	
	}
	
	//METODO QUE VERIFICA SE HÁ UM FEEDBACK DO MANISTANTE PARA A OUVIDORIA
	function VerificaFeedback()
	{
		$con = new gtiConexao();
		$con->gtiConecta();
		
		$SQL = 'SELECT feedback FROM manifestacao WHERE registro=\''.$this->registro.'\';';						

		$manifestacao = $con->gtiPreencheTabela($SQL);	
		$existe=false;
		
			
		foreach($manifestacao as $chave => $linha)
		{
			if (($linha['feedback']) != '')
			{
				$existe=true;
			}
		}		
		
		$con->gtiDesconecta();
		return $existe;
	
	}
	
	//METODO QUE VERIFICA SE HÁ UM FEEDBACK DO MANISTANTE PARA A OUVIDORIA
	function VerificaFeedback2($codigo)
	{
		$con = new gtiConexao();
		$con->gtiConecta();
		
		$SQL = 'SELECT feedback FROM manifestacao WHERE manifestacao_id='.$codigo.';';						

		$manifestacao = $con->gtiPreencheTabela($SQL);	
		$existe=false;
		
			
		foreach($manifestacao as $chave => $linha)
		{
			if (($linha['feedback']) != '')
			{
				$existe=true;
			}
		}		
		
		$con->gtiDesconecta();
		return $existe;
	
	}
	
	// METODO QUE VERIFICA O TOTAL DE MANIFESTAÇÕES EXISTENTES EM DIFERENTES STATUS
	function PegaTotalManifestacao($status)
	{
		$con = new gtiConexao();
		$con->gtiConecta();
		
		/* 1 - Andamento
		*  2 - Abertas
		*  3 - Fechadas
		*/
		
		$SQL = 'SELECT count(manifestacao_id) as total FROM manifestacao WHERE ref_status='.$status.';';
		if ($status != 1 and $status != 2)
		{
			$SQL = 'SELECT count(manifestacao_id) as total FROM manifestacao WHERE ref_status <> 1 AND ref_status <> 2;';
		}		
		
		$total = $con->gtiPreencheTabela($SQL);	
		
		foreach($total as $chave => $linha)
		{
			$cont = $linha['total'];
		}		
		
		return $cont;
	}
	
	// METODO QUE CAPTURA AS RESPOSTAS ENVIADAS PELOS DEPARTAMENTOS
	function PegaRespostasDepartamentos($cod_manifestacao)
	{
	
		$con = new gtiConexao();
		$con->gtiConecta();
		
		require_once("../controle/data.gti.php");	
		require_once("../controle/hora.gti.php");	
		$data = new gtiData();
		$hora = new gtiHora();
		
		$SQL = 
		'SELECT 
		d.nome,
		d.departamento_id,
		a.andamento_id,
		a.resposta, 
		a.data_envio, 
		a.data_resposta,
		a.hora_envio, 
		a.hora_resposta
		FROM 
		departamento as d,
		andamento as a
		WHERE 
		a.ref_departamento = d.departamento_id
		AND
		a.ref_manifestacao='.$cod_manifestacao.' ORDER BY a.data_envio,a.data_resposta,a.andamento_id;';
	
	    		
		$total = $con->gtiPreencheTabela($SQL);	
		
		$resposta = "";
		
		
		foreach($total as $chave => $linha)
		{
		
			$dif = $hora->difDataHora($data->ConverteDataBR($linha['data_envio']),"","d");
			$depto = "";
			if ((trim($linha['resposta']) == '') and ($dif>5))
			{
				$coddepto_codmanifestacao = $linha['departamento_id'].':'.$cod_manifestacao.":".$linha['andamento_id'];
				$res = 
				'<tr>
				<td style="color:#FF0000;">'.utf8_encode($linha['nome']).'</td>
				<td style="color:#FF0000;" >Em espera</td>
				<td style="color:#FF0000; text-align:center;">'.$data->ConverteDataBR($linha['data_envio']);
				if (!empty($linha['hora_envio']))
					$res .= ' '.$linha['hora_envio'];
				
				$res .= '</td><td style="color:#FF0000; text-align:center;" width="8px"><input name="btnReenviar" type="button" class="botaoA" id="btnReenviar" value="Reenviar Email"  onclick="submitForm(\'frmDetalhes\',\'reenviar\',\''.$coddepto_codmanifestacao.'\');"/></td>
				</tr>';
			} 
			else if((trim($linha['resposta']) == '') and ($dif<=5))
			{ 
				//Alteração em 08/10/2014 - Cor original #FFCC00 - COLÉGIO PEDRO II
				$coddepto_codmanifestacao = $linha['departamento_id'].':'.$cod_manifestacao.":".$linha['andamento_id'];
				$res = 
				'<tr>
				<td style="color:#FFCC00;">'.utf8_encode($linha['nome']).'</td>
				<td style="color:#FFCC00;" >Em espera</td>
				<td style="color:#FFCC00; text-align:center;">'.$data->ConverteDataBR($linha['data_envio']);
				if (!empty($linha['hora_envio']))
					$res .= ' '.$linha['hora_envio'];
				$res .= '</td><td style="color:#FFCC00; text-align:center;" width="8px"><input name="btnReenviar" type="button" class="botaoA" id="btnReenviar" value="Reenviar Email"  onclick="submitForm(\'frmDetalhes\',\'reenviar\',\''.$coddepto_codmanifestacao.'\');"/></td>
				</tr>';
			}
			else
			{
				$res = 
				'<tr>
				<td style="color:#009900;">'.utf8_encode($linha['nome']).'</td>
				<td style="color:#009900;">'.utf8_encode($linha['resposta']).'</td>
				<td style="color:#009900; text-align:center;">'.$data->ConverteDataBR($linha['data_envio']);
				if (!empty($linha['hora_envio']))
					$res .= ' '.$linha['hora_envio'];
				$res .= '</td><td style="color:#009900; text-align:center;">'.$data->ConverteDataBR($linha['data_resposta']);
				if (!empty($linha['hora_resposta']))
					$res .= ' '.$linha['hora_resposta'];
				$res .= '</td></tr>';
			}
			
			$resposta .= $res; 
			
		}	
		
		return $resposta;
	}
	
	
	// METODO QUE CAPTURA AS RESPOSTAS ENVIADAS PELOS DEPARTAMENTOS
	function PegaRespostasDepartamentosSimples($cod_manifestacao)
	{
	
		$con = new gtiConexao();
		$con->gtiConecta();
		
		require_once("../controle/data.gti.php");	
		require_once("../controle/hora.gti.php");	
		$data = new gtiData();
		$hora = new gtiHora();
		
		$SQL = 
		'SELECT 
		d.nome, 
		a.resposta, 
		a.data_envio, 
		a.data_resposta,
		a.hora_envio,
		a.hora_resposta
		FROM 
		departamento as d,
		andamento as a
		WHERE 
		a.ref_departamento = d.departamento_id
		AND
		a.ref_manifestacao='.$cod_manifestacao.' ORDER BY a.data_envio, a.hora_envio DESC;';
	
		
		$total = $con->gtiPreencheTabela($SQL);	
		
		$resposta = "";
		
		foreach($total as $chave => $linha)
		{
		
			$dif = $hora->difDataHora($data->ConverteDataBR($linha['data_envio']),"","d");
			$depto = "";
			if ((trim($linha['resposta']) == '') and ($dif>5))
			{
				$res = 
				'<tr>
				<td style="color:#000000;">'.$linha['nome'].'</td>
				<td style="color:#000000;" >Em espera</td>
				<td style="color:#000000; text-align:center;">'.$data->ConverteDataBR($linha['data_envio']).' '.$linha['hora_envio'].'</td>
				<td style="color:#000000; text-align:center;">--</td>
				</tr>';
			} 
			else if((trim($linha['resposta']) == '') and ($dif<=5))
			{
				$res = 
				'<tr>
				<td style="color:#000000;">'.$linha['nome'].'</td>
				<td style="color:#000000;" >Em espera</td>
				<td style="color:#000000; text-align:center;">'.$data->ConverteDataBR($linha['data_envio']).' '.$linha['hora_envio'].'</td>
				<td style="color:#000000; text-align:center;">--</td>
				</tr>';
			}
			else
			{
				$res = 
				'<tr>
				<td style="color:#000000;">'.$linha['nome'].'</td>
				<td style="color:#000000;">'.$linha['resposta'].'</td>
				<td style="color:#000000; text-align:center;">'.$data->ConverteDataBR($linha['data_envio']).' '.$linha['hora_envio'].'</td>
				<td style="color:#000000; text-align:center;">'.$data->ConverteDataBR($linha['data_resposta']).' '.$linha['hora_resposta'].'</td>
				</tr>';
			}
			
			$resposta .= $res; 
			
		}	
		
		return $resposta;
	}
	
	//METODO QUE CAPTURA O TOTAL DE MANIFESTAÇÕES EM UM DETERMINADO PERÍODO
	function PegaTotalManifestacoesPeriodo($data_inicial, $data_final)
	{
		$con = new gtiConexao();
		$con->gtiConecta();
		$data_inicial = implode("-",array_reverse(explode("/",$data_inicial)));
		$data_final = implode("-",array_reverse(explode("/",$data_final)));

		$SQL = 'SELECT 
					count(manifestacao_id) as total 
				FROM
					manifestacao
				WHERE
					data_criacao >= \''.$data_inicial.'\'
				AND 
					data_criacao <= \''.$data_final.'\' 
				;';
		
		$total = $con->gtiPreencheTabela($SQL);	
		
		foreach($total as $chave => $linha)
		{
			$cont = $linha['total'];
		}		
		
		return $cont;
	}
	
	//METODO PARA LISTAR DADOS DAS MANIFESTACÕES FECHADAS PARA PREENCHER SEU RESPECTIVO GRID
public function ListaFiltroStatusArray($valor, $idStatus, $tipo_filtro)
    {
		require_once("../controle/data.gti.php");
		require_once("../modelo/status.cls.php");
		
		$data = new gtiData();
		$status = new clsStatus();
	
    	$SQL = 
		'
		SELECT 
		m.manifestacao_id, 
		m.assunto, 
		c.nome as nome_clientela, 
		t.nome as nome_tipo,
		m.forma_identificacao, 
		m.data_criacao,
		m.data_finalizacao,
		m.ref_status,
    	m.visualizado
		FROM 
		manifestacao as m, tipo as t, clientela as c
		WHERE
		m.ref_tipo = t.tipo_id
		AND
		m.ref_clientela = c.clientela_id
		AND 
		m.ref_status = '.$idStatus.'
		
		AND
		lower(m.'.$tipo_filtro.') LIKE \'%'.$valor.'%\'
		ORDER BY "data_criacao" desc;
		';
		    	
    	$con = new gtiConexao();
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();
		
		$arr = "";
		$cont = -1;
		
		switch ($idStatus){
			case 1:
				$urlStatus = "andamento";
				$limite = 7;
				break;
			case 2:
				$urlStatus = "abertas";
				$limite = 7;
				break;
			case 3:
				$urlStatus = "fechadas";
				$limite = 9;
				break;
		}
		
		if ($tbl->RecordCount()!=0)
		{		
			foreach($tbl as $chave => $linha)
			{
				$i = 0;
				$lin[$i++] = $linha['manifestacao_id'];			
				$lin[$i++] = '<![CDATA[<span>'.$linha['assunto'].'</span> ]]>';
				$lin[$i++] = '<![CDATA[<span>'.$linha['nome_clientela'].'</span> ]]>';
				$lin[$i++] = '<![CDATA[<span>'.$linha['nome_tipo'].'</span> ]]>';	
				
				switch ($linha['forma_identificacao'])
				{
					case 'A':
						$lin[$i++] = '<![CDATA[<span>Anonimo</span> ]]>';
					break;
					case 'S':
						$lin[$i++] = '<![CDATA[<span>Sigiloso</span> ]]>';
					break;
					default:
						$lin[$i++] = '<![CDATA[<span>Identificado</span> ]]>';
					break;
				}
				
				$status->SelecionaPorCodigo($linha['ref_status']);
				
				$lin[$i++] = '<![CDATA[<span>'.$data->ConverteDataBR($linha['data_criacao']).'</span> ]]>';
				if ($idStatus == 3){
					$lin[$i++] = '<![CDATA[<span>'.$data->ConverteDataBR($linha['data_finalizacao']).'</span> ]]>';
					$lin[$i++] = '<![CDATA[<span>'.$status->GetNome().'</span> ]]>';
					
					//Verifica se há um feedback
					// S - Sim e N = Não
					$feedback = "N";
					$verifica= $this->VerificaFeedback2($linha['manifestacao_id']);
					if ($verifica==true)
					{
						$feedback = "S";
					}
					
					
					$lin[$i++] = '<![CDATA[<span>'.$feedback.'</span> ]]>';
				}
				if ($linha['visualizado'] == 't')
					$lin[$i++] = '<![CDATA[<span><img src="imagens/finalizar.png" width="16px" heigth="16px"></span> ]]>';
				else
					$lin[$i++] = '<![CDATA[<span><img src="imagens/cancelar.png"></span> ]]>';
				$lin[$i++] = '<![CDATA[ver^'.$urlStatus.'_detalhes.frm.php?codigo='.$linha['manifestacao_id'].'^_self]]>';
				
				
				$arr[$cont++] = $lin;
			}
		}
		else
		{
			for ($i=0;$i<$limite;$i++)
				$lin[$i] = '';

			$arr[$cont++] = $lin;
		}
		return $arr;
    }
	
	public function ReenviarEmail($cod_depto, $cod_andamento)
	{
		require_once("../modelo/departamento.cls.php");
		require_once("../controle/email.gti.php");
		require_once("../config.cls.php");	
		
		$departamento= new clsDepartamento();
		$config = new clsConfig();
		$email = new gtiMail();
		$con = new gtiConexao();
				
		$departamento->SetCodigo($cod_depto);
		$departamento->Consultar();
		
		
		$SQL = ' SELECT registro 
		FROM andamento 
		WHERE andamento_id = '.$cod_andamento;		
		//WHERE ref_departamento = '.$cod_depto.'
		//AND ref_manifestacao = '.$cod_manifestacao.';';
		
		$con->gtiConecta();
		$tbl = $con->gtiPreencheTabela($SQL);
		$con->gtiDesconecta();	
		foreach($tbl as $chave => $linha)
		{
			$reg_andamento = $linha['registro'];
		}	
		
		
		//TEXTO QUE SERA ENVIADO VIA EMAIL PARA O DEPARTAMENTO
		$texto_email = '
		<table width="100%" border="1">
  <tr>
    <td><div align="center"><strong>A OUVIDORIA NECESSITA DE SUA RESPOSTA</strong></div></td>
  </tr>
  <tr>
    <td><p align="center">--------------------------------------------------------------------------------------------------------------------------</p>
    <p align="justify">Caro respons&aacute;vel pelo(a) <strong>' .utf8_decode($departamento->GetNome()). '</strong>, encaminho a V.Sa. a presente manifesta&ccedil;&atilde;o para que analise a sua proced&ecirc;ncia e import&acirc;ncia, e solicito a gentileza de apresentar, o mais breve poss&iacute;vel, seu parecer &agrave; Se&ccedil;&atilde;o de Ouvidoria, que responder&aacute; diretamente ao manifestante ou enviar&aacute; o processo a outro departamento caso seja necess&aacute;rio.	</p>
    <p align="justify">Para dar seu parecer, entre no endere&ccedil;o:</p>
    <p align="justify">
	<a href="'.$config->GetRaiz().'/visao/acompanha_depto.frm.php">'.$config->GetRaiz().'/visao/acompanha_depto.frm.php</a>
	</p>
    <p align="justify">e digite o c&oacute;digo do seu ticket que &eacute; 
	<span style="font-size: large;	color: #FF0000;	font-weight: bold;">' .$reg_andamento. '</span></p>
    <p align="justify">Favor n&atilde;o retornar esse email</p>
	<p align="justify">Este email foi reenviado</p>
    <p align="justify">Atenciosamente</p>
    <p align="justify">&quot;Ouvidoria do '.utf8_encode($config->GetNomeInstituicao()).'</p>
    <p align="center">--------------------------------------------------------------------------------------------------------------------------</p>
    </td>
  </tr>
  <tr>
    <td><div align="center">
      <p><strong>VOX - Sistema de Ouvidoria</strong></p>
      <p><strong>'.utf8_encode($config->GetNomeInstituicao()).'</strong></p>
    </div></td>
  </tr>
</table>
		';
		
		$email->AdicionarTexto($texto_email);
		if($email->Enviar($config->GetEmailOuvidoria(), $departamento->GetEmail(), utf8_encode('Existe uma manifestação para o seu departamento (Reenvio de email)'), $config->GetEmailOuvidoria())==false)
		{
			$this->DeletaAndamento($reg_andamento);
			$config->ExibeErro($config->GetPaginaRetorno(), "Erro ao enviar o email para o departamento");
			
		}
	
	}
	
	
}


?>