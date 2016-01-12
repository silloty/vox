<?php
session_start();
require_once("../modelo/tipo.cls.php");
require_once("../modelo/clientela.cls.php");
require_once("../config.cls.php");
$config = new clsConfig();
$quant = $config->GetQuantCharManifestacao();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../favicon.ico">
<title>VOX Sistema de Ouvidoria - Modo Manifestando - &quot;Fa&ccedil;a sua manifesta&ccedil;&atilde;o!!!&quot;</title>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/ajax/modo_manifestando.ajax.js"></script>
<script type="text/javascript" src="js/mascara.js"></script>
<link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function limiteTexto(limiteCampo, limiteContador, limite) {
	if (limiteCampo.value.length > limite) {
		limiteCampo.value = limiteCampo.value.substring(0, limite);
	} else {
		limiteContador.value = limite - limiteCampo.value.length;
	}
}
</script>
<style type="text/css">
<!--
.style22 {
	font-size: large;
	font-weight: bold;
}
.style26 {font-size: 12px}
a:link {
	color: #FF0000;
	text-decoration: underline;
}
a:visited {
	text-decoration: underline;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: underline;
}
.style27 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
}
.style33 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
.style34 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style35 {font-size: 10px}
-->
</style>

</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" hspace="0" >
  <tr>
    <td valign="top"> 
		<table width="100%" height="80" border="0" align="center" background="">
  <tr>
    <td height="80px" background="imagens/bg_barra.jpg" align="center" >
	<div style="height:70px; width:500px; background:url(imagens/logo_bvox.png)" ></div>	</td>
  </tr>
  <tr>
    <td height="25px" background="imagens/bg_barra.jpg" align="center" ><div align="center"><span class="style22">:: FA&Ccedil;A SUA MANIFESTA&Ccedil;&Atilde;O :: <br>
      <span class="style27">ou consulte andamento clicando <a href="consulta.frm.php" target="_blank">aqui</a></span></span></div></td>
  </tr>
  
  <tr>
    <td align="center" background="imagens/fundo.jpg"><div align="left"></div></td>
  </tr>
  <tr>
    <td align="center" background="imagens/fundo.jpg">
	
	<script type="text/javascript" src="js/tooltip/wz_tooltip.js"></script> 
<form id="frmManifestacao"  method="post" action="modo_manifestando.exe.php">
<p>
  <input type="hidden" name="txtMetodo" id="txtMetodo" value=""/>
</p>
<table>
  
  <tr>
    <td>
	<table>
        <tr>
          <td class="labelTextos">Eu</td>
          <td><select name="dpdClientela" class="caixaElegante" id="dpdClientela" >
            <option selected="selected" value="">-- Selecione --</option>
            <?php 
			$clientela = new clsClientela();
			echo $clientela->ListaComboClientela();
		?>
          </select></td>
        </tr>
        <tr>
          <td class="labelTextos">Gostaria de fazer um(a) </td>
          <td><select name="dpdTipo" class="caixaElegante" id="dpdTipo">
            <option selected="selected" value="">-- Selecione --</option>
            <?php 
			$tipo = new clsTipo();
			echo $tipo->ListaComboTipo(1);
	   ?>
          </select></td>
        </tr>
        <tr>
          <td class="labelTextos">Meu email é </td>
          <td><input name="txtEmail" type="text" class="caixaTextoElegante" id="txtEmail" size="300" value="<?php echo $_SESSION['vox_email'];?>"/>
            <img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip('É importante que o manifestante forneça &lt;br&gt; um endereço de <strong> email válido </strong> para contato. &lt;br&gt; Através desse email o manifestante terá acesso &lt;br&gt; ao código para visualizar o andamento de sua manifesta&ccedil;&atilde;o', BGCOLOR, '#FFFFFF')" onmouseout="UnTip()" /></td>
        </tr>
        <tr>
          <td class="labelTextos">Eu</td>
          <td><select name="dpdIdentificacao" class="caixaElegante" id="dpdIdentificacao" onchange="OcultaCampo(this.value);">
            <option value="">-- Selecione --</option>
            <option value="I">quero me identificar (Identificado)</option>
            <option value="S">quero ser identificado apenas pelo ouvidor(a) (Sigiloso)</option>
            <option value="A">não quero me identificar (Anônimo)</option>
          </select>
            <img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip('Ao optar por <strong>quero me identificar </strong> o setor &lt;br&gt; envolvido com a manifesta&ccedil;&atilde;o terá acesso ao &lt;br&gt; nome do manifestante.&lt;br&gt; Ao optar por <strong>quero ser identificado somente &lt;br&gt; pelo ouvidor(a) </strong> seu nome será mantido em sigilo. &lt;br&gt; Ao optar por <strong> não quero me identificar </strong> o manifestante &lt;br&gt; terá acesso ao andamento caso guarde o numero &lt;br&gt; da manifesta&ccedil;&atilde;o ou informe um email válido.', BGCOLOR, '#FFFFFF')" onmouseout="UnTip()"/></td>
        </tr>
      </table></td>
  </tr>
  </table>
  <br />
  
  <span id="spanteste">
  
  <table width="472">
  <tr>
    <td class="labelTextos">Nome:</td>
    <td><input name="txtNome" type="text" class="caixaDadosElegante" id="txtNome" size="40" value="<?php echo $_SESSION['vox_nome'];?>" /></td>
  </tr>
  
  <tr>
    <td class="labelTextos">CPF**:</td>
    <td><input name="txtCPF" type="text" class="caixaDadosElegante" id="txtCPF" onKeyUp="soNumeros(this);" size="30" maxlength="11" value="<?php echo $_SESSION['vox_cpf'];?>"/>
    *</td>
  </tr>
  
  <tr>
    <td><span class="labelTextos">Telefone</span>:</td>
    <td><input name="txtTelefone" type="text" class="caixaDadosElegante" id="txtTelefone" onkeyup="soNumeros(this)" maxlength="10" value="<?php echo $_SESSION['vox_telefone'];?>"/>
    *</td>
  </tr>
  
  <tr>
    <td class="labelTextos">Endereço:</td>
    <td><input name="txtEndereco" type="text" class="caixaDadosElegante" id="txtEndereco" size="40" value="<?php echo $_SESSION['vox_endereco'];?>"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right" class="style26 style34"><span class="style35">* Somente números</span> </div>
    	<div align="right" class="style26 style34"><span class="style35">** Campos Opcionais</span> </div>
    </td>
  </tr>
  </table>
  </span>
  
  <br />
  
  <table width="472">
  <tr>
  <td class="labelTextos">Assunto:</td>
    <td>
    <input name="txtAssunto" type="text" class="caixaAssuntoElegante" id="txtAssunto" size="30" value="<?php echo $_SESSION['vox_assunto'];?>"/></td>
  </tr>
  <tr>
    <td colspan="2" class="labelTextos">Manifesta&ccedil;&atilde;o:</td>
    </tr>
  <tr>
    <td colspan="2">
      <textarea name="txtManifestacao" cols="40" rows="7" class="caixaManifestacaoElegante" id="txtManifestacao" onKeyDown="limiteTexto(this.form.txtManifestacao,this.form.countdown,<?php echo $quant ?>);" onKeyUp="limiteTexto(this.form.txtManifestacao,this.form.countdown,<?php echo $quant ?>);"><?php echo $_SESSION['vox_manifestacao'];?></textarea></td>
    </tr>
  <tr>
    <td colspan="2">  
    	<font size="1">Voc&ecirc; tem <input readonly type="text" name="countdown" size="3" value="<?php echo $quant ?>" disabled> caracteres restantes.</font><br><br>
		<span class="labelTextos">Digite os n&uacute;meros que voc&ecirc; v&ecirc; na imagem </span> 
	  <input name="txtSeguranca" type="text" class="caixaSegurancaElegante" id="txtSeguranca" size="5" maxlength="6">
	  &nbsp;<br><img src="imagens/img.php" id="captcha">
	  <img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip('Problemas com a imagem? Clique aqui.', BGCOLOR, '#FFFFFF')" onmouseout="UnTip()" onclick="javascript: document.getElementById('captcha').src = 'imagens/img.php?' + Math.random() " value="Problemas com a imagem?"/>
	</td>
  </tr>
  <tr>
  <td colspan="2"><input name="btnEnviar" type="button" class="botaoPrincipal" id="btnEnviar"  onclick="submitForm('frmManifestacao', 'enviar')" value="Enviar"/></td>
    </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>	</td>
  </tr>
</table>

	</td>
  </tr>
  <tr>
  	<td background="imagens/barra.jpg"><p align="center" class="rodape">&nbsp;</p></td>
  </tr>
</table>

    


</body>
</html>