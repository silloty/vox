<?php
/**
 * Logiciel : HTML2PDF - classe styleHTML
 * 
 * Convertisseur HTML => PDF, utilise fpdf de Olivier PLATHEY 
 * Distribué sous la licence GPL. 
 *
 * @author		Laurent MINGUET <webmaster@spipu.net>
 * @version		3.08 - 24/06/2008
 */
 
if (!defined('__CLASS_STYLEHTML__'))
{
	define('__CLASS_STYLEHTML__', true);
	
	class styleHTML
	{
		var $css		= array();		// tableau des CSS
		var $css_keys	= array();		// tableau des clefs CSS, pour l'ordre d'execution
		var $value		= array();		// valeurs actuelles
		var $table		= array();		// tableau d'empilement pour historisation des niveaux
		var $pdf		= null;			// référence au PDF parent
		var $htmlColor	= array();		// liste des couleurs HTML
		/**
		 * Constructeur
		 *
		 * @param	&pdf		référence à l'objet HTML2PDF parent
		 * @return	null
		 */
		function styleHTML(&$pdf)
    	{
    		$this->init();		// initialisation
    		$this->pdf = &$pdf;
    	}
    	
 		/**
		 * Initialisation du style
		 *
		 * @return	null
		 */
		function init()
    	{
    		$color = array();
    		$color['AliceBlue']			= '#F0F8FF';
			$color['AntiqueWhite']		= '#FAEBD7';
			$color['Aqua']				= '#00FFFF';
			$color['Aquamarine']		= '#7FFFD4';
			$color['Azure']				= '#F0FFFF';
			$color['Beige']				= '#F5F5DC';
			$color['Bisque']			= '#FFE4C4';
			$color['Black']				= '#000000';
			$color['BlanchedAlmond']	= '#FFEBCD';
			$color['Blue']				= '#0000FF';
			$color['BlueViolet']		= '#8A2BE2';
			$color['Brown']				= '#A52A2A';
			$color['BurlyWood']			= '#DEB887';
			$color['CadetBlue']			= '#5F9EA0';
			$color['Chartreuse']		= '#7FFF00';
			$color['Chocolate']			= '#D2691E';
			$color['Coral']				= '#FF7F50';
			$color['CornflowerBlue']	= '#6495ED';
			$color['Cornsilk']			= '#FFF8DC';
			$color['Crimson']			= '#DC143C';
			$color['Cyan']				= '#00FFFF';
			$color['DarkBlue']			= '#00008B';
			$color['DarkCyan']			= '#008B8B';
			$color['DarkGoldenRod']		= '#B8860B';
			$color['DarkGray']			= '#A9A9A9';
			$color['DarkGrey']			= '#A9A9A9';
			$color['DarkGreen']			= '#006400';
			$color['DarkKhaki']			= '#BDB76B';
			$color['DarkMagenta']		= '#8B008B';
			$color['DarkOliveGreen']	= '#556B2F';
			$color['Darkorange']		= '#FF8C00';
			$color['DarkOrchid']		= '#9932CC';
			$color['DarkRed']			= '#8B0000';
			$color['DarkSalmon']		= '#E9967A';
			$color['DarkSeaGreen']		= '#8FBC8F';
			$color['DarkSlateBlue']		= '#483D8B';
			$color['DarkSlateGray']		= '#2F4F4F';
			$color['DarkSlateGrey']		= '#2F4F4F';
			$color['DarkTurquoise']		= '#00CED1';
			$color['DarkViolet']		= '#9400D3';
			$color['DeepPink']			= '#FF1493';
			$color['DeepSkyBlue']		= '#00BFFF';
			$color['DimGray']			= '#696969';
			$color['DimGrey']			= '#696969';
			$color['DodgerBlue']		= '#1E90FF';
			$color['FireBrick']			= '#B22222';
			$color['FloralWhite']		= '#FFFAF0';
			$color['ForestGreen']		= '#228B22';
			$color['Fuchsia']			= '#FF00FF';
			$color['Gainsboro']			= '#DCDCDC';
			$color['GhostWhite']		= '#F8F8FF';
			$color['Gold']				= '#FFD700';
			$color['GoldenRod']			= '#DAA520';
			$color['Gray']				= '#808080';
			$color['Grey']				= '#808080';
			$color['Green']				= '#008000';
			$color['GreenYellow']		= '#ADFF2F';
			$color['HoneyDew']			= '#F0FFF0';
			$color['HotPink']			= '#FF69B4';
			$color['IndianRed']			= '#CD5C5C';
			$color['Indigo']			= '#4B0082';
			$color['Ivory']				= '#FFFFF0';
			$color['Khaki']				= '#F0E68C';
			$color['Lavender']			= '#E6E6FA';
			$color['LavenderBlush']		= '#FFF0F5';
			$color['LawnGreen']			= '#7CFC00';
			$color['LemonChiffon']		= '#FFFACD';
			$color['LightBlue']			= '#ADD8E6';
			$color['LightCoral']		= '#F08080';
			$color['LightCyan']			= '#E0FFFF';
			$color['LightGoldenRodYellow']	= '#FAFAD2';
			$color['LightGray']			= '#D3D3D3';
			$color['LightGrey']			= '#D3D3D3';
			$color['LightGreen']		= '#90EE90';
			$color['LightPink']			= '#FFB6C1';
			$color['LightSalmon']		= '#FFA07A';
			$color['LightSeaGreen']		= '#20B2AA';
			$color['LightSkyBlue']		= '#87CEFA';
			$color['LightSlateGray']	= '#778899';
			$color['LightSlateGrey']	= '#778899';
			$color['LightSteelBlue']	= '#B0C4DE';
			$color['LightYellow']		= '#FFFFE0';
			$color['Lime']				= '#00FF00';
			$color['LimeGreen']			= '#32CD32';
			$color['Linen']				= '#FAF0E6';
			$color['Magenta']			= '#FF00FF';
			$color['Maroon']			= '#800000';
			$color['MediumAquaMarine']	= '#66CDAA';
			$color['MediumBlue']		= '#0000CD';
			$color['MediumOrchid']		= '#BA55D3';
			$color['MediumPurple']		= '#9370D8';
			$color['MediumSeaGreen']	= '#3CB371';
			$color['MediumSlateBlue']	= '#7B68EE';
			$color['MediumSpringGreen']	= '#00FA9A';
			$color['MediumTurquoise']	= '#48D1CC';
			$color['MediumVioletRed']	= '#C71585';
			$color['MidnightBlue']		= '#191970';
			$color['MintCream']			= '#F5FFFA';
			$color['MistyRose']			= '#FFE4E1';
			$color['Moccasin']			= '#FFE4B5';
			$color['NavajoWhite']		= '#FFDEAD';
			$color['Navy']				= '#000080';
			$color['OldLace']			= '#FDF5E6';
			$color['Olive']				= '#808000';
			$color['OliveDrab']			= '#6B8E23';
			$color['Orange']			= '#FFA500';
			$color['OrangeRed']			= '#FF4500';
			$color['Orchid']			= '#DA70D6';
			$color['PaleGoldenRod']		= '#EEE8AA';
			$color['PaleGreen']			= '#98FB98';
			$color['PaleTurquoise']		= '#AFEEEE';
			$color['PaleVioletRed']		= '#D87093';
			$color['PapayaWhip']		= '#FFEFD5';
			$color['PeachPuff']			= '#FFDAB9';
			$color['Peru']				= '#CD853F';
			$color['Pink']				= '#FFC0CB';
			$color['Plum']				= '#DDA0DD';
			$color['PowderBlue']		= '#B0E0E6';
			$color['Purple']			= '#800080';
			$color['Red']				= '#FF0000';
			$color['RosyBrown']			= '#BC8F8F';
			$color['RoyalBlue']			= '#4169E1';
			$color['SaddleBrown']		= '#8B4513';
			$color['Salmon']			= '#FA8072';
			$color['SandyBrown']		= '#F4A460';
			$color['SeaGreen']			= '#2E8B57';
			$color['SeaShell']			= '#FFF5EE';
			$color['Sienna']			= '#A0522D';
			$color['Silver']			= '#C0C0C0';
			$color['SkyBlue']			= '#87CEEB';
			$color['SlateBlue']			= '#6A5ACD';
			$color['SlateGray']			= '#708090';
			$color['SlateGrey']			= '#708090';
			$color['Snow']				= '#FFFAFA';
			$color['SpringGreen']		= '#00FF7F';
			$color['SteelBlue']			= '#4682B4';
			$color['Tan']				= '#D2B48C';
			$color['Teal']				= '#008080';
			$color['Thistle']			= '#D8BFD8';
			$color['Tomato']			= '#FF6347';
			$color['Turquoise']			= '#40E0D0';
			$color['Violet']			= '#EE82EE';
			$color['Wheat']				= '#F5DEB3';
			$color['White']				= '#FFFFFF';
			$color['WhiteSmoke']		= '#F5F5F5';
			$color['Yellow']			= '#FFFF00';
			$color['YellowGreen']		= '#9ACD32';
			
			$this->htmlColor = array();
			foreach($color as $key => $val) $this->htmlColor[strtolower($key)] = $val;			
			
    		$this->table = array();
    		
    		$this->value = array();
    		$this->initStyle();
			
			// initialisation des styles sans héritages
			$this->resetStyle();
    	}
    	
    	function initStyle()
    	{
     		$this->value['id_balise']		= 	'body';		// balise
    		$this->value['id_name']			= 	null;		// name
			$this->value['id_class']		= 	null;		// class
			$this->value['id_lst']			= 	array('*');	// lst de dependance
			$this->value['mini-size']		= 	1.;			// rapport de taille	spécifique aux sup, sub
			$this->value['mini-decal']		= 	0;			// rapport de position	spécifique aux sup, sub
			$this->value['font-family']		= 	'Arial';
			$this->value['font-bold']		= 	false;
			$this->value['font-italic']		= 	false;
			$this->value['font-underline']	= 	false;
			$this->value['font-size']		= 	$this->ConvertToMM('10pt');
			$this->value['text-align']		= 	'left';
			$this->value['vertical-align']	= 	'middle';
			$this->value['color']			= 	array(0, 0, 0);
			$this->value['width']			= 	0;
			$this->value['height']			= 	0;
			$this->value['background']		= 	null;
			$this->value['border']			= 	array();
			$this->value['padding']			= 	array();	
    	}
    	
  		/**
		 * Initialisation des styles sans héritages
		 *
		 * @param	string	balise HTML
		 * @return	null
		 */
		function resetStyle($balise = '')
    	{
 			$this->value['background']		= null;
			$this->value['width']			= 0;
			$this->value['height']			= 0;
			$this->value['border']	= array(
										't' => $this->readBorder('none'),
										'r' => $this->readBorder('none'),
										'b' => $this->readBorder('none'),
										'l' => $this->readBorder('none')
									);
			if ($balise=='table')
			{
				$this->value['padding']	= array(
										't' => 0,
										'r' => 0,
										'b' => 0,
										'l' => 0
									);
			}
			else
			{
				$this->value['padding']	= array(
										't' => $this->ConvertToMM('1px'),
										'r' => $this->ConvertToMM('1px'),
										'b' => $this->ConvertToMM('1px'),
										'l' => $this->ConvertToMM('1px')
									);
			}
		}
    	
  		/**
		 * Initialisation de la font PDF
		 *
		 * @return	null
		 */
	   	function FontSet()
		{
			$b = ($this->value['font-bold']			? 'B' : '');
			$i = ($this->value['font-italic']		? 'I' : '');
			$u = ($this->value['font-underline']	? 'U' : '');
			
			// taille en mm, à ramener en pt
			$size = $this->value['font-size'];
			$size = 72 * $size / 25.4;
			 
			$this->pdf->SetFont($this->value['font-family'], $b.$i.$u, $this->value['mini-size']*$size);
			$this->pdf->SetTextColor($this->value['color'][0],$this->value['color'][1], $this->value['color'][2]);
			if ($this->value['background'])
				$this->pdf->SetFillColor($this->value['background'][0],$this->value['background'][1], $this->value['background'][2]);
			else
				$this->pdf->SetFillColor(255);				
		}

 		/**
		 * Monter d'un niveau dans l'historisation
		 *
		 * @return	null
		 */		
		function save()
		{
			$this->table[count($this->table)] = $this->value;
		}
		
 		/**
		 * Descendre d'un niveau dans l'historisation
		 *
		 * @return	null
		 */		
		function load()
		{
			if (count($this->table))
			{
				$this->value = $this->table[count($this->table)-1];
				unset($this->table[count($this->table)-1]);
			}
		}

 		/**
		 * Analyse un tableau de style provenant du parseurHTML
		 *
		 * @param	string	nom de la balise
		 * @param	array	tableau de style
		 * @return	null
		 */			
		function analyse($balise, &$param)
		{
			// preparation
			$balise = strtolower($balise);
			$name	= isset($param['name'])		? strtolower($param['name'])	: null;
			$class	= isset($param['class'])	? strtolower($param['class'])	: null;
			
			// identification de la balise et des styles direct qui pourraient lui être appliqués
			$this->value['id_balise']	= $balise;
			$this->value['id_name']		= $name;
			$this->value['id_class']	= $class;
			$this->value['id_lst']		= array();
			$this->value['id_lst'][] = '*';
			$this->value['id_lst'][] = $balise;
			if ($class)
			{
				$this->value['id_lst'][] = '*.'.$class;
				$this->value['id_lst'][] = '.'.$class;
				$this->value['id_lst'][] = $balise.'.'.$class;
			}
			if ($name)
			{
				$this->value['id_lst'][] = '*#'.$name;
				$this->value['id_lst'][] = '#'.$name;
				$this->value['id_lst'][] = $balise.'#'.$name;
			}

			// style CSS
			$styles = $this->getFromCSS();

			// on ajoute le style propre à la balise
			$styles = array_merge($styles, $param['style']);

			// mise à zero des styles non hérités
			$this->resetStyle($balise);
					
			// interpreration des nouvelles valeurs
			$correct_width = false;
			foreach($styles as $nom => $val)
			{
				switch($nom)
				{
					case 'font-weight':
						$this->value['font-bold'] = ($val=='bold');
						break;
					
					case 'font-style':
						$this->value['font-italic'] = ($val=='italic');
						break;
					
					case 'text-decoration':
						$this->value['font-underline'] = ($val=='underline');
						break;
					
					case 'font-size':
						$val = $this->ConvertToMM($val, $this->value['font-size']);
						if ($val) $this->value['font-size'] = $val;
						break;
					
					case 'color':
						$this->value['color'] = $this->ConvertToRVB($val);
						break;
					
					case 'text-align':
						$this->value['text-align'] = $val;
						break;
						
					case 'vertical-align':
						$this->value['vertical-align'] = $val;
						break;
					
					case 'width':
						$this->value['width'] = $this->ConvertToMM($val, $this->getLastWidth());
						if ($this->value['width'] && substr($val, -1)=='%') $correct_width=true;
						break;
					
					case 'height':
						$this->value['height'] = $this->ConvertToMM($val, $this->getLastHeight());
						break;
				
					case 'padding':
						$val = explode(' ', $val);
						foreach($val as $k => $v)
						{
							$v = trim($v);
							if ($v!='') $val[$k] = $v;
							else	unset($val[$k]);
						}
						$val = array_values($val);
						if (count($val)!=4)
						{
							$val = $this->ConvertToMM($val[0], 0);
							$this->value['padding']['t'] = $val;
							$this->value['padding']['r'] = $val;
							$this->value['padding']['b'] = $val;
							$this->value['padding']['l'] = $val;
						}
						else
						{
							$this->value['padding']['t'] = $this->ConvertToMM($val[0], 0);
							$this->value['padding']['r'] = $this->ConvertToMM($val[1], 0);
							$this->value['padding']['b'] = $this->ConvertToMM($val[2], 0);
							$this->value['padding']['l'] = $this->ConvertToMM($val[3], 0);							
						}
						break;
						
					case 'padding-top':
						$this->value['padding']['t'] = $this->ConvertToMM($val, 0);
						break;

					case 'padding-right':
						$this->value['padding']['r'] = $this->ConvertToMM($val, 0);
						break;

					case 'padding-bottom':
						$this->value['padding']['b'] = $this->ConvertToMM($val, 0);
						break;

					case 'padding-left':
						$this->value['padding']['l'] = $this->ConvertToMM($val, 0);
						break;
												
					case 'border':
						$val = $this->readBorder($val);
						$this->value['border']['t'] = $val;
						$this->value['border']['r'] = $val;
						$this->value['border']['b'] = $val;
						$this->value['border']['l'] = $val;
						break;

					case 'border-top':
						$this->value['border']['t'] = $this->readBorder($val);
						break;

					case 'border-right':
						$this->value['border']['r'] = $this->readBorder($val);
						break;

					case 'border-bottom':
						$this->value['border']['b'] = $this->readBorder($val);
						break;

					case 'border-left':
						$this->value['border']['l'] = $this->readBorder($val);
						break;
					
					case 'background-color':
					case 'background':
						if ($val=='transparent')	$this->value['background'] = null;
						else						$this->value['background'] = $this->ConvertToRVB($val);
						break;
					
					default:
						break;	
				}				
			}

			// correction de la largeur pour correspondre au modèle de boite quick
			if ($correct_width)
			{
				$this->value['width']-= $this->value['padding']['l'] + $this->value['padding']['r'];
				$this->value['width']-= $this->value['border']['l']['width'] + $this->value['border']['r']['width'];
				if (in_array($balise, array('table', 'th', 'td')))
				{
					$this->value['width']-= $this->ConvertToMM(isset($param['cellspacing']) ? $param['cellspacing'] : '2px');
				}
				if ($this->value['width']<0) $this->value['width']=0;
			}
		}
		
 		/**
		 * Récupération de la largeur de l'objet parent
		 *
		 * @return	float	largeur
		 */
		function getLastWidth()
		{
			for($k=count($this->table); $k>0; $k--)
			{
				if ($this->table[$k-1]['width']) return $this->table[$k-1]['width'];
			}
			return $this->pdf->w - $this->pdf->lMargin - $this->pdf->rMargin;
		}

 		/**
		 * Récupération de la hauteur de l'objet parent
		 *
		 * @return	float	hauteur
		 */
		 function getLastHeight()
		{
			for($k=count($this->table); $k>0; $k--)
			{
				if ($this->table[$k-1]['height']) return $this->table[$k-1]['height'];
			}
			return 0;
		}
		
		/**
		 * Récupération des propriétés CSS de la balise en cours
		 *
		 * @return	array()		tableau des propriétés CSS
		 */		
		function getFromCSS()
		{
			$styles	= array();	// style à appliquer
			$getit	= array();	// styles à récuperer

			// identification des styles direct, et ceux des parents
			$lst = array();
			$lst[] = $this->value['id_lst'];
			for($i=count($this->table)-1; $i>=0; $i--) $lst[] = $this->table[$i]['id_lst'];

			// identification des styles à récuperer
			foreach($this->css_keys as $key => $num)
				if ($this->getReccursiveStyle($key, $lst))
					$getit[$key] = $num;

			// si des styles sont à recuperer
			if (count($getit))
			{
				// on les récupère, mais dans l'odre de définition, afin de garder les priorités
				asort($getit);
				foreach($getit as $key => $val) $styles = array_merge($styles, $this->css[$key]);				
			}
			
			return $styles;	
		}
		
		/**
		 * Identification des styles à récuperer, en fonction de la balise et de ses parents
		 *
		 * @param	string		clef CSS à analyser
		 * @param	array()		tableau des styles direct, et ceux des parents
		 * @param	string		prochaine etape
		 * @return	boolean		clef autorisée ou non
		 */
		function getReccursiveStyle($key, $lst, $next = null)
		{
			// si propchaine etape, on construit les valeurs
			if ($next!==null)
			{
				if ($next) $key = trim(substr($key, 0, -strlen($next))); // on elève cette etape
				unset($lst[0]);
				if (!count($lst)) return false; // pas d'etape possible
				$lst = array_values($lst);
			}
			
			// pour chaque style direct possible de l'etape en cours
			foreach($lst[0] as $nom)
			{
				if ($key==$nom) return true; // si la clef conrrespond => ok
				if (substr($key, -strlen(' '.$nom))==' '.$nom && $this->getReccursiveStyle($key, $lst, $nom)) return true; // si la clef est la fin, on analyse ce qui précède
			}

			// si on est pas à la premiere etape, on doit analyse toutes les sous etapes			
			if ($next!==null && $this->getReccursiveStyle($key, $lst, '')) return true;
		
			// aucun  style trouvé	
			return false;	
		}
		
		/**
		 * Analyse d'une propriété Border
		 *
		 * @param	string		propriété border
		 * @return	array()		propriété décodée
		 */
		function readBorder($val)
		{
			$none = array('type' => 'none', 'width' => 0, 'color' =>  array(0, 0, 0));

			// valeurs par défault
			$type	= 'solid';
			$width	= $this->ConvertToMM('1pt');
			$color	= array(0, 0, 0);

			// nettoyage des valeurs
			$val = explode(' ', $val);
			foreach($val as $k => $v)
			{
				$v = trim($v);
				if ($v)	$val[$k] = $v;
				else	unset($val[$k]);	
			}
			$val = array_values($val);
			// identification des valeurs
			foreach($val as $key)
			{
				if ($key=='none' || $key=='hidden') return $none;
				
				if ($this->ConvertToMM($key)!==null)						$width = $this->ConvertToMM($key);	
				else if (array_sum($this->ConvertToRVB($key)))				$color = $this->ConvertToRVB($key);
				elseif (in_array($key, array('solid', 'dotted', 'dashed')))	$type = $key;	
			}
			if (!$width) return $none;
			return array('type' => $type, 'width' => $width, 'color' => $color);
		}
		
 		/**
		 * Convertir une longueur en mm
		 *
		 * @param	string			longueur, avec unité, à convertir
		 * @param	float			longueur du parent
		 * @return	float			longueur exprimée en mm
		 */	
		function ConvertToMM($val, $old=0.)
		{
			$val = trim($val);
			if (preg_match('/^[0-9\.]+$/isU', $val)) $val.= 'px';
			if (preg_match('/^[0-9\.]+px$/isU', $val))		$val = 25.4/96. * str_replace('px', '', $val);
			else if (preg_match('/^[0-9\.]+pt$/isU', $val))	$val = 25.4/72. * str_replace('pt', '', $val);
			else if (preg_match('/^[0-9\.]+in$/isU', $val))	$val = 25.4 * str_replace('in', '', $val);
			else if (preg_match('/^[0-9\.]+mm$/isU', $val))	$val = 1.*str_replace('mm', '', $val);
			else if (preg_match('/^[0-9\.]+%$/isU', $val))	$val = 1.*$old*str_replace('%', '', $val)/100.;
			else											$val = null;	

			return $val;
		}
		
 		/**
		 * Décomposition d'un code couleur HTML
		 *
		 * @param	string			couleur au format CSS
		 * @return	array(r, v, b)	couleur exprimé par ses comporantes R, V, B, de 0 à 255.
		 */	
		function ConvertToRVB($val)
		{
			$val = trim($val);
			
			if (isset($this->htmlColor[strtolower($val)])) $val = $this->htmlColor[strtolower($val)];
			
			if (preg_match('/rgb\([\s]*([0-9%]+)[\s]*,[\s]*([0-9%]+)[\s]*,[\s]*([0-9%]+)[\s]*\)/isU', $val, $match))
			{
				$r =$match[1]; if (substr($r, -1)=='%') $r = floor(255*substr($r, 0, -1)/100);
				$v =$match[2]; if (substr($v, -1)=='%') $v = floor(255*substr($v, 0, -1)/100);
				$b =$match[3]; if (substr($b, -1)=='%') $b = floor(255*substr($b, 0, -1)/100);
			}
			else if (strlen($val)==7 && substr($val, 0, 1)=='#')
			{
				$r = hexdec(substr($val, 1, 2));
				$v = hexdec(substr($val, 3, 2));
				$b = hexdec(substr($val, 5, 2));
			}
			else if (strlen($val)==4 && substr($val, 0, 1)=='#')
			{
				$r = hexdec(substr($val, 1, 1).substr($val, 1, 1));
				$v = hexdec(substr($val, 2, 1).substr($val, 2, 1));
				$b = hexdec(substr($val, 3, 1).substr($val, 3, 1));
			}
			else
			{
				$r=0;
				$v=0;
				$b=0;	
			}
			return array(floor($r), floor($v), floor($b));	
		}
		
		/**
		 * Analyser une feuille de style
		 *
		 * @param	string			code CSS
		 * @return	null
		 */	
		function analyseStyle(&$code)
		{
			// on remplace tous les espaces, tab, \r, \n, par des espaces uniques
			$code = preg_replace('/[\s]+/', ' ', $code);


			// on analyse chaque style
			preg_match_all('/([^{}]+){([^}]*)}/isU', $code, $match);
			for($k=0; $k<count($match[0]); $k++)
			{
				// noms
				$noms	= strtolower(trim($match[1][$k]));
				
				// style, séparé par des; => on remplie le tableau correspondant
				$styles	= trim($match[2][$k]);
				$styles = explode(';', $styles);
				$stl = array();
				foreach($styles as $style)
				{
					$tmp = explode(':', $style);
					if (count($tmp)==2)	$stl[trim(strtolower($tmp[0]))] = trim($tmp[1]);
				}
				
				// décomposition des noms par les ,
				$noms = explode(',', $noms);
				foreach($noms as $nom)
				{
					$nom = trim($nom);
					// Si il a une fonction spécifique, comme :hover => on zap
					if (strpos($nom, ':')!==false) continue;
					if (!isset($this->css[$nom]))
						$this->css[$nom] = $stl;
					else
						$this->css[$nom] = array_merge($this->css[$nom], $stl);
					
				}
			}
			
			$this->css_keys = array_flip(array_keys($this->css));
		}
		
		/**
		 * Extraction des feuille de style du code HTML
		 *
		 * @param	string			code HTML
		 * @return	null
		 */	
		function readStyle(&$html)
		{
			$style = ' ';

			// extraction des balises link, et suppression de celles-ci dans le code HTML
			preg_match_all('/<link([^>]*)>/isU', $html, $match);
			$html = preg_replace('/<link[^>]*>/isU',	'', $html);			
			$html = preg_replace('/<\/link[^>]*>/isU',	'', $html);
			
			// analyse de chaque balise
			foreach($match[1] as $code)
			{
				$tmp = array();
				// lecture des paramétres du type nom=valeur
				$prop = '([a-zA-Z0-9_]+)=([^"\'\s>]+)';
				preg_match_all('/'.$prop.'/is', $code, $match);
				for($k=0; $k<count($match[0]); $k++)
					$tmp[trim(strtolower($match[1][$k]))] = trim($match[2][$k]);
	
				// lecture des paramétres du type nom="valeur"
				$prop = '([a-zA-Z0-9_]+)=["]([^"]*)["]';
				preg_match_all('/'.$prop.'/is', $code, $match);
				for($k=0; $k<count($match[0]); $k++)
					$tmp[trim(strtolower($match[1][$k]))] = trim($match[2][$k]);
	
				// lecture des paramétres du type nom='valeur'
				$prop = "([a-zA-Z0-9_]+)=[']([^']*)[']";
				preg_match_all('/'.$prop.'/is', $code, $match);
				for($k=0; $k<count($match[0]); $k++)
					$tmp[trim(strtolower($match[1][$k]))] = trim($match[2][$k]);

				// si de type text/css => on garde
				if (isset($tmp['type']) && strtolower($tmp['type'])=='text/css' && isset($tmp['href']) && is_file($tmp['href']))
				{
					$style.= file_get_contents($tmp['href'])."\n";
				}
			}


			// extraction des balises style, et suppression de celles-ci dans le code HTML
			preg_match_all('/<style[^>]*>(.*)<\/style[^>]*>/isU', $html, $match);
			$html = preg_replace('/<style[^>]*>(.*)<\/style[^>]*>/isU', '', $html);			

			// analyse de chaque balise
			foreach($match[1] as $code)
			{
				$code = str_replace('<!--', '', $code);
				$code = str_replace('-->', '', $code);
				$style.= $code."\n";
			} 
			
			$this->analyseStyle($style);
		}
	}
}
?>