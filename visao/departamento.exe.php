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
		require_once("../modelo/departamento.cls.php");
		
		$xml = new gtiXML();
		$departamento = new clsDepartamento();
		
		$arr = $departamento->ListaDepartamentoArray();
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
	case 'filtrar':
		header("Content-Type: text/xml");

		require_once("../controle/xml.gti.php");
		require_once("../modelo/departamento.cls.php");
		
		$xml = new gtiXML();
		$departamento = new clsDepartamento();
		
		$arr = $departamento->FiltraDepartamentoArray(strtolower($valor));
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
	
	//EXCLUSеES------------------------------------------------
	case 'excluir':
		
		
		if ($codigo != 1 )
		{
			require_once("../modelo/departamento.cls.php");
			$departamento = new clsDepartamento();
			$departamento->Excluir($codigo);
				
			$config = new clsConfig();
			$config->ConfirmaOperacao("departamento.frm.php","Registro excluido com sucesso!");
		}
		else
		{
			require_once("../config.cls.php");
			$config = new clsConfig();
			$config->ConfirmaOperacao("departamento.frm.php","Vocъ nуo pode excluir o departamento Ouvidoria!");
		}
		
		
		
		
		
	break;
	
	//ALTERAЧеES-----------------------------------------------
	
	case 'altera':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = utf8_encode($_POST['txtNome']);
		$email = utf8_encode($_POST['txtEmail']);
		$descricao = utf8_encode($_POST['txtDescricao']);

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
		$valida->ValidaCampoRequerido($email,'email');
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			//ALTERANDO
			require_once("../modelo/departamento.cls.php");
			require_once("../config.cls.php");
			
			$departamento = new clsDepartamento();		
			
			$departamento->SetCodigo($codigo);
			$departamento->SetNome($nome);
			$departamento->SetEmail($email);
			$departamento->SetDescricao($descricao);
		
			$departamento->Alterar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("departamento.frm.php","Registro alterado com sucesso!");
		}
	break;
	
	//INSERЧеES-------------------------------------------------

	case 'novo':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = utf8_encode($_POST['txtNome']);
		$email = utf8_encode($_POST['txtEmail']);
		$descricao = utf8_encode($_POST['txtDescricao']);

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
		$valida->ValidaCampoRequerido($email,'email');
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			require_once("../modelo/departamento.cls.php");
			require_once("../config.cls.php");
			
			$departamento = new clsDepartamento();		
			
			$departamento->SetCodigo($codigo);
			$departamento->SetNome($nome);
			$departamento->SetEmail($email);
			$departamento->SetDescricao($descricao);
		
			$departamento->Salvar();
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("departamento.frm.php","Registro salvo com sucesso!");
		}
	break;
}
?>