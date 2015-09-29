<?php
session_start();

require_once("../modelo/manifestacao.cls.php");
require_once("../controle/data.gti.php");

$metodo = $_GET['metodo'];
$registro = $_POST['valor'];


$data = new gtiData();

switch ($metodo)
{

	case 'andamento':
			$manifestacao = new clsManifestacao();
			$manifestacao->SetRegistro($registro);			
			$manifestacao->Consultar();
			
			$_SESSION['vox_registro'] = $registro;
			//verificando se já é o momento de exibir o feedback
			$resposta = "";			
			if($manifestacao->VerificaRespostaFinal()==true )
			{	
				$resposta = 
				'
					<tr>
					<td>Caro manifestante sua resposta &eacute; de grande import&acirc;ncia para nossa Ouvidoria! Se desejar se manifestar sobre a qualidade deste atendimento ou qualquer outra opini&atilde;o sobre a resolu&ccedil;&atilde;o deste processo utilize o campo abaixo:</td>
				  </tr>
					 <tr>
				    <td><strong>Responder &agrave; Ouvidoria:</strong><br/>
				        <label>
				        <textarea name="txtResposta" cols="40" rows="6"></textarea>
				        </label>
			            <label>
			            <input name="bntResponder" type="submit" id="bntResponder" value="Responder" />
		            </label></td>
			      </tr>
				  
				';
			}
			
			
			//indica que a manifestacao nao existe
			if (trim($manifestacao->GetCodigo()) == '')
			{
				echo '<br><strong>Essa manifesta&ccedil;&atilde;o n&atilde;o existe!</strong>';
			}
			else if (trim($manifestacao->GetIdentificacao()) == 'S')
			{
				echo 
				'
				<br>
				<table width="100%" border="0">
				  <tr>
					<td><strong>MANIFESTA&Ccedil;&Atilde;O SIGILOSA</strong></td>
				  </tr>
				  <br>
				  <tr>
					<td><strong>Nome do Manifestante:</strong> '. $manifestacao->GetNome() .'</td>
				  </tr>
				  <tr>
					<td><strong>CPF:</strong> '. $manifestacao->GetCpf() .'</td>
				  </tr>
				  <tr>
					<td><strong>Endere&ccedil;o:</strong> '. $manifestacao->GetEndereco() .'</td>
				  </tr>
				  <tr>
					<td><strong>Telefone:</strong> '. $manifestacao->GetTelefone() .'</td>
				  </tr>
				  <tr>
					<td><strong>Email:</strong> '. $manifestacao->GetEmail() .'</td>
				  </tr>
				  <tr>
					<td><strong>Data de envio da manifesta&ccedil;&atilde;o:</strong> '. $data->ConverteDataBR($manifestacao->GetDataCriacao()) .'</td>
				  </tr>
				  <tr>
					<td><strong>Assunto:</strong> '. $manifestacao->GetAssunto() .' </td>
				  </tr>
				  <tr>
					<td><strong>Conte&uacute;do da manifesta&ccedil;&atilde;o:</strong> '. $manifestacao->GetConteudo() .' </td>
				  </tr>
				  <tr>
					<td><strong>Setores por onde a manifesta&ccedil;&atilde;o passou:</strong> ' . $manifestacao->GetDepartamentos() .'
					<img src="../imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando ha mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
					</td>
				  </tr>
				  <tr>
					<td><strong>Respostas/Resolu&ccedil;&atilde;o:</strong> '. $manifestacao->GetRespostaFinal() .'</td>
				  </tr>
				  <tr>
				  '.$resposta.'
				</table>
				';
			}
			else if (trim($manifestacao->GetIdentificacao()) == 'I')
			{
				echo 
				'
				<br>
				<table width="100%" border="0">
				  <tr>
					<td><strong>MANIFESTA&Ccedil;&Atilde;O IDENTIFICADA</strong></td>
				  </tr>
				  <br>
				  <tr>
					<td><strong>Nome do Manifestante:</strong> '. $manifestacao->GetNome() .'</td>
				  </tr>
				  <tr>
					<td><strong>CPF:</strong> '. $manifestacao->GetCpf() .'</td>
				  </tr>
				  <tr>
					<td><strong>Endere&ccedil;o:</strong> '. $manifestacao->GetEndereco() .'</td>
				  </tr>
				  <tr>
					<td><strong>Telefone:</strong> '. $manifestacao->GetTelefone() .'</td>
				  </tr>
				  <tr>
					<td><strong>Email:</strong> '. $manifestacao->GetEmail() .'</td>
				  </tr>
				  <tr>
					<td><strong>Data de envio da manifesta&ccedil;&atilde;o:</strong> '. $data->ConverteDataBR($manifestacao->GetDataCriacao()) .'</td>
				  </tr>
				  <tr>
					<td><strong>Assunto:</strong> '. $manifestacao->GetAssunto() .' </td>
				  </tr>
				  <tr>
					<td><strong>Conte&uacute;do da manifesta&ccedil;&atilde;o:</strong> '. $manifestacao->GetConteudo() .' </td>
				  </tr>
				  <tr>
					<td><strong>Setores por onde a manifesta&ccedil;&atilde;o passou:</strong> ' . $manifestacao->GetDepartamentos() .'
					<img src="../imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando ha mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
					</td>
				  </tr>
				  <tr>
					<td><strong>Respostas/Resolu&ccedil;&atilde;o:</strong> '. $manifestacao->GetRespostaFinal() .'</td>
				  </tr>
				  <tr>
				  '.$resposta.'
				</table>
				';
			}
			else
			{
				echo 
				'
				<br>
				<table width="100%" border="0">
				  <tr>
					<td><strong>MANIFESTA&Ccedil;&Atilde;O AN&Ocirc;NIMA</strong></td>
				  </tr>
				  <br>
				  <tr>
					<td><strong>Raz&atilde;o do anonimato:</strong> '. $manifestacao->GetAnonimato() .' </td>
				  </tr>
				  <tr>
					<td><strong>Data de envio da manifesta&ccedil;&atilde;o:</strong> '. $data->ConverteDataBR($manifestacao->GetDataCriacao()) .'</td>
				  </tr>
				  <tr>
					<td><strong>Assunto:</strong> '. $manifestacao->GetAssunto() .' </td>
				  </tr>
				  <tr>
					<td><strong>Conte&uacute;do da manifesta&ccedil;&atilde;o:</strong> '. $manifestacao->GetConteudo() .' </td>
				  </tr>
				  <tr>
					<td><strong>Setores por onde a manifesta&ccedil;&atilde;o passou:</strong> ' . $manifestacao->GetDepartamentos() .'
					<img src="../imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando ha mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" />
					</td>
				  </tr>
				  <tr>
					<td><strong>Respostas/Resolu&ccedil;&atilde;o:</strong> '. $manifestacao->GetRespostaFinal() .'</td>
				  </tr>
				  '.$resposta.'
				</table>
				';
			}
			
	break;

}




?>