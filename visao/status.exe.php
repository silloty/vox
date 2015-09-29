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
		require_once("../modelo/status.cls.php");
		
		$xml = new gtiXML();
		$status = new clsStatus();
		
		$arr = $status->ListaStatusArray();
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
	
	//EXCLUSеES------------------------------------------------
	case 'excluir':
	if (($codigo == 1) or ($codigo ==2) or ($codigo ==3))
	{	
		require_once("../config.cls.php");
		$config = new clsConfig();
		$config->ConfirmaOperacao("status.frm.php","Voce nao pode excluir o status Aberto, Fechado ou Em Andamento!");
		
	}
	else
	{
		require_once("../modelo/status.cls.php");
		$status = new clsStatus();
		$status->Excluir($codigo);
			
		$config = new clsConfig();
		$config->ConfirmaOperacao("status.frm.php","Registro excluido com sucesso!");
	}
	break;
	
	//ALTERAЧеES-----------------------------------------------
	
	case 'altera':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = $_POST['txtNome'];
		$descricao = $_POST['txtDescricao'];

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			//ALTERANDO
			require_once("../modelo/status.cls.php");
			require_once("../config.cls.php");
			
			$status = new clsStatus();		
			
			$status->SetCodigo($codigo);
			$status->SetNome($nome);
			$status->SetDescricao($descricao);
		
			$status->Alterar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("status.frm.php","Registro alterado com sucesso!");
		}
	break;
	
	//INSERЧеES-------------------------------------------------

	case 'novo':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = $_POST['txtNome'];
		$descricao = $_POST['txtDescricao'];

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			require_once("../modelo/status.cls.php");
			require_once("../config.cls.php");
			
			$status = new clsStatus();		
			
			$status->SetCodigo($codigo);
			$status->SetNome($nome);
			$status->SetDescricao($descricao);
		
			$status->Salvar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("status.frm.php","Registro salvo com sucesso!");
		}
	break;
}
?>