<?php

$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Kann nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Json
{
  	//---------------------------------------------------------------------------------------------
  	// Die Methode liest ein JSON-File ein und zeigt den Inhalt einfach an. Das Inputfile MUSS
  	// dabei den folgenden (JSON)Aufbau vorweisen:
  	//
  	//		[
	//			"Beitrag 1",
	//			{
	//				"description": "Das ist die Beschreibung des ersten Beitrags",
	//		        "content":     "Hier kommt der vollständige Beitragstext..."
	//			},
	//			"Beitrag 2",
	//			{
	//				"description": "Das ist die Beschreibung des zweiten Beitrags",
	//		        "content":     "Hier kommt der vollständige Beitragstext..."
	//			}
	//		]
  	//
  	//---------------------------------------------------------------------------------------------
  	public static function jsonRead($file)
    {
		$file_data = file_get_contents($file);

		foreach(json_decode($file_data, true) as $key=>$value)
		{
  			if (is_array($value))
    		{
				foreach($value as $key=>$value)			// interessant: es gibt keine Variablen- 
        		{										// Überschneidungen von '$value' und '$key' 
          			echo '<p>'.$value.'</p>';			// mit der äußeren Schleife.
        		}
    		} else {
				echo '<h2>'.$value.'</h2>';
    		}
		}
    }
}
?>