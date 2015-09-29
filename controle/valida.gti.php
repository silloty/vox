<?php

class gtiValidacao
{
	
	private $erro;
	private $mensagem;
	
	function gtiValidacao()
	{
		$this->erro = false;
		$this->mensagem = '<script type="text/javascript" language="javascript">alert("';
	}
	
	public function GetErro()
	{
		return $this->erro;
	}
	
	public function SetErro($value)
	{
		$this->erro = $value;
	}
	
	public function GetMensagem()
	{
		return $this->mensagem . '"); history.back();</script>';
	}
	
	public function SetMensagem($value)
	{
		$this->mensagem = $value;
	}
	
	public function AddMensagem($value)
	{
		$this->mensagem .= $value;
	}
	
	public function ValidaTelefone($telefone, $campo)
	{
		$p1 = $telefone[0];
		$ddd = $telefone[1] . $telefone[2];
		$p2 = $telefone[3];
		$num1 = $telefone[4].$telefone[5].$telefone[6].$telefone[7];
		$traco = $telefone[8];
		$num2 = $telefone[9].$telefone[10].$telefone[11].$telefone[12];
		
		if (!(($p1 == "(") and (is_numeric($ddd)==true) and ($p2 == ")") and (is_numeric($num1)==true) and ($traco == "-") and (is_numeric($num2))))
		{
			$this->erro = true;
			$this->mensagem .= '\n '.$campo.' Inv\u00e1lido!';
		}
	}
	
	public function ValidaCampoNumerico($conteudo, $campo)
	{
		if (!(is_numeric($conteudo)))
		{
			$this->erro = true;
			$this->mensagem .= '\n \u00c9 necess\u00e1rio um n\u00famero no campo '.$campo.'!';
		}
	}
	
	public function ValidaCampoNumericoInteiro($conteudo, $campo)
	{
		if (!(is_numeric($conteudo)))
		{
			$this->erro = true;
			$this->mensagem .= '\n \u00c9 necess\u00e1rio um n\u00famero no campo '.$campo.'!';
		}
	}
	
	public function ValidaCampoRequerido($conteudo, $campo)
	{
		if (trim($conteudo)=="")
		{
			$this->erro = true;
			$this->mensagem .= '\n O campo '.$campo.' \u00e9 obrigat\u00f3rio!';
		}
	}
	
		
	/*
	* FUNÇÃO PARA VALIDAR SE O COMBO FOI SELECIONADO
	* @AUTHOR = SILAS ANTÔNIO CEREDA DA SILVA
	* 12/02/2009
	*/
	public function ValidaDPD($conteudo, $campo)
	{
		if (trim($conteudo)=="" or trim($conteudo)=="-- Selecione --")
		{
			$this->erro = true;
			$this->mensagem .= '\n O campo '.$campo.' \u00e9 obrigat\u00f3rio!';
		}
	}
	
	public function ComparaCaptcha($campo)
	{
		//session_name('captcha');
		session_start();


		if(isset($_POST['txtSeguranca']))
		{
  			if( $_SESSION['vox_palavra'] <> $_POST['txtSeguranca'])
  			{
  				$this->erro = true;
				$this->mensagem .= '\n O campo '.$campo.' n\u00e3o confere!';
  			}
		}	
	}
	
	public function ValidaComparacao($conteudo, $compara, $campo, $operador)
	{
		if (trim($operador)=="==")
		{
			if (trim($conteudo)==$compara)
			{
				$this->erro = true;
				$this->mensagem .= '\n O campo '.$campo.' não foi preenchido corretamente ou selecionado!';
			}
		}
		else
		{
			if (trim($conteudo)!=$compara)
			{
				$this->erro = true;
				$this->mensagem .= '\n O campo '.$campo.' não foi preenchido corretamente ou selecionado!';
			}
		}
	}
	
	public function ValidaSexo($conteudo)
	{
		if ($conteudo == "--selecione--")
		{
			$this->erro = true;
			$this->mensagem .= '\n Selecione alguma opção no campo sexo!';
		}
	}
	
	public function ValidaCEP($cep)
	{
		if (!((is_numeric($cep)) and (strlen($cep) == 8)))
		{
			$this->erro = true;
			$this->mensagem .= '\n CEP inválido!';
		}
	}
	
	
	/*
	* FUNÇÃO PARA VALIDAÇÃO DE CPF
	* MODIFICADA DIA 02/03/2009
	* POR SILAS ANTÔNIO CEREDA DA SILVA	
	*/
	public function ValidaCPF($cpf)
	{
	// Verifica se é somente numeros
		if(!is_numeric($cpf)) {
  			$this->erro = true;
			$this->mensagem .= '\n CPF inv\u00e1lido, tente novamente!';
		}
		else 
		{
			if( ($cpf == '11111111111') || ($cpf == '22222222222') ||
			   ($cpf == '33333333333') || ($cpf == '44444444444') ||
			   ($cpf == '55555555555') || ($cpf == '66666666666') ||
			   ($cpf == '77777777777') || ($cpf == '88888888888') ||
			   ($cpf == '99999999999') || ($cpf == '00000000000') ) 
			{
				$this->erro = true;
				$this->mensagem .= '\n CPF inv\u00e1lido, tente novamente!';
			}
			else
			{
			   $dv_informado = substr($cpf, 9,2);
			   for($i=0; $i<=8; $i++) {
			   $digito[$i] = substr($cpf, $i,1);
   			}

   			/*Verificando o valor do décimo dígito de verificação*/

			$posicao = 10;
			$soma = 0;
			for($i=0; $i<=8; $i++) 
			{
				$soma = $soma + $digito[$i] * $posicao;
				$posicao = $posicao - 1;
			}
			$digito[9] = $soma % 11;
			if($digito[9] < 2) 
			{
				$digito[9] = 0;
			}
			else
			{
				$digito[9] = 11 - $digito[9];
			}

		   /*Verificando o valor do décimo primeiro dígito de verificação*/
		
			$posicao = 11;
			$soma = 0;
		
			for ($i=0; $i<=9; $i++) 
			{
				$soma = $soma + $digito[$i] * $posicao;
				$posicao = $posicao - 1;
			}
				$digito[10] = $soma % 11;
				if ($digito[10] < 2)
				{
					$digito[10] = 0;
				}
				else
				{
				$digito[10] = 11 - $digito[10];
				}

  			/*Verificando se o dígito verificador é igual ao informado pelo usuário*/

			$dv = $digito[9] * 10 + $digito[10];
			if ($dv != $dv_informado)
			{
				$this->erro = true;
				$this->mensagem .= '\n CPF inv\u00e1lido, tente novamente!';
			}
			
			}
		}
	}
	
	public function ValidaEmail($email)
	{
		if(!stristr($email, "@") || !stristr($email, "."))
		{
			$this->erro = true;
			$this->mensagem .= '\n Email inv\u00e1lido!';
		}
	}
	
	
	public function ValidaData($sData)
	{

		setlocale(LC_CTYPE,"pt_BR");
	
		if((trim($sData) == "") OR (strlen($sData) != 10))
		{
			$this->erro = true;
			$this->mensagem .= '\n Data inv\u00e1lida!';			
		}
		else
		{
			if ($sData[2] == "/" )
			{
				$sData = str_replace('/','-',$sData);
			}
			
			list($d,$m,$a) = explode('-',$sData,3);			
			if(!checkdate($m,$d,$a))
			{
				$this->erro = true;
				$this->mensagem .= '\n Data inv\u00e1lida!';
			}
		}
	}
	
	public function ValidaComparacaoData($data1, $data2, $operacao)
	{

		$data1 = strtotime($data1); 
		$data2 = strtotime($data2); 
	
		switch ($operacao)
		{
			//SELEÇÕES DE GRID----------------------------------------------
			case '>':
				if (!($data1 > $data2))
				{
					$this->erro = true;
					$this->mensagem .= '\n A data inicial deve ser maior que a final!';	
				}
			break;
			case '<':
				if (!($data1 < $data2))
				{
					$this->erro = true;
					$this->mensagem .= '\n A data inicial deve ser menor que a final!';	
				}
			break;
			case '==':
				if (!($data1 == $data2))
				{
					$this->erro = true;
					$this->mensagem .= '\n A data inicial deve ser igual a final!';	
				}
			break;
			case '!=':
				if (!($data1 != $data2))
				{
					$this->erro = true;
					$this->mensagem .= '\n A data inicial deve ser diferente da final!';	
				}
			break;
		}	
		
	}
}



?>