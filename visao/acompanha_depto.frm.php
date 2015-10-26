<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include '../tema.php'; ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../favicon.ico">
<title>Resposta &agrave; manifesta&ccedil;&atilde;o</title>


<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/ajax/acompanha_depto.ajax.js" type="text/javascript"></script>
<?php echo $css; ?>
</head>

<body>
<?php echo $barra_brasil; ?>
<?php echo $cabecalho; ?>
<div id="principal">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" hspace="0" >
  <tr>
    <td valign="top"> 
		<table width="100%" height="80" border="0" align="center" background="">
  <tr>
    <td height="80px" background="imagens/bg_barra.jpg" align="center" >
	<div style="height:70px; width:500px; background:url(imagens/logo_bvox.png)" ></div>
	
	</td>
  </tr>
  <tr>
    <td height="25px" background="imagens/bg_barra.jpg" align="center" ><span class="style22"><strong>:: ENVIE UMA RESPOSTA PARA A MANIFESTAÇÃO:: </strong></span></td>
  </tr>
  
  <tr>
    <td align="center">
	
<br>
<form id="frmResposta" name="frmResposta" method="post" action="acompanha_depto.exe.php">
<table width="100%">
 
  <tr>
    <td>Insira o n&uacute;mero do ticket aqui: 
      <label>
      <input name="txtConsulta" type="text" id="txtConsulta" size="40" />
      </label>
      <label>
      <input type="button" name="btnConsulta" id="btnConsulta" value="Consultar" onclick="Acompanha_depto(txtConsulta.value)"/>
      </label>
	</td>
  </tr>
  
  <tr>
    <td>    
	
    <span id="spanResposta"></span>
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
</div>
</body>
</html>
