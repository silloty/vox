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
	$config->ConfirmaOperacao($config->GetPaginaPrincipal(),"Voc� n�o tem permiss�o para acessar essa p�gina!");
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

   
<head>
    <title>&Aacute;rea Administrativa - VOX</title>
    <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
    
    <!-- ESTILO DATAGRID-->
	<link href="estilo/datagrid/dhtmlxgrid.css"  rel="stylesheet" type="text/css" />
	<link href="estilo/datagrid/dhtmlxgrid_skins.css" rel="stylesheet" type="text/css"  />
	<link href="estilo/datagrid/style.css" rel="stylesheet" type="text/css" />
	
    <!-- ESTILO JANELA -->
    <link href="css/themes/default.css" rel="stylesheet" type="text/css" />	
  	<link href="css/themes/spread.css" rel="stylesheet" type="text/css" />	
  	<link href="css/themes/alert.css" rel="stylesheet" type="text/css" />	
  	<link href="css/themes/alert_lite.css" rel="stylesheet" type="text/css" />	

  	<link href="css/themes/alphacube.css" rel="stylesheet" type="text/css" />	
  	<link href="css/themes/debug.css" rel="stylesheet" type="text/css"/>
    
    <!-- MENU ESQUERDO -->
<script src="js/menu_direito/milonic_src.js" type="text/javascript"></script>
<script src="js/menu_direito/mmenudom.js" type="text/javascript"></script>
<script src="js/menu_direito/dados/mn_dados.js" type="text/javascript"></script>
<script src="js/menu_direito/contextmenu.js" type="text/javascript"></script>  
    
<script src="js/prototype.js" type="text/javascript"></script>
    
    <!-- JANELA -->
<script type="text/javascript" src="js/janela/effects.js"> </script>
<script type="text/javascript" src="js/janela/window.js"> </script>
<script type="text/javascript" src="js/janela/window_effects.js"> </script>
<script type="text/javascript" src="js/janela/debug.js"> </script>  
  	
  	<!-- DATAGRID -->
<script  type="text/javascript" src="js/datagrid/dhtmlxcommon.js"></script>
<script  type="text/javascript" src="js/datagrid/dhtmlxgrid.js"></script>		
<script  type="text/javascript" src="js/datagrid/dhtmlxgridcell.js"></script>
<script  type="text/javascript" src="js/datagrid/dhtmlxgrid_pgn.js"></script>
<script  type="text/javascript" src="js/datagrid/dhtmlxgrid_drag.js"></script>
<script  type="text/javascript" src="js/datagrid/dhtmlxgrid_excell_link.js"></script>

<script  type="text/javascript" src="js/ajax/clientela.ajax.js"></script>
    <style type="text/css">
<!--
.style22 {color: #FF0000}
.style23 {color: #FFFFFF;
	font-weight: bold;
}
-->
    </style>
</head>

<body>
   
    <table align="center" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td valign="top">
                <table width="780px" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
                        <td>
                            <img alt="" src="imagens/banner.jpg" width="100%"/></td>
                    </tr>
                    <tr>
                        <td class="barra">
                            <table cellpadding="0" cellspacing="0" class="style4">
                                <tr>
                                    <td class="style7">
                                        &nbsp;&nbsp; Seja Bem Vindo <?php echo $admin->GetNome(); ?>!&nbsp;</td>
                                    
                                    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="25%"><img src="imagens/back.png" alt="voltar" width="8" height="30" style="width: 17px; height: 16px" /></td>
                                        <td width="75%">&nbsp;<a href="admin.frm.php"><b>VOLTAR</b></a></td>
                                      </tr>
                                    </table></td><td >&nbsp;&nbsp;&nbsp;</td>
                              <td valign="middle">
                                        <table cellpadding="0" cellspacing="0" class="style5">
                                            <tr>
                                                <td class="style6">
                                        <img alt="" src="imagens/bt_logout.jpg" style="margin-top: 0px" /></td>
                                                <td>
                                                    &nbsp;<b><a href="<?php echo $config->GetPaginaPrincipal() ?>">SAIR</a></b></td>
                                            </tr>
                                        </table>                                    </td><td >&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                            </table>                            </td>
                    </tr>
                    <tr>
                    
                    </tr>
                    <tr>
                        <td>
                        
                        
                        
                                
                                <!-- TABELA GRID-->
                                <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td  height="36"><b>&nbsp;&nbsp;&nbsp;MANIFESTA&Ccedil;&Otilde;ES EM ABERTO <span class="style22">(clique em VER para visualizar detalhes da manifesta&ccedil;&atilde;o)</span></b></td>
                                  </tr>
                                  <tr>
                                      <td>                                        
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="3%"></td>
                                            <td width="94%">									            
									            <input type="Text" id="txtFiltro" name="txtFiltro">
												<input name="btnFiltrar" type="Button" id="btnFiltrar" onclick="Filtrar()" value="Filtrar">	
												&nbsp;por:<input type="radio" name="txtTipoFiltro" id="txtTipoFiltro" value="nome">Nome<input type="radio" id="txtTipoFiltro" name="txtTipoFiltro" value="assunto" checked="checked">Assunto											
											</td>
                                            <td width="3%">&nbsp;</td>
                                          </tr>
                                        </table>                                        
                                       </td>
                                  </tr>
                                  <tr>
                                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="178">
                                        
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="3%">&nbsp;</td>
                                            <td width="94%">
 
										
														<div id="grid" height="330px" style="background-color:white;overflow:hidden"></div>                                            </td>
                                            <td width="3%">&nbsp;</td>
                                          </tr>
                                        </table>                                        </td>
                                      </tr>
                                      <tr>
                                        <td height="33" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td>
                                        <table width="298" border="0" cellspacing="0" cellpadding="0">
                                        </table></td>
                                            <td id="recinfoArea"></td>
                                            <td id="pagingArea"></td>
                                          </tr>
                                        </table></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table>
                   <!-- FIM TABELA COMPROVACAO -->
                                 <script>
                                        									
									
											grid = new dhtmlXGridObject('grid');
											grid.setImagePath("imagens/datagrid/");
											grid.setHeader("C\u00f3digo, Assunto, Clientela, Tipo, Identificacao, Data, Viu,");
											grid.setInitWidths("60,*,100,70,90,70,30,30");
											grid.setColAlign("center, right, center, center, center, left, center");
											grid.setColTypes("ro,ro,ro,ro,ro,ro,ro,link");
											grid.setColSorting("int,str,str,str,str,str,str,str");
											grid.enablePaging(true,15,5,"pagingArea",true,"recinfoArea");
      										grid.enableKeyboardSupport(true);											
											grid.enableDragAndDrop("false");
					
											grid.init();
											grid.setSkin("light");
											grid.loadXML("abertas.exe.php?metodo=carregagrid&codigo=");
										</script>
								<script>
						
											function Filtrar()
											{
												var valor;
												valor = document.getElementById("txtFiltro").value;
												var tipo_filtro = document.getElementsByName("txtTipoFiltro");
												for (var i = 0, length = tipo_filtro.length; i < length; i++) {
												    if (tipo_filtro[i].checked) {								    
												        tipo_filtro = tipo_filtro[i].value;
												        break;
												    }
												}
												grid.init();
												grid.loadXML("abertas.exe.php?metodo=filtrar&valor="+valor+"&tipo_filtro="+tipo_filtro);
											
											}
								
																													
								</script>
                        
                        
                        
                        </td>
                    </tr>
                    
                    <tr>
                        <td>&nbsp;                            </td>
                    </tr>
                    <tr>
                        <td bgcolor="#68B92C" valign="middle" align="center" class="rodape"><span class="style23">Sistema de Ouvidoria - VOX / <?php echo $config->GetNomeInstituicao();?></span></td>
                  </tr>
                    <tr>
                        <td bgcolor="Silver" valign="middle" align="center" class="barra">
                            &nbsp;
                            <div align="center">
		                      <img src="imagens/postgres.gif" width="80" height="15">
		                      <img src="imagens/php.png" width="80" height="15">
		                      <img src="imagens/gti.gif" width="80" height="15">		                    </div>                            </td>
                    </tr>
                </table>
          </td>
        </tr>
    </table>

</body>
</html>

