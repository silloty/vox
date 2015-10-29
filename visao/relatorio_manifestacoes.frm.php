<?php

require_once("../config.cls.php");
require_once("../modelo/usuario.cls.php");

$config = new clsConfig();

// VERIFICANDO USUÁRIO

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


//Capturando o intervalo de datas por GET
$data_inicial = $_GET['data1'];
$data_final = $_GET['data2'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Relat&oacute;rio de Manifesta&ccedil;&otilde;es::</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}

.style12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;}
.style18 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #000000; }
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td width="62%"><p align="center" class="style1">VOX - Sistema de Ouvidoria <br> 
      <?php echo $config->GetNomeInstituicao();?></p>    </td>
    <td width="38%"><div align="left"><img src="imagens/logo_menor.jpg" width="229" height="112" /></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center"><span class="style2">Rela&ccedil;&atilde;o de manifesta&ccedil;&otilde;es recebidas no per&iacute;odo de <?php echo $data_inicial . ' a ' . $data_final ?> </span></div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="left"></div></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td width="3%" bgcolor="#68B92C"><div align="center"><span class="style18">N&ordm;</span></div></td>
        <td width="5%" bgcolor="#68B92C"><div align="center"><span class="style18">C&oacute;digo</span></div></td>
        <td width="8%" bgcolor="#68B92C"><div align="center"><span class="style18">Data Reg. </span></div></td>
        <td width="9%" bgcolor="#68B92C"><div align="center"><span class="style18">Tipo</span></div></td>
        <td width="9%" bgcolor="#68B92C"><div align="center"><span class="style18">Identifica&ccedil;&atilde;o</span></div></td>
        <td width="9%" bgcolor="#68B92C"><div align="center"><span class="style18">Nome</span></div></td>
        <td width="18%" bgcolor="#68B92C"><div align="center"><span class="style18">Assunto</span></div></td>
        <td width="18%" bgcolor="#68B92C"><div align="center"><span class="style18">Departamento</span></div></td>
        <td width="9%" bgcolor="#66B92B"><div align="center"><span class="style18">Clientela</span></div></td>
        <td width="12%" bgcolor="#68B92C"><div align="center"><span class="style18">Solu&ccedil;&atilde;o</span></div></td>
      </tr>
     
	 <tr>
	 <?php
	  	if (isset($_SESSION['vox_manifestacao'])) 
		{
			$man = $_SESSION['vox_manifestacao'];
			$cont=0;
			
			
			foreach($man as $chave => $linha)
			{
				$i = 0;
				$num = $linha[$i++];
				$codigo = $linha[$i++];
				$data_reg = $linha[$i++];
				$tipo = $linha[$i++];	
				$identificacao = $linha[$i++];
				$nome = $linha[$i++];
				$assunto = $linha[$i++];
				$departamento = $linha[$i++];
				$clientela=$linha[$i++];
				$situacao =$linha[$i++];
				
				echo '
				<tr>
					<td><span class="style12">'.$num.'</span></td>
					<td><span class="style12">'.$codigo.'</span></td>
					<td><span class="style12">'.$data_reg.'</span></td>
					<td><span class="style12">'.$tipo.'</span></td>
					<td><span class="style12">'.$identificacao.'</span></td>
					<td><span class="style12">'.$nome.'</span></td>
					<td><span class="style12">'.$assunto.'</span></td>
					<td><span class="style12">'.$departamento.'</span></td>
					<td><span class="style12">'.$clientela.'</span></td>
					<td><span class="style12">'.$situacao.'</span></td>
				</tr>
					';
			}
		}
	  	
		?>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
