<?php
	class clsConfig
	{
		
		private $app_raiz;
		private $app_biblioteca;
		private $app_controle;
		private $app_js;
		private $app_modelo;
		private $app_visao;
		private $app_imagens;
		private $app_estilos;
		
		//configuracoes bd
		private $m_host;
		private $m_usuario;
		private $m_senha;
		private $m_esquema;
		private $m_driver;
	
		function clsConfig()
		{
			$this->app_raiz = "https://sistemas.cefetbambui.edu.br/ouvidoria";
			$this->app_biblioteca = "ouvidoria/biblioteca/";
			$this->app_controle = "ouvidoria/controle/";
			$this->app_js = "ouvidoria/js/";
			$this->app_modelo = "ouvidoria/modelo/";
			$this->app_visao = "ouvidoria/visao/";
			$this->app_imagens = "ouvidoria/visao/imagens/";
			$this->app_estilos = "ouvidoria/visao/estilo/";
			
			//dados do banco
			$this->m_driver = 'postgres';
			$this->m_esquema = 'vox';
			$this->m_host = 'IP_SERVIDOR_DADOS';
			$this->m_senha = 'SENHA';
			$this->m_usuario = 'usrvox';
			
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
                                                    return "ouvidoria.bambui@ifmg.edu.br";
                                                            }
                       
                        public function GetEmailAdmin()
                                    {
                                                    return "silas.silva@ifmg.edu.br";
                                                            }
                       
                        public function GetImagemSemFoto()
                                    {
                                                    return "semfoto.jpg";
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
