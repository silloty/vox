<?php
$pagina = $_GET['pagina'];
$mensagem = $_GET['mensagem'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>CONFIRMA&Ccedil;&Atilde;O</title>    
</head>
<body>

    <table align="center" cellpadding="0" cellspacing="0" class="style11">
        <tr>
            <td style="text-align: center">
                <br />
                <b>
                <?php
                	echo $mensagem;
                ?>
                </b>
                <br />
                <br />
                <img alt="" src="imagens/back.png" style="width: 17px; height: 16px" /><br />
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
