<?php
require_once("../config.cls.php");
require_once("../modelo/relatorios.cls.php");
require_once("../modelo/tipo.cls.php");
require_once("../modelo/clientela.cls.php");
require_once("../modelo/status.cls.php");
require_once("../modelo/departamento.cls.php");
require_once("../controle/valida.gti.php");

$relatorio = $_REQUEST['txtRelatorio'];
$data_inicial = $_POST['txtDataInicial'];
$data_final = $_POST['txtDataFinal'];

$config = new clsConfig();
$valida = new gtiValidacao();
$valida->ValidaCampoRequerido($data_inicial,'data_inicial');
$valida->ValidaCampoRequerido($data_final,'data_final');
$valida->ValidaData($data_inicial,'data_inicial');
$valida->ValidaData($data_final,'data_final');

switch ($relatorio)
{
	case 'manifestacao':
		
		$rel = new clsRelatorios();
				
		$_SESSION['vox_manifestacao'] = $rel->relManifestacao($data_inicial,$data_final);
		header('location:relatorio_manifestacoes.frm.php?data1='.$data_inicial.'&data2='.$data_final.'');
		exit();
		
		
	break;
	
	case 'atividade':
		//$rel = new clsRelatorios();
		$tipo = new clsTipo();
		$rel = new clsRelatorios();
		$cli = new clsClientela();
		$status = new clsStatus();
		$depto = new clsDepartamento();
		
		$_SESSION['vox_tipo'] = $tipo->TotalPorTipo($data_inicial, $data_final);
		$_SESSION['vox_forma'] = $rel->TotalPorIdentificacao($data_inicial, $data_final);
		$_SESSION['vox_clientela'] = $cli->TotalPorClientela($data_inicial, $data_final);
		$_SESSION['vox_status'] = $status->TotalPorStatus($data_inicial, $data_final);
	
		$_SESSION['vox_depto'] = $rel->TotalDeptosPorTipo($data_inicial, $data_final);
		$_SESSION['vox_qtde_deptos'] = $rel->TotalDeptos($data_inicial, $data_final);
			
					
		header('location:relatorio_atividades.frm.php?data1='.$data_inicial.'&data2='.$data_final.'');
		exit();
		
	break;
}

?>
