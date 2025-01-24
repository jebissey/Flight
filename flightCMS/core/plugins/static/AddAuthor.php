<?php
//--------------------------------------------------------------------------------------------------
// Plugin to add a Line after the Content
//--------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class AddAuthor 
{
	//---------------------------------------------------------------------------------------------
	// Static call for this Plugin in Template:
	//
	//    ... echo AddAuthor::addAuthor(''); ...
	//---------------------------------------------------------------------------------------------
	static function addAuthor()
	{
		$html = '<p class="meta">';
      	$html .= '________<br>';
      	$html .= ' FlightCMS - ';
      	$html .= 'Das Teilen unserer Webseiten, Beiträge und Grafiken ist ausdrücklich gewollt und erwünscht. ';
        $html .= 'Durch das gegenseitige Verlinken, teilen wir Link-Juice und können etwas positive Reputation ';
		$html .= 'an dich weitergeben. Mach doch einfach mit, denn WISSEN muss allen Menschen auf diesem Planeten ';
		$html .= 'kostenlos zur Verfügung stehen - das Internet ist frei und gehört uns! ';
      	$html .= '<span><sup><a href="/plugins/flightcms-plugin-addauthor" title="Plugin-Beschreibung"><i class="bi bi-plug-fill"></i></a></sup></span>';
		echo $html;
	}
}
?>