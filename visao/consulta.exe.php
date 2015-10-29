<?php
session_start();

require_once("../modelo/manifestacao.cls.php");
require_once("../config.cls.php");
require_once("../controle/valida.gti.php");
require_once("../funcao.php");

$resposta = anti_injection($_POST['txtResposta']);
$registro = $_SESSION['vox_registro']; //Campo Hidden

$valida = new gtiValidacao();
$valida->ValidaCampoRequerido($resposta,'resposta');
	
if ($valida->GetErro() == true)
{
	echo $valida->GetMensagem();
}
else
{
	$manifestacao = new clsManifestacao();
	$manifestacao->SetRegistro($registro);
	$manifestacao->Consultar($registro);		
	$manifestacao->SetFeedback(addslashes($resposta));
	$manifestacao->EnviarFeedback();
	$manifestacao->DesmarcarComoVisto();
	$config = new clsConfig();
	$config->ConfirmaOperacao('consulta.frm.php',"A ouvidoria agradece a sua colaboracao!");
}
?>