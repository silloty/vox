<?php
	
	require_once("../config.cls.php");
	require_once("../controle/browser.gti.php");
	$config = new clsConfig();
	
	$nav = trim($_SESSION['vox_nav']);
	
	$config->Logout(false);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="shortcut icon" href="../favicon.ico">
    <title>:: VOX ::</title>
    <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
     <script src="js/validator.js" type="text/javascript"></script>
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
                            <img src="imagens/banner.jpg" alt="" width="777" /></td>
                  </tr>
                    <td class="barra">
                            <table cellpadding="0" cellspacing="0" class="style4">
                                <tr>
                                    <td class="style7">
                                        &nbsp;&nbsp; <span class="style23">Seja Bem Vindo! Este &eacute; o VOX, por favor, efetue seu login para iniciar a sess&atilde;o!</span></td>
                                        <td align="right">&nbsp;<img alt="ajuda" src="imagens/bt_ajuda.jpg" style="margin-top: 0px" /></td>
                                        <td>&nbsp;<a href="ajuda/ajuda.frm.php" target="_blank"><b>AJUDA</b></a></td>
                                </tr>
                            </table>
                            </td>
                    <tr>
                        <td class="style2">
                            </td>
                    </tr>
                    <tr>
                        <td>
                          
						  
	
						  
						  <form id="frmInicial" name="frmInicial" method="post" action="inicial.exe.php" onsubmit="return v.exec()">
                            <table width="410" align="center" cellpadding="0" cellspacing="0" class="telaLogin" >
                                <tr>
                                  <td width="403">
                                        <table cellpadding="0" cellspacing="0" class="formLogin" align="center">
                                            
                                            <tr>
                                                <td class="style3">
                                                    Login:</td>
                                                <td style="text-align: left">
                                                    <input id="txtLogin" name="txtLogin" type="text" class="caixaGrande" maxlength="20" value=""/></td>
                                            </tr>
                                            <tr>
                                                <td class="style3">
                                                    Senha:</td>
                                                <td style="text-align: left">
                                                    <input id="txtSenha" name="txtSenha" type="password" class="caixaGrande" maxlength="20" value=""/></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;                                                    </td>
                                                <td>&nbsp;                                                    </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;                                                    </td>
                                                <td style="text-align: right">
                                                    <input id="cmdConfirmar" name="cmdConfirmar" type="submit" value="Confirmar" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                  </td>
                                </tr>
                            </table>
                          </form>
						  
						  
						  
						  
						  
                        </td>
                  </tr>
                    <tr>
                        <td class="style1">
                            </td>
                    </tr>
                    <tr>
                        <td align="center" valign="middle" bgcolor="#6AB82E" class="rodape"><span class="style22">Sistema de Ouvidoria - <?php echo $config->GetNomeInstituicao();?></span></td>
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
<script language="javascript">

var campos =
{
    'txtLogin': {'l':'Login','r':true,'mn':1,'mx':20,'t':'txtLogin'},
    'txtSenha': {'l':'Senha','r':true,'mn':1,'mx':20,'t':'txtSenha'},
}

var v = new validator('frmInicial', campos);

</script>
</html>
