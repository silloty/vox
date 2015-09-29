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

$valor = $_REQUEST['valor'];

switch ($metodo)
{
	//SELEЧеES DE GRID----------------------------------------------
	
	case 'carregagrid':
		header("Content-Type: text/xml");

		require_once("../controle/xml.gti.php");
		require_once("../modelo/manifestacao.cls.php");
		
		$xml = new gtiXML();
		$manifestacao = new clsManifestacao();
			
		$arr = $manifestacao->ListaManifestacaoFechadasArray();
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
	case 'filtrar':
		header("Content-Type: text/xml");

		require_once("../controle/xml.gti.php");
		require_once("../modelo/manifestacao.cls.php");
					
		$xml = new gtiXML();
		$manifestacao = new clsManifestacao();
			
		$arr = $manifestacao->ListaFiltroFechadasArray(strtolower($valor));
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
}
?>