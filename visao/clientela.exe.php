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
		require_once("../modelo/clientela.cls.php");
		
		$xml = new gtiXML();
		$clientela = new clsClientela();
		
		$arr = $clientela->ListaClientelaArray();
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
	
	//EXCLUSеES------------------------------------------------
	case 'excluir':
		require_once("../modelo/clientela.cls.php");
		$clientela = new clsClientela();
		$clientela->Excluir($codigo);
			
		$config = new clsConfig();
		$config->ConfirmaOperacao("clientela.frm.php","Registro excluido com sucesso!");
		
	break;
	
	//ALTERAЧеES-----------------------------------------------
	
	case 'altera':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = utf8_encode($_POST['txtNome']);

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			//ALTERANDO
			require_once("../modelo/clientela.cls.php");
			require_once("../config.cls.php");
			
			$clientela = new clsClientela();		
			
			$clientela->SetCodigo($codigo);
			$clientela->SetNome($nome);
		
			$clientela->Alterar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("clientela.frm.php","Registro alterado com sucesso!");
		}
	break;
	
	//INSERЧеES-------------------------------------------------

	case 'novo':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = utf8_encode($_POST['txtNome']);

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			require_once("../modelo/clientela.cls.php");
			require_once("../config.cls.php");
			
			$clientela = new clsClientela();		
			
			$clientela->SetCodigo($codigo);
			$clientela->SetNome($nome);
		
			$clientela->Salvar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("clientela.frm.php","Registro salvo com sucesso!");
		}
	break;
}
?>