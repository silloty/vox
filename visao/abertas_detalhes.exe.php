<?php

require_once("../config.cls.php");
require_once("../controle/valida.gti.php");

$valida = new gtiValidacao();
$config = new clsConfig();

$metodo = $_POST['txtMetodo'];
$codigo = $_POST['txtCodigo'];

switch ($metodo)
{
	//ALTERA��ES-----------------------------------------------
	case 'salvar':
				
		$tipo = $_POST['dpdTipo'];
		$clientela = $_POST['dpdClientela'];
		$visualizado = $_POST['txtVisualizado'];
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
				
			//ALTERANDO
			require_once("../modelo/manifestacao.cls.php");
			
			$manifestacao = new clsManifestacao();		
			
			$manifestacao->SetCodigo($codigo);
			$manifestacao->SetCodigoTipo($tipo);
			$manifestacao->SetCodigoClientela($clientela);
			$manifestacao->SetVisualizado($visualizado);
			$manifestacao->Alterar();

			$config->ConfirmaOperacao('abertas.frm.php',"Manifestacao alterada com sucesso!");
		}
	break;
	
	//ENCAMINHAR
	case 'encaminhar':
	
		require_once("../controle/hora.gti.php");
					
		$cod_depto = $_POST['dpdDepartamentos'];
		$valida->ValidaDPD($cod_depto,'departamento');
		
				
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
		
			//Capturando Data Sistema
			$data = new gtiHora();
			$data_envio = $data->getData();
			$hora_envio = $data->getHora();
					
			//ENCAMINHANDO
			require_once("../modelo/manifestacao.cls.php");
			require_once("../config.cls.php");
			require_once ('../funcao.php');
			
			if ($_POST["txtDespacho"]){
				$manifestacao = new clsManifestacao();
				$manifestacao->SetCodigo($codigo);
				$manifestacao->ConsultarPorCodigo();
				$manifestacao->SetDataEnvio($data_envio);
				$manifestacao->SetHoraEnvio($hora_envio);
				$reg_andamento = $manifestacao->EncaminharDepto(1);
			
				$despacho = anti_injection($_POST["txtDespacho"]);
				$manifestacao = new clsManifestacao();
				$manifestacao->SetResposta($despacho);
				$manifestacao->Responder($reg_andamento);
			}
			$data = new gtiHora();
			$data_envio = $data->getData();
			$hora_envio = $data->getHora();
			
			$manifestacao = new clsManifestacao();		
			
			$manifestacao->SetCodigo($codigo);
			$manifestacao->ConsultarPorCodigo();
			$manifestacao->SetDataEnvio($data_envio);
			$manifestacao->SetHoraEnvio($hora_envio);
			$manifestacao->EncaminharDepto($cod_depto);

			$config->ConfirmaOperacao('abertas_detalhes.frm.php?codigo='.$codigo,"Manifestacao encaminhada com sucesso!");
		}
	break;
	
	
	//FINALIZAR
	case 'finalizar':
					
		//Finalizando
		require_once("../modelo/manifestacao.cls.php");
						
		$resp_final = $_POST['txtRespostaFinal'];

		$valida->ValidaCampoRequerido($resp_final,'resposta final');
		
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			$manifestacao = new clsManifestacao();
			$manifestacao->SetCodigo($codigo);
			$manifestacao->ConsultarPorCodigo();
			$manifestacao->SetRespostaFinal($resp_final);
			$manifestacao->Finalizar();
			
			$config->ConfirmaOperacao('abertas.frm.php?codigo='.$codigo,"Manifestacao Finalizada!");
		}
		
	break;
	
}
?>