<?php


class gtiData
{
	public function gtiData()
	{
	}
	
	function EntreDatas($datainicial, $datafinal, $datapesquisa)
	{ 
		$datainicial = strtotime($datainicial); 
		$datafinal = strtotime($datafinal); 
		$data = strtotime($datapesquisa); 
		
		if (($datainicial < $data) && ($datafinal > $data)) 
		{ 
			$valid = true; 
		} 
		else 
		{ 
			$valid = false; 
		}
		
		return $valid;
	}
	
	function ValidaData($sData)
	{
		setlocale(LC_CTYPE,"pt_BR");
		
		if((trim($sData) == "") OR (strlen($sData) != 10))
		{
		return FALSE;
		}
		else
		{
		//$sData = explode("/","$sData");
		list($d,$m,$a) = explode('/',$sData,3);
		//$dia = $sData[0]; $mes = $sData[1]; $ano = $sData[2];
		
		if(!checkdate($m,$d,$a))
		{
		return FALSE;
		}
		else
		{
		return TRUE;
		}
		}
	}
	
	//int mktime ( [int hour [, int minute [, int second [, int month [, int day [, int year [, int is_dst]]]]]]])
	
	function getTimestamp($sData=null)
	{
	
	if($sData != null AND strlen(trim($sData)) != 10)
	{
	
	$a = substr($sData, 0, 4);
	$m = substr($sData, 0, 2);
	
	// DATA NO FORMATO ISO yyyy-mm-dd
	if(substr_count($a, '-') == 0 AND substr_count($sData, '-') == 2)
	{
	//echo "A data ? ISO <br />";
	// substr($sData, 0, 4);
	//$separador = '-';
	list($a,$m,$d) = explode('-',$sData,3);
	}
	
	// DATA NO FORMATO ISO yyyy/mm/dd
	if(substr_count($a, '/') == 0 AND substr_count($sData, '/') == 2)
	{
	//echo "A data ? ISO <br />";
	// substr($sData, 0, 4);
	//$separador = '/';
	list($a,$m,$d) = explode('/',$sData,3);
	}
	
	// DATA NO FORMATO pt_BR dd-mm-yyyy
	if(substr_count($a, '-') != 0 AND substr_count($sData, '-') == 2 )
	{
	//echo "A data N?O ? ISO <br />";
	//$separador = '-';
	list($d,$m,$a) = explode('-',$sData,3);
	}
	
	// DATA NO FORMATO pt_BR dd/mm/yyyy
	if(substr_count($a, '/') != 0 AND substr_count($sData, '/') == 2 )
	{
	//echo "A data N?O ? ISO <br />";
	//$separador = '/';
	list($d,$m,$a) = explode('/',$sData,3);
	}
	
	$timestamp = mktime(0,0,0,$m,$d,$a);
	}
	else
	{
	$timestamp = mktime();
	}
	
	return $timestamp;
	}
	
	
	function ConverteDataBR($date)
	{ // YYYY-MM-DD a DD-MM-YYYY
		list($year, $month, $day) = split("-", $date);
		return $day . "/" . $month . "/" . $year;
	}
	
	function ConverteDataHifen($date)
	{ // YYYY-MM-DD a DD-MM-YYYY
		list($year, $month, $day) = split("/", $date);
		return $year . '-' . $month . '-' . $day;
		
	}
	
	function getTimeStamp2Date($time)
	{ // 'YYYY-MM-DD hh:mm:ss A'
		// $time = getTimestamp($time);
		$year = substr($time,0,4);
		$month = substr($time,4,2);
		$day = substr($time,6,2);
		$hour = substr($time,8,2);
		$minute = substr($time,10,2);
		$second = substr($time,12,2);
		
		$date = mktime($hour, $minute, $second, $month, $day, $year);
		$date = date("Y-m-d h:i:s A", "$date");
		
		// $date = date("d/m/Y", "$date");
		
		return $date;
	}
	
	
	function getSegundos($iValor, $sTipo)
	{
		$Segundos = $iValor;
		switch($sTipo) {
		case "semana" : $Segundos = $Segundos * 7;
		case "dia" : $Segundos = $Segundos * 24;
		case "hora" : $Segundos = $Segundos * 60;
		case "minuto" : $Segundos = $Segundos * 60;
		}
		return $Segundos;
	}
	
	function getCalcAno($iValor,$data)
	{
		setlocale(LC_CTYPE,"pt_BR");
		$yy = date("Y", getTimestamp($data)) + $iValor;
		$tt = date("$yy-m-d H:i:s", getTimestamp($data));
		//$this->setDate($tt);
		return $tt;
	}
	
	function getCalcMes($iValor,$data)
	{
	if($iValor >= 0)
	{
	$sign = +1;
	}
	else
	{
	$sign = -1;
	}
	$iValor = abs($iValor);
	
	$yy = date("Y", getTimestamp($data));
	$mm = date("m", getTimestamp($data)) + $sign * $iValor;
	while(abs($mm) >= 12)
	{
	$mm -= $sign * 12;
	$yy += $sign;
	}
	//$tt = date("$yy-$mm-d H:i:s", getTimestamp($data));
	$ttmp = date("d\/$mm\/$yy", getTimestamp($data));
	$tt = strftime("%d/%m/%Y", getTimestamp($ttmp));
	//$this->setDate($tt);
	return $tt;
	}
	
	function getNovaData($data, $operacao, $pdata, $qtde)
	{
	if( !($operacao == "-" || $operacao == "+"))
	{
	$msg_erro .= "getCalcData Error: Opera??o inv?lida!";
	}
	else
	{
	// Separa dia, mes y a?o
	list($ano, $mes, $dia) = explode("-",$data,3);
	
	// Determina la operaci?n (Suma o resta)
	if($operacao == "-")
	{
	$op = "-";
	}
	else
	{
	$op = '';
	}
	
	
	//
	
	// Determina en donde ser? efectuada la operaci?n (dia, mes, a?o)
	if($pdata == "dia") $opdia = $op."$qtde";
	if($pdata == "mes") $opmes = $op."$qtde";
	if($pdata == "ano") $opano = $op."$qtde";
	
	// Generamos la nueva data
	$data = mktime(0, 0, 0, $mes + $opmes, $dia + $opdia, $ano + $opano);
	
	return $data;
	}
	}
	
	function getDataExtenso($data)
	{
	list($ano,$mes,$dia) = explode("-",$data,3);
	$DataExtenso = $dia .' de '. getMesExtenso($mes) . ' de ' . $ano;
	return $DataExtenso;
	}
	
	function getMesExtenso($mes)
	{
	if ($mes == 1)
	$MesExtenso = 'Janeiro';
	else if ($mes == 2)
	$MesExtenso = 'Fevereiro';
	else if ($mes == 3)
	$MesExtenso = 'Mar&ccedil;o';
	else if ($mes == 4)
	$MesExtenso = 'Abril';
	else if ($mes == 5)
	$MesExtenso = 'Maio';
	else if ($mes == 6)
	$MesExtenso = 'Junho';
	else if ($mes == 7)
	$MesExtenso = 'Julho';
	else if ($mes == 8)
	$MesExtenso = 'Agosto';
	else if ($mes == 9)
	$MesExtenso = 'Setembro';
	else if ($mes == 10)
	$MesExtenso = 'Outubro';
	else if ($mes == 11)
	$MesExtenso = 'Novembro';
	else if ($mes == 12)
	$MesExtenso = 'Dezembro';
	
	return $MesExtenso;
	}
	
	function getDia($data)
	{
	list($ano,$mes,$dia) = explode('-',$data,3);
	return $dia;
	}
	
	function getMes($data)
	{
	list($dia,$mes,$ano) = explode('/',$data,3);
	return $mes;
	}
	
	function getAno($data)
	{
	list($dia,$mes,$ano) = explode('/',$data,3);
	return $ano;
	}
	
	function getMesAno($data)
	{
	list($ano,$mes,$dia) = explode("-",$data,3);
	$mesano = getMesExtenso($mes)." ".$anio;
	return $mesano;
	}
	
	function getDiaMes($data)
	{
	list($ano,$mes,$dia) = explode("-",$data,3);
	$diames = getMesExtenso($mes)." ".$dia;
	return $diames;
	}
	
	function getDiaSemanaExtenso($data)
	{
	
	list($y,$m,$d) = explode("-",$data,3);
	$timestamp = mktime(0,0,0,$m,$d,$y);
	$date = getdate ($timestamp);
	$dayofweek = $date['wday'];
	
	$dia = $dayofweek;
	
	if ($dia == 0)
	$DiaSemana = 'Domingo';
	else if ($dia == 1)
	$DiaSemana = 'Lunes';
	else if ($dia == 2)
	$DiaSemana = 'Martes';
	else if ($dia == 3)
	$DiaSemana = 'Miercoles';
	else if ($dia == 4)
	$DiaSemana = 'Jueves';
	else if ($dia == 5)
	$DiaSemana = 'Viernes';
	else if ($dia == 6)
	$DiaSemana = 'S&#225bado';
	
	return $DiaSemana;
	}
	
	function getUltimoDiaMes($data)
	{
	
	list($d,$m,$a) = explode("/",$data,3);
	
	$UltimoDiaMes = strftime("%d/%m/%Y", (mktime(0,0,0,($m+1),0,$a)));
	
	return $UltimoDiaMes;
	
	}
	
	function getPrimeiroDiaMes($data)
	{
	
	list($d,$m,$a) = explode("/",$data,3);
	
	$PrimeiroDiaMes = strftime("%d/%m/%Y", (mktime(0,0,0,$m,1,$a)));
	
	return $PrimeiroDiaMes;
	
	}
	
	/*
	
	$Aux = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);
	
	
	//Verifica os meses com 30 dias
	if (sMes == 4 || sMes == 6 || sMes == 9 || sMes == 11)
	{
	if (sDia == 31)
	return false;
	}
	
	if (sMes == 2)
	{
	if (sDia > 29)
	return false;
	if (sDia == 29 AND ((sAno/4) != parseInt(sAno/4)))
	return false;
	}
	
	
	function getDiaSemanaExtenso($data){
	
	list($y,$m,$d) = explode("-",$data,3);
	$timestamp = mktime(0,0,0,$m,$d,$y);
	$date = getdate ($timestamp);
	$dayofweek = $date['wday'];
	
	$dia = $dayofweek;
	
	if ($dia == 0)
	$DiaSemana = 'Domingo';
	else if ($dia == 1)
	$DiaSemana = 'Lunes';
	else if ($dia == 2)
	$DiaSemana = 'Martes';
	else if ($dia == 3)
	$DiaSemana = 'Miercoles';
	else if ($dia == 4)
	$DiaSemana = 'Jueves';
	else if ($dia == 5)
	$DiaSemana = 'Viernes';
	else if ($dia == 6)
	$DiaSemana = 'S&#225bado';
	
	return $DiaSemana;
	} */
	
	function machine_date($date)
	{ //DD-MM-YYYY a YYYY-MM-DD
	list($day, $month, $year) = split("-", $date);
	return $year . "-" . $month . "-" . $day;
	}
	
	function human_date($date){ // YYYY-MM-DD a DD-MM-YYYY
	list($year, $month, $day) = split("-", $date);
	return $day . "-" . $month . "-" . $year;
	}
	function local_date($date)
	{ // MM-DD-YYYY a DD-MM-YYYY.
	list($month, $day, $year) = split("-", $date);
	return $day . "-" . $month . "-" . $year;
	}
	
	function foreign_date($date)
	{ // DD-MM-YYYY a MM-DD-YYYY
	list($month, $day, $year) = split("-", $date);
	return $month . "-" . $day . "-" . $year;
	}
	
	function convert_timestamp($timestamp)
	{ // 'YYYY-MM-DD hh:mm:ss A'
	$year = substr($timestamp,0,4);
	$month = substr($timestamp,4,2);
	$day = substr($timestamp,6,2);
	$hour = substr($timestamp,8,2);
	$minute = substr($timestamp,10,2);
	$second = substr($timestamp,12,2);
	
	$date = mktime($hour, $minute, $second, $month, $day, $year);
	$date = date("Y-m-d h:i:s A", "$date");
	
	return $date;
	}
	
	function diferencia($data,$data2){
	
	//list($year,$month,$day) = explode('-',$data,3);
	//list($year2,$month2,$day2) = explode('-',$data2,3);
	
	list($day,$month,$year) = explode('-',$data,3);
	list($day2,$month2,$year2) = explode('-',$data2,3);
	
	$yearaux = $year - $year2;
	$monthaux = $month - $month2;
	$dayaux = $day2 - $day;
	
	$date = mktime(0, 0, 0, $monthaux, $dayaux, $yearaux);
	
	$diferencia = date("Y-m-d", "$date");
	
	list($year,$month,$day) = explode("-",$diferencia,3);
	$year -= 2000;
	if($year < 0){
	$year = 0;
	$month = 0;
	}
	
	$diferenciaA['years'] = $year;
	$diferenciaA['months'] = $month;
	$diferenciaA['days'] = $day;
	
	return $diferenciaA;
	}
	
	function getDias($nData)
	{
	setlocale(LC_CTYPE,"pt_BR");
	
	// DESMEMBRA DATA
	$nData = explode("/","$nData");
	$dia = $nData[0];
	$mes = $nData[1];
	$ano = $nData[2];
	
	$TimeStamp = (mktime() - 86400) - mktime(0, 0, 0, $mes, $dia, $ano);
	$Dias = $TimeStamp / 86400;
	$Idade = floor($Dias / 365.25);
	
	return $Dias;
	
	}
	
	function getIdade($nData)
	{
	setlocale(LC_CTYPE,"pt_BR");
	
	// DESMEMBRA DATA
	$nData = explode("/","$nData");
	$dia = $nData[0];
	$mes = $nData[1];
	$ano = $nData[2];
	
	$TimeStamp = (mktime() - 86400) - mktime(0, 0, 0, $mes, $dia, $ano);
	$Dias = $TimeStamp / 86400;
	$Idade = floor($Dias / 365.25);
	
	return $Idade;
	}

}



?>