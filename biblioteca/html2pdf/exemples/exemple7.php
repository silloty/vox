<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribu� sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 */
 	ob_start();
 	include(dirname(__FILE__).'/res/exemple7a.php');
 	include(dirname(__FILE__).'/res/exemple7b.php');
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
	$pdf = new HTML2PDF('P', 'A4', 'fr');
	$pdf->WriteHTML($content, isset($_GET['vuehtml']));
	$pdf->Output();
?>