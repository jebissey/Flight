<?php
//-------------------------------------------------------------------------------------------------
// Die Servervariable HTTPS ist bei lokalen Webservern wie XAMPP unter Umständen nicht gesetzt und 
// das Plugin kann zu einem Fehler führen.
//
// 27.12.23 - Fix Servervariable 'HTTPS'
//-------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Sitemap
{   
  	private $domain;
  	private $https;
	private $datum;
	private $content;
  	private $output;

	//---------------------------------------------------------------------------------------------
	// Register Hook
	//---------------------------------------------------------------------------------------------
  	function hook()
    {
      	return 'afterStart';
    }
  
	//---------------------------------------------------------------------------------------------
	// Start by Hook 'afterStart'
	//---------------------------------------------------------------------------------------------
  	function run($var)
    {
      	if(!file_exists('sitemap.xml'))
        {
			$https = 'http://';

			if (isset($_SERVER['HTTPS'])) 																	// unter LOCALHOST nicht gesetzt!
			{
      			if($_SERVER['HTTPS'])
        		{
          			$this->https = 'https://';
        		} else {
          			$this->https = 'http://';
        		}
			}
      
      		$this->domain   = $this->https.$_SERVER['SERVER_NAME'].'/';
			$this->datum    = date('Y-m-d');
			$this->content  = 'content/';
	      
	    	$this->output  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
			$this->output .= '<!-- created with FlightCMS.de -->'."\n";
			$this->output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
			$this->output .= '<url>'."\n";
			$this->output .= '  <loc>'.$this->domain.'</loc>'."\n";
			$this->output .= '  <lastmod>'.$this->datum.'</lastmod>'."\n";
			$this->output .= '  <priority>1.0</priority>'."\n";
			$this->output .= '</url>'."\n";
      
     		$this->rekursive_dir($this->content);
      
      		$this->output .= '</urlset>';
			file_put_contents('sitemap.xml', $this->output);
          	file_put_contents('sitemaps.xml', $this->output);
			file_put_contents('sitemap.txt', $this->output);
          	file_put_contents('sitemaps.txt', $this->output);
        }
    }

	function rekursive_dir($dir) 
    {      
		foreach (scandir($dir) as $file) 
        {
  			if ($file === '..' or $file === '.' or $file === 'index.md') continue;
        	if (is_dir($dir.$file)) 
            {
        		$this->output .= '<url>'."\n";
        		$this->output .= '  <loc>'.$this->domain.trim(str_replace('content/','',$dir.$file)).'</loc>'."\n";
            	$this->output .= '  <lastmod>'.$this->datum.'</lastmod>'."\n";
            	$this->output .= '  <priority>1.0</priority>'."\n";
            	$this->output .= '</url>'."\n";
            	$this->rekursive_dir($dir.$file.'/');
        	} else {
        		$this->output .= '<url>'."\n";
            	$this->output .= '  <loc>'.$this->domain.trim(str_replace(array('content/','.md','.txt'),'',$dir.$file)).'</loc>'."\n";
            	$this->output .= '  <lastmod>'.$this->datum.'</lastmod>'."\n";
            	$this->output .= '  <priority>1.0</priority>'."\n";
            	$this->output .= '</url>'."\n";
        	}
		}
	}
}
?>