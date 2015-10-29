﻿<?php
   require_once("config.cls.php");
   $config = new clsConfig();
   include 'tema.php';
?>

<html>
<head>
<link rel="shortcut icon" href="../favicon.ico">
<style type="text/css">

.linkbotao {
	color: #FFFFFF !important;
	font-size: x-large !important;
	font-family: Verdana, Arial, Helvetica, sans-serif !important;
   text-decoration: none !important;
}

</style>
<?php echo $css; ?>
<title>:: VOX ::</title></head>
<body>
	<div id="principal">
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><div align="center"><img src="visao/imagens/logovox.jpg" alt="" ></div></td>
        <td width="50%" bgcolor="#67BA2C" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td><p align="center"><img src="visao/imagens/cefet.jpg" alt="" ></p>
<p align="center"><span style="font-size: 7pt; font-family: Verdana"><strong>Processo de Homologa&ccedil;&atilde;o do VOX Beta</strong><br />                
        </span></p></td>
        <td align="center" valign="top" bgcolor="#68B92C">
        <?php
						require_once("controle/browser.gti.php");
						$browser = new gtiBrowser();
						$arr = $browser->getBrowser();
						$navegador = $arr['nav'];
						$versao = $arr['ver'];
						if (trim($navegador) == 'FIREFOX')			
						{			
							echo '<a href="visao/inicial.frm.php" class="linkbotao">ENTRAR</a>';
							$_SESSION['nav'] = '1';
						}
						else
						{
							echo '<p class="linkbotao">Este sistema &eacute; visualizado somente no navegador Mozilla Firefox
    							  <br> 
    							  <br>
								  <img width="100" height="105" src="visao/imagens/firefox.png"></p>';
						}
		?>
       
        </td>
      </tr>
    </table>
    </div>
</body>
</html>


