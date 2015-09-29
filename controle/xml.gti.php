<?php

class gtiXML
{
    

    function __construct()
    {

    }
    
    function ArrayParaXML($arr)
    {
    	
	   	$valor = '<rows>';
    	$cont = 0;
    	
    	foreach ($arr as $chave => $linha) 
    	{
    		$valor .= '<row id="'.$cont++.'">';
    		
    		foreach ($linha as $chaveCol => $coluna)
    		{
			   $valor .= ' <cell>'.$coluna.'</cell>';
    		}
    		
    		$valor .= '</row>';
		}
		
		return $valor .= '</rows>';
    }

}

?>