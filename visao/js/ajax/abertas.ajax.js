//FUN��O PARA SUBMETER FORMUL�RIO--------------------------------------------------
function submitForm(nome, txtMetodo,txtCodigo)
{
	$('txtMetodo').value = txtMetodo;
	$('txtCodigo').value = txtCodigo;
	$(nome).submit();
}

