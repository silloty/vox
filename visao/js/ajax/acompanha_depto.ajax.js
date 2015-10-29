//FORMULARIO--------------------------------------------------
function Acompanha_depto(valor)
{
	if (valor != "")
	{
	
	   var parametro = null;
	   var objAjax = null;
	
	   var carregando = null;
	   carregando = '&nbsp;&nbsp;&nbsp; <center><img src="imagens/carregando.gif" title="" alt="" border="0"></img></center><BR><center><b>Carregando...</b></center>';
	   
		parametro = 'valor=' + valor;
		
		$('spanResposta').innerHTML = carregando;
		objAjax = new Ajax.Request('acompanha_depto.post.php?metodo=resposta', {method: 'post', parameters: parametro, onComplete: PreencheSpanResposta});
	
	}
	else
	{
		$('spanResposta').innerHTML = '';
		alert('Informe um registro!');	
	}
   
}

//PREENCHEDOR DO SPAN FORMULARIO
function PreencheSpanResposta(resposta)
{
   var s = unescape(resposta.responseText);
   $('spanResposta').innerHTML = s;
}
