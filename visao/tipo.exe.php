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
		require_once("../modelo/tipo.cls.php");
		
		$xml = new gtiXML();
		$tipo = new clsTipo();
		
		$arr = $tipo->ListaTipoArray();
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
	
	//EXCLUSеES------------------------------------------------
	case 'excluir':
		require_once("../modelo/tipo.cls.php");
		$tipo = new clsTipo();
		$tipo->Excluir($codigo);
			
		$config = new clsConfig();
		$config->ConfirmaOperacao("tipo.frm.php","Registro excluido com sucesso!");
		
	break;
	
	//ALTERAЧеES-----------------------------------------------
	
	case 'altera':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = $_POST['txtNome'];
		$visivel = $_POST['dpdVisivel'];

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
		$valida->ValidaDPD($visivel,'visivel');
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			//ALTERANDO
			require_once("../modelo/tipo.cls.php");
			require_once("../config.cls.php");
			
			$tipo = new clsTipo();		
			
			$tipo->SetCodigo($codigo);
			$tipo->SetNome($nome);
			$tipo->SetVisivel($visivel);
		
			$tipo->Alterar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("tipo.frm.php","Registro alterado com sucesso!");
		}
	break;
	
	//INSERЧеES-------------------------------------------------

	case 'novo':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = $_POST['txtNome'];
		$visivel = $_POST['dpdVisivel'];

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
		$valida->ValidaDPD($visivel,'visivel');
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			require_once("../modelo/tipo.cls.php");
			require_once("../config.cls.php");
			
			$tipo = new clsTipo();		
			
			$tipo->SetCodigo($codigo);
			$tipo->SetNome($nome);
			$tipo->SetVisivel($visivel);
		
			$tipo->Salvar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("tipo.frm.php","Registro salvo com sucesso!");
		}
	break;
}
?>