<?php

require_once("../config.cls.php");
require_once("../modelo/usuario.cls.php");
require_once("../modelo/manifestacao.cls.php");

$config = new clsConfig();

//Pegaremos logo abaixo o total das manifestacoes por status sendo que:
/* 1 - Andamento
*  2 - Abertas
*  3 - Fechadas
*/	

$manifestacao = new clsManifestacao();
	
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
                <table align="center" cellpadding="0" cellspacing="1" width="780px">
                    <tr>
                        <td>
                            <img src="imagens/banner.jpg" alt="" width="776" /></td>
                  </tr>
                    <tr>
                        <td class="barra">
                            <table cellpadding="0" cellspacing="0" class="style4">
                                <tr>
                                    <td class="style7 style23">
                                        &nbsp;&nbsp; Seja Bem Vindo&nbsp; <?php echo $admin->GetNome(); ?>!&nbsp;</td>
                                    <td >
                                     
                                     <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                       <tr>
                                         <td>&nbsp;</td>
                                         <td>&nbsp;<a href="admin.frm.php"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></a></td>
                                       </tr>
                                     </table>
                                     
                                  </td>
                              <td valign="middle">
                                        <table cellpadding="0" cellspacing="0" class="style5">
                                            <tr>
                                                <td class="style6">&nbsp;
                                        <img alt="" src="imagens/bt_logout.jpg" style="margin-top: 0px" /></td>
                                                <td>
                                                    &nbsp;<b><a href="<?php  echo $config->GetPaginaPrincipal()  ?>">SAIR</a></b></td>
                                            </tr>
                                        </table>
                                  </td>
                                </tr>
                            </table>
                            </td>
                    </tr>
                    <tr>
                      <td>
                            <br />
                            <table width="468" align="center" cellpadding="0" cellspacing="0" class="style8">
                                <tr>
                                    <td width="126" align="center">
                                      <p><img src="imagens/bt_abertas.png" alt="" name="bt_abertas" id="bt_abertas" onmouseover="CarregaToolTip('bt_abertas')" onmouseout="CarregaToolTip('')" /><br />
                                  <a href="abertas.frm.php" onmouseover="CarregaToolTip('bt_abertas')" onmouseout="CarregaToolTip('')">Abertas</a>(<?php  echo $manifestacao->PegaTotalManifestacao(2); ?>)</p></td>
<td width="120" align="center">
<p><img src="imagens/bt_andamento.png" alt="" name="bt_andamento" id="bt_andamento" onmouseover="CarregaToolTip('bt_andamento')" onmouseout="CarregaToolTip('')"/><br />
                                           <a href="andamento.frm.php" onmouseover="CarregaToolTip('bt_andamento')" onmouseout="CarregaToolTip('')">Andamento</a>(<?php  echo $manifestacao->PegaTotalManifestacao(1); ?>)</p>                                        </td>
                              <td width="111" align="center">
<img src="imagens/bt_fechadas.png" alt="" name="bt_fechadas" id="bt_fechadas" onmouseover="CarregaToolTip('bt_fechadas')" onmouseout="CarregaToolTip('')"/><br />
                                  <a href="fechadas.frm.php" onmouseover="CarregaToolTip('bt_fechadas')" onmouseout="CarregaToolTip('')"> Fechadas</a>(<?php  echo $manifestacao->PegaTotalManifestacao(3); ?>)</td>
                              <td width="109" align="center"><img src="imagens/bt_usuario.png" alt="" name="bt_usuario" id="bt_usuario" onmouseover="CarregaToolTip('bt_usuario')" onmouseout="CarregaToolTip('')"/><br />
                                <a href="usuario.frm.php" onmouseover="CarregaToolTip('bt_usuario')" onmouseout="CarregaToolTip('')"> Usuários</a></td>
                              <td width="109" align="center"><img alt="" src="imagens/bt_relatorios.png" id="bt_relatorios" onmouseover="CarregaToolTip('bt_relatorios')" onmouseout="CarregaToolTip('')"/><br />
                                <a href="relatorios.frm.php" onmouseover="CarregaToolTip('bt_relatorios')" onmouseout="CarregaToolTip('')">Relat&oacute;rios</a></td>
                              </tr>
                                <tr>
                                    <td align="center"><img src="imagens/bt_departamentos.png" alt="" name="bt_departamentos" id="bt_departamentos" onmouseover="CarregaToolTip('bt_departamentos')" onmouseout="CarregaToolTip('')"/><br />
                                      <a href="departamento.frm.php" onmouseover="CarregaToolTip('bt_departamentos')" onmouseout="CarregaToolTip('')">Departamentos</a></td>
                                    <td align="center">
                                      <img src="imagens/bt_tipo.png" alt="" name="bt_tipos" id="bt_tipos" onmouseover="CarregaToolTip('bt_tipos')" onmouseout="CarregaToolTip('')"/><br />
                                        <a href="tipo.frm.php" onmouseover="CarregaToolTip('bt_tipos')" onmouseout="CarregaToolTip('')">Tipos</a></td>
                                    <td align="center"><img src="imagens/bt_clientela.png" alt="" name="bt_clientela" id="bt_clientela" onmouseover="CarregaToolTip('bt_clientela')" onmouseout="CarregaToolTip('')"/><br />
                                      <a href="clientela.frm.php" onmouseover="CarregaToolTip('bt_clientela')" onmouseout="CarregaToolTip('')"> Clientela</a></td>
                                    <td align="center"><img src="imagens/bt_status.png" alt="" name="bt_status" id="bt_status" onmouseover="CarregaToolTip('bt_status')" onmouseout="CarregaToolTip('')"/><br />
                                      <a href="status.frm.php" onmouseover="CarregaToolTip('bt_status')" onmouseout="CarregaToolTip('')">Status</a></td>
                                  <td align="center"><img src="imagens/bt_ajuda.png" alt="" name="bt_ajuda" id="bt_ajuda" onmouseover="CarregaToolTip('bt_ajuda')" onmouseout="CarregaToolTip('')"/><br />
                                    <a href="ajuda/ajuda.frm.php" onmouseover="CarregaToolTip('bt_ajuda')" onmouseout="CarregaToolTip('')">Ajuda</a></td>
                              </tr>
                            </table>
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="style9" align="center">
                                <tr>
                                    <td>                                       
                                      <textarea id="txtInfo" class="semBorda">Clique sobre uma das op&ccedil;&otilde;es acima para acessar as &aacute;reas de configura&ccedil;&otilde;es.</textarea></td>
                                </tr>
                            </table>
                            </td>
                        
                    </tr>
                    <tr>
                        <td>&nbsp;
                            </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" bordercolor="#333333" bgcolor="#68B92E" class="rodape"><span class="style22">Sistema de Ouvidoria - VOX / IFMG - Campus Bambu&iacute;</span></td>
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
            </td>
        </tr>
    </table>

</body>
</html>

