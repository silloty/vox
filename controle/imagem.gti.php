<?php

class gtiImagem
{
    

    function __construct()
    {

    }
    
    function ConverteBinario($binario)
    {
    	$image = pg_unescape_bytea($binario);
    	header("Content-type: image/jpeg"); 
		echo $image;
    }
    
    function PegaDeArquivo($caminho)
    {
    	$image = file_get_contents($caminho);
    	header("Content-type: image/jpeg"); 
		echo $image;
    }

}

?>