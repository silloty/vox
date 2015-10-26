<?php

require_once("../modelo/usuario.cls.php");
require_once("../config.cls.php");
require_once("../funcao.php");

$config = new clsConfig();

$login = anti_injection($_POST['txtLogin']); 
$senha = anti_injection($_POST['txtSenha']);

$usuario = new clsUsuario();
$msg = "Login ou Senha incorretos!";

if ($usuario->Autentica($login,$senha)==true)
{
	$_SESSION['vox_codigo'] = $usuario->GetCodigo();			
	header ("location: admin.frm.php");			
	exit;	
}

$config->Logout(false);
$config->ConfirmaOperacao($config->GetPaginaPrincipal(),$msg);




?>
