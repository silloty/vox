<?php

/**
* Classe para geração de relatórios
* @author Silas Antônio Cereda da Silva
* @version 1.0
* since 02/03/2009
* Criação da classe
**/

require_once("../controle/conexao.gti.php");
require_once("../controle/relatorio.gti.php");


class clsRelatorios
{
	//METODO QUE CAPTURA OS DADOS DAS MANIFESTAÇÕES EM UM PERÍODO E RETORNA-OS EM UM ARRAY
	public function RelManifestacao($data_inicial, $data_final)
	{	
			require_once("../modelo/manifestacao.cls.php");
			require_once("../controle/data.gti.php");
			$man = new clsManifestacao();
			$data = new gtiData();
			$data_inicial = implode("-",array_reverse(explode("/",$data_inicial)));
			$data_final = implode("-",array_reverse(explode("/",$data_final)));
	
			$con = new gtiConexao();
			$con->gtiConecta();
					
			$SQL = 
			'SELECT 
			manifestacao_id 
			FROM 
			vw_manifestacao
			WHERE
			data_criacao >= \''.$data_inicial.'\'
			AND 
			data_criacao <= \''.$data_final.'\'
			ORDER BY data_criacao;
			;';	  
								  	
			$tbl = $con->gtiPreencheTabela($SQL);			
			$con->gtiDesconecta();
			
			$cont = 0;
			$rel = array();
									
			foreach($tbl as $chave => $linha)
			{				
				$i = 0;
				$man->SetCodigo($linha['manifestacao_id']);
				$man->ConsultarPorCodigo();
			
				$rel[$cont][$i++] = $cont + 1;
				$rel[$cont][$i++] = $man->GetCodigo();
				$rel[$cont][$i++] = $data->ConverteDataBR($man->GetDataCriacao());
				$rel[$cont][$i++] = utf8_decode($man->GetTipo());
				
				switch ($man->GetIdentificacao())
				{
					case 'S':
						$rel[$cont][$i++] = 'Sigiloso';
						$rel[$cont][$i++] = utf8_decode($man->GetNome());
					break;
					case 'I':
						$rel[$cont][$i++] = 'Identificado';
						$rel[$cont][$i++] = utf8_decode($man->GetNome());
					break;
					default:
						$rel[$cont][$i++] = 'Anônimo';
						$rel[$cont][$i++] = utf8_decode('N&atilde;o Informado');
					break;
										
				}
				 
				$rel[$cont][$i++] = utf8_decode($man->GetAssunto());
				$rel[$cont][$i++] = utf8_decode($man->GetDepartamentosSimples());
				$rel[$cont][$i++] = utf8_decode($man->GetClientela());
				$rel[$cont][$i++] = utf8_decode($man->GetStatus());
				
				$cont++;
			}
			
			return $rel;
	}
	
	//METODO QUE CAPTURA O TOTAL DE MANIFESTACOES 
	//PRA CADA TIPO DE IDENTIFICACAO NO PERIODO INFORMADO
	public function TotalPorIdentificacao($data_inicial, $data_final)
	{
		$forma = "I";
		// IDENTIFICADOS
		
		$data_inicial = implode("-",array_reverse(explode("/",$data_inicial)));
		$data_final = implode("-",array_reverse(explode("/",$data_final)));
		
		$SQL = 'SELECT 
					count(manifestacao_id) as total_ident 
				FROM 
					manifestacao 
				WHERE 
					forma_identificacao=\''.$forma.'\'
				AND
					data_criacao >= \''.$data_inicial.'\'
				AND 
					data_criacao <= \''.$data_final.'\' 
			
				;';
		
		$con = new gtiConexao();
		$con->gtiConecta();
		$ident = $con->gtiPreencheTabela($SQL);
						
		foreach($ident as $chave => $linha)
		{		
			$arr[0] = $linha['total_ident'];
		}	
		
		// SIGILOSOS
		$forma = "S";
		$SQL = 'SELECT 
						count(manifestacao_id) as total_sigi 
					FROM 
						manifestacao 
					WHERE 
						forma_identificacao = \''.$forma.'\'
					AND
						data_criacao >= \''.$data_inicial.'\'
					AND 
						data_criacao <= \''.$data_final.'\' 
				
					;';
		
		$con = new gtiConexao();
		$con->gtiConecta();
		$sigi = $con->gtiPreencheTabela($SQL);
				
		foreach($sigi as $chave => $linha)
		{			
			$arr[1] = $linha['total_sigi'];
		}	
		
		// ANONIMOS
		$forma = "A";
		$SQL = 'SELECT 
						count(manifestacao_id) as total_anoni 
					FROM 
						manifestacao 
					WHERE 
						forma_identificacao = \''.$forma.'\'
					AND
						data_criacao >= \''.$data_inicial.'\'
					AND 
						data_criacao <= \''.$data_final.'\' 
				
					;';
		
		$con = new gtiConexao();
		$con->gtiConecta();
		$anoni = $con->gtiPreencheTabela($SQL);
				
		foreach($anoni as $chave => $linha)
		{			
			$arr[2] = $linha['total_anoni'];
		}
		
		$con->gtiDesconecta();
		return $arr;
	
	}
	
	//METODO QUE CAPTURA O TOTAL DE MANIFESTAÇOES DE CADA 
	//TIPO ENVIADAS A CADA DEPARTAMENTO EM UM CERTO PERIODO	
	public function TotalDeptosPorTipo($data_inicial, $data_final)
	{
	
		$SQL = 'SELECT * FROM departamento;';
	
		$con = new gtiConexao();
		$con->gtiConecta();
		$depto = $con->gtiPreencheTabela($SQL);
		
		$data_inicial = implode("-",array_reverse(explode("/",$data_inicial)));
		$data_final = implode("-",array_reverse(explode("/",$data_final)));
		
		$cont=0;
		
		foreach($depto as $chave => $linha1)
		{
			$cod_depto = $linha1['departamento_id'];
						
			$SQL = 'SELECT * FROM tipo;';
			$tipo = $con->gtiPreencheTabela($SQL);
								
			foreach($tipo as $chave => $linha2)
			{
				$cod_tipo = $linha2['tipo_id'];
								
				$SQL = 'SELECT 
							count(distinct manifestacao_id) as total 
						FROM 
							manifestacao, tipo, departamento, andamento 
						WHERE 
							departamento_id = '.$cod_depto.'
						AND
							ref_departamento = departamento_id
						AND
							ref_status <> 2
						AND
							manifestacao_id = ref_manifestacao
						AND
							tipo_id = '.$cod_tipo.'
						AND
							ref_tipo = tipo_id
						AND
							data_criacao >= \''.$data_inicial.'\'
						AND 
							data_criacao <= \''.$data_final.'\' 
						;';
					
					$total = $con->gtiPreencheTabela($SQL);
					
					foreach($total as $chave => $linha3)
					{
						$nome_depto =  utf8_decode($linha1['nome']);
						$nome_tipo =  utf8_decode($linha2['nome']);
						$qtde = $linha3['total'];
						
						if($qtde<>0)
						{				
							$arr[$cont][0] = $nome_depto;
							$arr[$cont][1] = $nome_tipo;
							$arr[$cont][2] = $qtde;
	
							$cont++;										
						}//IF QTDE
					}//foreach total
			}//foreach tipo
			
		}//foreach depto
		
		//die();
		$con->gtiDesconecta();
		return $arr;		
	}

	// METODO QUE CAPTURA O TOTAL DE MANIFESTACOES PRA CADA DEPARTAMENTO EM UM CERTO PERIODO
	public function TotalDeptos($data_inicial, $data_final)
	{
	
		$SQL = 'SELECT * FROM departamento;';
	
		$con = new gtiConexao();
		$con->gtiConecta();
		$depto = $con->gtiPreencheTabela($SQL);
		
		$data_inicial = implode("-",array_reverse(explode("/",$data_inicial)));
		$data_final = implode("-",array_reverse(explode("/",$data_final)));
		
		$cont=0;
		
		foreach($depto as $chave => $linha1)
		{
			$cod_depto = $linha1['departamento_id'];
										
				$SQL = 'SELECT 
							count(distinct manifestacao_id) as total 
						FROM 
							manifestacao, tipo, departamento, andamento 
						WHERE 
							departamento_id = '.$cod_depto.'
						AND
							ref_departamento = departamento_id
						AND
							ref_status <> 2
						AND
							manifestacao_id = ref_manifestacao
						AND
							ref_tipo = tipo_id
						AND
							data_criacao >= \''.$data_inicial.'\'
						AND 
							data_criacao <= \''.$data_final.'\'
						;';
					
					
					
					$total = $con->gtiPreencheTabela($SQL);
					
					foreach($total as $chave => $linha3)
					{
						$nome_depto =  utf8_decode($linha1['nome']);
						$qtde = $linha3['total'];
						
						if($qtde<>0)
						{	
							$arr[$cont][0] = $nome_depto;
							$arr[$cont][1] = $qtde;
	
							$cont++;									
						}//IF QTDE
					}//foreach total		
		}//foreach depto
		
		$con->gtiDesconecta();
		return $arr;		
	}	
}
?>