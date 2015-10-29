<?php
session_start();
$metodo = $_GET['metodo'];
$codigo = $_POST['valor'];

switch ($metodo)
{

	case 'ocultacampo':
		if (trim($codigo) == 'A')
		{
		
			echo 
			'		
				<table  width="472">	
								<tr>
				<td colspan="2">Raz&otilde;es para o anonimato:</td>
				</tr>
			  <tr>
				<td colspan="2">				  
					<textarea name="txtRazao" cols="40" rows="5" id="txtRazoes" class="caixaManifestacaoElegante">'.$_SESSION['vox_razao'].'</textarea>				  
				</td>				
			  </tr>
			  <tr>	
			';
		}
		else		
		{
			echo
			'		
			<table width="472">
  <tr>
    <td>Nome:</td>
    <td><input name="txtNome" type="text" class="caixaDadosElegante" id="txtNome" size="40" value="'.$_SESSION['vox_nome'].'"/></td>
  </tr>
  
  <tr>
    <td>CPF:</td>
    <td><input name="txtCPF" type="text" class="caixaDadosElegante" id="txtCPF" onKeyUp="soNumeros(this);" size="30" maxlength="11" value="'.$_SESSION['vox_cpf'].'"/>
    *</td>
  </tr>
  
  <tr>
    <td>Telefone:</td>
    <td><input name="txtTelefone" type="text" class="caixaDadosElegante" id="txtTelefone" onkeyup="soNumeros(this)" maxlength="10" value="'.$_SESSION['vox_telefone'].'"/>
    *</td>
  </tr>
  
  <tr>
    <td>Endere&ccedil;o:</td>
    <td><input name="txtEndereco" type="text" class="caixaDadosElegante" id="txtEndereco" size="40" value="'.$_SESSION['vox_endereco'].'" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right" class="style26">* Somente n&uacute;meros </div></td>
  </tr>';
		}
		if (trim($codigo) == 'A' || trim($codigo) == 'S')
			echo
			'<tr>
				<td>					
				</td>
				<td>
					<div align="right" class="style26">
						Obs: Em manifesta&ccedil;&otilde;es an&ocirc;nimas ou sigilosas, evitar a identifica&ccedil;&atilde;o ao preencher o formul&aacute;rio.
					</div>
				</td>
			  </tr>';
		echo '</table>';
	break;

}




?>