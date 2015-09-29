<?php

if (isset($_POST['txtMetodo']))
{
	$metodo = $_POST['txtMetodo'];
	$codigo = $_POST['txtCodigo'];
}
else
{
	$metodo = $_REQUEST['metodo'];
	$codigo = $_REQUEST['codigo'];
}


switch ($metodo)
{
	//SELEЧеES DE GRID----------------------------------------------
	
	case 'carregagrid':
		header("Content-Type: text/xml");

		require_once("../controle/xml.gti.php");
		require_once("../modelo/manifestacao.cls.php");
		
		$xml = new gtiXML();
		$manifestacao = new clsManifestacao();
		
		$arr = $manifestacao->ListaManifestacaoAbertasArray();
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
}
?>