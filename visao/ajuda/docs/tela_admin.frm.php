<html>
<head>
<?php 
	include "../../../config.cls.php";
	$config = new clsConfig();
?>
<link rel="stylesheet" type="text/css" href="../../estilo/estilo.css">
<link rel="shortcut icon" href="../favicon.ico">
<link rel="stylesheet" type="text/css" href="../../estilo/menu_ajuda.css">
<style type="text/css">

.style3 {
	font-size: xx-large;
	font-weight: bold;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
.style22 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style25 {
	color: #244D23;
	font-weight: bold;
	font-size: 14px;
}
.style28 {
	font-size: 14px;
	color: #5AA024;
}
.style30 {font-size: 14px}


-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><title>Central de Ajuda - VOX</title></head>
<body>
<table width="100%" height="163" border="0" cellpadding="0" cellspacing="0">
  <tr background="../../imagens/bg_ajuda1.jpg">
    <td height="85" background="../../imagens/bg_ajuda1.jpg" bgcolor="#5AA024">&nbsp;&nbsp;&nbsp;<span class="style3">Central de Ajuda do VOX</span></td>
  </tr>
  <tr>
    <td height="29" bgcolor="#FFFFFF"><strong>&nbsp;<span class="style22">&nbsp;</span><span class="subtitulo">2</span></strong><span class="subtitulo"> Tela Administrativa </span></td>
  </tr>
  <tr>
    <td height="19" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <th width="78%" valign="top" scope="col"><div align="left">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th width="3%" bgcolor="#F3F8F1" scope="col">&nbsp;</th>
              <th width="93%" bgcolor="#F3F8F1" scope="col"><div align="justify">
                <p class="texto">Esta tela &eacute; a sua &aacute;rea de trabalho pois &eacute; nela que est&aacute; o acesso a todas funcionalidades do sistema Vox. Encontra-se aqui o acesso, atrav&eacute;s do clique no texto abaixo da imagem, &agrave;s telas de: </p>
                <ul>
                  <li class="texto">Manifesta&ccedil;&otilde;es abertas   ;</li>
                  <li class="texto">Manifesta&ccedil;&otilde;es em andamento ;</li>
                  <li class="texto">Manifesta&ccedil;&otilde;es fechadas ;</li>
                  <li class="texto">Cadastro de usu&aacute;rios ;</li>
                  <li class="texto">Relat&oacute;rios;</li>
                  <li class="texto">Cadastro de departamentos;</li>
                  <li class="texto">Cadastro de tipos;</li>
                  <li class="texto">Cadastro de  clientela;</li>
                  <li class="texto">Cadastro de status;</li>
                  <li class="texto">Central de ajuda. </li>
                </ul>
                <p class="texto"><img src="img_ajuda/TelaAdmin2.jpg" width="658" height="503"></p>
                <p class="texto">1 - &Aacute;REA INFORMATIVA: Ao passar o cursor do mouse sobre as figuras, ou sobre o texto abaixo dela, este texto modificar&aacute;, informando o usu&aacute;rio sobre a a&ccedil;&atilde;o que ser&aacute; realizada ao clicar no link abaixo da figura. </p>
                <p class="texto">2 - CONTADOR: Este n&uacute;mero entre par&ecirc;nteses(), indica a quantidade de manifesta&ccedil;&otilde;es existentes naquele local.</p>
                <p class="texto">3 - MENU DIREITO - Ao clicar com o bot&atilde;o direito sobre alguma das partes da tela, aparecer&aacute; um menu contendo um atalho para todas as outras funcionalidades do sistema. Basta apenas clicar sobre a op&ccedil;&atilde;o desejada. Este menu &eacute; encontrado em todas as outras telas do sistema.</p>
                <p class="texto">4 - BOT&Atilde;O SAIR - Clique em sair para encerrar a sess&atilde;o. &Eacute; importante encerrar a sess&atilde;o para que outro usu&aacute;rio tenha acesso ao sistema sem precisar da autentica&ccedil;&atilde;o. </p>
                <p class="texto">&nbsp;</p>
              </div></th>
              <th width="4%" bgcolor="#F3F8F1" scope="col">&nbsp;</th>
            </tr>
          </table>
        </div></th>
        <th width="22%" align="left" valign="top" bgcolor="#F3F8F1" scope="col"><table width="100%" height="186" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <th background="../../imagens/barra.jpg" scope="col">menu</th>
          </tr>
          <tr>
            <td>
           
				<ul id="menu">
					<li><a href="principal.frm.php" target="_self">1 - Tela principal/Login</a></li>
					<li><a href="tela_admin.frm.php" target="_self">2 - Tela administrativa</a></li>
					<li><a href="tela_abertas.frm.php" target="_self">3 - Manifesta&ccedil;&otilde;es abertas</a></li>
					<li><a href="tela_abertas_detalhes.frm.php" target="_self">4 - Detalhes Manifesta&ccedil;&otilde;es abertas</a></li>
					<li><a href="tela_andamento.frm.php" target="_self">5 - Manifesta&ccedil;&otilde;es em andamento</a></li>
					<li><a href="tela_andamento_detalhes.frm.php" target="_self">6 - Detalhes Manifesta&ccedil;&otilde;es andamento</a></li>
					<li><a href="tela_fechadas.frm.php" target="_self">7 - Manifesta&ccedil;&otilde;es fechadas</a></li>
					<li><a href="tela_fechadas_detalhes.frm.php" target="_self">8 - Detalhes Manifesta&ccedil;&otilde;es fechadas</a></li>
					<li><a href="tela_usuarios.frm.php" target="_self">9 - Cadastro de usu&aacute;rios</a></li>
					<li><a href="tela_deptos.frm.php" target="_self">10 - Cadastro de dapartamentos</a></li>
					<li><a href="tela_tipos.frm.php" target="_self">11 - Cadastro de tipos</a></li>
					<li><a href="tela_clientela.frm.php" target="_self">12 - Cadastro de clientela</a></li>
					<li><a href="tela_status.frm.php" target="_self">13 - Cadastro de status</a></li>
					<li><a href="ajuda.frm.php" target="_self"><<< VOLTAR</a></li>
				</ul>
          		    	
           </td>
          </tr>
        </table></th>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td background="../../imagens/barra.jpg"><div align="center"><span class="rodape style22 style25"><span class="rodape style28"><span class="rodape  style30">VOX  - <?php echo $config->GetNomeInstituicao();?> </span></span></span></div></td>
  </tr>
</table>
<br>


</body>
</html>


