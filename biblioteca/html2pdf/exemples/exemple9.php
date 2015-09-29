<?php
/**
 * Logiciel : exemple d'utilisation de HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribué sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 */
 $generate = isset($_GET['make_pdf']);
 if ($generate)
 {
 	ob_start();
 }
 else
 {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >	
		<title>Exemple d'auto génération de PDF</title>
	</head>
	<body>
<?php	
 }
?>
<br>
Ceci est un exemple de génération de PDF via un bouton :)<br>
<br>
<img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']); ?>/res/image_9.png.php?px=5&amp;py=20" alt="" ><br>
<br>
<?php
	if ($generate)
	{
		$content = ob_get_clean();
		require_once(dirname(__FILE__).'/../html2pdf.class.php');
		$pdf = new HTML2PDF('P','A4','en');
		$pdf->WriteHTML($content);
		$pdf->Output();
		exit;
	}
?>
		<input type="button" value="Generer le PDF" onclick="window.location.href='?make_pdf';">
	</body>
</html>