<?php
$pagina = $_GET['pagina'];
$mensagem = $_GET['mensagem'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ERRO</title>
    <link href="estilo/estilo.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
	<!--
	.style23 {color: #FF0000; font-weight: bold; font-size: x-large;}
	-->
	</style>
</head>
<body>

    <table align="center" cellpadding="0" cellspacing="0" class="style11">
        <tr>
            <td style="text-align: center">
                <br />
                <b>
                <span style="color:#F00; font-family:Verdana, Geneva, sans-serif; font-size:16px">
                <?php
                	echo $mensagem;
                ?>
                </b>
                <br />
                <br />
                <img alt="" src="imagens/back.gif" style="width: 17px; height: 16px" /><br />
                <b>
                <a href="
                
                <?php
                	echo $pagina;
                ?>
                
                ">
                VOLTAR</a>
                </b></td>
        </tr>
    </table>

</body>
</html>
