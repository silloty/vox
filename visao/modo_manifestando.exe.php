﻿﻿<?php
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
		require_once("../funcao.php");
		require_once("../config.cls.php");

		$config = new clsConfig();
		
		$clientela = anti_injection($_POST['dpdClientela']);		
		$tipo = anti_injection($_POST['dpdTipo']);
		$email = anti_injection($_POST['txtEmail']);
		$identificacao = anti_injection($_POST['dpdIdentificacao']);
		$nome = anti_injection($_POST['txtNome']);
		$cpf = anti_injection($_POST['txtCPF']);
		$telefone = anti_injection($_POST['txtTelefone']);
		$assunto = anti_injection($_POST['txtAssunto']);
		$manifestacao = anti_injection($_POST['txtManifestacao']);
		$razao = anti_injection($_POST['txtRazao']);
		$endereco = anti_injection($_POST['txtEndereco']);
		$seguranca = anti_injection($_POST['txtSeguranca']);
		
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
		$valida->ValidaEmail($email);
		
		if($identificacao=='A')
		{
			$valida->ValidaCampoRequerido($razao,'razao do anonimato');
		}
		elseif($identificacao=='S' or $identificacao=='I')
		{
			
			$valida->ValidaCampoRequerido($nome,'nome');
			$valida->ValidaCampoRequerido($telefone,'telefone');
			$valida->ValidaCampoNumericoInteiro($telefone,'telefone');
			if ($cpf != '')
				$valida->ValidaCPF($cpf,'cpf');
			else
				$cpf = "Não Informado";
			$valida->ValidaCampoRequerido($endereco,'endereco');
		}
										
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();			
		}
		elseif(($valida->GetErro() == false))
		{
			require_once("../modelo/manifestacao.cls.php");
			
			$modo = new clsManifestacao();
						
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
			$texto_confirmacao = utf8_encode(':: SUA MANIFESTAÇÃO FOI ENCAMINHADA COM SUCESSO:: <br><br/>Caro manifestante, o '.utf8_encode($config->GetNomeInstituicao()).' <br> agradece a sua manifestação. Suas considerações foram imediatamente <br> remetidas a nossa ouvidoria e serão analisadas por <br> nosso(a) ouvidor(a). Para ter acesso ao andamento de sua manifestação <br> entre com o seguinte número: <br><br> ------------------------------------- <br>'.$modo->GetRegistro().' <br> ------------------------------------- <br><br>na nossa <a href="'.$config->GetRaiz().'/visao/consulta.frm.php" target="_blank">página de acompanhamento</a>. <br/><br>Caso tenha informado um email válido, a sua manifestação <br> será analisada e quando uma resposta for elaborada um segundo <br> email será remetido para a caixa de mensagem que você indicou. <br> A ouvidoria agradece a sua participação no nosso crescimento.<br><br>VOX - Sistema de Ouvidoria<br>Colégio Pedro II');
			
			
			session_destroy();
			
			$config->ConfirmaOperacao("modo_manifestando.frm.php",$texto_confirmacao);
						
		}
	break;
	
}
?>