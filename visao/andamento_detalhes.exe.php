<?php

$metodo = $_POST['txtMetodo'];
$codigo = $_POST['txtCodigo'];

switch ($metodo)
{
	//ENCAMINHAR
	case 'encaminhar':
	
		require_once("../controle/hora.gti.php");
		require_once("../controle/valida.gti.php");
	
		$valida = new gtiValidacao();
		
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
			
					
			//ENCAMINHANDO
			require_once("../modelo/manifestacao.cls.php");
			require_once("../config.cls.php");
			
			$manifestacao = new clsManifestacao();		
			
			$manifestacao->SetCodigo($codigo);
			$manifestacao->ConsultarPorCodigo();
			$manifestacao->SetDataEnvio($data_envio);
					
			$manifestacao->EncaminharDepto($cod_depto);
			
			$config = new clsConfig();
			$config->ConfirmaOperacao('andamento_detalhes.frm.php?codigo='.$codigo,"Manifestacao encaminhada com sucesso!");
		}
	break;
	
	
	//FINALIZAR
	case 'finalizar':
					
		//Finalizando
		require_once("../modelo/manifestacao.cls.php");
		require_once("../config.cls.php");
		require_once("../controle/valida.gti.php");
				
		$resp_final = $_POST['txtRespostaFinal'];

		$valida = new gtiValidacao();
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
			$manifestacao->SetRespostaFinal(addslashes($resp_final));
			$manifestacao->Finalizar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao('andamento.frm.php',"Manifestacao Finalizada!");
		}
		
	break;
	case 'reenviar':
	
		require_once("../modelo/manifestacao.cls.php");
		require_once("../config.cls.php");
		
		$cod = explode(":", $codigo);
		$cod_departamento = $cod[0];
		$cod_manifestacao = $cod[1];
			
		$manifestacao = new clsManifestacao();
		$manifestacao->ReenviarEmail($cod_departamento,$cod_manifestacao);
		
		$config = new clsConfig();
		$config->ConfirmaOperacao('andamento_detalhes.frm.php?codigo='.$cod_manifestacao,"Email enviado com sucesso!");
		
	break;
	
}
?>