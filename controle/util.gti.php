<?php

/**
 *
 * Classe que efetua processos generalizados
 *
 * ------------------------------------------------------------
 *
 *     CLASSE PARA UTILIDADES EM GERAL
 *        Propriedade da GTI - Criacao: 11/02/2009
 *
*/

class gtiUtil
{
	//construtor
	function __Construct()
    {
	}
	
	//METODO QUE GERA UM REGISTRO UNICO PARA UTILIZA��O NA GERA��O DOS REGISTROS DAS MANIFESTA��ES
	function GeraRegistroUnico()
	{
		$prefixo = 'S';
		$random = $prefixo;
		$random .= chr(rand(65,90));
		$random .= time();
		$random .= uniqid($prefixo);
		return $random;
	}
			
}


?>
