<?php
session_start();
$registro = $_SESSION['vox_registro'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../favicon.ico">
<title>Consulta andamento da manifesta&ccedil;&atilde;o</title>
<script src="js/geral.js" type="text/javascript"></script>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/ajax/consulta.ajax.js" type="text/javascript"></script>
<!--
<script type="text/javascript">
	function PegaRegistro(valor) 
	{
		document.frmConsulta.txtRegistro.value = document.frmConsulta.txtConsulta.value;
		//alert(document.frmConsulta.txtRegistro.value);
	}
</script>
-->

<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />

</head>

<body background="imagens/fundo.jpg">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" hspace="0" >
  <tr>
    <td valign="top"> 
		<table width="100%" height="80" border="0" align="center" background="">
  <tr>
    <td bgcolor="#FFCC00">
	<div class="topoGoverno" id="barra-superior">
          <div align="left"><img src="imagens/logo_edu.gif" alt="Minist&eacute;rio da Educa&ccedil;&atilde;o" width="430" height="20" border="0" >          </div>
    </div>
	</td>
  </tr>
  <tr>
    <td height="80px" background="imagens/bg_barra.jpg" align="center" >
	<div style="height:70px; width:500px; background:url(imagens/logo_bvox.png)" ></div>
	
	</td>
  </tr>
  <tr>
    <td height="25px" background="imagens/bg_barra.jpg" align="center" ><span class="style22"><strong>:: CONSULTE O ANDAMENTO DA SUA MANIFESTAÇÃO:: </strong></span></td>
  </tr>
  
  <tr>
    <td align="center">
<form id= "frmConsulta" name="frmConsulta" method="post" action="consulta.exe.php">
<input name="txtRegistro" type="hidden" id="txtRegistro" value="<?php echo $registro?>"/>
<script type="text/javascript" src="js/tooltip/wz_tooltip.js"></script>
<table width="100%">

  <tr>
    <td>Consulte o andamento de sua manifestação:</td>
  </tr>
  
  <tr>
    <td>Insira nº do registro aqui: 
      <label>
      <input name="txtConsulta" type="text" id="txtConsulta" size="40" />
      </label>
      <label>
      <input type="button" name="btnConsulta" id="btnConsulta" value="Consultar" onclick="Acompanhamento(txtConsulta.value);"/>
      </label>
	</td>
  </tr>
  
  <tr>
    <td>    
    <span id="spanManifestacao"></span>
    </td>
  </tr>
  
  
  <tr>
    <td>   
	<br />
       <strong><a style="text-decoration:none; color:#006600" href="modo_manifestando.frm.php">Fazer uma manifestação!</a></strong>
    </td>
  </tr>
</table>

</form>
	
	</td>
  </tr>
  
  
</table>

	</td>
  </tr>
  
  

  
</table>
</body>
</html>
