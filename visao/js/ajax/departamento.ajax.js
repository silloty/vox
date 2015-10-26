//FUNÇÃO PARA SUBMETER FORMULÁRIO--------------------------------------------------
function submitForm(nome, txtMetodo,txtCodigo)
{
	$('txtMetodo').value = txtMetodo;
	$('txtCodigo').value = txtCodigo;
	$(nome).submit();
}

