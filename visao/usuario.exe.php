<?php
require_once("../config.cls.php");
$config = new clsConfig();

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
	//SELE��ES DE GRID----------------------------------------------
	
	case 'carregagrid':
		header("Content-Type: text/xml");

		require_once("../controle/xml.gti.php");
		require_once("../modelo/usuario.cls.php");
		
		$xml = new gtiXML();
		$usuario = new clsUsuario();
		
		$arr = $usuario->ListaUsuarioArray();
		$lista = $xml->ArrayParaXML($arr);
		
		echo $lista;
	break;
	
	
	//EXCLUS�ES------------------------------------------------
	case 'excluir':
		if ($codigo != 1 )
		{
			require_once("../modelo/usuario.cls.php");
			$usuario = new clsUsuario();
			$usuario->Excluir($codigo);
			
			$config = new clsConfig();
			$config->ConfirmaOperacao("usuario.frm.php","Registro excluido com sucesso!");
		}
		else
		{
			require_once("../config.cls.php");
			$config = new clsConfig();
			$config->ConfirmaOperacao("usuario.frm.php","Voc� n�o pode excluir o usu�rio administrador!");
		}
	break;
	
	//ALTERA��ES-----------------------------------------------
	
	case 'altera':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = utf8_encode($_POST['txtNome']);
		$login = utf8_encode($_POST['txtLogin']);
		$senha = utf8_encode($_POST['txtSenha']);
		$senha2 = utf8_encode($_POST['txtSenha2']);
		$codigo_usuario = $_SESSION['vox_codigo'];

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
		$valida->ValidaCampoRequerido($login,'login');
		$valida->ValidaCampoRequerido($senha,'senha');
		$valida->ValidaCampoRequerido($senha2,'repita_senha');
					
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{			
			if ($codigo == $codigo_usuario)
			{
				if ($senha == $senha2)
				{
				
					//ALTERANDO
					require_once("../modelo/usuario.cls.php");
					
					
					$usuario = new clsUsuario();		
					
					$usuario->SetCodigo($codigo);
					$usuario->SetNome($nome);
					$usuario->SetLogin($login);
					$usuario->SetSenha($senha);
				
					$usuario->Alterar();
					
					$config->ConfirmaOperacao("usuario.frm.php","Registro alterado com sucesso!");
				}else
				{
					$config->ConfirmaOperacao("usuario.frm.php","Senha nao confere. Repita a Operacao!");
				}
			}elseif($codigo_usuario==1)
			{
				if ($senha == $senha2)
				{
				
					//ALTERANDO
					require_once("../modelo/usuario.cls.php");
					
					
					$usuario = new clsUsuario();		
					
					$usuario->SetCodigo($codigo);
					$usuario->SetNome($nome);
					$usuario->SetLogin($login);
					$usuario->SetSenha($senha);
				
					$usuario->Alterar();
					
					$config->ConfirmaOperacao("usuario.frm.php","Registro alterado com sucesso!");
				}else
				{
					$config->ConfirmaOperacao("usuario.frm.php","Senha nao confere. Repita a Operacao!");
				}
			}else
			{
				$config->ConfirmaOperacao("usuario.frm.php","Voc� n�o tem permiss�o para alterar este usu�rio!");
			}
		}
	break;
	
	//INSER��ES-------------------------------------------------

	case 'novo':
		require_once("../controle/valida.gti.php");
		
		$codigo = $_POST['txtCodigo'];	
		$nome = utf8_encode($_POST['txtNome']);
		$login = utf8_encode($_POST['txtLogin']);
		$senha = utf8_encode($_POST['txtSenha']);
		$senha2 = utf8_encode($_POST['txtSenha2']);

		$valida = new gtiValidacao();
		$valida->ValidaCampoRequerido($nome,'nome');
		$valida->ValidaCampoRequerido($login,'login');
		$valida->ValidaCampoRequerido($senha,'senha');
		$valida->ValidaCampoRequerido($senha2,'repita_senha');
		
			
		if ($valida->GetErro() == true)
		{
			echo $valida->GetMensagem();
		}
		else
		{
			if ($senha == $senha2)
			{
			
				require_once("../modelo/usuario.cls.php");
							
				$usuario = new clsUsuario();		
				
				$usuario->SetCodigo($codigo);
				$usuario->SetNome($nome);
				$usuario->SetLogin($login);
				$usuario->SetSenha($senha);
			
				$usuario->Salvar();
				
				$config->ConfirmaOperacao("usuario.frm.php","Registro salvo com sucesso!");
			}else
			{
				$config->ConfirmaOperacao("usuario.frm.php","Senha nao confere. Repita a Operacao!");
			}
		}
	break;
}
?>