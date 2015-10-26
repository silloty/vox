<?php
//require_once('../config.cls.php');
//require_once("class.smtp.php");
require_once("../biblioteca/phpmailer/class.phpmailer.php");

class gtiMail
{
    private $parts;
    
    /*
     * Método construtor
     */
    function __construct()
    {
        $this->parts = array();
        $this->boundary = md5(time());
    }
    
    /*
     * Adiciona Texto
     */
    function AdicionarTexto($body)
    {
        $body = stripslashes($body);
        $msg = $body;
        
        $this->parts[] = $msg;
    }
    
    /*
     * Adiciona Imagem
     */
    function AdicionarPng($arquivo, $download)
    {
        $fd=fopen($arquivo, 'rb');
        $contents=fread($fd, filesize($arquivo));
        $contents=chunk_split(base64_encode($contents),68,"n");
        fclose($fd);
        
        $msg  = "--{$this->mime_boundary}n";
        $msg .= "Content-Type: image/png; name={$download}n";
        $msg .= "Content-Transfer-Encoding: base64n";
        $msg .= "Content-Disposition: attachment; filename={$download}nn";
        $msg .= "{$contents}";
        
        $this->parts[] = $msg;
    }
    
    /*
     * Envia Email
     */
    function Enviar($de, $para, $assunto, $nome_remetente)
    {
    	require_once '../config.cls.php';
		$config = new clsConfig();
		/*
		$msg = implode("n", $this->parts);
        
		if(!mail($para, $assunto, $msg, "From: $nome_remetente\nContent-Type: text/html; charset=iso-8859-1"))
		{
			return false;
		}
		else
		{
			return true;
		}
		
       	*/	
		
		//if(($para=="") || ($para==0))
		//{
		//	$para="vox.bambui@ifmg.edu.br";
		//}
		
		
		$msg = implode("n", $this->parts);
		
		$email = new PHPMailer();
		
		$email->IsSMTP();
		$email->Host = $config->GetEmailHost();
		$email->SMTPAuth = true;
		$email->Username = $config->GetEmailOuvidoria();
		$email->Password = $config->GetEmailSenha();
		$email->From = $de;
		
		
		
        $email->CharSet = "UTF-8";
		$email->SMTPSecure = "tls";
        $email->FromName = $nome_remetente;
        $email->Subject = $assunto;
        $email->IsHtml(true);
        $email->AddAddress($para,$para);
        $email->Body = $msg;
		$email->SMTP_PORT = 587;
        $email->AltBody = $msg;
        
        if(!$email->Send())
		{
			return false;
		}
		else
		{
			return true;
		}
		
		//echo print_r($email->ErrorInfo);
		
		
		
			
    }
}

?>
