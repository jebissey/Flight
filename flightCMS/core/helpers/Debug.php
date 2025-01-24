<?php
//-------------------------------------------------------------------------------------------------
// Helper zum debuggen des CMS. Erzeugt ein HTML-Dokument das mit 'start()' eingeleitet und mit
// 'stop()' beendet wird. Mit 'out()' wird Inhalt geschrieben.
//-------------------------------------------------------------------------------------------------

$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Kann nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Debug
{
	//---------------------------------------------------------------------------------------------
	// write a Table-Record
	//---------------------------------------------------------------------------------------------
  	public static function out($pgm, $methode, $value)
    {
      	if(DEBUG_ACTIVE)
        {
          	$out  = '<tr>';
          	$out .= '<td class="py-1 px-3">'.$pgm.'</td>';
			$out .= '<td class="py-1 px-3">'.$methode.'</td>';
          	$out .= '<td class="py-1 px-3">'.strip_tags($value).'</td>';
          	$out .= '</tr>';
      		file_put_contents(LOG_DIR.'/'.DEBUG_FILE, $out."\n", FILE_APPEND | LOCK_EX)!==false;
        }
    }
	//---------------------------------------------------------------------------------------------
	// Create a HTML-Header Bootstrap Style and start the HTML-Table
	//---------------------------------------------------------------------------------------------
  	public static function start()
    {
		if (!is_dir(LOG_DIR)) 
		{
			mkdir(LOG_DIR);
		}
		if(file_exists(LOG_DIR.'/'.DEBUG_FILE))	
		{
			unlink(LOG_DIR.'/'.DEBUG_FILE);
		}
      	$out  = '<html>';
      	$out .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">';
  		$out .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css" rel="stylesheet" >';
      	$out .= '<style>';
      	$out .= 'tr:nth-child(even) {background-color: rgba(60,60,60,0.7);}';
		$out .= 'tr:nth-child(odd)  {background-color: rgba(60,60,60,0.2);}';
      	$out .= '</style>';
      	$out .= '<body class="p-5 bg-dark text-light">';
		$out .= '<div class="container">';
		$out .= '<div class="bg-secondary p-5 rounded mb-3">';
      	$out .= '<p class="lead">Start: '.$_SERVER['REMOTE_ADDR'].'</p>';
		$out .= '</div>';
      	$out .= '<table width=100%>';
      	file_put_contents(LOG_DIR.'/'.DEBUG_FILE, $out."\n");
    }
	//---------------------------------------------------------------------------------------------
	// Close HTML-Document and finish the HTML-Table
	//--------------------------------------------------------------------------------------------
  	public static function stop()
    {
      	$out  = '</table>';
		$out .= '<hr>';
      	$out .= '<p class="fs-6 text-secondary">by FlightCMS</p>';
		$out .= '</div>';
      	$out .= '</body>';
      	$out .= '</html>';
      	file_put_contents(LOG_DIR.'/'.DEBUG_FILE, $out."\n", FILE_APPEND | LOCK_EX)!==false;
    }
}
?>