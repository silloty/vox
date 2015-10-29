<?php
$relatorio = @$_REQUEST['relatorio'];

?>

<html>
<head>
	<title>PRATO</title>
    <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
    <script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/ajax/relatorios.ajax.js" type="text/javascript"></script>
</head>
<body>
<form id="frmRelatorios" name="frmRelatorios" method="post" action="relatorios.exe.php">
<input type="hidden" name="txtRelatorio" id="txtRelatorio" value=""/>

<table width="416" height="208" border="0" cellpadding="0" cellspacing="0" align="left" >
  <tr>
    <td width="17" valign="top">&nbsp;</td>
    <td width="385" valign="middle" align="center">
    
    <table width="91%" border="0" cellspacing="0" cellpadding="0" class="tabelaDeTipos">
      <tr>
        <td>&nbsp;</td>
        <td>
		
		<?php
			
        	switch (trim($relatorio))
        	{
        		case 'manifestacao':
					echo '<b> RELAT&Oacute;RIO DE MANIFESTA&Ccedil;&Atilde;O POR PER&Iacute;ODO</b>';
				break;
        		case 'atividade':
        			echo '<b> RELAT&Oacute;RIO DE ATIVIDADES POR PER&Iacute;ODO</b>';
        		break;
        	}
		?>   
		
		</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="76">Data Inicial :</td>
        <td width="310">
            <label>
            <input name="txtDataInicial" type="text" id="txtDataInicial" size="10" maxlength="10"/> 
            (dd/mm/aaaa)
            </label></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Data Final :</td>
        <td>
            <label>
            <input name="txtDataFinal" type="text" id="txtDataFinal" size="10" maxlength="10" />
            </label>              (dd/mm/aaaa)            </td>
      </tr>
      
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
        <input id="PDF" type="button" value="Gerar" class="botao"
        name="cmdGerar" onClick="submitForm('frmRelatorios', '<?php  echo $relatorio; ?>')"/>
      </tr>
    </table></td>
    <td width="14" valign="top">&nbsp;</td>
  </tr>
</table>

</form>
</body>
</html>
