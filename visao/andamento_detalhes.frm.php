<?php

require_once("../config.cls.php");
require_once("../modelo/usuario.cls.php");
require_once("../controle/data.gti.php");
$config = new clsConfig();
$data = new gtiData();

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
	<script src="js/ajax/abertas.ajax.js" type="text/javascript"></script>
	<script src="js/prototype.js" type="text/javascript"></script>
    
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
.style23 {
	font-size: small;
	
}
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
                                    <td class="style7">
                                        &nbsp;&nbsp; Seja Bem Vindo <?php echo $admin->GetNome(); ?>!&nbsp;</td>
                                    
                                    <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="25%"><img src="imagens/back.png" alt="voltar" width="8" height="30" style="width: 17px; height: 16px" /></td>
                                        <td width="75%">&nbsp;<a href="andamento.frm.php"><b>VOLTAR</b></a></td>
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
                            </table>                      </td>
                    </tr>
                    <tr>
                      <td bgcolor="#F3F8F1">
                            <br />
                            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="">
                                <tr>
                                    <td colspan="5" align="center">
<script type="text/javascript" src="js/tooltip/wz_tooltip.js"></script>
<form id="frmDetalhes" method="post" action="andamento_detalhes.exe.php">


<input type="hidden" name="txtMetodo" id="txtMetodo" value=""/>
<input type="hidden" name="txtCodigo" id="txtCodigo" value=""/>

                                     <?php
					 
					 require_once("../modelo/manifestacao.cls.php");
					 require_once("../controle/data.gti.php");
					 require_once("../modelo/clientela.cls.php");
					 require_once("../modelo/tipo.cls.php");
					 require_once("../modelo/departamento.cls.php");
					 
					 $codigo = $_GET['codigo'];
					 
					 $manifestacao = new clsManifestacao();
					 $manifestacao->SetCodigo(trim($codigo));
					 $manifestacao->ConsultarPorCodigo();
					 $clientela = new clsClientela();
					 $tipo = new clsTipo();
					 $departamento = new clsDepartamento();
					 
								
					if(trim($manifestacao->GetIdentificacao()) == 'S')
					{
                     	echo 
						'
							<table width="100%" border="0">
                          <tr>
                            <td width="211"><strong>Forma de Identificação:</strong> </td>
                            <td width="402"><label>Sigiloso</label></td>
                            <td width="147" rowspan="11" valign="bottom"><div align="center">
                              <table width="100%" border="0">
  <tr>
    <td><div align="center"><img src="imagens/encaminhar.png" width="70" height="70" /></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <input name="btnEncaminhar" type="button" class="botaoA" id="btnEncaminhar" value="Encaminhar"  onclick="submitForm(\'frmDetalhes\',\'encaminhar\','.$manifestacao->GetCodigo().');"/>
    </div></td>
  </tr>
</table>
</p>
                              <img src="imagens/finalizar.png" width="70" height="70" /><br><br><input name="btnFinalizar" type="button" class="botaoA" id="btnFinalizar" value="Finalizar"  onClick="submitForm(\'frmDetalhes\',\'finalizar\','.$manifestacao->GetCodigo().');"/>
                              </div></td>
                          </tr>
                          <tr>
                            <td><strong>Nome do manifestante:</strong></td>
                            <td>'. $manifestacao->GetNome() .'</td>
  </tr>
						  <tr>
                            <td><strong>CPF:</strong></td>
                			<td>'. $manifestacao->GetCpf().'</td>
  </tr>
                          <tr>
                            <td><strong>Tipo de manifestação: </strong></td>
                            <td>'.$manifestacao->GetTipo().'</td>
  </tr>
                          <tr>
                            <td><strong>Clientela: </strong></td>
                            <td>
                            '.$manifestacao->GetClientela().'
                            </td>
  </tr>
                          <tr>
                            <td><strong>Endereço: </strong></td>
                            <td>'.$manifestacao->GetEndereco().'</td>
                          </tr>
                          <tr>
                            <td><strong>Email: </strong></td>
                            <td>'.$manifestacao->GetEmail().'</td>
                          </tr>
                          <tr>
                            <td><strong>Data da manifestação: : </strong></td>
                            <td>'.$data->ConverteDataBR($manifestacao->GetDataCriacao()).'</td>
  </tr>
                          <tr>
                            <td><strong>Já passou por: </strong></td>
                            <td>'.$manifestacao->GetDepartamentos().'
							<img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
							</td>
  </tr>
                          <tr>
                            <td><strong>Departamento: </strong></td>
                            <td><label>
                              <select name="dpdDepartamentos" id="dpdDepartamentos" style="width:400px">
							  	<option>-- Selecione --</option>
							  '.$departamento->ListaComboDepartamento().'
                              </select>
                            </label></td>
  </tr>
  	<tr>
                            <td valign="top"><strong>Assunto: </strong></td>
                            <td valign="top">'.$manifestacao->GetAssunto().'</td>
  </tr>
                          <tr>
                            <td valign="top"><strong>Conteúdo da manifestação: </strong></td>
                            <td valign="top">'.$manifestacao->GetConteudo().'</td>
  </tr>
                          <tr>
                              <td><strong>Resposta Final </strong></td>
                            <td><label>
                              <textarea name="txtRespostaFinal" cols="40" rows="7" id="txtRespostaFinal"></textarea>
                            </label></td>
                            <td valign="top"><div align="center">
                              <label>
                              
                              </label>
                            </div></td>
                          </tr>
						
						';
					 }
 					 elseif(trim($manifestacao->GetIdentificacao()) == 'I')
					 {
							echo
							'
								<table width="100%" border="0">
                          <tr>
                            <td width="211"><strong>Forma de Identificação:</strong> </td>
                            <td width="402"><label>Identificado</label></td>
                            <td width="147" rowspan="11" valign="bottom"><div align="center">
                              <table width="100%" border="0">
  <tr>
    <td><div align="center"><img src="imagens/encaminhar.png" width="70" height="70" /></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <input name="btnEncaminhar" type="button" class="botaoA" id="btnEncaminhar" value="Encaminhar"  onclick="submitForm(\'frmDetalhes\',\'encaminhar\','.$manifestacao->GetCodigo().');"/>
    </div></td>
  </tr>
</table>
</p>
                              <img src="imagens/finalizar.png" width="70" height="70" /><br><br><input name="btnFinalizar" type="button" class="botaoA" id="btnFinalizar" value="Finalizar"  onClick="submitForm(\'frmDetalhes\',\'finalizar\','.$manifestacao->GetCodigo().');"/>
                              </div></td>
                          </tr>
                          <tr>
                            <td><strong>Nome do manifestante:</strong></td>
                            <td>'. $manifestacao->GetNome() .'</td>
  </tr>
						  <tr>
                            <td><strong>CPF:</strong></td>
                			<td>'. $manifestacao->GetCpf().'</td>
  </tr>
                          <tr>
                            <td><strong>Tipo de manifestação: </strong></td>
                            <td>'.$manifestacao->GetTipo().'</td>
  </tr>
                          <tr>
                            <td><strong>Clientela: </strong></td>
                            <td>
                            '.$manifestacao->GetClientela().'
                            </td>
  </tr>
                          <tr>
                            <td><strong>Endereço: </strong></td>
                            <td>'.$manifestacao->GetEndereco().'</td>
                          </tr>
                          <tr>
                            <td><strong>Email: </strong></td>
                            <td>'.$manifestacao->GetEmail().'</td>
                          </tr>
                          <tr>
                            <td><strong>Data da manifestação: : </strong></td>
                            <td>'.$data->ConverteDataBR($manifestacao->GetDataCriacao()).'</td>
  </tr>
                          <tr>
                            <td><strong>Já passou por: </strong></td>
                            <td>'.$manifestacao->GetDepartamentos().'
							<img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
							</td>
  </tr>
                          <tr>
                            <td><strong>Departamento: </strong></td>
                            <td><label>
                              <select name="dpdDepartamentos" id="dpdDepartamentos" style="width:400px">
							  	<option>-- Selecione --</option>
							  '.$departamento->ListaComboDepartamento().'
                              </select>
                            </label></td>
  </tr>
  <tr>
                            <td valign="top"><strong>Assunto: </strong></td>
                            <td valign="top">'.$manifestacao->GetAssunto().'</td>
  </tr>
                          <tr>
                            <td valign="top"><strong>Conteúdo da manifestação: </strong></td>
                            <td valign="top">'.$manifestacao->GetConteudo().'</td>
  </tr>
                          <tr>
                              <td><strong>Resposta Final </strong></td>
                            <td><label>
                              <textarea name="txtRespostaFinal" cols="40" rows="7" id="txtRespostaFinal"></textarea>
                            </label></td>
                            <td valign="top"><div align="center">
                              <label>
                              
                              </label>
                            </div></td>
                          </tr>
                          
							';
					 }		 
					 else //anonima
					 {
						echo
						'
							<table width="100%" border="0">
                          <tr>
                            <td width="211"><strong>Forma de Identificação:</strong> </td>
                            <td width="402"><label>An&ocirc;nima</label></td>
                            <td width="147" rowspan="8" valign="bottom"><div align="center">
                              <table width="100%" border="0">
  <tr>
    <td><div align="center"><img src="imagens/encaminhar.png" width="70" height="70" /></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <input name="btnEncaminhar" type="button" class="botaoA" id="btnEncaminhar" value="Encaminhar"  onclick="submitForm(\'frmDetalhes\',\'encaminhar\','.$manifestacao->GetCodigo().');"/>
    </div></td>
  </tr>
</table>
</p>
                              <img src="imagens/finalizar.png" width="70" height="70" /><br><br><input name="btnFinalizar" type="button" class="botaoA" id="btnFinalizar" value="Finalizar"  onClick="submitForm(\'frmDetalhes\',\'finalizar\','.$manifestacao->GetCodigo().');"/>
                              </div></td>
                          </tr>
                          
                          <tr>
                            <td><strong>Tipo de manifestação: </strong></td>
                            <td>'.$manifestacao->GetTipo().'</td>
  </tr>
                          <tr>
                            <td><strong>Clientela: </strong></td>
                            <td>
                            '.$manifestacao->GetClientela().'                            </td>
  </tr>
                          
                          <tr>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td><strong>Data da manifestação: : </strong></td>
                            <td>'.$data->ConverteDataBR($manifestacao->GetDataCriacao()).'</td>
  </tr>
                          <tr>
                            <td><strong>Já passou por: </strong></td>
                            <td>'.$manifestacao->GetDepartamentos().'
							<img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
							</td>
  </tr>
                          <tr>
                            <td><strong>Departamento: </strong></td>
                            <td><label>
                              <select name="dpdDepartamentos" id="dpdDepartamentos" style="width:400px">
							  	<option>-- Selecione --</option>
							  '.$departamento->ListaComboDepartamento().'
                              </select>
                            </label></td>
  </tr>
  <tr>
                            <td valign="top"><strong>Assunto: </strong></td>
                            <td valign="top">'.$manifestacao->GetAssunto().'</td>
  </tr>
                          <tr>
                            <td valign="top"><strong>Conteúdo da manifestação: </strong></td>
                            <td valign="top">'.$manifestacao->GetConteudo().'</td>
  </tr>
  <tr>
                            <td valign="top"><strong>Razão do anonimato: </strong></td>
                            <td valign="top">'.$manifestacao->GetAnonimato().'</td>
  </tr>
                          <tr>
                              <td><strong>Resposta Final </strong></td>
                            <td><label>
                              <textarea name="txtRespostaFinal" cols="40" rows="7" id="txtRespostaFinal"></textarea>
                            </label></td>
                            <td valign="top"><div align="center">
                              <label>
                              
                              </label>
                            </div></td>
                          </tr>
						';
					 
					 }
					 
					 ?>
					 
					 
					 
<tr>
	<td colspan="3"><table width="100%" border="0">
	  <tr>
		<td><strong>Respostas dos Departamentos </strong></td>
	  </tr>
	  <tr>
		<td><table width="100%" border="1" class="style23">
		  <tr>
			<td width="20%" background="imagens/barra.jpg"><strong>Departamento</strong></td>
			<td width="50%" background="imagens/barra.jpg"><strong>Resposta</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data do envio</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data da resposta</strong></td>
		  </tr>
		  <?php
		   echo $manifestacao->PegaRespostasDepartamentos($manifestacao->GetCodigo());		  
		  ?>
		</table></td>
	  </tr>
	</table></td>
</tr>
</table>					 
					 
</form>
</td>
</tr>
              </table>          </td>
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
		                      <img src="imagens/gti.gif" width="80" height="15">		                    </div>                      </td>
                    </tr>
</table>
            </td>
        </tr>
    </table>

</body>
</html>

