<?php

require_once("../config.cls.php");
require_once("../modelo/usuario.cls.php");
require_once("../modelo/manifestacao.cls.php");

$config = new clsConfig();
$man = new clsManifestacao();

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

$total_manifestacoes = $man-> PegaTotalManifestacoesPeriodo($data_inicial, $data_final);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="../favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VOX - Relatório de Atividades</title>
<style type="text/css">
<!--
.style2 {
	font-size: 36px;
	font-family: Tahoma, Arial, sans-serif;
}
.style3 {
	font-family: Tahoma, Arial, sans-serif;
	font-weight: bold;
}
.style4 {
	color: #FFFFFF;
	font-weight: bold;
	font-family: Tahoma, Arial, sans-serif;
	font-size: 12px;
}
.style5 {
	font-family: Tahoma, Arial, sans-serif;
	font-size: 14px;
}
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td bgcolor="#68B92C">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><img src="imagens/logo_menor.jpg" width="229" height="112" /></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p align="center" class="style2"><strong>RELATÓRIO </strong></p>
      <p align="center" class="style2"><strong>DE</strong></p>
    <p align="center" class="style2"><strong> ATIVIDADES</strong></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p align="center" class="style3">Período: <?php echo $data_inicial . ' à ' . $data_final ?></p>    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  
  <tr>
    <td><div align="center" class="style5"><?php echo $admin-> GetNome(); ?></div></td>
  </tr>
  <tr>
    <td bgcolor="#68B92C"><div align="center"><span class="style4">Ouvidoria do Instituto Federal Minas Gerais - Campus Bambuí</span></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center"></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center"><strong>Relatório Ouvidoria <br> 
      Periodo de <?php echo $data_inicial . ' à ' . $data_final ?></strong></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><strong>Introdução:</strong></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="justify">Durante o período de <?php echo $data_inicial . ' à ' . $data_final ?> , a Ouvidoria do Insituto Federal Minas Gerais - Campus Bambuí recebeu <?php echo $total_manifestacoes ?> manifestações.<br>
      A ouvidoria atendeu, em sala própria, de 7h às 11h e de 17h às 21h nas quintas-feiras e de 7h às 11h e de 13h às 17h nos demais dias de semana.<br>
    As formas disponíveis foram e-mail, telefone, pessoalmente ou pelo formulário eletrônico.</div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><strong>Tipos de Manifestações:</strong><br><br>
    
	<?php 
	
		if (isset($_SESSION['vox_tipo'])) 
		{
			$tipo = $_SESSION['vox_tipo'];
			foreach($tipo as $chave => $linha)
			{
				$labelTipo[$chave] = $linha[0];
				$valorTipo[$chave] = $linha[1];	
				$nome = htmlentities($linha[0]);
				$qtde = $linha[1];
				echo $nome .': '. $qtde ."<br>";	
			}
		}
		
		require_once("../controle/grafico.gti.php");
		
		//GERANDO O GRÁFICO
		$grafico = new gtiGrafico();
		
		$grafico->SetTitulo(utf8_decode("Tipos de Manifestações"));
		$grafico->SetSubTitulo(utf8_decode("Período " . $data_inicial. ' a ' .$data_final));
		$grafico->SetDadosEixoX($labelTipo); //Array
		$grafico->SetDadosEixoY($valorTipo); // Array Somente Numeros
		$grafico->SetLargura(800);  // Somente Numeros
		$grafico->SetAltura(250);  // Somente Numeros
		$grafico->SetLabelEixoX("");
		$grafico->SetLabelEixoY("Quantidade");
		$grafico->SetNome("grafico_tipo.png");
					
		$grafico->GerarGraficoBarra();
	?>
	<br>
	<img alt="Grafico de Barras"  src="imagens/graficos/grafico_tipo.png" style="border: 1px solid gray;"/>	</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center"></div></td>
  </tr>
      <td bgcolor="#FFFFFF"><strong>Identificação dos Usuários</strong>: <br><br>
	
	<?php
		//Capturando formas de identificação através de sessão
		//Array criado para receber os tipos
		$forma_nome = array("Identificado", "Sigiloso", "Anonimo");
		
		if (isset($_SESSION['vox_forma'])) 
		{
				$forma = $_SESSION['vox_forma'];
				foreach($forma as $chave => $linha)
				{
					$forma = $linha;
					echo $forma_nome[$chave] .': '. $forma ."<br>";	
				}
		}
		
		require_once("../controle/grafico.gti.php");
		
		//GERANDO O GRÁFICO
		$grafico = new gtiGrafico();
		
		$grafico->SetTitulo(utf8_decode("Identificação dos Usuários"));
		$grafico->SetSubTitulo(utf8_decode("Período " . $data_inicial. ' a ' .$data_final));
		$grafico->SetDadosEixoX($forma_nome); //Array
		$grafico->SetDadosEixoY($_SESSION['vox_forma']); // Array Somente Numeros
		$grafico->SetLargura(600);  // Somente Numeros
		$grafico->SetAltura(250);  // Somente Numeros
		$grafico->SetLabelEixoX("");
		$grafico->SetCorBarra("chartreuse4");
		$grafico->SetLabelEixoY("Quantidade");
		$grafico->SetNome("grafico_forma.png");
					
		$grafico->GerarGraficoBarra();

	?>
	<br>
	<img alt="Grafico de Barras"  src="imagens/graficos/grafico_forma.png" style="border: 1px solid gray;"/>	</td>
  </tr>
   <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
   <tr>
     <td bgcolor="#FFFFFF">&nbsp;</td>
   </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center" ></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><p><strong>Departamentos Destinatários das Manifestações:</strong></p>
    <?php 
		
		if (isset($_SESSION['vox_qtde_deptos'])) 
		{
			$qtde_total = $_SESSION['vox_qtde_deptos'];
			
			foreach($qtde_total as $chave => $linha)
			{
				$labelDeptos[$chave] = $linha[0];
				$valorDeptos[$chave] = $linha[1];
				$porcentagem[$chave] = ($linha[1] * 100) / $total_manifestacoes;	
			}
		}
		
		
				
		if (isset($_SESSION['depto'])) 
		{
			$nome_comparacao = "";
			$cont=0;
			$deptos = $_SESSION['depto'];
			foreach($deptos as $chave => $linha)
			{
				$nome = htmlentities($linha[0]);
				$tipo = htmlentities($linha[1]);
				$qtde = $linha[2];
				
				if($nome_comparacao <> $nome)
				{
					echo '<br> <strong>'. $nome .'</strong> <br> Total de Manifestações: '.$valorDeptos[$cont].' <br> <u>Tipos de manifestações </u> <br>'. $tipo .': ' .$qtde .'<br>';
					$cont++;
				}
				else
				{
					echo $tipo .': ' .$qtde .'<br>';
				}
				
				$nome_comparacao = htmlentities($linha[0]);
			}
		}
				
		//GERANDO O GRÁFICO
		
		$grafico = new gtiGrafico();
		
		$grafico->SetTitulo(utf8_decode("Manifestações por departamento (em unidades)"));
		$grafico->SetSubTitulo(utf8_decode("Período " . $data_inicial. ' a ' .$data_final));
		$grafico->SetDadosEixoX($labelDeptos); //Array
		$grafico->SetDadosEixoY($valorDeptos); // Array Somente Numeros
		$grafico->SetLargura(800);  // Somente Numeros
		$grafico->SetAltura(650);  // Somente Numeros
		$grafico->SetLabelEixoX("");
		$grafico->SetCorBarra("red");
		$grafico->SetLarguraBarra(35);
		$grafico->SetLabelEixoY("Quantidade");
		$grafico->SetFormato('%0.d');
		$grafico->SetNome("grafico_depto.png");
					
		$grafico->GerarGraficoBarraHorizontal();
		
		
		//GERANDO GRAFICO PORCENTAGEM
		
		$grafico->SetTitulo(utf8_decode("Manifestações por departamento (em %)"));
		$grafico->SetSubTitulo(utf8_decode("Período " . $data_inicial. ' a ' .$data_final));
		$grafico->SetDadosEixoX($labelDeptos); //Array
		$grafico->SetDadosEixoY($porcentagem); // Array Somente Numeros
		$grafico->SetLargura(800);  // Somente Numeros
		$grafico->SetAltura(600);  // Somente Numeros
		$grafico->SetLabelEixoX("");
		$grafico->SetCorBarra("darkblue");
		$grafico->SetLarguraBarra(35);
		$grafico->SetLabelEixoY("Quantidade");
		$grafico->SetFormato('%0.1f%%');
		$grafico->SetNome("grafico_depto_pcto.png");
					
		$grafico->GerarGraficoBarraHorizontal();
		
		
	?>
	<br>
	 <img alt="Grafico de Barras"  src="imagens/graficos/grafico_depto.png" style="border: 1px solid gray;"/>	<br><br> <img alt="Grafico de Barras"  src="imagens/graficos/grafico_depto_pcto.png" style="border: 1px solid gray;"/></td> 
	</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center"></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><strong>Estado de Resolução Geral das Manifestações:</strong><br><br>
    <?php 
	
		if (isset($_SESSION['vox_status'])) 
		{
			$status = $_SESSION['vox_status'];
			foreach($status as $chave => $linha)
			{
				$labelStatus[$chave] = $linha[0];
				$valorStatus[$chave] = $linha[1];
				$nome = htmlentities($linha[0]);
				$qtde = $linha[1];
				echo $nome .': '. $qtde ."<br>";	
			}
		}
		
		require_once("../controle/grafico.gti.php");
		
		$grafico = new gtiGrafico();
		
		$grafico->SetTitulo(utf8_decode("Resolução das Manifestações"));
		$grafico->SetSubTitulo(utf8_decode("Período " . $data_inicial. ' a ' .$data_final));
		$grafico->SetDadosEixoX($labelStatus); //Array
		$grafico->SetDadosEixoY($valorStatus); // Array Somente Numeros
		$grafico->SetLargura(800);  // Somente Numeros
		$grafico->SetAltura(300);  // Somente Numeros
		$grafico->SetLabelEixoX("");
		$grafico->SetLabelEixoY("Quantidade");
		$grafico->SetCorBarra("tomato1");
		$grafico->SetNome("grafico_status.png");
					
		$grafico->GerarGraficoBarra();
	?>
	<br>
	<img alt="Grafico de Barras"  src="imagens/graficos/grafico_status.png" style="border: 1px solid gray;"/>	</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><strong>Clientela:</strong><br><br>
	
	<?php 
	
		if (isset($_SESSION['vox_clientela'])) 
		{
			$clientela = $_SESSION['vox_clientela'];
			foreach($clientela as $chave => $linha)
			{
				$labelCli[$chave] = $linha[0];
				$valorCli[$chave] = $linha[1];
				$nome = htmlentities($linha[0]);
				$qtde = $linha[1];
				echo $nome .': '. $qtde ."<br>";	
			}
		}
		
		require_once("../controle/grafico.gti.php");
		
		//GERANDO O GRÁFICO
		$grafico = new gtiGrafico();
		
		$grafico->SetTitulo(utf8_decode("Clientela"));
		$grafico->SetSubTitulo(utf8_decode("Período " . $data_inicial. ' a ' .$data_final));
		$grafico->SetDadosEixoX($labelCli); //Array
		$grafico->SetDadosEixoY($valorCli); // Array Somente Numeros
		$grafico->SetLargura(800);  // Somente Numeros
		$grafico->SetAltura(300);  // Somente Numeros
		$grafico->SetLabelEixoX("");
		$grafico->SetLabelEixoY("Quantidade");
		$grafico->SetCorBarra("lightskyblue3");
		$grafico->SetNome("grafico_clientela.png");
					
		$grafico->GerarGraficoBarra();
	?>
	<br>
	<img alt="Grafico de Barras"  src="imagens/graficos/grafico_clientela.png" style="border: 1px solid gray;"/>	</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center"></div></td>
  </tr>
</table>
</body>
</html>
