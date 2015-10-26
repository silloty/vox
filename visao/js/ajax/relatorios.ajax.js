//FUNÇÃO PARA SUBMETER FORMULÁRIO--------------------------------------------------
function submitForm(nome, txtRelatorio)
{
	$('txtRelatorio').value = txtRelatorio;
	$(nome).submit();
}

