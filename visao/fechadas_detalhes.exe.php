<?php

require_once("../config.cls.php");
require_once("../controle/valida.gti.php");

$valida = new gtiValidacao();
$config = new clsConfig();

$metodo = $_POST['txtMetodo'];
$codigo = $_POST['txtCodigo'];

switch ($metodo)
{
	
	//ALTERAЧеES-----------------------------------------------
	case 'alterar':
				
		$tipo = $_POST['dpdTipo'];
		$status = $_POST['dpdStatus'];
			
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
			$manifestacao->SetCodigoStatus($status);
					
			$manifestacao->AlterarFechadas();

			$config->ConfirmaOperacao('fechadas_detalhes.frm.php?codigo='.$codigo,"Manifestacao alterada com sucesso!");
		}
	break;
	
}
?>