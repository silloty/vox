//FORMULARIO--------------------------------------------------
function OcultaCampo(valor)
{
   var parametro = null;
   var objAjax = null;

   var carregando = null;
   carregando = '&nbsp;&nbsp;&nbsp; <center><img src="imagens/carregando.gif" title="" alt="" border="0"></img></center><BR><center><b>Carregando..</b></center>';
   
	parametro = 'valor=' + valor;
	$('spanteste').innerHTML = carregando;
	objAjax = new Ajax.Request('modo_manifestando.post.php?metodo=ocultacampo', {method: 'post', parameters: parametro, onComplete: PreencheSpanteste});
   
}

//PREENCHEDOR DO SPAN FORMULARIO
function PreencheSpanteste(resposta)
{
   var s = unescape(resposta.responseText);
   $('spanteste').innerHTML = s;
}

//FUNÇÃO PARA SUBMETER FORMULÁRIO--------------------------------------------------
function submitForm(nome, valor)
{
	$('txtMetodo').value = valor;
	$(nome).submit();
}