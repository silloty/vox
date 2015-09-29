<?php
require_once("config.cls.php");
$config = new clsConfig();
?>

<html>
<head>
<link rel="shortcut icon" href="../favicon.ico">
<style type="text/css">
<!--


.linkbotao {    
	color: #FFFFFF;
	font-size: xx-large;
	font-family: Verdana, Arial, Helvetica, sans-serif;
   text-decoration: none;
}

</style>
<title>:: VOX ::</title></head>
<body>


    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><div align="center"><img src="visao/imagens/logovox.jpg" alt="" ></div></td>
        <td width="50%" bgcolor="#67BA2C" scope="col">&nbsp;</td>
      </tr>
      <tr>
        <td><p align="center"><img src="visao/imagens/cefet.jpg" alt="" ></p>
<p align="center"><span style="font-size: 7pt; font-family: Verdana"><strong>Processo de Homologa&ccedil;&atilde;o do VOX Beta</strong><br />
                <?php
						require_once("controle/browser.gti.php");
						$browser = new gtiBrowser();
						$arr = $browser->getBrowser();
						$navegador = $arr['nav'];
						$versao = $arr['ver'];
						if (trim($navegador) == 'FIREFOX')			
						{			
							echo '<strong>Obrigado por usar o navegador Mozilla Firefox!</strong>';
							$_SESSION['nav'] = '1';
						}
						else
						{
							echo 'Este sistema &eacute; visualizado somente no navegador Mozilla Firefox 2.0<br/><a href="visao/frmFirefox.php">Veja por que a GTI recomenda o Mozilla Firefox como navegador padr&atilde;o</a>';
						}
						
						
						
					?>
        </span></p></td>
        <td align="center" valign="top" bgcolor="#68B92C"><a href="<?php $config->GetPaginaPrincipal();?> visao/inicial.frm.php" class="linkbotao">ENTRAR</a></td>
      </tr>
    </table>
</body>
</html>


