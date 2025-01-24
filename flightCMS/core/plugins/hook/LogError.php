<?php
//--------------------------------------------------------------------------------------------------
// Create a EXCEL Import CSV-File (log/404.csv) with a collection of IP addresses that access 
// incorrectly for this Month.
//--------------------------------------------------------------------------------------------------
$error = <<<EOD
	<body style="background-color: FIREBRICK; color: WHITE; padding: 2em; font-size: 1.4em; font-family: Arial;">
	<h1>ERROR</h1><p>Plugins können nicht direkt aufgerufen werden.</p>
	</body>
EOD;
if(defined('VERSION')) {/* nothing */} else {defined('version') OR die($error);}

class LogError
{   
	//---------------------------------------------------------------------------------------------
	// Register the Plugin by Hook
	//---------------------------------------------------------------------------------------------
  	function hook()
    {
      	return 'onError';
    }
  
	//---------------------------------------------------------------------------------------------
	// Start the Plugin by Hook
	//---------------------------------------------------------------------------------------------
  	function run($var)
    {
		$error_file  = LOG_DIR.'/404-'.date('Y-m-d').'.csv';												// the same File in 'SuspectIP.php'
		$remote_addr = "'".$_SERVER['REMOTE_ADDR'];
		$request_uri = $_SERVER['REQUEST_URI'];
		$user_agent  = str_replace(';',' ',$_SERVER['HTTP_USER_AGENT']);

    	file_put_contents($error_file, $remote_addr.';'.date('d.m.Y').';'.date('H:i:s').';'.$request_uri.';'.$user_agent."\n", FILE_APPEND | LOCK_EX)!==false;
    }
}
?>