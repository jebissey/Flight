<?php
//-------------------------------------------------------------------------------------------------
// Helper zum bereinigen von Eingabefeldern wie eMails, Name, Vorname,...
//-------------------------------------------------------------------------------------------------

$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Kann nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class Purify
{
	public static function input($input)
	{
		return str_replace(array('<','>','#','?','%','&'), '', $input);
	}
}
?>