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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
   <script type="text/javascript" src="js/tooltip/wz_tooltip.js"></script>
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
                                        <td width="75%">&nbsp;<a href="fechadas.frm.php"><b>VOLTAR</b></a></td>
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
                      <td>
                            <br />
                            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="">
                                <tr>
                                    <td colspan="5" align="center" bgcolor="#F3F8F1">
<script type="text/javascript" src="js/tooltip/wz_tooltip.js"></script>							
<form id="frmDetalhes" method="post" action="fechadas_detalhes.exe.php">
<input type="hidden" name="txtMetodo" id="txtMetodo" value=""/>
<input type="hidden" name="txtCodigo" id="txtCodigo" value=""/>

                                     <?php
					 
					 require_once("../modelo/manifestacao.cls.php");
					 require_once("../controle/data.gti.php");
					 require_once("../modelo/clientela.cls.php");
					 require_once("../modelo/tipo.cls.php");
					 require_once("../modelo/status.cls.php");
					 
					
					 $codigo = $_GET['codigo'];
										 
					 $manifestacao = new clsManifestacao();
					 $manifestacao->SetCodigo(trim($codigo));
					 $manifestacao->ConsultarPorCodigo();
					 $manifestacao->MarcarComoVisto();
					 $clientela = new clsClientela();
					 $tipo = new clsTipo();
					 $status = new clsStatus();
					 
					 echo '<table width="100%" border="0">
							<tr>
                            	<td width="211"><strong>C&oacute;digo:</strong></td>
                            	<td>'.$manifestacao->GetCodigo().'</td>
                            </tr>';					
					if ($manifestacao->GetVisualizado() == 't')
						$visualizado = 'checked';
					if(trim($manifestacao->GetIdentificacao()) == 'S')
					{
                     	echo 
						'
						  <tr>
    						<td width="211"><strong>Visualizado:</strong></td>
                            <td><input name="txtVisualizado" type="checkbox" '.$visualizado.' value="t" /></td>
    					  </tr>
                          <tr>
                            <td width="211"><strong>Forma de Identifica&ccedil;&atilde;o:</strong> </td>
                            <td width="402"><label>Sigiloso</label></td>
                            <td width="147" rowspan="11" valign="bottom"><div align="center">
                              <table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</p>
                              <img src="imagens/save.png" width="70" height="70" /><br><br><input name="btnAlterar" type="button" class="botaoA" id="btnAlterar" value="Salvar Altera&ccedil;&otilde;es"  onClick="submitForm(\'frmDetalhes\',\'alterar\','.$manifestacao->GetCodigo().');"/>
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
                            <td><strong>Tipo de manifesta&ccedil;&atilde;o: </strong></td>
                            <td><label>
                              <select name="dpdTipo" id="dpdTipo">
							  <option value="'.$manifestacao->GetCodigoTipo().'">'.$manifestacao->GetTipo().'</option>
							  '.$tipo->ListaComboTipo(0).'
                              </select>
                            </label></td>
  </tr>
                          <tr>
                            <td><strong>Clientela: </strong></td>
                            <td>
                            '.$manifestacao->GetClientela().'
                            </td>
  </tr>
                          <tr>
                            <td><strong>Endere&ccedil;o: </strong></td>
                            <td>'.$manifestacao->GetEndereco().'</td>
                          </tr>
                          <tr>
                            <td><strong>Email: </strong></td>
                            <td>'.$manifestacao->GetEmail().'</td>
                          </tr>
                          <tr>
                            <td><strong>Data da manifesta&ccedil;&atilde;o: : </strong></td>
                            <td>'.$data->ConverteDataBR($manifestacao->GetDataCriacao()).' &agrave;s '.$manifestacao->GetDataHora().'</td>
  </tr>
                          <tr>
                            <td><strong>J&aacute; passou por: </strong></td>
                            <td>'.$manifestacao->GetDepartamentos().'
							<img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
							</td>
  </tr>
                          <tr>
                            <td><strong>Status da Manifestacao: </strong></td>
                            <td><label>
                              <select name="dpdStatus" id="dpdStatus">
							  <option value="'.$manifestacao->GetCodigoStatus().'">'.$manifestacao->GetStatus().'</option>
							  '.$status->ListaComboStatus().'
                              </select>
                            </label></td>
  </tr>
  <tr>
                            <td valign="top"><strong>Assunto: </strong></td>
                            <td valign="top">'.$manifestacao->GetAssunto().'</td>
  </tr>
                          <tr>
                            <td valign="top"><strong>Conte&uacute;do da manifesta&ccedil;&atilde;o: </strong></td>
                            <td valign="top">'.$manifestacao->GetConteudo().'</td>
  </tr>
  	<tr>
	<td>&nbsp;</td>
	</tr>
                          <tr>
                     <td><strong>Resposta Final:</strong></td>
                            <td>'.$manifestacao->GetRespostaFinal().'</td>
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
    					  <tr>
    						<td width="211"><strong>Visualizado:</strong></td>
                            <td><input name="txtVisualizado" type="checkbox" '.$visualizado.' value="t" /></td>
    					  </tr>
                          <tr>
                            <td width="211"><strong>Forma de Identifica&ccedil;&atilde;o:</strong> </td>
                            <td width="402"><label>Identificado</label></td>
                            <td width="147" rowspan="11" valign="bottom"><div align="center">
                              <table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</p>
                              <img src="imagens/save.png" width="70" height="70" /><br><br>
							  <input name="btnAlterar" type="button" class="botaoA" id="btnAlterar" value="Salvar Altera&ccedil;&otilde;es"  onClick="submitForm(\'frmDetalhes\',\'alterar\','.$manifestacao->GetCodigo().');"/>
                              </div></td>
                          </tr>
                          <tr>
                            <td><strong>Nome do manifestante:</strong></td>
                            <td>'.  $manifestacao->GetNome() .'</td>
  </tr>
						  <tr>
                            <td><strong>CPF:</strong></td>
                			<td>'. $manifestacao->GetCpf().'</td>
  </tr>
                          <tr>
                            <td><strong>Tipo de manifesta&ccedil;&atilde;o: </strong></td>
                            <td><label>
                              <select name="dpdTipo" id="dpdTipo">
							  <option value="'.$manifestacao->GetCodigoTipo().'">'.$manifestacao->GetTipo().'</option>
							  '.$tipo->ListaComboTipo(0).'
                              </select>
                            </label></td>
  </tr>
                          <tr>
                            <td><strong>Clientela: </strong></td>
                            <td>
                            '.$manifestacao->GetClientela().'
                            </td>
  </tr>
                          <tr>
                            <td><strong>Endere&ccedil;o: </strong></td>
                            <td>'.$manifestacao->GetEndereco().'</td>
                          </tr>
                          <tr>
                            <td><strong>Email: </strong></td>
                            <td>'.$manifestacao->GetEmail().'</td>
                          </tr>
                          <tr>
                            <td><strong>Data da manifesta&ccedil;&atilde;o: : </strong></td>
                            <td>'.$data->ConverteDataBR($manifestacao->GetDataCriacao()).' &agrave;s '.$manifestacao->GetDataHora().'</td>
  </tr>
                          <tr>
                            <td><strong>J&aacute; passou por: </strong></td>
                            <td>'.$manifestacao->GetDepartamentos().'
							<img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
							</td>
  </tr>
                          <tr>
                            <td><strong>Status da manifesta&ccedil;&atilde;o: </strong></td>
                            <td><label>
                              <select name="dpdStatus" id="dpdStatus">
							  <option value="'.$manifestacao->GetCodigoStatus().'">'.$manifestacao->GetStatus().'</option>
							  '.$status->ListaComboStatus().'
                              </select>
                            </label></td>
  </tr>
  <tr>
                            <td valign="top"><strong>Assunto: </strong></td>
                            <td valign="top">'.$manifestacao->GetAssunto().'</td>
  </tr>
                          <tr>
                            <td valign="top"><strong>Conte&uacute;do da manifesta&ccedil;&atilde;o: </strong></td>
                            <td valign="top">'.$manifestacao->GetConteudo().'</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	</tr>
                          <tr>
                              <td><strong>Resposta Final:</strong></td>
                            <td>'.$manifestacao->GetRespostaFinal().'</td>
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
    					  <tr>
    						<td width="211"><strong>Visualizado:</strong></td>
                            <td><input name="txtVisualizado" type="checkbox" '.$visualizado.' value="t" /></td>
    					  </tr>
                          <tr>
                            <td width="211"><strong>Forma de Identifica&ccedil;&atilde;o:</strong> </td>
                            <td width="402"><label>An&ocirc;nima</label></td>
                            <td width="147" rowspan="8" valign="bottom"><div align="center">
                              <table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</p>
                              <img src="imagens/save.png" width="70" height="70" /><br><br>
							  <input name="btnAlterar" type="button" class="botaoA" id="btnAlterar" value="Salvar Altera&ccedil;&otilde;es"  onClick="submitForm(\'frmDetalhes\',\'alterar\','.$manifestacao->GetCodigo().');"/>
                              </div></td>
                          </tr>
                          
                          <tr>
                            <td><strong>Tipo de manifesta&ccedil;&atilde;o: </strong></td>
                            <td><label>
                              <select name="dpdTipo" id="dpdTipo">
							  <option value="'.$manifestacao->GetCodigoTipo().'">'.$manifestacao->GetTipo().'</option>
							  '.$tipo->ListaComboTipo(0).'
                              </select>
                            </label></td>
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
                            <td><strong>Data da manifesta&ccedil;&atilde;o: : </strong></td>
                            <td>'.$data->ConverteDataBR($manifestacao->GetDataCriacao()).' &agrave;s '.$manifestacao->GetDataHora().'</td>
  </tr>
                          <tr>
                            <td><strong>J&aacute; passou por: </strong></td>
                            <td>'.$manifestacao->GetDepartamentos().'
							<img src="imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
							</td>
  </tr>
                          <tr>
                            <td><strong>Status da manifesta&ccedil;&atilde;o: </strong></td>
                            <td><label>
                              <select name="dpdStatus" id="dpdStatus">
							  <option value="'.$manifestacao->GetCodigoStatus().'">'.$manifestacao->GetStatus().'</option>
							  '.$status->ListaComboStatus().'
                              </select>
                            </label></td>
  </tr>
  <tr>
                            <td valign="top"><strong>Assunto: </strong></td>
                            <td valign="top">'.$manifestacao->GetAssunto().'</td>
  </tr>
                          <tr>
                            <td valign="top"><strong>Conte&uacute;do da manifesta&ccedil;&atilde;o: </strong></td>
                            <td valign="top">'.$manifestacao->GetConteudo().'</td>
  </tr>
  <tr>
  </td>
  <tr>
                            <td valign="top"><strong>Raz&atilde;o do anonimato:</strong></td>
                            <td valign="top">'.$manifestacao->GetAnonimato().'</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	</tr>
                          <tr>
                               <td><strong>Resposta Final:</strong></td>
                            <td>'.$manifestacao->GetRespostaFinal().'</td>
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
	    <td bgcolor="#F3F8F1"><strong>Feedback do manifestante: </strong> 
		<?php 
		if (trim($manifestacao->GetFeedback())=='')
		{
			echo 'O manifestante n&atilde;o enviou um feedback.';
		}
		else
		{
			echo $manifestacao->GetFeedback(); 
		}
		
		
		
		?></td>
	    </tr>
	  <tr>
		<td><strong>Respostas dos Departamentos </strong></td>
	  </tr>
	  <tr>
		<td bgcolor="#EFF7E8"><table width="100%" border="1" class="style23">
		  <tr>
			<td width="20%" background="imagens/barra.jpg"><strong>Departamento</strong></td>
			<td width="50%" background="imagens/barra.jpg"><strong>Resposta</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data/Hora do envio</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data/Hora da resposta</strong></td>
		  </tr>
		  <?php
		   echo utf8_decode($manifestacao->PegaRespostasDepartamentos($manifestacao->GetCodigo()));		  
		  ?>
		</table></td>
	  </tr>
	</table></td>
</tr>
</table>					 
					 
		
</form>   
                                 </td>
</tr>
                            </table>                      </td>
                    </tr>
                    
                    
                    <tr>
                        <td align="center" valign="middle" bordercolor="#333333" bgcolor="#68B92E" class="rodape"><span class="style22">Sistema de Ouvidoria - <?php echo utf8_encode($config->GetNomeInstituicao());?></span></td>
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

