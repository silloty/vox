<?php

require_once("../modelo/manifestacao.cls.php");
require_once("../config.cls.php");
require_once("../controle/valida.gti.php");
require_once("../funcao.php");

$reg_andamento = anti_injection($_POST['txtConsulta']);
$resposta = $_POST['txtResposta'];
$codigo = $_POST['txtCodigo'];
$valida = new gtiValidacao();
$valida->ValidaCampoRequerido($reg_andamento,'registro');
$valida->ValidaCampoRequerido($resposta,'resposta');
	
if ($valida->GetErro() == true)
{
	echo $valida->GetMensagem();
}
else
{
	$manifestacao = new clsManifestacao();
	$manifestacao->SetResposta(addslashes($resposta));
	$manifestacao->Responder($reg_andamento);
	$manifestacao->SetCodigo($codigo);	
	$manifestacao->DesmarcarComoVisto();

	$config = new clsConfig();
	$config->ConfirmaOperacao('acompanha_depto.frm.php',"Manifestacao respondida com sucesso!");
}
?>