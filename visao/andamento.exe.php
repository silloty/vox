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
$tipo_filtro = $_REQUEST['tipo_filtro'];

switch ($metodo)
{
	//SELEЧеES DE GRID----------------------------------------------
	
	case 'carregagrid':
		header("Content-Type: text/xml");

		require_once("../controle/xml.gti.php");
		require_once("../modelo/manifestacao.cls.php");
		
		$xml = new gtiXML();
		$manifestacao = new clsManifestacao();
			
		$arr = $manifestacao->ListaManifestacaoAndamentoArray();
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
	case 'filtrar':
		header("Content-Type: text/xml");
	
		require_once("../controle/xml.gti.php");
		require_once("../modelo/manifestacao.cls.php");
			
		$xml = new gtiXML();
		$manifestacao = new clsManifestacao();
			
		$arr = $manifestacao->ListaFiltroStatusArray(strtolower($valor), 1, strtolower($tipo_filtro));
		$lista = $xml->ArrayParaXML($arr);
	
		echo $lista;
	break;
}
?>