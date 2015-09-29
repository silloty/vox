<?php

class gtiBrowser
{
	public function gtiBrowser()
	{
	}

	public function getBrowser()
	{
	    $var = $_SERVER['HTTP_USER_AGENT'];
	    $info['browser'] = "OTHER";
	    
	    // valid brosers array
	    $browser = array ("MSIE", "OPERA", "FIREFOX", "MOZILLA",
	                      "NETSCAPE", "SAFARI", "LYNX", "KONQUEROR");
	
	    // bots = ignore
	    $bots = array('GOOGLEBOT', 'MSNBOT', 'SLURP');
	
	    foreach ($bots as $bot)
	    {
	        // if bot, returns OTHER
	        if (strpos(strtoupper($var), $bot) !== FALSE)
	        {
	            return $info;
	        }
	    }
	    
	    // loop the valid browsers
	    foreach ($browser as $parent)
	    {
	        $s = strpos(strtoupper($var), $parent);
	        $f = $s + strlen($parent);
	        $version = substr($var, $f, 5);
	        $version = preg_replace('/[^0-9,.]/','',$version);
	        if (strpos(strtoupper($var), $parent) !== FALSE)
	        {
	            $info['nav'] = $parent;
	            $info['ver'] = $version;
	            return $info;
	        }
	    }
	    return $info;
	}

}

?>