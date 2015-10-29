<?php
/**
 * Logiciel : HTML2PDF
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribu� sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * @version		3.08 - 24/06/2008
 */

if (!defined('__CLASS_HTML2PDF__'))
{
	define('__CLASS_HTML2PDF__', true);
	
	require_once(dirname(__FILE__).'/mypdf.class.php');			// classe mypdf d�riv� de fpdf de Olivier PLATHEY 
	require_once(dirname(__FILE__).'/parsingHTML.class.php');	// classe de parsing HTML
	require_once(dirname(__FILE__).'/styleHTML.class.php');		// classe de gestion des styles

	global $HTML2PDF_TABLEAU;	$HTML2PDF_TABLEAU = array();	// tableau global necessaire � la gestion des tables imbriqu�es 

	class HTML2PDF
	{
		var $langue			= 'fr';		// langue des messages
		var $sens			= 'P';		// sens d'affichage Portrait ou Landscape
		var $format			= 'A4';		// format de la page : A4, A3, ...
		var $background		= array();	// informations sur le background
		
		var $style			= null;		// objet de style
		var $parsing		= null;		// objet de parsing
		var $parse_pos		= 0;		// position du parsing
		var $temp_pos		= 0;		// position temporaire pour multi tableau
		
		var $sub_html		= null;		// sous html
		var $sub_part		= false;	// indicateur de sous html
		
		var $pdf			= null;		// objet PDF
		var $maxX			= 0;		// zone maxi X
		var $maxY			= 0;		// zone maxi Y

		var $FirstPage		= true;		// premier page
		
		var $defaultLeft	= 5;		// marges par default de la page
		var $defaultTop		= 5;
		var $defaultRight	= 5;
		var $defaultBottom	= 8;
		
		var $margeLeft		= 0;		//marges r�elles de la page
		var $margeTop		= 0;
		var $margeRight		= 0;
		var $margeBottom	= 0;
		
		var $maxH			= 0;		// plus grande hauteur dans la ligne, pour saut de ligne � corriger
		var $inLink			= '';		// indique si on est � l'interieur d'un lien
		
		var $subHEADER		= array();	// tableau des sous commandes pour faire l'HEADER
		var $subFOOTER		= array();	// tableau des sous commandes pour faire le FOOTER
		var $subSTATES		= array();	// tableau de sauvegarde de certains param�tres
		
		/**
		 * Constructeur
		 *
		 * @param	string		sens portrait ou landscape
		 * @param	string		format A4, A5, ...
		 * @param	string		langue : fr, en, it...
		 * @param	boolean		forcer la cr�ation de la premiere page, ne pas utiliser, c'est utilis� en interne pour la gestion des tableaux
		 * @return	null
		 */
		function HTML2PDF($sens = 'P', $format = 'A4', $langue='fr', $force_page = false)
		{
			// sauvegarde des param�tres 
			$this->sens			= $sens;
			$this->format		= $format;
			$this->FirstPage	= true;
			$this->langue		= strtolower($langue);
			
			// chargement du fichier de langue
			$this->textLOAD($this->langue);
			
			// cr�ation de l' objet PDF
			$this->pdf = &new MyPDF($sens, 'mm', $format);
			
			// initialisation des marges
			$this->setMargins();
			
			// initialisation des styles
			$this->style = &new styleHTML($this->pdf);
			$this->style->FontSet();
			
			// initialisation du parsing
			$this->parsing = &new parsingHTML();
			$this->sub_html = null; 
			$this->sub_part	= false;
			
			// premier page forc�e
			if ($force_page) $this->setNewPage($this->sens);
		}

		/**
		* d�finir les marges
		*
		* @return	null
		*/
		function setMargins()
		{
			$this->margeLeft	= $this->defaultLeft;
			$this->margeRight	= $this->defaultRight;
			$this->margeTop		= $this->defaultTop 	+ (isset($this->background['top']) ? $this->background['top'] : 0);
			$this->margeBottom	= $this->defaultBottom	+ (isset($this->background['bottom']) ? $this->background['bottom'] : 0);
			
			$this->pdf->SetMargins($this->margeLeft, $this->margeTop, $this->margeRight);			
			$this->pdf->cMargin = 0;
			$this->pdf->SetAutoPageBreak(false, $this->margeBottom);
		}
		
		function SetPageHeader()
		{
			if (!count($this->subHEADER)) return false;

			$OLD_parse_pos = $this->parse_pos;
			$OLD_parse_code = $this->parsing->code;
			
			$this->parse_pos = 0;
			$this->parsing->code = $this->subHEADER;
			$this->MakeHTMLcode();
			
			$this->parse_pos = 	$OLD_parse_pos;
			$this->parsing->code = $OLD_parse_code;
		}

		function SetPageFooter()
		{
			if (!count($this->subFOOTER)) return false;

			$OLD_parse_pos = $this->parse_pos;
			$OLD_parse_code = $this->parsing->code;
			
			$this->parse_pos = 0;
			$this->parsing->code = $this->subFOOTER;
			$this->MakeHTMLcode();
			
			$this->parse_pos = 	$OLD_parse_pos;
			$this->parsing->code = $OLD_parse_code;
		}
				
		/**
		* cr�ation d'une nouvelle page avec une orientation particuliere
		*
		* @param	string		sens P=portrait ou L=landscape
		* @param	array		tableau des propri�t�s du fond de la page
		* @return	null
		*/
		function setNewPage($orientation = '', $background = null)
		{
			$this->FirstPage = false;

			$this->sens = $orientation ? $orientation : $this->sens;
			$this->background = $background!==null ? $background : $this->background;
			$this->maxY = 0;	
			$this->maxX = 0;

			$old_left	= $this->pdf->lMargin;
			$old_right	= $this->pdf->rMargin;
			$old_top	= $this->pdf->tMargin;
			$this->pdf->lMargin =  $this->defaultLeft;
			$this->pdf->rMargin =  $this->defaultRight;
			$this->pdf->tMargin =  $this->defaultTop;
			$this->pdf->AddPage($this->sens);
			
			if (!$this->sub_part)
			{
				if (is_array($this->background) && isset($this->background['img']) && $this->background['img'])
					$this->pdf->Image($this->background['img'], $this->background['posX'], $this->background['posY'], $this->background['width']);
				
				$this->SetPageHeader();
				$this->SetPageFooter();
			}
			
			$this->lMargin = $old_left;
			$this->rMargin = $old_right;
			$this->tMargin = $old_top;
			$this->SetMargins();
			$this->pdf->setX($this->margeLeft);
			$this->pdf->setY($this->margeTop);
		}
		
		/** 
		* r�cup�ration du PDF 
		* 
		* @param	string     nom du fichier PDF 
		* @param	boolean    forcer l'affichage ou la r�cup�ration 
		* @return	string     contenu du pdf, ou true, fonction de $recup 
		*/
		function Output($nom_fichier = 'document.pdf', $return = false)
		{
			if ($return)
			{
				return $this->pdf->Output($nom_fichier, 'S');
			}
			else
			{
				$this->pdf->Output($nom_fichier, 'I');
				return true;
			}
		}
		
		/**
		* cr�ation d'un sous HTML2PDF pour la gestion des tableaux imbriqu�s
		*
		* @param	HTML2PDF	futur sous HTML2PDF pass� en r�f�rence pour cr�atio
		* @return	null
		*/		
		function CreateSubHTML(&$sub_html, $cellmargin=0)
		{
			// initialisation du sous objet
			$sub_html = new HTML2PDF($this->sens, $this->format, $this->langue, true);

			$sub_html->style->css			= $this->style->css;
			$sub_html->style->css_keys		= $this->style->css_keys;
			$sub_html->style->table			= $this->style->table;
			$sub_html->style->value			= $this->style->value;
			$sub_html->style->value['text-align'] = 'left';
			
			// initialisation de la largeur
			if ($this->style->value['width'])
			{
				$marge = $cellmargin*2;
				$marge+= $this->style->value['padding']['l'] +  $this->style->value['padding']['r'];
				$marge+= $this->style->value['border']['l']['width'] + $this->style->value['border']['r']['width'];
				$marge = $sub_html->pdf->w - $this->style->value['width'] + $marge;
			}
			else
				$marge = $this->margeLeft+$this->margeRight;

			$sub_html->pdf->SetMargins(0, 0, $marge);

			// initialisation des positions et autre
			$sub_html->maxX = 0;
			$sub_html->maxY = 0;
			$sub_html->maxH = 0;
			$sub_html->pdf->setX(0);
			$sub_html->pdf->setY(0);
			$sub_html->style->FontSet();
		}
		
		/**
		* destruction d'un sous HTML2PDF pour la gestion des tableaux imbriqu�s
		*
		* @return	null
		*/	
		function DestroySubHTML()
		{
			
			unset($this->sub_html);
			$this->sub_html = null;	
		}
		
		/**
		* traitement d'un code HTML
		*
		* @param	string	code HTML � convertir
		* @param	boolean	afficher en pdf (false) ou en html (true)
		* @return	null
		*/	
		function WriteHTML($html, $vue = false)
		{
			$html = str_replace('&euro;', '�', $html);
			$html = str_replace('[[page_nb]]',	'{nb}',	 $html);
			
			$html = str_replace('[[date_y]]',	date('Y'),	 $html);
			$html = str_replace('[[date_m]]',	date('m'),	 $html);
			$html = str_replace('[[date_d]]',	date('d'),	 $html);

			$html = str_replace('[[date_h]]',	date('H'),	 $html);
			$html = str_replace('[[date_i]]',	date('i'),	 $html);
			$html = str_replace('[[date_s]]',	date('s'),	 $html);

			// si on veut voir le r�sultat en HTML => on appelle la fonction
			if ($vue)	$this->vueHTML($html);	

			// sinon, traitement pour conversion en PDF :
			// parsing
			$this->sub_pdf = false;
			$this->style->readStyle($html);
			$this->parsing->setHTML($html);
			$this->parsing->parse();
			$this->MakeHTMLcode();
		}

		function MakeHTMLcode()
		{
			// pour chaque element identifi� par le parsing
			for($this->parse_pos=0; $this->parse_pos<count($this->parsing->code); $this->parse_pos++)
			{
				// r�cup�ration de l'�l�ment
				$todo = $this->parsing->code[$this->parse_pos];
				
				// si c'est une ouverture de tableau
				if ($todo['name']=='table' && !$todo['close'])
				{
					// on va cr�er un sous HTML, et on va travailler sur une position temporaire
					$this->sub_part = true;
					$this->temp_pos = $this->parse_pos;
					
					// pour tous les �l�ments jusqu'� la fermeture de la table afin de pr�parer les dimensions
					while(isset($this->parsing->code[$this->temp_pos]) && !($this->parsing->code[$this->temp_pos]['name']=='table' && $this->parsing->code[$this->temp_pos]['close']))
					{
						$this->loadAction($this->parsing->code[$this->temp_pos]);
						$this->temp_pos++;
					}
					if (isset($this->parsing->code[$this->temp_pos])) 	$this->loadAction($this->parsing->code[$this->temp_pos]);
					$this->sub_part = false;
				}
				
				// chargement de l'action correspondant � l'�l�ment
				$this->loadAction($todo);
			}			
		} 


	
		/**
		* affichage en mode HTML du contenu
		*
		* @param	string	contenu
		* @return	null
		*/	
		function vueHTML($content)
		{
			$content = preg_replace('/<page_header([^>]*)>/isU',	'<hr>HEADER : $1<hr><div$1>', $content);
			$content = preg_replace('/<page_footer([^>]*)>/isU',	'<hr>FOOTER : $1<hr><div$1>', $content);
			$content = preg_replace('/<page([^>]*)>/isU',			'<hr>PAGE : $1<hr><div$1>', $content);
			$content = preg_replace('/<\/page([^>]*)>/isU',			'</div><hr>', $content);
			
			echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Restitution HTML</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
	</head>
	<body style="padding: 10px; font-size: 10pt;font-family:	Arial;">
'.$content.'
	</body>
</html>';
			exit;	
		}

		/**
		* chargement de l'action correspondante � un element de parsing
		*
		* @param	array	�l�ment de parsing
		* @return	null
		*/		
		function loadAction($row)
		{
			// nom de l'action
			$fnc	= ($row['close'] ? 'c_' : 'o_').strtoupper($row['name']);
			
			// parametres de l'action
			$param	= $row['param'];
			
			// si aucune page n'est cr��, on la cr��
			if ($fnc!='o_PAGE' && $this->FirstPage)
			{
					$this->setNewPage();
			}

			// lancement de l'action
			if (is_callable(array(&$this, $fnc)))
			{
				$this->{$fnc}($param);
			}
			else
			{
				HTML2PDF::makeError(1, __FILE__, __LINE__, strtoupper($row['name']));
			}
		}
		
		/**
		* balise : PAGE
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_PAGE($param)
		{
			$this->subHEADER = array();
			$this->subFOOTER = array();
			$this->maxH = 0;
						
			// identification de l'orientation demand�e
			$orientation = '';
			if (isset($param['orientation']))
			{
				$param['orientation'] = strtolower($param['orientation']);
				if ($param['orientation']=='p')			$orientation = 'P';
				if ($param['orientation']=='portrait')	$orientation = 'P';

				if ($param['orientation']=='l')			$orientation = 'L';
				if ($param['orientation']=='paysage')	$orientation = 'L';
				if ($param['orientation']=='landscape')	$orientation = 'L';
			}

			// identification des propri�t�s du background
			$background = array();
			if (isset($param['backimg']))
			{
				$background['img']		= isset($param['backimg'])	? $param['backimg']		: '';		// nom de l'image
				$background['posX']		= isset($param['backimgx'])	? $param['backimgx']	: 'center'; // position horizontale de l'image
				$background['posY']		= isset($param['backimgy'])	? $param['backimgy']	: 'middle'; // position verticale de l'image
				$background['width']	= isset($param['backimgw'])	? $param['backimgw']	: '100%';	// taille de l'image (100% = largueur de la feuille)
				
				// conversion du nom de l'image, en cas de param�tres en _GET
				$background['img'] = str_replace('&amp;', '&', $background['img']);
				// conversion des positions
				if ($background['posX']=='left')	$background['posX'] = '0%';
				if ($background['posX']=='center')	$background['posX'] = '50%';
				if ($background['posX']=='right')	$background['posX'] = '100%';
				if ($background['posY']=='top')		$background['posY'] = '0%';
				if ($background['posY']=='middle')	$background['posY'] = '50%';
				if ($background['posY']=='bottom')	$background['posY'] = '100%';


				// si il y a une image de pr�cis�
				if ($background['img'])	
				{
					// est-ce que c'est une image ?
					$infos=@GetImageSize($background['img']);
					if (count($infos)>1)
					{
						// taille de l'image, en fonction de la taille sp�cifi�e. 
						$Wi = $this->style->ConvertToMM($background['width'], $this->pdf->w);
						$Hi = $Wi*$infos[1]/$infos[0];
						
						// r�cup�ration des dimensions et positions de l'image
						$background['width']	= $Wi;	
						$background['posX']		= $this->style->ConvertToMM($background['posX'], $this->pdf->w - $Wi);
						$background['posY']		= $this->style->ConvertToMM($background['posY'], $this->pdf->h - $Hi);
					}
					else
						$background = array();	
				}
				else
					$background = array();
			}
			
			// marges TOP et BOTTOM pour le texte.
			$background['top']		= isset($param['backtop'])			? $param['backtop'] 		: '0';
			$background['bottom']	= isset($param['backbottom'])		? $param['backbottom']		: '0';
			if (preg_match('/^([0-9]*)$/isU', $background['top']))		$background['top'].= 'mm';
			if (preg_match('/^([0-9]*)$/isU', $background['bottom']))	$background['bottom'].= 'mm';
			$background['top']		= $this->style->ConvertToMM($background['top']);
			$background['bottom']	= $this->style->ConvertToMM($background['bottom']);
			
			// nouvelle page
			$this->setNewPage($orientation, $background);

			$this->style->save();
			$this->style->analyse('PAGE', $param);
			$this->style->FontSet();


			if (isset($param['footer']))
			{
				$lst = explode(';', $param['footer']);
				foreach($lst as $key => $val) $lst[$key] = trim(strtolower($val));
				$page	= in_array('page', $lst);
				$date	= in_array('date', $lst);
				$heure	= in_array('heure', $lst);
			}
			else
			{
				$page	= null;
				$date	= null;
				$heure	= null;
			}
			$this->pdf->SetMyFooter($page, $date, $heure);
		}

		/**
		* balise : PAGE
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_PAGE($param)
		{
			$this->maxH = 0;

			$this->style->load();
			$this->style->FontSet();
		}
		
		
		function o_PAGE_HEADER($param)
		{
			$this->subHEADER = array();
			for($this->parse_pos; $this->parse_pos<count($this->parsing->code); $this->parse_pos++)
			{
				$todo = $this->parsing->code[$this->parse_pos];
				if ($todo['name']=='page_header') $todo['name']='page_header_sub';
				$this->subHEADER[] = $todo;
				if (strtolower($todo['name'])=='page_header_sub' && $todo['close']) break;
			}

			$this->SetPageHeader();
		}
		
		function o_PAGE_FOOTER($param)
		{
			$this->subFOOTER = array();
			for($this->parse_pos; $this->parse_pos<count($this->parsing->code); $this->parse_pos++)
			{
				$todo = $this->parsing->code[$this->parse_pos];
				if ($todo['name']=='page_footer') $todo['name']='page_footer_sub';
				$this->subFOOTER[] = $todo;
				if (strtolower($todo['name'])=='page_footer_sub' && $todo['close']) break;
			}
			
			$this->SetPageFooter();
		}

		function o_PAGE_HEADER_SUB($param)
		{
			$this->subSTATES = array();
			$this->subSTATES['x']	= $this->pdf->x;
			$this->subSTATES['y']	= $this->pdf->y;
			$this->subSTATES['s']	= $this->style->value;
			$this->subSTATES['t']	= $this->style->table;
			$this->subSTATES['ml']	= $this->pdf->lMargin;
			$this->subSTATES['mr']	= $this->pdf->rMargin;
			$this->subSTATES['mt']	= $this->pdf->tMargin;
			$this->subSTATES['mb']	= $this->pdf->bMargin;
	
			$this->pdf->x						= $this->defaultLeft;
			$this->pdf->y						= $this->defaultTop;
			$this->style->initStyle();
			$this->style->resetStyle();
			$this->style->value['width']		= $this->pdf->w - $this->defaultLeft - $this->defaultRight;
			$this->style->table					= array();
			$this->pdf->lMargin					= $this->defaultLeft;
			$this->pdf->rMargin					= $this->defaultRight;
			$this->pdf->tMargin					= $this->defaultTop;
			$this->pdf->bMargin					= $this->defaultBottom;
			$this->pdf->PageBreakTrigger		= $this->pdf->h - $this->pdf->bMargin;

			$this->style->save();
			$this->style->analyse('page_header_sub', $param);
			$this->style->FontSet();
		}

		function c_PAGE_HEADER_SUB($param)
		{
			$this->style->load();

			$this->pdf->x						= $this->subSTATES['x'];
			$this->pdf->y						= $this->subSTATES['y'];
			$this->style->value					= $this->subSTATES['s'];
			$this->style->table					= $this->subSTATES['t'];
			$this->pdf->lMargin					= $this->subSTATES['ml'];
			$this->pdf->rMargin					= $this->subSTATES['mr'];
			$this->pdf->tMargin					= $this->subSTATES['mt'];
			$this->pdf->bMargin					= $this->subSTATES['mb'];
			$this->pdf->PageBreakTrigger		= $this->pdf->h - $this->pdf->bMargin;

			$this->style->FontSet();			
		}
				
		function o_PAGE_FOOTER_SUB($param)
		{
			$this->subSTATES = array();
			$this->subSTATES['x']	= $this->pdf->x;
			$this->subSTATES['y']	= $this->pdf->y;
			$this->subSTATES['s']	= $this->style->value;
			$this->subSTATES['t']	= $this->style->table;
			$this->subSTATES['ml']	= $this->pdf->lMargin;
			$this->subSTATES['mr']	= $this->pdf->rMargin;
			$this->subSTATES['mt']	= $this->pdf->tMargin;
			$this->subSTATES['mb']	= $this->pdf->bMargin;
	
			$this->pdf->x						= $this->defaultLeft;
			$this->pdf->y						= $this->defaultTop;
			$this->style->initStyle();
			$this->style->resetStyle();
			$this->style->value['width']		= $this->pdf->w - $this->defaultLeft - $this->defaultRight;
			$this->style->table					= array();			
			$this->pdf->lMargin					= $this->defaultLeft;
			$this->pdf->rMargin					= $this->defaultRight;
			$this->pdf->tMargin					= $this->defaultTop;
			$this->pdf->bMargin					= $this->defaultBottom;
			$this->pdf->PageBreakTrigger		= $this->pdf->h - $this->pdf->bMargin;

			// on en cr�� un sous HTML que l'on transforme en PDF
			// pour r�cup�rer la hauteur
			// on extrait tout ce qui est contenu dans le FOOTER
			$sub = null;
			$res = $this->parsing->getLevel($this->parse_pos);
			$this->CreateSubHTML($sub);
			$sub->writeHTML($res[1]);
			$this->pdf->y = $this->pdf->h - $sub->maxY - $this->defaultBottom - 0.01;
			unset($sub);
			
			$this->style->save();			
			$this->style->analyse('page_footer_sub', $param);
			$this->style->FontSet();			
		}

		function c_PAGE_FOOTER_SUB($param)
		{
			$this->style->load();

			$this->pdf->x						= $this->subSTATES['x'];
			$this->pdf->y						= $this->subSTATES['y'];
			$this->style->value					= $this->subSTATES['s'];
			$this->style->table					= $this->subSTATES['t'];
			$this->pdf->lMargin					= $this->subSTATES['ml'];
			$this->pdf->rMargin					= $this->subSTATES['mr'];
			$this->pdf->tMargin					= $this->subSTATES['mt'];
			$this->pdf->bMargin					= $this->subSTATES['mb'];
			$this->pdf->PageBreakTrigger		= $this->pdf->h - $this->pdf->bMargin;

			$this->style->FontSet();			
		}
		
		/**
		* balise : NOBREAK
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/
		function o_NOBREAK($param)
		{
			$this->maxH = 0;
			// on extrait tout ce qui est contenu dans le NOBREAK
			$res = $this->parsing->getLevel($this->parse_pos);

			// on en cr�� un sous HTML que l'on transforme en PDF
			// pour analyse les dimensions
			// et voir si ca rentre
			$sub = null;
			$this->CreateSubHTML($sub);
			$sub->writeHTML($res[1]);
			
			$y = $this->pdf->getY();
			if (
					$sub->maxY < ($this->pdf->h - $this->pdf->tMargin-$this->pdf->bMargin) &&
					$y + $sub->maxY>=($this->pdf->h - $this->pdf->bMargin)
				)
				$this->setNewPage();
			unset($sub);
		}
		

		/**
		* balise : NOBREAK
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_NOBREAK($param)
		{
			$this->maxH = 0;
			
		}
		
		/**
		* balise : WRITE
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_WRITE($param)
		{
			$fill = ($this->style->value['background']!=null);

			// r�cup�ration du texte � �crire, et conversion
			$txt = $param['txt'];
			$txt = html_entity_decode($txt);
			$txt = str_replace('[[page_cu]]',	$this->pdf->PageNo(),	$txt);
			
			// tailles du texte
			$h	= 1.08*$this->style->value['font-size'];
			$dh	= $h*$this->style->value['mini-decal'];
				
			$w = $this->pdf->GetStringWidth($txt);

			// identification de l'alignement
			$align = 'L';		
			if ($this->style->value['text-align']!='left')
			{
				$w = $this->style->value['width'];					
				if ($this->style->value['text-align']=='center') $align = 'C';		
				if ($this->style->value['text-align']=='right') $align = 'R';
			}
			
			$maxX = 0;									// plus grande largeur du texte apres retour � la ligne
			$left  = $this->pdf->lMargin;				// marge de gauche
			$right = $this->pdf->w-$this->pdf->rMargin;	// marge de droite
			$w = $this->pdf->GetStringWidth($txt);		// largeur du texte
			$x = $this->pdf->getX();					// position du texte
			$y = $this->pdf->getY();
			$nb = 0;									// nbr de lignes d�coup�es

			// tant que ca ne rentre pas sur la ligne et qu'on a du texte => on d�coupe
			while($x+$w>$right && $x<$right && strlen($txt))
			{
				// liste des mots
				$lst = explode(' ', $txt);
				
				// trouver une phrase qui rentre dans la largeur, en ajoutant les mots 1 � 1
				$i=0;
				$old = '';
				$str = $lst[0];
				while(($x+$this->pdf->GetStringWidth($str))<=$right)
				{
					unset($lst[$i]);
					$old = $str;

					$i++;
					$str.= ' '.$lst[$i];
				}
				$str = $old;
				
				// si rien de rentre, et que le premier mot ne rentre de toute facon pas dans une ligne, on le force...
				if ($i==0 && (($left+$this->pdf->GetStringWidth($lst[0]))>=$right))
				{
					$str = $lst[0];
					unset($lst[0]);						
				}
				
				// r�cup�ration des mots restant, et calcul de la largeur
				$txt = implode(' ', $lst);
				$w = $this->pdf->GetStringWidth($str);

				// ecriture du bout de phrase extrait et qui rentre
				$this->pdf->Cell(($align=='L' ? $w : $this->style->value['width']), $h+$dh, $str, 0, 0, $align, $fill, $this->inLink);
				$this->maxH = max($this->maxH, $h);
				
				// d�termination de la largeur max
				$maxX = max($maxX, $this->pdf->getX());

				// nouvelle position et nouvelle largeur pour la boucle
				$w = $this->pdf->GetStringWidth($txt);
				$y = $this->pdf->getY();
				$x = $this->pdf->getX();

				// si il reste du text � afficher
				if (strlen($txt))
				{
					// retour � la ligne
					$this->o_BR(array('style' => ''));

					$y = $this->pdf->getY();
					$x = $this->pdf->getX();
					
					// si la prochaine ligne ne rentre pas dans la page => nouvelle page 
					if ($y + $h>$this->pdf->h - $this->pdf->bMargin) $this->setNewPage();
				
					// ligne supl�mentaire. au bout de 1000 : trop long => exit
					$nb++;
					if ($nb>1000) HTML2PDF::makeError(2, __FILE__, __LINE__, array($txt, $right-$left, $this->pdf->GetStringWidth($txt))); 
				}
			}

			// si il reste du text apres d�coupe, c'est qu'il rentre direct => on l'affiche
			if (strlen($txt))
			{				
				$this->pdf->Cell(($align=='L' ? $w : $this->style->value['width']), $h+$dh, $txt, 0, 0, $align, $fill, $this->inLink);
				$this->maxH = max($this->maxH, $h);
			}
			
			// d�termination des positions MAX
			$maxX = max($maxX, $this->pdf->getX());
			$maxY = $this->pdf->getY()+$h;

			// position maximale globale
			$this->maxX = max($this->maxX, $maxX);
			$this->maxY = max($this->maxY, $maxY);
		}

		/**
		* tracer une image
		* 
		* @param	string	nom du fichier source
		* @return	null
		*/	
		function Image($src)
		{
			// est-ce que c'est une image ?
			$infos=@GetImageSize($src);

			if (count($infos)<2)
			{
				HTML2PDF::makeError(6, __FILE__, __LINE__, $src);
				return false;
			}
			
			// r�cup�ration des dimensions dans l'unit� du PDF
			$wi = $infos[0]/$this->pdf->k;
			$hi = $infos[1]/$this->pdf->k;
			
			// d�termination des dimensions d'affichage en fonction du style
			if ($this->style->value['width'] && $this->style->value['height'])
			{
				$w = $this->style->value['width'];
				$h = $this->style->value['height'];
			}
			else if ($this->style->value['width'])
			{
				$w = $this->style->value['width'];
				$h = $hi*$w/$wi;
				
			}
			else if ($this->style->value['height'])
			{
				$h = $this->style->value['height'];
				$w = $wi*$h/$hi;
			}
			else
			{
				$w = $wi;
				$h = $hi;					
			}
			
			// position d'affichage
			$x = $this->pdf->getX();
			$y = $this->pdf->getY();

			// d�termination de la position r�elle d'affichage en fonction du text-align du parent
			$old = isset($this->style->table[count($this->style->table)-1]) ? $this->style->table[count($this->style->table)-1] : $this->value;
			$parent_w = $old['width'] ? $old['width'] : $this->pdf->w - $this->pdf->lMargin - $this->pdf->rMargin;
			if ($parent_w>$w)
			{
				if ($this->style->value['text-align']=='center')		$x = $x + 0.5*($parent_w - $w);		
				else if ($this->style->value['text-align']=='right')	$x = $x + $parent_w - $w;
			}
						
			// affichage de l'image, et positionnement � la suite
			$this->pdf->Image($src, $x, $y, $w, $h, '', $this->inLink);				
			$this->pdf->SetX($x+$w);

			// position MAX
			$this->maxX = max($this->maxX, $x+$w);
			$this->maxY = max($this->maxY, $y+$h);
 			$this->maxH = $h;
		}
		
		function Rectangle($x, $y, $w, $h, $border, $padding, $margin, $background)
		{
			if ($h===null) return false;
		
			$x+= $margin;
			$y+= $margin;
			$w-= $margin*2;
			$h-= $margin*2;
			
			// initialisation du style des bordures de la premiere partie de tableau
			$STYLE = '';
			if ($background)
			{
				$this->pdf->SetFillColor($background[0], $background[1], $background[2]);
				$STYLE.= 'F';					
			}
			if ($STYLE)
			{
				$this->pdf->Rect($x, $y, $w, $h, $STYLE);
			}

			$x-= 0.01;
			$y-= 0.01;
			$w+= 0.02;
			$h+= 0.02;
			if ($border['b']['width']) $border['b']['width']+= 0.02;
			if ($border['l']['width']) $border['l']['width']+= 0.02;
			if ($border['t']['width']) $border['t']['width']+= 0.02;
			if ($border['r']['width']) $border['r']['width']+= 0.02;
			
			if ($border['b']['width'])
			{
				$pt = array();
				$pt[] = $x+$w;							$pt[] = $y+$h;
				$pt[] = $x+$w-$border['r']['width'];	$pt[] = $y+$h;
				$pt[] = $x+$border['l']['width'];		$pt[] = $y+$h;
				$pt[] = $x;								$pt[] = $y+$h;
				$pt[] = $x+$border['l']['width'];		$pt[] = $y+$h-$border['b']['width'];
				$pt[] = $x+$w-$border['r']['width'];	$pt[] = $y+$h-$border['b']['width'];

				$this->Line($pt, $border['b']['color'], $border['b']['type'], $border['b']['width']);
			}

			if ($border['l']['width'])
			{
				$pt = array();
				$pt[] = $x;								$pt[] = $y+$h;
				$pt[] = $x;								$pt[] = $y+$h-$border['b']['width'];
				$pt[] = $x;								$pt[] = $y+$border['t']['width'];
				$pt[] = $x;								$pt[] = $y;
				$pt[] = $x+$border['l']['width'];		$pt[] = $y+$border['t']['width'];
				$pt[] = $x+$border['l']['width'];		$pt[] = $y+$h-$border['b']['width'];

				$this->Line($pt, $border['l']['color'], $border['l']['type'], $border['l']['width']);
			}
			
			if ($border['t']['width'])
			{
				$pt = array();
				$pt[] = $x;								$pt[] = $y;
				$pt[] = $x+$border['l']['width'];		$pt[] = $y;
				$pt[] = $x+$w-$border['r']['width'];	$pt[] = $y;
				$pt[] = $x+$w;							$pt[] = $y;
				$pt[] = $x+$w-$border['r']['width'];	$pt[] = $y+$border['t']['width'];
				$pt[] = $x+$border['l']['width'];		$pt[] = $y+$border['t']['width'];

				$this->Line($pt, $border['t']['color'], $border['t']['type'], $border['t']['width']);
			}

			if ($border['r']['width'])
			{
				$pt = array();
				$pt[] = $x+$w;								$pt[] = $y;
				$pt[] = $x+$w;								$pt[] = $y+$border['t']['width'];
				$pt[] = $x+$w;								$pt[] = $y+$h-$border['b']['width'];
				$pt[] = $x+$w;								$pt[] = $y+$h;
				$pt[] = $x+$w-$border['r']['width'];		$pt[] = $y+$h-$border['b']['width'];
				$pt[] = $x+$w-$border['r']['width'];		$pt[] = $y+$border['t']['width'];
				
				$this->Line($pt, $border['r']['color'], $border['r']['type'], $border['r']['width']);
			}

			if ($background) $this->pdf->SetFillColor($background[0], $background[1], $background[2]);
		}
		
		function Line($pt, $color, $type, $width)
		{
			$this->pdf->SetFillColor($color[0], $color[1], $color[2]);
			if ($type=='dashed' || $type=='dotted')
			{
				$tmp = array(); $tmp[]=$pt[0]; $tmp[]=$pt[1]; $tmp[]=$pt[2]; $tmp[]=$pt[3]; $tmp[]=$pt[10]; $tmp[]=$pt[11];
				$this->pdf->Polygon($tmp, 'F');

				$tmp = array(); $tmp[]=$pt[4]; $tmp[]=$pt[5]; $tmp[]=$pt[6]; $tmp[]=$pt[7]; $tmp[]=$pt[8]; $tmp[]=$pt[9];
				$this->pdf->Polygon($tmp, 'F');
				
				$tmp = array(); $tmp[] = $pt[2]; $tmp[] = $pt[3]; $tmp[] = $pt[4];  $tmp[] = $pt[5];  $tmp[] = $pt[8];  $tmp[] = $pt[9];  $tmp[] = $pt[10];  $tmp[] = $pt[11];
				$pt = $tmp;
				
				if ($pt[2]==$pt[0])
				{
					$l = abs(($pt[3]-$pt[1])*0.5);
					$px = 0;
					$py = $width;
					$x1 = $pt[0]; $y1 = ($pt[3]+$pt[1])*0.5;
					$x2 = $pt[6]; $y2 = ($pt[7]+$pt[5])*0.5;
				}
				else
				{
					$l = abs(($pt[2]-$pt[0])*0.5);
					$px = $width;
					$py = 0;					
					$x1 = ($pt[2]+$pt[0])*0.5; $y1 = $pt[1];
					$x2 = ($pt[6]+$pt[4])*0.5; $y2 = $pt[7];
				}
				if ($type=='dashed')
				{
					$px = $px*3.;
					$py = $py*3.;
				}
				$mode = ($l/($px+$py)<.5);
				
				for($i=0; $l-($px+$py)*($i-0.5)>0; $i++)
				{
					if (($i%2)==$mode)
					{
						$j = $i-0.5;
						$lx1 = $px*($j);	if ($lx1<-$l)	$lx1 =-$l;
						$ly1 = $py*($j);	if ($ly1<-$l)	$ly1 =-$l;
						$lx2 = $px*($j+1);	if ($lx2>$l)	$lx2 = $l;
						$ly2 = $py*($j+1);	if ($ly2>$l)	$ly2 = $l;
						
						$tmp = array();
						$tmp[] = $x1+$lx1;	$tmp[] = $y1+$ly1;	
						$tmp[] = $x1+$lx2; 	$tmp[] = $y1+$ly2;	
						$tmp[] = $x2+$lx2; 	$tmp[] = $y2+$ly2;	
						$tmp[] = $x2+$lx1;	$tmp[] = $y2+$ly1;
						$this->pdf->Polygon($tmp, 'F');	

						if ($j>0)
						{
							$tmp = array();
							$tmp[] = $x1-$lx1;	$tmp[] = $y1-$ly1;	
							$tmp[] = $x1-$lx2; 	$tmp[] = $y1-$ly2;	
							$tmp[] = $x2-$lx2; 	$tmp[] = $y2-$ly2;	
							$tmp[] = $x2-$lx1;	$tmp[] = $y2-$ly1;
							$this->pdf->Polygon($tmp, 'F');	
						}
					}
				}		
			}
			else if ($type=='solid')
			{
				$this->pdf->Polygon($pt, 'F');
			}
		}
	
		/**
		* balise : BR
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_BR($param)
		{
			$h = 1.08*$this->style->value['font-size'];

			$h = max($this->maxH, $h);
			$y = $this->pdf->getY();
			
			// si le saut de ligne rentre => on le prend en compte, sinon nouvelle page
			if ($y+$h<$this->pdf->h - $this->pdf->bMargin)	$this->pdf->Ln($h);
			else	$this->setNewPage();
				
			$this->maxH = 0;
		}
		
		/**
		* balise : HR
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_HR($param)
		{
			$this->o_BR($param);
			
			$this->style->save();
			$this->style->analyse('hr', $param);
			$this->style->FontSet();
			$this->pdf->Cell(0,0.2,'',1,1,'C',1);
			$this->style->load();
			$this->style->FontSet();
			
			$this->o_BR($param);
		}

		/**
		* balise : B
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_B($param, $other = 'b')
		{
			$this->style->save();
			$this->style->value['font-bold'] = true;
			$this->style->analyse($other, $param);
			$this->style->FontSet();
		}
		function o_STRONG($param) { $this->o_B($param, 'strong'); }
				
		/**
		* balise : B
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_B($param)
		{
			$this->style->load();
			$this->style->FontSet();
		}
		function c_STRONG($param) { $this->c_B($param); }
		
		/**
		* balise : I
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_I($param, $other = 'i')
		{
			$this->style->save();
			$this->style->value['font-italic'] = true;
			$this->style->analyse($other, $param);
			$this->style->FontSet();
		}	
		function o_ADDRESS($param)	{ $this->o_I($param, 'address');	}
		function o_CITE($param)		{ $this->o_I($param, 'cite');		}
		function o_EM($param)		{ $this->o_I($param, 'em');			}
		function o_SAMP($param)		{ $this->o_I($param, 'samp');		}

		/**
		* balise : I
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_I($param)
		{
			$this->style->load();
			$this->style->FontSet();
		}	
		function c_ADDRESS($param)	{ $this->c_I($param); }
		function c_CITE($param)		{ $this->c_I($param); }
		function c_EM($param) 		{ $this->c_I($param); }
		function c_SAMP($param)		{ $this->c_I($param); }

		/**
		* balise : U
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_U($param)
		{
			$this->style->save();
			$this->style->value['font-underline'] = true;
			$this->style->analyse('u', $param);
			$this->style->FontSet();
		}	

		/**
		* balise : U
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_U($param)
		{
			$this->style->load();
			$this->style->FontSet();
		}

		/**
		* balise : A
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_A($param)
		{
			$this->inLink = str_replace('&amp;', '&', isset($param['href']) ? $param['href'] : '');
			$this->style->save();
			$this->style->value['font-underline'] = true;
			$this->style->value['color'] = array(20, 20, 250);
			$this->style->analyse('a', $param);
			$this->style->FontSet();			
		}

		/**
		* balise : A
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_A($param)
		{
			$this->inLink	= '';
			$this->style->load();
			$this->style->FontSet();			
		}

		/**
		* balise : H1
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_H1($param)
		{
			$this->o_BR(array());
			$this->style->save();
			$this->style->value['font-bold'] = true;
			$this->style->value['font-size'] = $this->style->ConvertToMM('28px');
			$this->style->analyse('h1', $param);
			$this->style->FontSet();
		}
		
		/**
		* balise : H1
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_H1($param)
		{
			$this->o_BR(array());
			$this->style->load();
			$this->style->FontSet();
			$this->o_BR(array());
		}

		/**
		* balise : H2
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_H2($param)
		{
			$this->o_BR(array());
			$this->style->save();
			$this->style->value['font-bold'] = true;
			$this->style->value['font-size'] = $this->style->ConvertToMM('24px');
			$this->style->analyse('h2', $param);
			$this->style->FontSet();
		}
		
		/**
		* balise : H2
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_H2($param)
		{
			$this->o_BR(array());
			$this->style->load();
			$this->style->FontSet();
			$this->o_BR(array());
		}		

		/**
		* balise : H3
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_H3($param)
		{
			$this->o_BR(array());
			$this->style->save();
			$this->style->value['font-bold'] = true;
			$this->style->value['font-size'] = $this->style->ConvertToMM('20px');
			$this->style->analyse('h3', $param);
			$this->style->FontSet();
		}
		
		/**
		* balise : H3
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_H3($param)
		{
			$this->o_BR(array());
			$this->style->load();
			$this->style->FontSet();
			$this->o_BR(array());
		}

		/**
		* balise : H4
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_H4($param)
		{
			$this->o_BR(array());
			$this->style->save();
			$this->style->value['font-bold'] = true;			
			$this->style->value['font-size'] = $this->style->ConvertToMM('16px');
			$this->style->analyse('h4', $param);
			$this->style->FontSet();
		}
		
		/**
		* balise : H4
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_H4($param)
		{
			$this->o_BR(array());
			$this->style->load();
			$this->style->FontSet();
			$this->o_BR(array());
		}

		/**
		* balise : H5
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_H5($param)
		{
			$this->o_BR(array());
			$this->style->save();
			$this->style->value['font-bold'] = true;
			$this->style->value['font-size'] = $this->style->ConvertToMM('12px');
			$this->style->analyse('h5', $param);
			$this->style->FontSet();
		}
		
		/**
		* balise : H5
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_H5($param)
		{
			$this->o_BR(array());
			$this->style->load();
			$this->style->FontSet();
			$this->o_BR(array());
		}

		/**
		* balise : H6
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_H6($param)
		{
			$this->o_BR(array());
			$this->style->save();
			$this->style->value['font-bold'] = true;			
			$this->style->value['font-size'] = $this->style->ConvertToMM('9px');
			$this->style->analyse('h6', $param);
			$this->style->FontSet();
		}
		
		/**
		* balise : H6
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_H6($param)
		{
			$this->o_BR(array());
			$this->style->load();
			$this->style->FontSet();
			$this->o_BR(array());
		}

		/**
		* balise : SPAN
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_SPAN($param, $other = 'span')
		{
			$this->style->save();
			$this->style->analyse($other, $param);
			$this->style->FontSet();		
		}	
		function o_FONT($param)		{ $this->o_SPAN($param, 'font');	}

		/**
		* balise : SPAN
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_SPAN($param)
		{
			$this->style->load();
			$this->style->FontSet();		
		}
		function c_FONT($param)		{ $this->c_SPAN($param); }

		/**
		* balise : BIG
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_BIG($param)
		{
			$this->style->save();
			$this->style->value['mini-decal']-= $this->style->value['mini-size']*0.2;
			$this->style->value['mini-size'] *= 1.2;
			$this->style->analyse('big', $param);
			$this->style->FontSet();
		}

		/**
		* balise : BIG
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_BIG($param)
		{
			$this->style->load();
			$this->style->FontSet();
		}

		/**
		* balise : SMALL
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_SMALL($param)
		{
			$this->style->save();
			$this->style->value['mini-decal']+= $this->style->value['mini-size']*0.18;
			$this->style->value['mini-size'] *= 0.82;
			$this->style->analyse('small', $param);
			$this->style->FontSet();
		}
		 
		/**
		* balise : SMALL
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_SMALL($param)
		{
			$this->style->load();
			$this->style->FontSet();
		}


		/**
		* balise : SUP
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_SUP($param)
		{
			$this->style->save();
			$this->style->value['mini-decal']-= $this->style->value['mini-size']*0.25;
			$this->style->value['mini-size'] *= 0.75;
			$this->style->analyse('sup', $param);
			$this->style->FontSet();
		}
		 
		/**
		* balise : SUP
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_SUP($param)
		{
			$this->style->load();
			$this->style->FontSet();
		}

		/**
		* balise : SUB
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_SUB($param)
		{
			$this->style->save();
			$this->style->value['mini-decal']+= $this->style->value['mini-size']*0.25;
			$this->style->value['mini-size'] *= 0.75;
			$this->style->analyse('sub', $param);
			$this->style->FontSet();
			$this->inSub = 1;
		}
		 
		/**
		* balise : SUB
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_SUB($param)
		{
			$this->style->load();
			$this->style->FontSet();
		}

		/**
		* balise : TABLE
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_TABLE($param)
		{
			$this->maxH = 0;
			// utilisation du tableau des param�tres des tables
			global $HTML2PDF_TABLEAU; 

			// lecture et initialisation du style
			$this->style->save();
			$this->style->analyse('table', $param);
			$this->style->FontSet();
				
			// si on est en mode sub_html : initialisation des dimensions et autres 
			if ($this->sub_part)
			{
				$HTML2PDF_TABLEAU[$param['num']] = array();
				$HTML2PDF_TABLEAU[$param['num']]['cellpadding']	= $this->style->ConvertToMM(isset($param['cellpadding']) ? $param['cellpadding'] : '1px'); // cellpadding du tableau
				$HTML2PDF_TABLEAU[$param['num']]['cellspacing']	= $this->style->ConvertToMM(isset($param['cellspacing']) ? $param['cellspacing'] : '2px'); // cellspacing du tableau
				$HTML2PDF_TABLEAU[$param['num']]['cases']		= array();				// liste des propri�t�s des cases
				$HTML2PDF_TABLEAU[$param['num']]['td_curr']		= 0;					// colonne courante
				$HTML2PDF_TABLEAU[$param['num']]['tr_curr']		= 0;					// ligne courante
				$HTML2PDF_TABLEAU[$param['num']]['curr_x']		= $this->pdf->getX();	// position courante X
				$HTML2PDF_TABLEAU[$param['num']]['curr_y']		= $this->pdf->getY();	// position courante Y
				$HTML2PDF_TABLEAU[$param['num']]['width']		= 0;					// largeur globale
				$HTML2PDF_TABLEAU[$param['num']]['height']		= 0;					// hauteur globale 
				$HTML2PDF_TABLEAU[$param['num']]['marge']		= array();
				$HTML2PDF_TABLEAU[$param['num']]['marge']['t']	= $this->style->value['padding']['t']+$this->style->value['border']['t']['width']+$HTML2PDF_TABLEAU[$param['num']]['cellspacing']*0.5;
				$HTML2PDF_TABLEAU[$param['num']]['marge']['r']	= $this->style->value['padding']['r']+$this->style->value['border']['r']['width']+$HTML2PDF_TABLEAU[$param['num']]['cellspacing']*0.5;
				$HTML2PDF_TABLEAU[$param['num']]['marge']['b']	= $this->style->value['padding']['b']+$this->style->value['border']['b']['width']+$HTML2PDF_TABLEAU[$param['num']]['cellspacing']*0.5;
				$HTML2PDF_TABLEAU[$param['num']]['marge']['l']	= $this->style->value['padding']['l']+$this->style->value['border']['l']['width']+$HTML2PDF_TABLEAU[$param['num']]['cellspacing']*0.5;
				$HTML2PDF_TABLEAU[$param['num']]['page']		= 0;					// nombre de pages
				$HTML2PDF_TABLEAU[$param['num']]['style_value'] = null;					// style du tableau
				$HTML2PDF_TABLEAU[$param['num']]['marge_l'] = $this->pdf->lMargin;		// marges left du tableau
				$HTML2PDF_TABLEAU[$param['num']]['marge_r'] = $this->pdf->rMargin;		// marges right du tableau 
				$HTML2PDF_TABLEAU[$param['num']]['marge_t'] = $this->pdf->tMargin;		// marges top du tableau 
				
				// adaptation de la largeur en fonction des marges du tableau
				$this->style->value['width']-= $HTML2PDF_TABLEAU[$param['num']]['marge']['l'] + $HTML2PDF_TABLEAU[$param['num']]['marge']['r'];
			}
			else
			{
				// on repart � la premiere page du tableau et � la premiere case
				$HTML2PDF_TABLEAU[$param['num']]['page'] = 0;
				$HTML2PDF_TABLEAU[$param['num']]['td_x']		= $HTML2PDF_TABLEAU[$param['num']]['marge']['l']+$HTML2PDF_TABLEAU[$param['num']]['curr_x'];
				$HTML2PDF_TABLEAU[$param['num']]['td_y']		= $HTML2PDF_TABLEAU[$param['num']]['marge']['t']+$HTML2PDF_TABLEAU[$param['num']]['curr_y'];				
				$HTML2PDF_TABLEAU[$param['num']]['td_curr']	= 0;
				$HTML2PDF_TABLEAU[$param['num']]['tr_curr']	= 0;

				// initialisation du style des bordures de la premiere partie de tableau
				$this->Rectangle(
						$HTML2PDF_TABLEAU[$param['num']]['curr_x'],
						$HTML2PDF_TABLEAU[$param['num']]['curr_y'],
						$HTML2PDF_TABLEAU[$param['num']]['width'],
						isset($HTML2PDF_TABLEAU[$param['num']]['height'][0]) ? $HTML2PDF_TABLEAU[$param['num']]['height'][0] : null,
						$this->style->value['border'],
						$this->style->value['padding'],
						0,
						$this->style->value['background']
					);

				$HTML2PDF_TABLEAU[$param['num']]['style_value'] = $this->style->value;
			}
		}

		/**
		* balise : TABLE
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_TABLE($param)
		{
			$this->maxH = 0;
			global $HTML2PDF_TABLEAU; 

			// restauration du style
			$this->style->load();
			$this->style->FontSet();

			// si on est en mode sub_html : initialisation des dimensions et autres 
			if ($this->sub_part)
			{
				// ajustement de la taille des cases
				$this->calculTailleCases($HTML2PDF_TABLEAU[$param['num']]['cases']);

				// calcul des dimensions du tableau - Largeur
				$HTML2PDF_TABLEAU[$param['num']]['width']  = $HTML2PDF_TABLEAU[$param['num']]['marge']['l'] + $HTML2PDF_TABLEAU[$param['num']]['marge']['r'];
				if (isset($HTML2PDF_TABLEAU[$param['num']]['cases'][0]))
					foreach($HTML2PDF_TABLEAU[$param['num']]['cases'][0]  as $case)
						$HTML2PDF_TABLEAU[$param['num']]['width']+=  $case['w'];

				// calcul des dimensions du tableau - hauteur du tableau sur chaque page
				$HTML2PDF_TABLEAU[$param['num']]['height'] = array();

				$h0 = $HTML2PDF_TABLEAU[$param['num']]['marge']['t'] + $HTML2PDF_TABLEAU[$param['num']]['marge']['b'];	// minimum de hauteur � cause des marges
				$height = $h0;										// hauteur par defaut
				$max = $this->pdf->h - $this->pdf->bMargin;			// max de hauteur par page
				$y = $HTML2PDF_TABLEAU[$param['num']]['curr_y'];	// position Y actuelle
				
				// on va lire les hauteurs de chaque ligne, une � une, et voir si ca rentre sur la page.
				for($k=0; $k<count($HTML2PDF_TABLEAU[$param['num']]['cases']); $k++)
				{
					// hauteur de la ligne $k
					$th = 0;
					$h = 0;
					for($i=0; $i<count($HTML2PDF_TABLEAU[$param['num']]['cases'][$k]); $i++)
					{
						$h = max($h, $HTML2PDF_TABLEAU[$param['num']]['cases'][$k][$i]['h']);
						
						if ($HTML2PDF_TABLEAU[$param['num']]['cases'][$k][$i]['rowspan']==1)
							$th = max($th, $HTML2PDF_TABLEAU[$param['num']]['cases'][$k][$i]['h']);
					}
			
					// si la ligne ne rentre pas dans la page
					//  => la hauteur sur cette page est trouv�e, et on passe � la page d'apres
					if ($y+$h+$height>$max)
					{
						$HTML2PDF_TABLEAU[$param['num']]['height'][] = $height;
						$height = $h0;						
						$y = $this->margeTop;
					}
					$height+= $th;
				}
				// rajout du reste de tableau (si il existe) � la derniere page
				if ($height!=$h0 || $k==0) $HTML2PDF_TABLEAU[$param['num']]['height'][] = $height;
			}
			else
			{
				// determination des coordonn�es de sortie du tableau
				$x = $HTML2PDF_TABLEAU[$param['num']]['curr_x'] + $HTML2PDF_TABLEAU[$param['num']]['width'];
				if (count($HTML2PDF_TABLEAU[$param['num']]['height'])>1)
					$y = $this->margeTop+$HTML2PDF_TABLEAU[$param['num']]['height'][count($HTML2PDF_TABLEAU[$param['num']]['height'])-1];
				else if (count($HTML2PDF_TABLEAU[$param['num']]['height'])==1)
					$y = $HTML2PDF_TABLEAU[$param['num']]['curr_y']+$HTML2PDF_TABLEAU[$param['num']]['height'][count($HTML2PDF_TABLEAU[$param['num']]['height'])-1];
				else
					$y = $HTML2PDF_TABLEAU[$param['num']]['curr_y'];					

				// restauration des marges
				$this->setMargins();
				$this->pdf->SetMargins(
								$HTML2PDF_TABLEAU[$param['num']]['marge_l'],
								$HTML2PDF_TABLEAU[$param['num']]['marge_t'],
								$HTML2PDF_TABLEAU[$param['num']]['marge_r']);	
				
				// position de sortie du tableau
				$this->pdf->setX($x);
				$this->pdf->setY($y);
				$this->maxX = max($this->maxX, $x);
				$this->maxY = max($this->maxY, $y);
			}
		}

		/**
		* balise : TR
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_TR($param)
		{
			$this->maxH = 0;
			global $HTML2PDF_TABLEAU; 

			// analyse du style
			$this->style->save();
			$this->style->analyse('tr', $param);
			$this->style->FontSet();
			
			// positionnement dans le tableau
			$HTML2PDF_TABLEAU[$param['num']]['tr_curr']++;
			$HTML2PDF_TABLEAU[$param['num']]['td_curr']= 0;
			
			// si on est pas dans un sub_html
			if (!$this->sub_part)
			{
				// Y courant apres la ligne
				$ty=null;
				for($ii=0; $ii<count($HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1]); $ii++)
					$ty = max($ty, $HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$ii]['h']);	
				
				// si la ligne ne rentre pas dans la page => nouvelle page
				if ($HTML2PDF_TABLEAU[$param['num']]['td_y'] + $HTML2PDF_TABLEAU[$param['num']]['marge']['b'] + $ty > $this->pdf->h - $this->pdf->bMargin)
				{
					$this->setNewPage();

					$HTML2PDF_TABLEAU[$param['num']]['page']++;
					$HTML2PDF_TABLEAU[$param['num']]['curr_y'] = $this->pdf->getY();
					$HTML2PDF_TABLEAU[$param['num']]['td_y'] = $HTML2PDF_TABLEAU[$param['num']]['curr_y']+$HTML2PDF_TABLEAU[$param['num']]['marge']['t'];

					// si la hauteur de cette partie a bien �t� calcul�e, on trace le cadre
					if (isset($HTML2PDF_TABLEAU[$param['num']]['height'][$HTML2PDF_TABLEAU[$param['num']]['page']]))
					{
						$old = $this->style->value;
						$this->style->value = $HTML2PDF_TABLEAU[$param['num']]['style_value'];

						// initialisation du style des bordures de la premiere partie de tableau
						$this->Rectangle(
								$HTML2PDF_TABLEAU[$param['num']]['curr_x'],
								$HTML2PDF_TABLEAU[$param['num']]['curr_y'],
								$HTML2PDF_TABLEAU[$param['num']]['width'],
								$HTML2PDF_TABLEAU[$param['num']]['height'][$HTML2PDF_TABLEAU[$param['num']]['page']],
								$this->style->value['border'],
								$this->style->value['padding'],
								$HTML2PDF_TABLEAU[$param['num']]['cellspacing']*0.5,
								$this->style->value['background']
							);
											 
						$this->style->value = $old;
					}
				}
			}
			else
			{
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1] = array();
			}							
		}

		/**
		* balise : TR
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_TR($param)
		{
			$this->maxH = 0;
			global $HTML2PDF_TABLEAU; 

			// restauration du style
			$this->style->load();
			$this->style->FontSet();			

			// si on est pas dans un sub_html
			if (!$this->sub_part)
			{
				// Y courant apres la ligne
				$ty=null;
				for($ii=0; $ii<count($HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1]); $ii++)
					if ($HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$ii]['rowspan']==1)
						$ty = $HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$ii]['h'];	

				// mise � jour des coordonn�es courantes
				$HTML2PDF_TABLEAU[$param['num']]['td_x'] = $HTML2PDF_TABLEAU[$param['num']]['curr_x']+$HTML2PDF_TABLEAU[$param['num']]['marge']['l'];
				$HTML2PDF_TABLEAU[$param['num']]['td_y']+= $ty;
			}
		}

		/**
		* balise : TD
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_TD($param, $other = 'td')
		{
			$this->maxH = 0;
			global $HTML2PDF_TABLEAU; 

			$param['cellpadding'] = $HTML2PDF_TABLEAU[$param['num']]['cellpadding'].'mm';
			$param['cellspacing'] = $HTML2PDF_TABLEAU[$param['num']]['cellspacing'].'mm';
			
			// analyse du style
			$this->style->save();
			$this->style->analyse($other, $param);
			$this->style->FontSet();
			$marge = array();
			$marge['t'] = $this->style->value['padding']['t']+0.5*$HTML2PDF_TABLEAU[$param['num']]['cellspacing']+$this->style->value['border']['t']['width'];
			$marge['r'] = $this->style->value['padding']['r']+0.5*$HTML2PDF_TABLEAU[$param['num']]['cellspacing']+$this->style->value['border']['r']['width'];
			$marge['b'] = $this->style->value['padding']['b']+0.5*$HTML2PDF_TABLEAU[$param['num']]['cellspacing']+$this->style->value['border']['b']['width'];
			$marge['l'] = $this->style->value['padding']['l']+0.5*$HTML2PDF_TABLEAU[$param['num']]['cellspacing']+$this->style->value['border']['l']['width'];

			// si on est dans un sub_html
			if ($this->sub_part)
			{
				// on se positionne dans le tableau
				$HTML2PDF_TABLEAU[$param['num']]['td_curr']++;
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1] = array();
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['w'] = 0;
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['h'] = 0;
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['dw'] = 0;
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['colspan'] = isset($param['colspan']) ? $param['colspan'] : 1;
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['rowspan'] = isset($param['rowspan']) ? $param['rowspan'] : 1;
				// on extrait tout ce qui est contenu dans le TD
				$res = $this->parsing->getLevel($this->temp_pos);
				
				// on en cr�� un sous HTML que l'on transforme en PDF
				// pour analyse les dimensions
				// et les r�cup�rer dans le tableau global.
				$this->CreateSubHTML($this->sub_html);
				$this->sub_html->writeHTML($res[1]);
				$this->temp_pos = $res[0]-2;
			}
			else
			{
				// on se positionne dans le tableau
				$HTML2PDF_TABLEAU[$param['num']]['td_curr']++;
				$HTML2PDF_TABLEAU[$param['num']]['td_x']+= $HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['dw'];
				
				// initialisation du style des bordures de la premiere partie de tableau
				$this->Rectangle(
						$HTML2PDF_TABLEAU[$param['num']]['td_x'],
						$HTML2PDF_TABLEAU[$param['num']]['td_y'],
						$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['w'],
						$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['h'],
						$this->style->value['border'],
						$this->style->value['padding'],
						$HTML2PDF_TABLEAU[$param['num']]['cellspacing']*0.5,
						$this->style->value['background']
					);
				

				$this->style->value['width'] = $HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['w'] - $marge['l'] - $marge['r'];

				// limitation des marges aux dimensions de la case
				$mL = $HTML2PDF_TABLEAU[$param['num']]['td_x']+$marge['l'];
				$mR = $this->pdf->w - $mL - $this->style->value['width'];
				$this->pdf->SetMargins($mL, 0, $mR);
				
				// positionnement en fonction
				$h_corr = $HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['h'];
				$h_reel = $HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['real_h'];
				switch($this->style->value['vertical-align'])
				{
					case 'bottom':
						$y_corr = $h_corr-$h_reel;
						break;
						
					case 'middle':
						$y_corr = ($h_corr-$h_reel)*0.5;
						break;
						
					case 'top':
					default:
						$y_corr = 0;
						break;	
				}

				$this->pdf->setX($HTML2PDF_TABLEAU[$param['num']]['td_x']+$marge['l']);
				$this->pdf->setY($HTML2PDF_TABLEAU[$param['num']]['td_y']+$marge['t']+$y_corr);
			}
		}

		/**
		* balise : TD
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_TD($param)
		{
			$this->maxH = 0;
			global $HTML2PDF_TABLEAU; 

			// r�cup�ration de la marge
			$marge = array();
			$marge['t'] = $this->style->value['padding']['t']+0.5*$HTML2PDF_TABLEAU[$param['num']]['cellspacing']+$this->style->value['border']['t']['width'];
			$marge['r'] = $this->style->value['padding']['r']+0.5*$HTML2PDF_TABLEAU[$param['num']]['cellspacing']+$this->style->value['border']['r']['width'];
			$marge['b'] = $this->style->value['padding']['b']+0.5*$HTML2PDF_TABLEAU[$param['num']]['cellspacing']+$this->style->value['border']['b']['width'];
			$marge['l'] = $this->style->value['padding']['l']+0.5*$HTML2PDF_TABLEAU[$param['num']]['cellspacing']+$this->style->value['border']['l']['width'];
			$marge['t']+= 0.01;
			$marge['r']+= 0.01;
			$marge['b']+= 0.01;
			$marge['l']+= 0.01;

			// si on est dans un sub_html
			if ($this->sub_part)
			{
				// dimentions de cette case
				$w0 = $this->sub_html->maxX + $marge['l'] + $marge['r'];
				$h0 = $this->sub_html->maxY + $marge['t'] + $marge['b'];
	
				// dimensions impos�es par le style
				$w2 = $this->style->value['width'] + $marge['l'] + $marge['r'];
				$h2 = $this->style->value['height'] + $marge['t'] + $marge['b'];
	
							// dimension finale de la case = max des 3 ci-dessus
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['w'] = max(array($w0, $w2));
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['h'] = max(array($h0, $h2));

				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['real_w'] = max(array($w0, $w2));
				$HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['real_h'] = max(array($h0, $h2));

				// suppresion du sous_html
				$this->DestroySubHTML();
			}
			else
			{
				//positionnement
				$HTML2PDF_TABLEAU[$param['num']]['td_x']+= $HTML2PDF_TABLEAU[$param['num']]['cases'][$HTML2PDF_TABLEAU[$param['num']]['tr_curr']-1][$HTML2PDF_TABLEAU[$param['num']]['td_curr']-1]['w'];
			}

			// restauration du style
			$this->style->load();
			$this->style->FontSet();	
		}
		
		function calculTailleCases(&$cases)
		{
			// construction d'un tableau de correlation
			$corr = array();

			// on fait correspondre chaque case d'un tableau norm� aux cases r�elles, en prennant en compte les colspan et rowspan
			$Yr=0;
			for($y=0; $y<count($cases); $y++)
			{
				$Xr=0; 	while(isset($corr[$Yr][$Xr])) $Xr++;
				
				for($x=0; $x<count($cases[$y]); $x++)
				{
					for($j=0; $j<$cases[$y][$x]['rowspan']; $j++)
					{
						for($i=0; $i<$cases[$y][$x]['colspan']; $i++)
						{
							$corr[$Yr+$j][$Xr+$i] = ($i+$j>0) ? '' : array($x, $y, $cases[$y][$x]['colspan'], $cases[$y][$x]['rowspan']);
						}
					}
					$Xr+= $cases[$y][$x]['colspan'];
					while(isset($corr[$Yr][$Xr])) $Xr++;
				}
				$Yr++;
			}
			
			if (!isset($corr[0])) return true;
			
			// on d�termine, pour les cases sans colspan, la largeur maximale de chaque colone
			$sw = array();
			for($x=0; $x<count($corr[0]); $x++)
			{
				$m=0;
				for($y=0; $y<count($corr); $y++)
					if (is_array($corr[$y][$x]) && $corr[$y][$x][2]==1)
						$m = max($m, $cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['w']);				
				$sw[$x] = $m;	
			}

			// on v�rifie que cette taille est valide avec les colones en colspan
			for($x=0; $x<count($corr[0]); $x++)
			{
				for($y=0; $y<count($corr); $y++)
				{
					if (is_array($corr[$y][$x]) && $corr[$y][$x][2]>1)
					{
						// somme des colonnes correspondant au colspan
						$s = 0; for($i=0; $i<$corr[$y][$x][2]; $i++) $s+= $sw[$x+$i];
						
						// si la somme est inf�rieure � la taille necessaire => r�gle de 3 pour adapter
						if ($s<$cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['w'])
							for($i=0; $i<$corr[$y][$x][2]; $i++) $sw[$x+$i] = $sw[$x+$i]/$s*$cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['w'];
					}
				}
			}

			// on applique les nouvelles largeurs
			for($x=0; $x<count($corr[0]); $x++)
			{
				for($y=0; $y<count($corr); $y++)
				{
					if (is_array($corr[$y][$x]))
					{
						if ($corr[$y][$x][2]==1)
						{
							$cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['w'] = $sw[$x];
						}
						else
						{
							// somme des colonnes correspondant au colspan
							$s = 0; for($i=0; $i<$corr[$y][$x][2]; $i++) $s+= $sw[$x+$i];
							$cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['w'] = $s;
						}
					}
				}
			}

			// on d�termine, pour les cases sans rowspan, la hauteur maximale de chaque colone
			$sh = array();
			for($y=0; $y<count($corr); $y++)
			{
				$m=0;
				for($x=0; $x<count($corr[0]); $x++)
					if (is_array($corr[$y][$x]) && $corr[$y][$x][3]==1)
						$m = max($m, $cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['h']);
				$sh[$y] = $m;	
			}


			// on v�rifie que cette taille est valide avec les lignes en rowspan
			for($y=0; $y<count($corr); $y++)
			{
				for($x=0; $x<count($corr[0]); $x++)
				{
					if (is_array($corr[$y][$x]) && $corr[$y][$x][3]>1)
					{
						// somme des colonnes correspondant au colspan
						$s = 0; for($i=0; $i<$corr[$y][$x][3]; $i++) $s+= $sh[$y+$i];
						
						// si la somme est inf�rieure � la taille necessaire => r�gle de 3 pour adapter
						if ($s<$cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['h'])
							for($i=0; $i<$corr[$y][$x][3]; $i++) $sh[$y+$i] = $sh[$y+$i]/$s*$cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['h'];
					}
				}
			}
			

			// on applique les nouvelles hauteurs
			for($y=0; $y<count($corr); $y++)
			{
				for($x=0; $x<count($corr[0]); $x++)
				{
					if (is_array($corr[$y][$x]))
					{
						if ($corr[$y][$x][3]==1)
						{
							$cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['h'] = $sh[$y];
						}
						else
						{
							// somme des lignes correspondant au rowspan
							$s = 0; for($i=0; $i<$corr[$y][$x][3]; $i++) $s+= $sh[$y+$i];
							$cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['h'] = $s;
							
							for($j=1; $j<$corr[$y][$x][3]; $j++)
							{
								$tx = $x+1;
								$ty = $y+$j;
								for(true; isset($corr[$ty][$tx]) && !is_array($corr[$ty][$tx]); $tx++);
								if (isset($corr[$ty][$tx])) $cases[$corr[$ty][$tx][1]][$corr[$ty][$tx][0]]['dw']+= $cases[$corr[$y][$x][1]][$corr[$y][$x][0]]['w'];
																	
							}
						}
					}
				}
			}		
		}

		/**
		* balise : TH
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_TH($param)
		{
			$this->maxH = 0;
			// identique � TD mais en gras
			$param['style']['font-weight'] = 'bold';
			$this->o_TD($param, 'th');
		}	

		/**
		* balise : TH
		* mode   : FERMETURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function c_TH($param)
		{
			$this->maxH = 0;
			// identique � TD
			$this->c_TD($param);			
		}

		/**
		* balise : IMG
		* mode   : OUVERTURE
		* 
		* @param	array	param�tres de l'�l�ment de parsing
		* @return	null
		*/	
		function o_IMG($param)
		{
			// analyse du style
			$src	= str_replace('&amp;', '&', $param['src']);	

			$this->style->save();
			$this->style->value['width']	= 0;
			$this->style->value['height']	= 0;
			$this->style->value['border']	= array(
												'type'	=> 'none',
												'width'	=> 0,
												'color'	=> array(0, 0, 0),
												);
			$this->style->value['background'] = null;
			$this->style->analyse('img', $param);
			$this->style->FontSet();

			// affichage de l'image			
			$this->Image($src);

			// restauration du style
			$this->style->load();
			$this->style->FontSet();	
		}
		
		function textLOAD($langue)
		{
			if (!preg_match('/^([a-z0-9]+)$/isU', $langue))
			{
				echo 'ERROR : language code <b>'.$langue.'</b> incorrect.';
				exit;
			}
			
			$file = dirname(__FILE__).'/langues/'.strtolower($langue).'.lst';
			if (!is_file($file))
			{
				echo 'ERROR : language code <b>'.$langue.'</b> unknown.<br>';
				echo 'You can create the translation file <b>'.$file.'</b> and send it to me in order to integrate it into a future version.';
				exit;				
			}
			
			$texte = array();
			$infos = file($file);
			foreach($infos as $val)
			{
				$val = trim($val);
				$val = explode("\t", $val);
				if (count($val)<2) continue;
				
				$t_k = trim($val[0]); unset($val[0]);
				$t_v = trim(implode(' ', $val));
				if ($t_k && $t_v) $texte[$t_k] = $t_v;
			}
			global $HTML2PDF_TEXTE_FILE;
			$HTML2PDF_TEXTE_FILE = $texte;	
		}
		
		function textGET($key)
		{
			global $HTML2PDF_TEXTE_FILE;
			if (!isset($HTML2PDF_TEXTE_FILE[$key])) return '######';
			
			return $HTML2PDF_TEXTE_FILE[$key];
		}
		
		function makeError($err, $file, $line, $other = null)
		{
			$msg = '';
			switch($err)
			{
				case 1:
					$msg = (HTML2PDF::textGET('err01'));
					$msg = str_replace('[[OTHER]]', $other, $msg); 
					break;
					
				case 2:
					$msg = (HTML2PDF::textGET('err02'));
					$msg = str_replace('[[OTHER_0]]', $other[0], $msg); 
					$msg = str_replace('[[OTHER_1]]', $other[1], $msg); 
					$msg = str_replace('[[OTHER_2]]', $other[2], $msg); 
					break;
					
				case 3:
					$msg = (HTML2PDF::textGET('err03'));
					$msg = str_replace('[[OTHER]]', $other, $msg); 
					break;
					
				case 4:
					$msg = (HTML2PDF::textGET('err04'));
					$msg = str_replace('[[OTHER]]', print_r($other, true), $msg); 
					break;
					
				case 5:
					$msg = (HTML2PDF::textGET('err05'));
					$msg = str_replace('[[OTHER]]', print_r($other, true), $msg); 
					break;
					
				case 6:
					$msg = (HTML2PDF::textGET('err06'));
					$msg = str_replace('[[OTHER]]', $other, $msg); 
					break;	
			}
			echo '<span style="color: #AA0000; font-weight: bold;">'.(HTML2PDF::textGET('txt01')).$err.'</span><br>';
			echo (HTML2PDF::textGET('txt02')).' '.$file.'<br>';
			echo (HTML2PDF::textGET('txt03')).' '.$line.'<br>';
			echo '<br>';
			echo $msg;
			exit;	
		}
	}
}
?>
