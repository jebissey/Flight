<?php

$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Kann nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Yml
{
    //---------------------------------------------------------------------------------------------
	// Ein Helper zum erstellen von YAML-Daten z.B. für die Newsletter-Registrierung. Die 
  	// Methode wird statisch aufgerufen:
	//
    //		Helpers::yamlWrite($yaml_key, $yaml_data, 'log/newsletter.yaml');
	//		Helpers::yamlWrite('Kontakt@Oliver-Lohse.de', array(...), 'log/newsletter.yaml');
    //
    // Dabei haben die Variablen die folgende Bedeutung:
    //
    //      $yaml_key  = 'Kontakt@Oliver.Lohse.de'
    //      $yaml_data = array('name' => 'Oliver Lohse', 'ip' => '47.11.08.15', 'date' => '1968-05-13');
    //
    // Durch die Bearbeitung des YAML-Parsers entsteht dabei der folgende Datei-Output:
    //
    //      ---
	//		Kontakt@Oliver-Lohse.de:
  	//			name: Oliver Lohse
  	//			ip:   47.11.08.15
  	//			date: 1968-05-13
	//
	// Die Methode prüft, ob die angegebene Mailadresse bereits in der YAML-Datei existiert, 
    // wenn nicht kann sie eingetragen werden. Angezeigt werden die Daten mit:
	//
	//		foreach(Dipper::parse(file_get_contents('log/newsletter.yaml')) as $key=>$value)
	//		{
	//			echo '<br>'.$key.'<br>';
	//			foreach ($value as $key=>$value)
	//			{
	//				echo $key.': '.$value.'<br>';
	//			}
	//		}
	//
  	//---------------------------------------------------------------------------------------------
	public static function yamlWrite($yaml_key, $yaml_data, $file)
	{
        if (!$yaml_key) $yaml_key = 'unknown Key '.date('Y-m-d H:i:s');
        $new_yaml_set   = array($yaml_key => $yaml_data);                                                   // Übergabedaten als YAML-Struktur aufbauen
		$full_yaml_file = Dipper::parse(file_get_contents($file));			                                // bisheriges YAML-File laden und parsen
		
        if (substr_count(strtolower(file_get_contents($file)), strtolower($yaml_key)) <1)
		{
			file_put_contents($file, Dipper::make($new_yaml_set)."\n", FILE_APPEND | LOCK_EX)!==false;      // Eintragen wenn nicht
		}
	}

	//---------------------------------------------------------------------------------------------
	// Im Prinzip wie 'yamlWrite()' jedoch ohne die Nutzung von Dipper. Schreibt einen
	// strukturierten Datenstrom im YAML-Format in eine Datei.
	//---------------------------------------------------------------------------------------------
	public static function formattedWrite($yaml_key, $yaml_data, $file)
	{
		$output = $yaml_key.':'."\n";
        foreach($yaml_data as $key=>$value)
        {
            $output .= '  '.$key.': '.$value."\n";
        }
        if (substr_count(strtolower(file_get_contents($file)), strtolower($yaml_key)) <1)
        {
            file_put_contents($file,$output);
        }
	}
  
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