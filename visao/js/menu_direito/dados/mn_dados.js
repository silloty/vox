fixMozillaZIndex=true; //Fixes Z-Index problem  with Mozilla browsers but causes odd scrolling problem, toggle to see if it helps
_menuCloseDelay=500;
_menuOpenDelay=150;
_subOffsetTop=2;
_subOffsetLeft=-2;




with(contextStyle=new mm_style()){
bordercolor="#999999";
borderstyle="solid";
borderwidth=1;
fontfamily="arial, verdana, tahoma";
fontsize="75%";
fontstyle="normal";
headerbgcolor="#4F8EB6";
headerborder=1;
headercolor="#ffffff";
offbgcolor="#ffffff";
offcolor="#000000";
onbgcolor="#ECF4F9";
onborder="1px solid #316AC5";
oncolor="#000000";
outfilter="randomdissolve(duration=0.4)";
overfilter="Fade(duration=0.2);Shadow(color=#777777', Direction=135, Strength=3)";
padding=3;
pagebgcolor="#eeeeee";
pageborder="1px solid #ffffff";
//pageimage="http://www.milonic.com/menuimages/db_red.gif";
separatorcolor="#999999";
//subimage="http://www.milonic.com/menuimages/black_13x13_greyboxed.gif";
}

with(milonic=new menuname("contextMenu")){
margin=3;
style=contextStyle;
top="offset=2";
aI("image=imagens/home.png;text=Principal;url=admin.frm.php;");
aI("image=imagens/back.png;text=Voltar;url=javascript:history.go(-1);");
aI("image=imagens/print.png;separatorsize=1;text=Imprimir;url=javascript:window.print();");
aI("image=imagens/ico_abertas.png;text=Abertas;url=abertas.frm.php;");
aI("image=imagens/ico_andamento.png;text=Andamento;url=andamento.frm.php;");
aI("image=imagens/ico_fechadas.png;separatorsize=1;text=Fechadas;url=fechadas.frm.php;");
aI("image=imagens/ico_usuarios.jpg;text=Usu&aacute;rios;url=usuario.frm.php;");
aI("image=imagens/ico_departamentos.png;text=Departamentos;url=departamento.frm.php;");
aI("image=imagens/ico_tipo.png;text=Tipos;url=tipo.frm.php;");
aI("image=imagens/ico_clientela.png;text=Clientela;url=clientela.frm.php;");
aI("image=imagens/ico_status.png;separatorsize=1;text=Status;url=status.frm.php;");
aI("image=imagens/ico_relatorios.png;separatorsize=1;text=Relat&oacute;rios;url=relatorios.frm.php;");
aI("image=imagens/ico_logout.jpg;separatorsize=1;text=Sair;url=inicial.frm.php;");
}



drawMenus();

