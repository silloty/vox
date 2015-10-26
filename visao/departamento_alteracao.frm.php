<?php
$metodo = @$_REQUEST['metodo'];
$codigo = @$_REQUEST['codigo'];

require_once("../modelo/departamento.cls.php");
$departamento = new clsDepartamento();
?>

<html>
<head>
	<title>Gest&atilde;o de Departamentos</title>
    <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
    <script src="js/prototype.js" type="text/javascript"></script>
	
    <script src="js/ajax/departamento.ajax.js" type="text/javascript"></script>
<br/>
</head>
<body>
<form id="frmAltera" name="frmAltera" method="post" action="departamento.exe.php">
<input type="hidden" name="txtMetodo" id="txtMetodo" value=""/>
<input type="hidden" name="txtCodigo" id="txtCodigo" value=""/>

<table width="416" height="208" border="0" cellpadding="0" cellspacing="0" align="left" >
  <tr>
    <td width="17" valign="top">&nbsp;</td>
    <td width="385" valign="middle" align="center" >
    
    <table width="82%" border="0" cellspacing="0" cellpadding="0" class="tabelaDeTipos">
      <tr>
        <td>&nbsp;</td>
        <td>
		<?php
        	switch (trim($metodo))
        	{
        		case 'novo':
					echo '<b> NOVO DEPARTAMENTO</b>';
				break;
        		case 'altera':
        			echo '<b> ALTERA&Ccedil;&Atilde;O DE DEPARTAMENTOS</b>';
        			$departamento->SelecionaPorCodigo($codigo);
        		break;
        	}
		?>        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="76">C&oacute;digo:</td>
        <td width="310">
            <label>
            <input type="text" name="txtCodigo" id="txtCodigo" class="caixaGrande" disabled="disabled" value="<?php echo $departamento->GetCodigo(); ?>"/>
            </label></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Nome:</td>
        <td>
            <label>
            <input type="text" name="txtNome" id="txtNome" class="caixaGrande" value="<?php echo $departamento->GetNome(); ?>"/>
            </label>        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Email:</td>
        <td><input type="text" name="txtEmail" id="txtEmail" class="caixaGrande" value="<?php echo $departamento->GetEmail(); ?>"/></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Descri&ccedil;&atilde;o</td>
        <td><label class="caixaGrande">
          <textarea name="txtDescricao" id="txtDescricao" ><?php echo $departamento->GetDescricao(); ?></textarea>
        </label></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      

      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
    
      <tr>
        <td>&nbsp;</td>
        <td>
        <input id="cmdGravar" type="button" value="Gravar" class="botao"
        name="cmdGravar" onClick="submitForm('frmAltera','<?php echo $metodo; ?>','<?php echo $codigo; ?>');"/>       </td>
      </tr>
    </table></td>
    <td width="14" valign="top">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
