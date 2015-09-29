<?php
session_start();

if (isset($_POST['txtMetodo']))
{
	$metodo = $_POST['txtMetodo'];
}

switch ($metodo)
{
		
	//ENVIAR-------------------------------------------------

	case 'enviar':
		require_once("../controle/valida.gti.php");
		require_once("../controle/hora.gti.php");
                require_once("../controle/data.gti.php");

		$clientela = $_POST['dpdClientela'];		
		$tipo = $_POST['dpdTipo'];
		$email = $_POST['txtEmail'];
		$identificacao = $_POST['dpdIdentificacao'];
		$nome = $_POST['txtNome'];
		$cpf = $_POST['txtCPF'];
		$telefone = $_POST['txtTelefone'];
		$assunto = $_POST['txtAssunto'];
		$manifestacao = $_POST['txtManifestacao'];
		$razao = $_POST['txtRazao'];
		$endereco = $_POST['txtEndereco'];
		$seguranca = $_POST['txtSeguranca'];
		
		//GUARDANDO VALORES NA SESSÃO
		$_SESSION['vox_email']= $email;
		$_SESSION['vox_nome']= $nome;
		$_SESSION['vox_cpf'] = $cpf;
		$_SESSION['vox_telefone'] = $telefone;
		$_SESSION['vox_assunto'] = $assunto;
		$_SESSION['vox_razao'] = $razao;
		$_SESSION['vox_manifestacao'] = $manifestacao;
		$_SESSION['vox_endereco'] = $endereco;
		
		$_SESSION['vox_clientela'] = $clientela;
		$_SESSION['vox_tipo'] = $tipo;
				
		//Capturando Data Sistema
		//$data = new gtiHora();
                //$data2 = new gtiData();
		//$datacriacao = $data2->ConverteDataHifen($data->getData());
		$datacriacao = date('Y-m-d');
	
		$valida = new gtiValidacao();
		$valida->ValidaDPD($clientela,'1 - eu');
		$valida->ValidaDPD($tipo,'gostaria de fazer um(a)');
		$valida->ValidaDPD($identificacao,'4 - eu');
		$valida->ValidaCampoRequerido($assunto,'assunto');
		$valida->ValidaCampoRequerido($manifestacao,'manifestacao');
		$valida->ValidaCampoRequerido($seguranca,'numero de seguranca');
		$valida->ComparaCaptcha('numero de seguranca');
		if($email=="")
		{
			$email="ouvidoria@ouvidoria.com";
		}
		else
		{
			$valida->ValidaEmail($email);
		}
		
			
			
		if($identificacao=='A')
		{
			$valida->ValidaCampoRequerido($razao,'razao do anonimato');
		}
		elseif($identificacao=='S' or $identificacao=='I')
		{
			
			$valida->ValidaCampoRequerido($nome,'nome');
			$valida->ValidaCampoRequerido($telefone,'telefone');
			$valida->ValidaCampoNumericoInteiro($telefone,'telefone');
			$valida->ValidaCampoRequerido($cpf,'cpf');
			$valida->ValidaCPF($cpf,'cpf');
			$valida->ValidaCampoRequerido($endereco,'endereco');
		}
										
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();			
		}
		elseif(($valida->GetErro() == false))
		{
			require_once("../modelo/manifestacao.cls.php");
			require_once("../config.cls.php");
			
			$modo = new clsManifestacao();
			$config = new clsConfig();	
			
			if(!stristr($email, "@") || !stristr($email, ".") || $email=="")
			{
				die($email);
				$email="ouvidoria@ouvidoria.com";
			}
						
			$modo->SetClientela($clientela);
			$modo->SetTipo($tipo);
			$modo->SetEmail($email);
			$modo->SetIdentificacao($identificacao);
			$modo->SetNome($nome);
			$modo->SetCpf($cpf);
			$modo->SetTelefone($telefone);
			$modo->SetAssunto(addslashes($assunto));
			$modo->SetConteudo(addslashes($manifestacao));
			$modo->SetAnonimato(addslashes($razao));
			$modo->SetDataCriacao($datacriacao);	
			$modo->SetEndereco($endereco);
			
			$modo->Enviar();			
				
			//tela de confirmacao de sucesso
			$texto_confirmacao = ':: SUA MANIFESTACAO FOI ENCAMINHADA COM SUCESSO:: <br><br/>Caro manifestante, o Instituto Federal Minas Gerais - Campus Bambui <br> agradece a sua manifestacao. Suas consideracoes foram imediatamente <br> remetidas a nosso departamento de ouvidoria e serao analisadas por <br> nosso(a) ouvidor(a). Para ter acesso ao andamento de sua manifestacao <br> entre com o seguinte numero: <br><br> ------------------------------------- <br>'.$modo->GetRegistro().' <br> ------------------------------------- <br><br>na nossa <a href="'.$config->GetRaiz().'/visao/consulta.frm.php">pagina de acompanhamento</a>. <br/><br>Caso tenha informado um email valido, a sua manifestacao <br> sera analisada e quando uma resposta for elaborada um segundo <br> email sera remetido para a caixa de mensagem que voce indicou. <br> A ouvidoria agradece a sua participacao no nosso crescimento.<br><br>VOX - Sistema de Ouvidoria<br>Instituto Federal Minas Gerais - Campus Bambui';
			
			
			session_destroy();
			
			$config->ConfirmaOperacao("modo_manifestando.frm.php",$texto_confirmacao);
						
		}
	break;
	
}
?>