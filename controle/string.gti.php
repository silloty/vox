<?php

class gtiString
{
	function gtiString()
	{
	}
	
	function setMascara($expr,$mask)
	{
	$ret = "";
	$j = 0;
	for($i = 0; $i < strlen($expr); $i++)
	{
	if(($mask[$j] != "9" ) AND ($mask[$j] != "X" ))
	{
	$ret .= $mask[$j];
	$j++;
	}
	if($mask[$j] == " ")
	{
	$ret .= " ";
	$j++;
	}
	$ret .= $expr[$i];
	$j++;
	}
	return $ret;
	}
	
	function isAlfanum($str)
	{
	
	for ($i = 0 ; $i < strlen($str) ; $i++ )
	{
	$str_at = $str{$i};
	$n = ord($str{$i});
	
	if((!is_numeric($str_at))&&(($n<65)||($n>90))&&(($n<97)||($n>122)))
	{
	return false;
	exit();
	}
	
	}
	return true;
	}
	
	function trocaini($wStr,$w1,$w2)
	{
	setlocale(LC_CTYPE,"pt_BR");
	$wde = 1;
	$para = 0;
	while($para < 1)
	{
	$wpos = strpos($wStr, $w1, $wde);
	if($wpos > 0)
	{
	$wStr = str_replace($w1, $w2, $wStr);
	$wde = $wpos+1;
	}
	else
	{
	$para = 2;
	}
	}
	$trocou = $wStr;
	return $trocou;
	}
	
	
	function setCapital($umtexto)
	{
	setlocale(LC_CTYPE,"pt_BR");
	$troca = strtolower($umtexto);
	$troca = ucwords($troca);
	$troca = trocaini($troca, " E ", " e ");
	$troca = trocaini($troca, " De ", " de ");
	$troca = trocaini($troca, " Da ", " da ");
	$troca = trocaini($troca, " Do ", " do ");
	$troca = trocaini($troca, " Das ", " das ");
	$troca = trocaini($troca, " Dos ", " dos ");
	
	$altabaixa = $troca;
	return $altabaixa;
	}
	
	// ValidaCampo -> Verifica se uma string cont?m um n?mero m?nimo e m?ximo de caracteres.
	
	
	function ValidaCampo($exp,$val)
	{
	setlocale(LC_CTYPE,"pt_BR");
	return ereg($exp, $val);
	}
	
	
	
	/*****************************************************************************************
	FunctionName : isAlphaNum
	Input : String
	OutPut : Returns True If string is Alphanumeric and False not Alphanumeric
	Explanation : Used to check whether the input string is Alphanumeric or not
	*****************************************************************************************/
	function isAlphaNum($sStr)
	{
	if(ereg("^[[:alnum:]]+$", $sStr))
	{
	return TRUE;
	}
	else
	{
	return FALSE;
	}
	}
	
	/*****************************************************************************************
	FunctionName : isNum
	Input : String
	OutPut : Returns True If string is numeric and False not numeric
	Explanation : Used to check whether the input string is numeric or not
	*****************************************************************************************/
	function isNum($sStr)
	{
	if(ereg("^[[:digit:]]+$", $sStr))
	{
	return TRUE;
	}
	else
	{
	return FALSE;
	}
	}
	
	function getNumeric2Real($nNumeric)
	{
	
	setlocale(LC_CTYPE,"pt_BR");
	
	$Real = explode('.',$nNumeric);
	
	$Inteiro = $Real[0];
	$Centavo = substr($Real[1], 0, 2);
	
	if ( strlen($Centavo) < 2 ) {
	
	$Centavo = str_pad($Centavo, 2, "0", STR_PAD_RIGHT);
	
	}
	
	$InteiroComMilhar = number_format($Inteiro, 0, '.', '.');
	
	$Real = $InteiroComMilhar.','.$Centavo;
	
	return $Real;
	
	}
	
	function getReal2Numeric($rValor)
	{
	
		setlocale(LC_CTYPE,"pt_BR");
		
		$ValNumeric = str_replace(",", "+", $rValor);
		$ValNumeric = str_replace(".", "", $ValNumeric);
		$ValNumeric = str_replace("+", ".", $ValNumeric);
		
		$Numeric = explode('.',$ValNumeric);
		
		$Inteiro = $Numeric[0];
		$Decimal = substr($Numeric[1], 0, 2);
		
		if ( strlen($Decimal) < 2 ) {
		
		$Decimal = str_pad($Decimal, 2, "0", STR_PAD_RIGHT);
		
		}
		
		$ValNumeric = $Inteiro.'.'.$Decimal;
		
		return $ValNumeric;
	
	}
	
	function removeAcentos($string)
	{
		$a = array(
		'/[ÂÀÁÄÃ]/' => 'A',
		'/[âãàáä]/' => 'a',
		'/[ÊÈÉË]/' => 'E',
		'/[êèéë]/' => 'e',
		'/[ÎÍÌÏ]/' => 'I',
		'/[îíìï]/' => 'i',
		'/[ÔÕÒÓÖ]/' => 'O',
		'/[ôõòóö]/' => 'o',
		'/[ÛÙÚÜ]/' => 'U',
		'/[ûúùü]/' => 'u',
		'/ç/' => 'c',
		'/Ç/' => 'C');
		
		// Retira o acento pela chave do array
		return preg_replace(array_keys($a), array_values($a), $string);
	}
}

?>