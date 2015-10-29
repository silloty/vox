<?php

require_once("../config.cls.php");
require_once("../modelo/usuario.cls.php");

$config = new clsConfig();
	
if ((isset($_SESSION['vox_codigo'])))
{
	$admin = new clsUsuario();
	$admin->SelecionaPorCodigo(trim($_SESSION['vox_codigo']));
}
else
{
	$config->Logout(false);
	$config->ConfirmaOperacao($config->GetPaginaPrincipal(),"Você não tem permissão para acessar essa página!");
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="shortcut icon" href="../favicon.ico">
    <title>&Aacute;rea Administrativa - VOX </title>
    <meta http-equiv="Content-Type" content="text/html; charset=ocidental" />
    <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
    <script src="js/geral.js" type="text/javascript"></script>
    
    <script src="js/menu_direito/milonic_src.js" type="text/javascript"></script>
    <script src="js/menu_direito/mmenudom.js" type="text/javascript"></script>
    <script src="js/menu_direito/dados/mn_dados.js" type="text/javascript"></script>
    <script src="js/menu_direito/contextmenu.js" type="text/javascript"></script>
	
	 <!-- ESTILO JANELA -->
    <link href="css/themes/default.css" rel="stylesheet" type="text/css" />	
  	<link href="css/themes/spread.css" rel="stylesheet" type="text/css" />	
  	<link href="css/themes/alert.css" rel="stylesheet" type="text/css" />	
  	<link href="css/themes/alert_lite.css" rel="stylesheet" type="text/css" />	

  	<link href="css/themes/alphacube.css" rel="stylesheet" type="text/css" />	
  	<link href="css/themes/debug.css" rel="stylesheet" type="text/css"/>

    <script src="js/prototype.js" type="text/javascript"></script>
    <script src="js/ajax/relatorios.ajax.js" type="text/javascript"></script>
    
    <!-- JANELA -->
    <script type="text/javascript" src="js/janela/effects.js"> </script>
  	<script type="text/javascript" src="js/janela/window.js"> </script>
  	<script type="text/javascript" src="js/janela/window_effects.js"> </script>
  	<script type="text/javascript" src="js/janela/debug.js"> </script>  
	
	<link href="estilo/datagrid/style.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
<!--
.style22 {
	color: #FFFFFF;
	font-weight: bold;
	font-family: Tahoma, Arial, sans-serif;
}
.style23 {font-family: Tahoma, Arial, sans-serif}
-->
    </style>
</head>
<body>
 <table align="center" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td valign="top">
                <form id="frmRelatorios" name="frmRelatorios" method="post" action="">
                <table width="780px" border="0" align="center" cellpadding="0" cellspacing="1">
                    <tr>
                        <td>
                            <img src="imagens/banner.jpg" alt="" width="100%" /></td>
                    </tr>
                    <tr>
                        <td class="barra">
                            <table cellpadding="0" cellspacing="0" class="style4">
                                <tr>
                                    <td class="style7">
                                        &nbsp;&nbsp; Seja Bem Vindo&nbsp; <?php echo $admin->GetNome(); ?>!&nbsp;</td>
                                    <td >
                                     
                                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                       <tr>
                                         <td width="25%"><img src="imagens/back.png" width="8" height="30" style="width: 17px; height: 16px" /></td>
                                         <td width="75%">&nbsp;<a href="admin.frm.php"><b>VOLTAR</b></a></td>
                                       </tr>
                                     </table>
                                     
                                  </td><td >&nbsp;&nbsp;&nbsp;</td>
                              <td valign="middle">
                                        <table cellpadding="0" cellspacing="0" class="style5">
                                            <tr>
                                                <td class="style6">
                                        <img alt="" src="imagens/bt_logout.jpg" style="margin-top: 0px" /></td>
                                                <td><b><a href="<?php echo $config->GetPaginaPrincipal(); ?>">SAIR</a></b></td>
                                            </tr>
                                        </table>
                                  </td>
                                </tr>
                          </table>
                      </td>
                    </tr>
                    <tr>
                        <td><div align="center">
                          <p><strong>:: RELAT&Oacute;RIOS ::</strong></p>
						  <p>
						    <input id="btnRelManifestacoes" type="button" value="Rela&ccedil;&atilde;o de manifesta&ccedil;&otilde;es recebidas" class="botaoHistSemBorda" name="btnRelManifestacoes"
        onclick="Dialog.alert({url: 'relatorio_periodo.frm.php?relatorio=manifestacao', options: {method: 'get'}}, {className: 'alphacube', width:450, okLabel: 'Voltar'});" />
                          </p>
						  <p>
						    <input id="btnRelAtividades" type="button" value="Relat&oacute;rio de atividades" class="botaoHistSemBorda" name="btnRelAtividades" onclick="Dialog.alert({url: 'relatorio_periodo.frm.php?relatorio=atividade', options: {method: 'get'}}, {className: 'alphacube', width:450, okLabel: 'Voltar'});"/>
						  </p>
						  <p>&nbsp;</p>
                        </div></td>
                  </tr>
                    <tr>
                        <td bgcolor="#68B92C" valign="middle" align="center" class="rodape"><span class="style22">Sistema de Ouvidoria - <?php echo $config->GetNomeInstituicao();?></span></td>
                    </tr>
                    <tr>
                        <td bgcolor="Silver" valign="middle" align="center" class="barra">
                            &nbsp;
                            <div align="center">
		                      <img src="imagens/postgres.gif" width="80" height="15">
		                      <img src="imagens/php.png" width="80" height="15">
		                      <img src="imagens/gti.gif" width="80" height="15">
		                    </div>
                      </td>
                    </tr>
                </table>
            </form>
            </td>
        </tr>
    </table>
</body>
</html>

