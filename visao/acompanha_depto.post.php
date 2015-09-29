<?php

require_once("../modelo/manifestacao.cls.php");
require_once("../controle/data.gti.php");


$metodo = $_GET['metodo'];
$reg_andamento = $_POST['valor'];

$data = new gtiData();

switch ($metodo)
{

	case 'resposta':
	
				
			$manifestacao = new clsManifestacao();
			$codigo = $manifestacao->PegaCodManifestacaoPorRegAndamento($reg_andamento);
			if($manifestacao->VerificaRespondida($reg_andamento)==true)
			{
				echo '<br><strong>'.htmlentities('Essa manifestação já foi respondida!').'</strong>';
				die;
			}		
						
			if (trim($codigo) == '')
			{
				echo '<br><strong>'.htmlentities('Essa manifestação não existe!').'</strong>';
				die;
			}
			
			$manifestacao->SetCodigo($codigo);
			$manifestacao->ConsultarPorCodigo();
			$feedback = '';
			if($manifestacao->GetFeedback()<>'')
			{
			
				$feedback = '
				<br>
				<tr>
					<td><strong>Esta manifesta&ccedil;&atilde;o foi reenviada a este setor pois o manifestante enviou um feedback. Segue logo abaixo o texto</strong><br> '. $manifestacao->GetFeedback() .'
					</td>
				</tr>
				<br>';
			}
			
			//indica que a manifestacao nao existe
			if (trim($manifestacao->GetCodigo()) == '')
			{
				echo '<br><strong>Essa manifesta&ccedil;&atilde;o n&atilde;o existe!</strong>';
			}
			else if (trim($manifestacao->GetIdentificacao()) == 'I')
			{
				echo 
				'
								
				<table width="100%" border="0">
				  <tr>
					<td><strong>MANIFESTA&Ccedil;&Atilde;O IDENTIFICADA</strong></td>
				  </tr>
				  <br>
				  <tr>
					<td><strong>Nome do Manifestante:</strong> '. $manifestacao->GetNome() .'					</td>
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
				  '.$feedback.'
				  <tr>
					<td><strong>Setores por onde a manifesta&ccedil;&atilde;o passou:</strong> '. $manifestacao->GetDepartamentos() .'<img src="../imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" /></td>
				  </tr>
				  <tr>
				   <tr>
					<td><strong>Responder:</strong><br>
					  <label>
					  <textarea name="txtResposta" cols="50" rows="10" id="txtResposta"></textarea>
					  <input name="btnResponder" type="submit" id="btnResponder" value="Enviar Resposta" />
					</label></td>
				  </tr>
				  <tr>
		<td><strong>Respostas e Departamentos por onde esta manifesta&ccedil;&atilde;o j&aacute; passou</strong></td>
	  </tr>
				  <tr>
<td>
	<table width="100%" border="1" class="style23">
		  <tr>
			<td width="20%" background="imagens/barra.jpg"><strong>Departamento</strong></td>
			<td width="50%" background="imagens/barra.jpg"><strong>Resposta</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data do envio</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data da resposta</strong></td>
		  </tr>
				'.$manifestacao->PegaRespostasDepartamentosSimples($manifestacao->GetCodigo()).'		  
	</table>
</td>
</tr>
				  <tr>
				</table>

				
				';
			}
			else if (trim($manifestacao->GetIdentificacao()) == 'S')
			{
				echo 
				'
				
				<table width="100%" border="0">
				  <tr>
					<td><strong>MANIFESTA&Ccedil;&Atilde;O SIGILOSA</strong></td>
				  </tr>
				  <br>
				  <tr>
					<td><strong>Data de envio da manifesta&ccedil;&atilde;o:</strong> '. $data->ConverteDataBR($manifestacao->GetDataCriacao()) .'</td>
				  </tr>
				  <tr>
					<td><strong>Assunto:</strong> '. $manifestacao->GetAssunto() .' </td>
				  </tr>
				  <tr>
					<td><strong>Conte&uacute;do da manifesta&ccedil;&atilde;o:</strong> '. $manifestacao->GetConteudo() .' </td>
				  </tr>
				  '.$feedback.'
				  <tr>
					<td><strong>Setores por onde a manifesta&ccedil;&atilde;o passou:</strong> '. $manifestacao->GetDepartamentos() .'<img src="../imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" /></td>
				  </tr>
				<tr>
					<td><strong>Responder:</strong><br>
					  <label>
					  <textarea name="txtResposta" cols="50" rows="10" id="txtResposta"></textarea>
					  <input name="btnResponder" type="submit" id="btnResponder" value="Enviar Resposta" />
					</label></td>
					<tr>
		<td><strong>Respostas e Departamentos por onde esta manifesta&ccedil;&atilde;o j&aacute; passou</strong></td>
	  </tr>
				  <tr>
<td>
	<table width="100%" border="1" class="style23">
		  <tr>
			<td width="20%" background="imagens/barra.jpg"><strong>Departamento</strong></td>
			<td width="50%" background="imagens/barra.jpg"><strong>Resposta</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data do envio</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data da resposta</strong></td>
		  </tr>
				'.$manifestacao->PegaRespostasDepartamentosSimples($manifestacao->GetCodigo()).'		  
	</table>
</td>
</tr>
				  </tr>
				</table>
				';
			}
			else
			{
				echo 
				'
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
				  '.$feedback.'
				  <tr>
					<td><strong>Setores por onde a manifesta&ccedil;&atilde;o passou:</strong> '. $manifestacao->GetDepartamentos() .'<img src="../imagens/info.png" alt="" width="17" height="17" onmouseover="Tip(\'Legenda de Cores <br> Verde - Respondida <br> Amarelo - Aguardando resposta <br> Vermelho - Aguardando há mais de 05 dias\', BGCOLOR, \'#FFFFFF\')" onmouseout="UnTip()" /></td>
				  </tr>
				  <tr>
					<td><strong>Responder:</strong><br>
					  <label>
					  <textarea name="txtResposta" cols="50" rows="10" id="txtResposta"></textarea>
					  <input name="btnResponder" type="submit" id="btnResponder" value="Enviar Resposta" />
					</label></td>
					<tr>
		<td><strong>Respostas e Departamentos por onde esta manifesta&ccedil;&atilde;o j&aacute; passou</strong></td>
	  </tr>
				  <tr>
<td>
	<table width="100%" border="1" class="style23">
		  <tr>
			<td width="20%" background="imagens/barra.jpg"><strong>Departamento</strong></td>
			<td width="50%" background="imagens/barra.jpg"><strong>Resposta</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data do envio</strong></td>
			<td width="15%" background="imagens/barra.jpg"><strong>Data da resposta</strong></td>
		  </tr>
				'.$manifestacao->PegaRespostasDepartamentosSimples($manifestacao->GetCodigo()).'		  
	</table>
</td>
</tr>
				  </tr>
				 
				</table>
				';
			}
			
	break;

}




?>