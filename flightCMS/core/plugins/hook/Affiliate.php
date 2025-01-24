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

define('AFFILIATE_FILE','Affiliate.yaml');
define('AFFILIATE_DIR', __DIR__);

class Affiliate 
{
	//---------------------------------------------------------------------------------------------
	// Register Plugin at Hook 'afterParseContent' and check exsist Affiliate.yaml File
  	function hook()
    {
		Debug::out('Affiliate.php','Hook-Register','afterParseContent');
		if(!file_exists(AFFILIATE_DIR.'/'.AFFILIATE_FILE))
		{
			$this->createAffiliateDB();																		// create YAML-DB when not exsist
		}
      	return 'beforeParseContent';																			// send Hook-Name for Register
    }
  
	//---------------------------------------------------------------------------------------------
	// start run() Methode at Hook 'afterParseContent'
  	function run($var)
    {
		Debug::out('Affiliate.php','Run','$var');
		$affiliate_DB = Dipper::parse(file_get_contents(AFFILIATE_DIR.'/'.AFFILIATE_FILE));
		$int          = rand(0, count($affiliate_DB)-1);
		$count        = 0;

		foreach($affiliate_DB as $key=>$value)
		{
			$count = $count+1;
			if ($int == ($count-1) )
			{
				$html = '';
      			$html .= '<div class="row mt-4">';
      			$html .= '    <div class="col-sm-2">';
      			$html .= '        <a href="'.$value['url'].'" title="Affiliate"><img src="'.$value['logo'].'" class="img-fluid mb-4" alt="Affiliate"></a>';
      			$html .= '    </div>';
      			$html .= '    <div class="col-sm-10">';
      			$html .= '        <p><strong>'.$value['title'].'</strong> - '.$value['description'].'</p>';
      			$html .= '        <p class="fs-6 opacity-75"><em>Wichtiger Hinweis: Je nach verwendetem Werbenetzwerk, musst du hier einen geeigneten Hinweis anbringen, der dem Leser anzeigt, das du mit Affiliate-Marketing Geld verdienst (ggf. in den Teilnahmenbedingungen des betreffenden Werbepartners nachlesen).</em> ';
      			$html .= '        <span><sup><a href="/plugins/flightcms-plugin-affiliate" title="Plugin-Beschreibung"><i class="bi bi-plug-fill"></i></a></sup></span></p>';
      			$html .= '    </div>';
      			$html .= '</div>';
			}
		}
      
		Debug::out('Affiliate.php','Return','$var');
      	return $html.$var;
    }

	//---------------------------------------------------------------------------------------------
	// Create a Demo-Affiliate YAML-DB when not exsist
	function createAffiliateDB() 
	{
        $affiliate=
        [
            'produkt-1'=>
            [
                'title'       =>'PHP 8 und MySQL',
				'logo'        =>'https://m.media-amazon.com/images/I/71lrxlp9KKL._SY466_.jpg',
				'url'         =>'https://www.amazon.de/PHP-MySQL-umfassende-fortgeschrittenen-PHP-Programmierung/dp/3836283271?crid=3DTB5T8NN7N6C&keywords=php+8+und+mysql&qid=1702460671&sprefix=php+%2Caps%2C133&sr=8-2&linkCode=ll1&tag=flightcms-21&linkId=e5a14ddcbdc62dd7f129caa59eb8bd8c&language=de_DE&ref_=as_li_ss_tl',
                'description' =>'Dynamische Webseiten mit PHP und MySQL programmieren: Alles, was Sie dafür wissen müssen, steht in diesem Buch. Profitieren Sie von einer praxisorientierten Einführung und lernen Sie alle neuen Sprachfeatures von PHP 8 kennen. Die Autoren Christian Wenz und Tobias Hauser sind erfahrene PHP-Programmierer und Datenbankspezialisten. Sie zeigen Ihnen, wie Sie MySQL und andere Datenbanksysteme effektiv einsetzen. Mit diesem Wissen machen Sie sich rundum fit für dynamische Websites.'                    
            ],
            'produkt-2'=>
            [
                'title'       =>'HTML und CSS',
				'logo'        =>'https://m.media-amazon.com/images/I/71OVjJFRbiS._SY466_.jpg',
				'url'         =>'https://www.amazon.de/HTML-CSS-umfassende-Nachschlagen-JavaScript/dp/3836281171?pd_rd_w=EfYgP&content-id=amzn1.sym.1fd66f59-86e9-493d-ae93-3b66d16d3ee0&pf_rd_p=1fd66f59-86e9-493d-ae93-3b66d16d3ee0&pf_rd_r=KMEE732EZS0FTJGEQ9QP&pd_rd_wg=2LTGJ&pd_rd_r=4807ed40-533b-4733-9774-94ca13d0e803&pd_rd_i=3836281171&psc=1&linkCode=ll1&tag=flightcms-21&linkId=419272e6356d9761987bb139afa9a0cf&language=de_DE&ref_=as_li_ss_tl',
                'description' =>'Moderne Web-Technologien für moderne Websites! In diesem Standardwerk gibt Ihnen Jürgen Wolf alle Werkzeuge an die Hand, die sie für einen starken Auftritt im Web benötigen. Lernen Sie alle Grundlagen von HTML, CSS und JavaScript kennen und erweitern Sie Ihr Wissen mit diesem umfassenden Lern- und Nachschlagewerk: vom Aufbau eines HTML-Dokuments über die Gestaltung mit CSS bis hin zur Web-Programmierung mit JavaScript. Inkl. einer Einführung in die wichtigen JavaScript-Frameworks React und Angular.'
            ]
        ];
		file_put_contents(AFFILIATE_DIR.'/'.AFFILIATE_FILE, Dipper::make($affiliate));
	}
}
?>