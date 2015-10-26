<?php
	class clsConfig
	{
		private $app_nome_instituicao;
		private $app_raiz;
		private $app_biblioteca;
		private $app_controle;
		private $app_js;
		private $app_modelo;
		private $app_visao;
		private $app_imagens;
		private $app_estilos;
		
		private $email_ouvidoria;
		private $email_admin;
		private $email_senha;
		private $email_host;
		
		//configuracoes bd
		private $m_host;
		private $m_usuario;
		private $m_senha;
		private $m_esquema;
		private $m_driver;
		
		private $quant_char_manifestacao;
		
		function clsConfig()
		{
			include 'config.php';
			$this->app_nome_instituicao = $nome_instituicao;
			$this->app_raiz = $diretorio["raiz"];
			$this->app_biblioteca = $diretorio["biblioteca"];
			$this->app_controle = $diretorio["controles"];
			$this->app_js = $diretorio["javascript"];
			$this->app_modelo = $diretorio["modelos"];
			$this->app_visao = $diretorio["visoes"];
			$this->app_imagens = $diretorio["imagens"];
			$this->app_estilos = $diretorio["estilos"];
			
			//dados do banco
			$this->m_driver = $database["driver"];
			$this->m_esquema = $database["esquema"];
			$this->m_host = $database["host"];
			$this->m_senha = $database["senha"];
			$this->m_usuario = $database["usuario"];

			$this->email_ouvidoria = $email["ouvidoria"];
			$this->email_admin = $email["admin"];
			$this->email_senha = $email["senha"];
			$this->email_host = $email["host"];   
			
			$this->quant_char_manifestacao = $quant_char_manifestacao;
			
			@session_start();
		        }

public function GetRaiz()
            {
                            return $this->app_raiz;
                                    }
                       
                        public function GetHost()
                                    {
                                                    return $this->m_host;
                                                            }
                       
                        public function GetUsuario()
                                    {
                                                    return $this->m_usuario;
                                                            }
                       
                        public function GetSenha()
                                    {
                                                    return $this->m_senha;
                                                            }
                       
                        public function GetEsquema()
                                    {
                                                    return $this->m_esquema;
                                                            }
                       
                        public function GetDriver()
                                    {
                                                    return $this->m_driver;
                                                            }
                       
                        public function GetPaginaConfirmacao()
                                    {
                                                    return "confirmacao.frm.php";
                                                            }
                       
                        public function GetPaginaErro()
                                    {
                                                    return "frmErro.php";
                                                            }
                       
                        public function GetPaginaRetorno()
                                    {
                                                    return "javascript:history.go(-1)";
                                                            }
                       
                        public function GetPaginaPrincipal()
                                    {
                                                    return "inicial.frm.php";
                                                            }
                       
                        public function GetEmailOuvidoria()
                                    {
                                                    return $this->email_ouvidoria;
                                                            }
                       
                        public function GetEmailAdmin()
                                    {
                                                    return $this->email_admin;
                                                            }
                        public function GetEmailHost()
                        			{
                        							return $this->email_host;
                        									}
                        public function GetEmailSenha()
                        			{
                        							return $this->email_senha;
                        									}                        									
                       
                        public function GetImagemSemFoto()
                                    {
                                                    return "semfoto.jpg";
                                                            }
                        public function GetNomeInstituicao()
                                    {
                                                   	return $this->app_nome_instituicao;
                                                            }
						public function GetQuantCharManifestacao(){
													return $this->quant_char_manifestacao;
						}
                        public function ConfirmaOperacao($volta, $mensagem)
                                    {
                                                    header('location:'. $this->GetPaginaConfirmacao() . '?pagina='. $volta . '&mensagem='.$mensagem);
                                                                die('Por Favor... Aguarde...');
                                                            }
                       
                        public function ExibeErro($volta, $mensagem)
                                    {
                                                    $mensagem = str_replace(array("\r", "\n"),array("<br>", "<br>"),$mensagem);
                                                                $mensagem = 'Falha ao executar a operacao. Informe ao administrador do sistema:<br><br>'.$mensagem;
                                                                $this->EnviaEmailErro($mensagem);
                                                                            header('location: '. $this->GetPaginaErro() . '?pagina='. $volta . '&mensagem='.$mensagem);
                                                                            die('Por Favor... Aguarde...');
                                                                                    }
                       
                               
                        public function EnviaEmailErro($mensagem)
                                    {
                                                    require_once("controle/email.gti.php");
                                                                $email = new gtiMail();
                                                               
                                                                $data_hora = date("d-m-Y H:i:s");
                                                                            $url = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
                                                                           
                                                                            $texto_email = 'Erro: '.$mensagem.'<br> Data/Hora: '.$data_hora.'<br> Pagina Acessada:'.$url; 
                                                                                                   
                                                                                        $email->AdicionarTexto($texto_email);
                                                        $email->Enviar($this->GetEmailOuvidoria(), $this->GetEmailAdmin(), 'Erro no VOX', 'Ouvidoria ERROR');
                                                                                                           
                                                                                                }       
                       
                       
                        public function Logout($redireciona)
                                    {
                                                    if(!isset($_SESSION['vox_nav']))
                                                                    {
                                                                                        session_start();           
                                                                                                    }   
                                                               
                                                                     $_SESSION = array();
                                                                unset($_SESSION);
                                                               
                                                                @session_destroy();
                                                                           
                                                                           
                                                                                 if ($redireciona==true)
                                                                                                 {
                                                                                                                     header('Location:' . $this->GetPaginaPrincipal());
                                                                                                                                     die('Por Favor... Aguarde...');   
                                                                                                                                 }   
                                                                                         }
                    }
		
?>
