<?php
//--------------------------------------------------------------------------------------------------
// Checks the file 'log/404.csv' and when a counter is reached the IP is blocked
//--------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class BlockIP
{   
	// --- HTML-File (Heredoc) for Display IP-Blocking Information ---
	private $error_doc = <<<EOD
		<!DOCTYPE html>
    	<html lang="de">
    	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    	</head>
    	<body class="fs-5">
        <div class="container p-5 bg-secondary">
        <h1 class="text-light fw-bold">IP Blocked</h1>
        </div>
        <div class="container p-5 bg-light">
        <p class="lead">Hinweis</p>
        <p>Die verwendete IP Adresse wurde wegen <strong>verdächtiger Aktivitäten</strong> gesperrt. 
        Der Aufruf der Webseite ist unter der verwendeten IP-Adresse für eine Stunde nicht mehr möglich.</p>
        <hr>
        <p class="fs-6 opacity-50">&copy; FlightCMS</p>
        </div>
    	</body>
		</html>
EOD;

	//---------------------------------------------------------------------------------------------
	// Register the Plugin by Hook
	//---------------------------------------------------------------------------------------------
  	function hook()
    {
		Debug::out('BlockIP.php','Hook-Register','beforeStart');
      	return 'beforeStart';
    }
  
	//---------------------------------------------------------------------------------------------
	// Start the Plugin by Hook
	//---------------------------------------------------------------------------------------------
  	function run($var)
    {
		$error_file  = LOG_DIR.'/404-'.date('Y-m-d').'.csv';												// the same File in 'OnError.php'
		$lock_count  = 3;
		$remote_addr = $_SERVER['REMOTE_ADDR'];

		if (file_exists($error_file))
		{
			if (substr_count(file_get_contents($error_file), $remote_addr) > $lock_count)					// ist das Suspect-Limit erreicht?
			{
				Flight::halt(404, $this->error_doc);														// stop FlightCMS and display Info
			}
		} else {
			file_put_contents($error_file, '', FILE_APPEND | LOCK_EX)!==false;								// create initial Suspect-IP File
		}
    }
}
?>