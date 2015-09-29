//FORMULARIO--------------------------------------------------
function Acompanhamento(valor)
{
	
	if (valor != "")
	{
	
	   var parametro = null;
	   var objAjax = null;
	
	   var carregando = null;
	   carregando = '&nbsp;&nbsp;&nbsp; <center><img src="imagens/carregando.gif" title="" alt="" border="0"></img></center><BR><center><b>Carregando...</b></center>';
	    
		parametro = 'valor=' + valor;
		
		$('spanManifestacao').innerHTML = carregando;
		objAjax = new Ajax.Request('consulta.post.php?metodo=andamento', {method: 'post', parameters: parametro, onComplete: PreencheSpanManifestacao});
	
	}
	else
	{
		$('spanManifestacao').innerHTML = '';
		alert('Informe um registro!');	
	}
   
}

//PREENCHEDOR DO SPAN FORMULARIO
function PreencheSpanManifestacao(resposta)
{
   var s = unescape(resposta.responseText);
   $('spanManifestacao').innerHTML = s;
}
