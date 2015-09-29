<?php
/**
 * Logiciel : HTML2PDF - classe MyPDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribué sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * @version		3.08 - 24/06/2008
 */

if (!defined('__CLASS_MYPDF__'))
{
	define('__CLASS_MYPDF__', true);
	
	require_once(dirname(__FILE__).'/_fpdf/fpdf.php');		// classe fpdf de Olivier PLATHEY 

	class MyPDF extends FPDF
	{
		var $footer_param = array();
		
	    function MyPDF($sens = 'P', $unit = 'mm', $format = 'A4')
	    {
	    	$this->FPDF($sens, $unit, $format);
	    	$this->AliasNbPages();
	    	$this->SetMyFooter();
	    }
	    
	    function SetMyFooter($page = null, $date = null, $heure = null)
	    {
	    	if ($page===null)	$page = false;
	    	if ($date===null)	$date = false;
	    	if ($heure===null)	$heure = false;
	    	
	    	$this->footer_param = array('page' => $page, 'date' => $date, 'heure' => $heure);	
	    }
	    
	    function Footer()
		{ 
			$txt = '';
			if ($this->footer_param['date'] && $this->footer_param['heure'])	$txt.= ($txt ? ' - ' : '').(HTML2PDF::textGET('pdf03'));
			if ($this->footer_param['date'] && !$this->footer_param['heure'])	$txt.= ($txt ? ' - ' : '').(HTML2PDF::textGET('pdf01'));
			if (!$this->footer_param['date'] && $this->footer_param['heure'])	$txt.= ($txt ? ' - ' : '').(HTML2PDF::textGET('pdf02'));
			if ($this->footer_param['page'])	$txt.= ($txt ? ' - ' : '').(HTML2PDF::textGET('pdf04'));
			
			$txt = str_replace('[[date_d]]',	date('d'),			$txt);
			$txt = str_replace('[[date_m]]',	date('m'),			$txt);
			$txt = str_replace('[[date_y]]',	date('Y'),			$txt);
			$txt = str_replace('[[date_h]]',	date('H'),			$txt);
			$txt = str_replace('[[date_i]]',	date('i'),			$txt);
			$txt = str_replace('[[date_s]]',	date('s'),			$txt);
			$txt = str_replace('[[current]]',	$this->PageNo(),	$txt);
			$txt = str_replace('[[nb]]',		'{nb}',				$txt);

			if (strlen($txt)>0)
			{
			 	$this->SetY(-11);
				$this->SetFont('Arial','I',8);
				$this->Cell(0, 10, $txt, 0, 0, 'R');
			}
		}
		
	    // Draw a polygon
	    // Auteur	: Andrew Meier
		// Licence	: Freeware
		function Polygon($points, $style='D')
		{
		    if($style=='F')							$op='f';
		    elseif($style=='FD' or $style=='DF')	$op='b';
		    else									$op='s';
		
		    $h = $this->h;
		    $k = $this->k;
		
		    $points_string = '';
		    for($i=0; $i<count($points); $i+=2)
		    {
		        $points_string .= sprintf('%.2f %.2f', $points[$i]*$k, ($h-$points[$i+1])*$k);
		        if($i==0)	$points_string .= ' m ';
		        else		$points_string .= ' l ';
		    }
		    $this->_out($points_string . $op);
		}
		
		// redéfinition de la fonction Image de FPDF afin de rajouter la gestion des fichiers PHP
		function Image($file,$x,$y,$w=0,$h=0,$type='',$link='')
		{
			//Put an image on the page
			if(!isset($this->images[$file]))
			{
				//First use of image, get info
				if($type=='')
				{
					/* MODIFICATION HTML2PDF pour le support des images PHP */
					$type = explode('?', $file);
					$type = pathinfo($type[0]);
					if (!isset($type['extension']) || !$type['extension'])
						$this->Error('Image file has no extension and no type was specified: '.$file);
						
					$type = $type['extension'];
					/* FIN MODIFICATION */
				}

				$type=strtolower($type);
				$mqr=get_magic_quotes_runtime();
				set_magic_quotes_runtime(0);
				
				/* MODIFICATION HTML2PDF pour le support des images PHP */
				if ($type=='php')
				{
					// identification des infos
					$infos=@GetImageSize($file);
					if (!$infos) $this->Error('Unsupported image : '.$file);
				
					// identification du type
					$type = explode('/', $infos['mime']);
					if ($type[0]!='image') $this->Error('Unsupported image : '.$file);
					$type = $type[1];
				}
				/* FIN MODIFICATION */
				
				if($type=='jpg' || $type=='jpeg')
					$info=$this->_parsejpg($file);
				elseif($type=='png')
					$info=$this->_parsepng($file);
				else
				{
					//Allow for additional formats
					$mtd='_parse'.$type;
					if(!method_exists($this,$mtd))
						$this->Error('Unsupported image type: '.$file);
					$info=$this->$mtd($file);
				}
				set_magic_quotes_runtime($mqr);
				$info['i']=count($this->images)+1;
				$this->images[$file]=$info;
			}
			else
				$info=$this->images[$file];
			//Automatic width and height calculation if needed
			if($w==0 && $h==0)
			{
				//Put image at 72 dpi
				$w=$info['w']/$this->k;
				$h=$info['h']/$this->k;
			}
			if($w==0)
				$w=$h*$info['w']/$info['h'];
			if($h==0)
				$h=$w*$info['h']/$info['w'];
			$this->_out(sprintf('q %.2f 0 0 %.2f %.2f %.2f cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i']));
			if($link)
				$this->Link($x,$y,$w,$h,$link);
		}
	}
}
?>