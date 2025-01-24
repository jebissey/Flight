<?php
//-------------------------------------------------------------------------------------------------
// Demo Affiliate Plugin mit zwei Amazon-Artikeln, die bei Aufruf eines HOOK zufällig angezeigt
// werden. Die Artikeldaten stammen aus der 'Affiliate.yaml' Datei, die automatisch mit Demo-Daten
// erzeugt wird, sofern diese nicht existiert.
//-------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Blogroll 
{  
  	public static function display()
    {
		Debug::out('Blogroll.php','Display','');
		$blogroll_DB = Dipper::parse(file_get_contents(__DIR__.'/Blogroll.yaml'));

		$html='';
		foreach($blogroll_DB as $key=>$value)
		{
			if($value['confirmed']) 
			{
				$html .= '<div class="col-sm-3">';
				$html .= '<div class="p-3 bg-secondary mb-4">';
            	$html .= '<p class="text-center"><a href="'.$value['url'].'">'.$value['title'].'</a></p>';
				$html .= '<hr>';
      			$html .= '<p>'.$value['description'].'</p>';
				$html .= '</div>';
    			$html .= '</div>';
			} else {
				$html .= '<div class="col-sm-3 opacity-75">';
				$html .= '<div class="p-3 bg-secondary mb-4">';
            	$html .= '<p>';
				$html .=         '<sup class="pending">pending</sup>';
				$html .=     '<a href="'.$value['url'].'" title="waiting for confirmation">';
				$html .=         $value['title'];
				$html .=     '</a>';
				$html .= '</p>';
				$html .= '<hr>';
      			$html .= '<p class="opacity-25">'.$value['description'].'</p>';
				$html .= '</div>';
    			$html .= '</div>';
			}
		}
      
		Debug::out('Blogroll.php','Return','$var');
      	return $html;
    }
}
?>