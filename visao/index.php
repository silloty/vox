<html>
<?php include '../tema.php'; ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="shortcut icon" href="../favicon.ico">
<?php echo $css; ?>
<title>:: VOX ::</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#fechar").click(function(){
        $(".mensagem").hide();
    });
});
</script>
</head>
<body>

<?php echo $barra_brasil; ?>
<?php echo $cabecalho; ?>
<div align="center">
	<object data="modo_manifestando.frm.php" width="50%" height="80%"></object>
</div>

<?php echo $rodape; ?>
</body>
</html>